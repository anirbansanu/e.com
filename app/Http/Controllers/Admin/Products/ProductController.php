<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\ProductToVariation;
use App\Models\Upload;
use App\Services\ProductService;
use App\Services\UploadService;
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

            $query = $request->input('query');
            $sort_by = $request->input('sort_by', 'updated_at');
            $sort_order = $request->input('sort_order', 'desc');
            $products = Product::with(['productToVariations','defaultStock.productPrice'])
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                    ->orWhere('description', 'like', '%' . $query . '%');
            })
            ->orderBy($sort_by, $sort_order)
            ->paginate(config('app.pagination_limit'));

            $products->appends(['query' => $query, 'sort_by' => $sort_by, 'sort_order' => $sort_order]);

            return view('admin.products.index', compact('products',"query","sort_by","sort_order"));
        } catch (\Exception $e) {
            // Handle general exceptions
            toast($e->getMessage(),'error');
            return redirect()->back()->with('error', 'An error occurred.');
        }
    }

    public function create(Request $request)
    {
        try {
            $step = $request->get('step',1);
            switch ($step) {
                case 1:
                    if($request->has("product_id"))
                    {
                        $product = $this->productService->getById($request->get("product_id"));
                        return view('admin.products.product_listing.create.step_1',compact('product','step'));
                    }
                    return view('admin.products.product_listing.create.step_1',compact('step'));
                    break;
                case 2:
                    if($request->has("product_id"))
                    {
                        $product = $this->productService->getById($request->get("product_id"),["productToVariations"]);

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
                        $product = $this->productService->getById($request->get("product_id"),["productToVariations"]);
                        // Check if the product has any variations

                        if($product->has_variations)
                        {
                            return view('admin.products.product_listing.create.step_3',compact('product','step'));
                        }
                        else
                        {
                            toast("Please add variations before proceeding.", 'warning');
                            return redirect()->route('products.create',["step"=>2,"product_id"=>$product->id]);
                        }

                    }
                    else
                    {
                        toast("Please add basic details before proceeding.", 'warning');
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
            toast($e->getMessage(), 'error');
            return redirect()->back()->with('error', 'An error occurred.');
        }
    }

    public function storeStepOne(ProductRequest $request){

        try {
            $product = $this->productService->stepOne($request->all());
            toast('Basic details saved successfully. Now, please add variants.', 'success');
            return redirect()->route('products.create',["step"=>2,"product_id"=>$product->id])->with('success', 'Product created successfully.');

        } catch (\Exception $e) {
            toast($e->getMessage(), 'error');
            return redirect()->back();
        }
    }
    public function storeStepTwo(Request $request){
        try {
            
            $product = $this->productService->stepTwo($request->all());
            toast('Variations saved successfully. Now, please complete step 3.', 'success');
            return redirect()->route('products.create',["step"=>3,"product_id"=>$product->id]);

        } catch (\Exception $e) {
            toast('Failed to save step 2: ' . $e->getMessage(), 'error');
            return redirect()->route('products.create',["step"=>1])->with('error', 'An error occurred.');
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
                toast('Product created successfully.', 'success');
                return redirect()->route('products.index');
            }
            else {
                toast("Please add stocks before proceeding.", 'warning');
                return redirect()->back();
            }

        }  catch (\Illuminate\Validation\ValidationException $e) {
            toast($e->validator->errors()->first());
            return redirect()->back();
        } catch (\Exception $e) {
            toast('Failed to create product: ' . $e->getMessage(), 'error');
            return redirect()->route('products.create',["step"=>2,'product_id'=>$request->get('product_id')])->with('error', 'An error occurred.');
        }
    }


    public function show($id)
    {
        try {
            $product = Product::findOrFail($id);
            return view('admin.products.show', compact('product'));
        } catch (ModelNotFoundException $e) {
            // Handle model not found exception
            toast('Product not found','error');
            return redirect()->route('products.index')->with('error', 'Product not found');
        } catch (\Exception $e) {
            // Handle general exceptions
            toast($e->getMessage(),'error');
            return redirect()->back()->with('error', 'An error occurred.');
        }
    }

    public function edit(Request $request,$id)
    {
        try {
            $step = $request->get('step',1);
            switch ($step) {
                case 1:
                    $product = $this->productService->getById($id);
                    return view('admin.products.product_listing.edit.step_1',compact('product','step'));
                    break;
                case 2:
                    $product = $this->productService->getById($id,["productToVariations"]);
                    return view('admin.products.product_listing.edit.step_2',compact('product','step'));
                    break;
                case 3:
                    $product = $this->productService->getById($id,["productToVariations"]);
                    // Check if the product has any variations

                    if($product->has_variations)
                    {
                        return view('admin.products.product_listing.edit.step_3',compact('product','step'));
                    }
                    else
                    {
                        toast("Please add variations before proceeding.", 'warning');
                        return redirect()->route('products.edit',["id"=>$product->id,"step"=>2]);
                    }
                    break;
                default:
                    return view('admin.products.product_listing.edit.step_1');
                    break;
            }
            return view('admin.products.product_listing.edit.step_1');
        }
        catch (ModelNotFoundException $e) {
            toast('Product not found','error');
            // Handle model not found exception
            return redirect()->route('products.index')->with('error', 'Product not found');
        }
        catch (\Exception $e) {
            // Handle general exceptions
            toast($e->getMessage(), 'error');
            return redirect()->back()->with('error', 'An error occurred.');
        }

    }
    public function editStepOne(ProductRequest $request){
        try {
            $product = $this->productService->stepOne($request->all());
            toast('Basic details updated successfully. Now, please add variants.', 'success');
            return redirect()->route('products.edit',["id"=>$product->id,"step"=>2])->with('success', 'Product created successfully.');

        } catch (\Exception $e) {
            toast($e->getMessage(), 'error');
            return redirect()->back();
        }
    }
    public function editStepTwo(Request $request){
        try {

            $product = $this->productService->stepTwo($request->all());
            toast('Variations updated successfully. Now, please complete step 3.', 'success');
            return redirect()->route('products.edit',["id"=>$product->id,"step"=>3]);

        } catch (\Exception $e) {
            toast('Failed to update step 2: ' . $e->getMessage(), 'error');
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
                toast('Product updated successfully.', 'success');
                return redirect()->route('products.index');
            }
            else {
                toast("Please add stocks before proceeding.", 'warning');
                return redirect()->back();
            }

        }  catch (\Illuminate\Validation\ValidationException $e) {
            toast($e->validator->errors()->first());
            return redirect()->back();
        } catch (\Exception $e) {
            toast('Failed to update product: ' . $e->getMessage(), 'error');
            return redirect()->back()->with('error', 'An error occurred.');
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
                $product->productToVariations()->delete();
                foreach ($request->variantions['variation_id'] as $index => $variant) {


                    $v = new ProductToVariation;
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

            toast('Product updated successfully', 'success');
            return redirect()->route('products.index')->with('success', 'Product updated successfully.');
        } catch (ValidationException $e) {
            // Handle validation errors
            DB::rollBack();
            toast($e->getMessage(), 'error');
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
        catch (ModelNotFoundException $e) {
            toast('Product not found','error');
            // Handle model not found exception
            return redirect()->route('products.index')->with('error', 'Product not found.');
        }
        catch (\Exception $e) {
            // Handle general exceptions
            DB::rollBack();
            toast($e->getMessage(), 'error');
            return redirect()->back()->with('error', 'An error occurred.');
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
            toast('Product not found','error');
            return redirect()->route('products.index')->with('error', 'Product not found.');
        } catch (\Exception $e) {
            // Handle general exceptions
            toast($e->getMessage(),'error');
            return redirect()->back()->with('error', 'An error occurred.');
        }
    }

    public function trash(Request $request)
    {
        try {
            $query = $request->input('query');
            $sort_by = $request->input('sort_by', 'updated_at');
            $sort_order = $request->input('sort_order', 'desc');
            $products = Product::onlyTrashed()
                                ->where(function ($q) use ($query) {
                                    $q->where('name', 'like', '%' . $query . '%')
                                        ->orWhere('description', 'like', '%' . $query . '%');
                                })
                                ->orderBy($sort_by, $sort_order)
                                ->paginate(config('app.pagination_limit'));

            $products->appends(['query' => $query, 'sort_by' => $sort_by, 'sort_order' => $sort_order]);
            return view('admin.products.trash', compact('products',"query","sort_by","sort_order"));
        } catch (\Exception $e) {
            // Handle general exceptions
            toast($e->getMessage(),'error');
            return redirect()->back()->with('error', 'An error occurred.');
        }
    }

    public function untrash($id)
    {
        try {
            $product = Product::withTrashed()->findOrFail($id);
            $product->restore();

            return redirect()->route('products.index')->with('success', 'Product restored successfully.');
        } catch (ModelNotFoundException $e) {
            toast('Product not found','error');
            // Handle model not found exception
            return redirect()->route('products.index')->with('error', 'Product not found.');
        } catch (\Exception $e) {
            // Handle general exceptions
            toast($e->getMessage(),'error');
            return redirect()->back()->with('error', 'An error occurred.');
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
            toast('Product not found','error');
            return redirect()->route('products.index')->with('error', 'Product not found.');
        } catch (\Exception $e) {
            // Handle general exceptions
            toast($e->getMessage(),'error');
            return redirect()->back()->with('error', 'An error occurred.');
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
