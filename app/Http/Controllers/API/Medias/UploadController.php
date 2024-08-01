<?php

namespace App\Http\Controllers\API\Medias;

use App\Http\Controllers\Controller;
use App\Http\Requests\Medias\UploadRequest;
use App\Services\Medias\UploadService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class UploadController extends Controller
{
    private $uploadService;

    /**
     * UploadController constructor.
     * @param UploadService $uploadService
     */
    public function __construct(UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }

    public function index()
    {
        return view('medias.index');
    }

    /**
     * Get images paths
     * @param $id
     * @param $conversion
     * @param null $filename
     * @return mixed
     */
    public function storage($id, $conversion, $filename = null)
    {
        $array = explode('.', $conversion . $filename);
        $extension = strtolower(end($array));

        $media = $this->uploadService->getMediaById($id);
        if (isset($filename)) {
            return response()->file(storage_path('app/public/' . $id . '/' . $conversion . '/' . $filename));
        } else {
            $filename = $conversion;
            return response()->file(storage_path('app/public/' . $id . '/' . $filename));
        }
    }

    public function all(Request $request, $collection = null)
    {
        $allMedias = $this->uploadService->allMedia($collection);

        $allMedias = $allMedias->filter(function ($element) {
            if (isset($element['custom_properties']['user_id'])) {
                return $element['custom_properties']['user_id'] == auth()->id();
            }
            return false;
        });

        // dd($allMedias);
        return $allMedias->toJson();
    }


    public function collectionsNames(Request $request)
    {
        $allMedias = $this->uploadService->collectionsNames();
        return $this->response(200,__('lang.retrieved_successfully', ['operator' => __('lang.collection_plural')]), $allMedias,[]);
    }
    /**
     * @param UploadRequest $request
     */
    public function store(Request $request)
    {
        $input = $request->all();
        try {
            $upload = $this->uploadService->create($input);
            $input['field'] = $input['field'] ?? 'image';
            $upload->addMedia($input['file'])
            ->withCustomProperties(['uuid' => $input['uuid'],'user_id' => auth()->id()])
            ->toMediaCollection($input['field'] ?? 'image');

            if($input['field'] == 'app_logo') {
                $updateSettings['app_logo'] = $input['uuid'];
                // setting($updateSettings)->save();
                Artisan::call("config:clear");
            }

            return $this->response(200, __('lang.uploaded_successfully'), $upload,[]);
        } catch (Exception $e) {
            return $this->response(400, $e->getMessage(), [], $e->getTrace());
        }
    }

    /**
     * clear cache from Upload table
     */
    public function clear(UploadRequest $request)
    {
        $input = $request->all();

        if(isset($input['id'])) {
            $media = $this->uploadService->getMediaById($input['id']);
            $input['uuid'] = $media['custom_properties']['uuid'];
        }

        if ($input['uuid']) {
            $result = $this->uploadService->clear($input['uuid']);
            return $this->response(200, __('lang.deleted_successfully', ['operator' => __('lang.media')]), $result, []);
        }
        return $this->response(400,  __('lang.error').__('lang.will').__('lang.in').__('lang.delete') , [], []);

    }

    /**
     * clear all cache
     * @return RedirectResponse
     */
    public function clearAll()
    {
        $this->uploadService->clearAll();
        return redirect()->back();
    }
}
