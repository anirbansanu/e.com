<?php

namespace App\Http\Controllers\Admin\Products;

use App\Enums\Gender;
use App\Enums\PurchaseType;
use App\Helpers\EnumHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Upload;
use App\Services\Products\ProductService;
use App\Services\Medias\UploadService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
class ProductController extends Controller
{
    private $uploadService;
    private $productService;
    /**
     * ProductController constructor.
     * @param UploadService $uploadService
     */
    public function __construct(ProductService $productService,UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
        $this->productService = $productService;
    }
    public function index(Request $request)
    {
        try {

            $search = $request->input('search');
            $sort_by = $request->input('sort_by', 'updated_at');
            $sort_order = $request->input('sort_order', 'desc');
            $entries = $request->input('entries', config('app.pagination_limit'));


            $products = Product::with(['brand','category','addedBy'])
            // with(['productVariants','defaultStock.productPrice'])
            ->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            })
            ->orderBy($sort_by, $sort_order)
            ->paginate($entries);

            $products->appends(['search' => $search,'entries' => $entries, 'sort_by' => $sort_by, 'sort_order' => $sort_order]);

            return view('admin.products.product_listing.index', compact('products',"search","entries","sort_by","sort_order"));
        } catch (\Exception $e) {
            // Handle general exceptions

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function create(Request $request)
    {
        try {
            $step = $request->get('step',1);
            switch ($step) {
                case 1:
                    $genderOptions = EnumHelper::getOptions(Gender::class);
                    $purchaseTypeOptions = EnumHelper::getOptions(PurchaseType::class);
                    if($request->has("product_id"))
                    {
                        $product = $this->productService->getById($request->get("product_id"));
                        return view('admin.products.product_listing.create.step_1',compact('product','step','genderOptions','purchaseTypeOptions'));
                    }
                    return view('admin.products.product_listing.create.step_1',compact('step','genderOptions','purchaseTypeOptions'));
                    break;
                case 2:
                    if($request->has("product_id"))
                    {
                        $product = $this->productService->getById($request->get("product_id"),["productVariants"]);

                        return view('admin.products.product_listing.create.step_2',compact('product','step'));
                    }
                    else
                    {

                        return redirect()->route('products.create',["step"=>1]);
                    }
                    break;
                case 3:
                    if($request->has("product_id"))
                    {
                        $product = $this->productService->getById($request->get("product_id"),["productVariants"]);
                        // Check if the product has any variations

                        if($product->has_variations)
                        {
                            return view('admin.products.product_listing.create.step_3',compact('product','step'));
                        }
                        else
                        {

                            return redirect()->route('products.create',["step"=>2,"product_id"=>$product->id]);
                        }

                    }
                    else
                    {

                        return redirect()->route('products.create',["step"=>1]);
                    }
                    break;
                default:
                    return view('admin.products.product_listing.create.step_1');
                    break;
            }
            return view('admin.products.product_listing.create.step_1');
        } catch (\Exception $e) {
            // Handle general exceptions

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function storeStepOne(ProductRequest $request){

        try {
            $product = $this->productService->stepOne($request->all());

            return redirect()->route('products.create',["step"=>2,"product_id"=>$product->id])->with('success', 'Product created successfully.');

        } catch (\Exception $e) {

            return redirect()->back();
        }
    }
    public function storeStepTwo(Request $request){
        try {

            $product = $this->productService->stepTwo($request->all());

            return redirect()->route('products.create',["step"=>3,"product_id"=>$product->id]);

        } catch (\Exception $e) {

            return redirect()->route('products.create',["step"=>1])->with('error', $e->getMessage());
        }
    }
    public function storeStepThree(Request $request){

        try {
            $request->validate([
                "product_id" => "required|exists:products,id",
                "is_default" => "required|in:on"
            ],
            [
                "product_id.required" => "Please select a product.",
                "product_id.exists" => "The selected product is invalid.",
                "is_default.required" => "Please specify if it's the default stock.",
                "is_default.in" => "The default field must be 'on'."
            ]);
            $product = $this->productService->stepThree($request->all());
            if($product->has_stocks){

                return redirect()->route('products.index');
            }
            else {

                return redirect()->back();
            }

        }  catch (\Illuminate\Validation\ValidationException $e) {

            return redirect()->back();
        } catch (\Exception $e) {

            return redirect()->route('products.create',["step"=>2,'product_id'=>$request->get('product_id')])->with('error', $e->getMessage());
        }
    }


    public function show($id)
    {
        try {
            $product = Product::findOrFail($id);
            return view('admin.products.show', compact('product'));
        } catch (ModelNotFoundException $e) {
            // Handle model not found exception

            return redirect()->route('products.index')->with('error', 'Product not found');
        } catch (\Exception $e) {
            // Handle general exceptions

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit(Request $request,$id)
    {
        try {
            $step = $request->get('step',1);
            $genderOptions = EnumHelper::getOptions(Gender::class);
            $purchaseTypeOptions = EnumHelper::getOptions(PurchaseType::class);
            switch ($step) {
                case 1:
                    $product = $this->productService->getById($id);
                    return view('admin.products.product_listing.edit.step_1',compact('product','step','genderOptions','purchaseTypeOptions'));
                    break;
                case 2:
                    $product = $this->productService->getBySlug($id,[]);
                    // $product = $this->productService->getBySlug($id,["productVariants"]);
                    return view('admin.products.product_listing.edit.step_2',compact('product','step'));
                    break;
                case 3:
                    $product = $this->productService->getBySlug($id,["productVariants"]);
                    // Check if the product has any variations

                    if($product->has_variations)
                    {
                        // return $product->productVariants->groupBy('attribute_name');
                        return view('admin.products.product_listing.edit.step_3',compact('product','step'));
                    }
                    else
                    {

                        return redirect()->route('admin.products.listing.edit',["slug"=>$product->slug,"step"=>2]);
                    }
                    break;
                default:
                    return view('admin.products.product_listing.edit.step_1');
                    break;
            }
            return view('admin.products.product_listing.edit.step_1',compact('step','genderOptions','purchaseTypeOptions'));
        }
        catch (ModelNotFoundException $e) {

            // Handle model not found exception
            return redirect()->route('products.index')->with('error', 'Product not found');
        }
        catch (\Exception $e) {
            // Handle general exceptions

            return redirect()->back()->with('error', $e->getMessage());
        }

    }
    public function editStepOne(ProductRequest $request){
        try {
            $product = $this->productService->stepOne($request->all());

            return redirect()->route('products.edit',["id"=>$product->id,"step"=>2])->with('success', 'Product created successfully.');

        } catch (\Exception $e) {

            return redirect()->back();
        }
    }
    public function editStepTwo(Request $request){
        try {

            $product = $this->productService->stepTwo($request->all());

            return redirect()->route('products.edit',["id"=>$product->id,"step"=>3]);

        } catch (\Exception $e) {

            return redirect()->back();
        }
    }
    public function editStepThree(Request $request){

        try {
            $request->validate([
                "product_id" => "required|exists:products,id",
                "is_default" => "required|in:on"
            ],
            [
                "product_id.required" => "Please select a product.",
                "product_id.exists" => "The selected product is invalid.",
                "is_default.required" => "Please specify if it's the default stock.",
                "is_default.in" => "The default field must be 'on'."
            ]);
            $product = $this->productService->stepThree($request->all());
            if($product->has_stocks){

                return redirect()->route('products.index');
            }
            else {

                return redirect()->back();
            }

        }  catch (\Illuminate\Validation\ValidationException $e) {

            return redirect()->back();
        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(ProductRequest $request, $id)
    {

        try {
            // Start a database transaction
            DB::beginTransaction();

            $product = Product::findOrFail($id);

            $validatedData = $request->validated();
            $validatedData['slug'] = Str::slug($validatedData['name']). '-' . mt_rand(1000, 9999);
            $validatedData['is_active'] = $request->has('is_active') ? 1 : 0;
            // Update the product with the new validatedData
            $product->update($validatedData);

            // Update or create product variations

            if (isset($request->variantions['variation_id']) && count($request->variantions['variation_id']) > 0) {
                $product->productVariants()->delete();
                foreach ($request->variantions['variation_id'] as $index => $variant) {


                    $v = new ProductVariant;
                    $v->product_id = $product->id;
                    $v->variation_id = $request->variantions['variation_id'][$index];
                    $v->variant_value = $request->variantions['variant_value'][$index];
                    $v->unit_id = $request->variantions['unit_id'][$index];
                    $v->save();

                }

            }


            // Update or delete images
            if (isset($request['image']) && is_array($request['image'])) {
                $existingImages = $product->getMedia('image')->pluck('uuid')->toArray();

                foreach ($request['image'] as $fileUuid) {
                    $cacheUpload = $this->uploadService->getByUuid($fileUuid);
                    $mediaItem = $cacheUpload->getMedia('image')->first();

                    // Check if the image already exists for the product
                    if (!in_array($fileUuid, $existingImages)) {
                        // If not, copy the new image
                        $mediaItem->copy($product, 'image');
                    }
                }

                // Delete images that were removed
                $removedImages = array_diff($existingImages, $request['image']);
                foreach ($removedImages as $removedImageUuid) {
                    $media = $product->getMedia('image')->where('uuid', $removedImageUuid)->first();
                    if ($media) {
                        $media->delete();
                    }
                }
            }

            // Commit the database transaction
            DB::commit();


            return redirect()->route('products.index')->with('success', 'Product updated successfully.');
        } catch (ValidationException $e) {
            // Handle validation errors
            DB::rollBack();

            return redirect()->back()->withErrors($e->errors())->withInput();
        }
        catch (ModelNotFoundException $e) {

            // Handle model not found exception
            return redirect()->route('products.index')->with('error', 'Product not found.');
        }
        catch (\Exception $e) {
            // Handle general exceptions
            DB::rollBack();

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();

            return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
        } catch (ModelNotFoundException $e) {
            // Handle model not found exception

            return redirect()->route('products.index')->with('error', 'Product not found.');
        } catch (\Exception $e) {
            // Handle general exceptions

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function trash(Request $request)
    {
        try {
            $search = $request->input('search');
            $sort_by = $request->input('sort_by', 'updated_at');
            $sort_order = $request->input('sort_order', 'desc');
            $products = Product::onlyTrashed()
                                ->where(function ($q) use ($search) {
                                    $q->where('name', 'like', '%' . $search . '%')
                                        ->orWhere('description', 'like', '%' . $search . '%');
                                })
                                ->orderBy($sort_by, $sort_order)
                                ->paginate(config('app.pagination_limit'));

            $products->appends(['search' => $search, 'sort_by' => $sort_by, 'sort_order' => $sort_order]);
            return view('admin.products.trash', compact('products',"search","sort_by","sort_order"));
        } catch (\Exception $e) {
            // Handle general exceptions

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function untrash($id)
    {
        try {
            $product = Product::withTrashed()->findOrFail($id);
            $product->restore();

            return redirect()->route('products.index')->with('success', 'Product restored successfully.');
        } catch (ModelNotFoundException $e) {

            // Handle model not found exception
            return redirect()->route('products.index')->with('error', 'Product not found.');
        } catch (\Exception $e) {
            // Handle general exceptions

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function toggleStatus($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->is_active = !$product->is_active;
            $product->save();

            return redirect()->route('products.index')->with('success', 'Product status toggled successfully.');
        } catch (ModelNotFoundException $e) {
            // Handle model not found exception

            return redirect()->route('products.index')->with('error', 'Product not found.');
        } catch (\Exception $e) {
            // Handle general exceptions

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    /**
     * Remove Media of Product
     * @param Request $request
     */
    public function removeMedia(Request $request)
    {
        $input = $request->all();
        try {
            $salon = Product::find($input['id']);
            if ($salon->hasMedia($input['collection'])) {
                $salon->getFirstMedia($input['collection'])->delete();
            }
            $this->response(200,'success','Media removed',1);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $this->response(400,'error','Failed to remove media',0);
        }
    }
}
