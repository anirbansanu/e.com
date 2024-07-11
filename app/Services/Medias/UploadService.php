<?php

namespace App\Services\Medias;

use App\Models\Media;
use App\Models\Upload;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
/**
 * Class UploadService.
 */
class UploadService
{
    /**
     * @var array
     */
    protected $fieldSearchable = [

    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return new Upload;
    }
    public function create(array $attributes)
    {
        $model = $this->model()->create($attributes);
        return $model;
    }
    public function update(array $attributes, $id)
    {
        $model = $this->model()->update($attributes, $id);
        return $model;
    }
    /**
     * @param $uuid
     * @throws Exception
     */
    public function clear($uuid): ?bool
    {
        $uploadModel = $this->getByUuid($uuid);
        $medias = Media::where('custom_properties->uuid', $uuid)->get();

        foreach ($medias as $media) {
            Storage::deleteDirectory(storage_path('app/public/' . $media->id));
            $media->delete();
        }

        return $uploadModel->delete();
    }

    /**
     * @param $uuids
     * @throws Exception
     */
    public function clearWhereIn($uuids): ?bool
    {
        $response_array = [];
        foreach ($uuids as $uuid) {
            $response = $this->clear($uuid);
            array_push($response_array, $response);
        }

        return in_array('false', $response_array) ? false : true;
    }

    public function getByUuid($uuid = '')
    {
        $uploadModel = Upload::where('uuid', $uuid)->first();
        return $uploadModel;
    }

    /**
     * Return Media Model by Id
     **/
    public function getMediaById($id)
    {
        return Media::query()->where('id', $id)->first();
    }

    /**
     * Return Media Model by collection name
     */
    public function getMediaByCollectionName($name)
    {
        return Media::query()->where('collection_name', $name);
    }

    /**
     * clear all uploaded cache
     */
    public function clearAll()
    {
        Upload::query()->where('id', '>', 0)->delete();
        Media::query()->where('model_type', '=', 'App\Models\Upload')->delete();
    }

    /**
     * @return Builder[]|Collection
     */
    public function allMedia($collection = null)
    {
        $medias = Media::query()->where('model_type', '=', 'App\Models\Upload')->where('collection_name','!=', 'story');
        if ($collection) {
            $medias = $medias->where('collection_name', $collection);
        }
        $medias = $medias->orderBy('id', 'desc')->get();
        return $medias;
    }


    public function collectionsNames()
    {
        $medias = Media::where('collection_name','!=', 'story')->get('collection_name')->pluck('collection_name', 'collection_name')->map(function ($c) {
            return ['value' => $c,
                'title' => Str::title(preg_replace('/_/', ' ', $c))
            ];
        })->unique();
        unset($medias['default']);
        $medias->prepend(['value' => 'default', 'title' => 'Default'], 'default');
        return $medias;
    }
}
