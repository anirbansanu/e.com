<?php

namespace App\Services\Products;

use App\Models\Combination;
use App\Models\Price;
use App\Models\Product;
// use App\Models\ProductToVariation;
// use App\Models\Stock;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
/**
 * Class ProductService.
 */
class ProductService
{

    public function getProducts(Request $request){
        $search = $request->input('search');
        $sort_by = $request->input('sort_by', 'updated_at');
        $sort_order = $request->input('sort_order', 'desc');
        $entries = $request->input('entries', config('app.pagination_limit'));

        $products = Product::where('is_active', 1)
            ->with([
                'category',
                'brand',
                // 'defaultStock.productPrice',
                // 'defaultStock.combinations'
            ])
            ->when($request->has('brand_id'), function ($query) use ($request) {
                $query->where('brand_id', $request->input('brand_id'));
            })
            ->when($request->has('category_id'), function ($query) use ($request) {
                $query->whereIn('category_id', $request->input('categories'));
            })
            ->when($request->has('min_price') && $request->has('max_price'), function ($query) use ($request) {
                // Assuming 'prices' table contains the price information
                $query->whereHas('defaultStock.productPrice', function ($subQuery) use ($request) {
                    $subQuery->whereBetween('price', [$request->input('min_price'), $request->input('max_price')]);
                });
            })
            ->when($request->has('gender'), function ($query) use ($request) {
                $query->where('gender', $request->input('gender'));
            })
            ->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            })
            ->orderBy($sort_by, $sort_order);

            if(auth()->user()->hasRole("Vendor"))
            $products = $products->where("added_by",auth()->id());

            $products = $products->paginate($entries);

        return $products;
    }
    public function getProductsForVendor(Request $request,$user_id){
        $search = $request->input('search');
        $sort_by = $request->input('sort_by', 'updated_at');
        $sort_order = $request->input('sort_order', 'desc');
        $entries = $request->input('entries', config('app.pagination_limit'));

        $products = Product::
            with([
                'category',
                'brand',
                'defaultStock.productPrice',
                'defaultStock.combinations'
            ])
            ->where("added_by",$user_id)
            ->when($request->has('brand_id'), function ($query) use ($request) {
                $query->where('brand_id', $request->input('brand_id'));
            })
            ->when($request->has('category_id'), function ($query) use ($request) {
                $query->whereIn('category_id', $request->input('categories'));
            })

            ->when($request->has('gender'), function ($query) use ($request) {
                $query->where('gender', $request->input('gender'));
            })
            ->when($request->has('search'),function ($q) use ($search) {
                if($search != "")
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            })
            ->orderBy($sort_by, $sort_order)->paginate($entries);

        return $products;
    }
    public function getProductById(Request $request,$id){
        $product = Product::with(['category','brand','productToVariations','stocks']);
        if(auth()->user()->hasRole("Vendor"))
            $product = $product->where("added_by",auth()->id());

        $product = $product->findOrFail($id);
        return $product;
    }
    public function createProduct($data, $uploadService)
    {

        switch ($data["step"]) {
            case 1:
                return $this->stepOne($data);
                break;
            case 2:
                return $this->stepTwo($data);
                break;
            case 3:
                return $this->stepThree($data);
                break;
            default:
                return null;
                break;
        }
    }
    public function stepOne($data) {
        if(isset($data["product_id"]) && $data["product_id"])
        {
            $product = $this->getById($data["product_id"]);

            $product->name = $data['name'];
            // $product->slug = $data['slug'];
            $product->description = $data['description'];
            $product->category_id = $data['category_id'];
            $product->brand_id = $data['brand_id'];
            $product->gender = $data['gender'];
            $product->feature = $data['feature'];
            $product->is_active = isset($data['is_active']) ? 1 : 0;
            $product->update();
            return $product;
        }
        else
        {
            $data['is_active'] = isset($data['is_active']) ? 1 : 0;
            $data['slug'] = Str::slug($data['name']). '-' . mt_rand(1000, 9999);
            $data['step'] = 1;
            $data['added_by']=auth()->id();
            $product = Product::create($data);
            return $product;
        }

    }
    // Here we place the product attributes sets and its attributes
    public function stepTwo($data) {
        $product = $this->getById($data["product_id"],["productToVariations"]);
        if($product->step < 2)
        {
            $product->step = 2;
            $product->update();
        }


        return $product;
    }
    // Here we place all product variants images
    public function stepThree($data)
    {
        $product = $this->getById($data["product_id"]);
        if($product->step < 3)
        {
            $product->step = 3;
            $product->update();
        }
        return $product;
    }

    // protected function generateUniqueSku($product, $variation)
    // {
    //     $baseSku = strtolower(str_replace(' ', '_', $product->name)); // Convert product name to lowercase and replace spaces with underscores
    //     $variantSku = strtolower(str_replace(' ', '_', $variation->variant_value)); // Convert variation value to lowercase and replace spaces with underscores
    //     $uniqueId = uniqid(); // Generate a unique identifier

    //     // Concatenate base SKU, variant SKU, and unique identifier
    //     $sku = $baseSku . '_' . $variantSku . '_' . $uniqueId;

    //     // Ensure SKU is unique
    //     while (Stock::where('sku', $sku)->exists()) {
    //         $uniqueId = uniqid(); // Generate a new unique identifier
    //         $sku = $baseSku . '_' . $variantSku . '_' . $uniqueId;
    //     }

    //     return $sku;
    // }


    public function getById($id,$relations=[]){
        if(count($relations)>0)
        $p = Product::with($relations);
        else
        $p = new Product;

        if(auth()->user()->hasRole("Vendor"))
        $p = $p->where("added_by",auth()->id());

        $p = $p->findOrFail($id);
        return $p;
    }

    public function productHasVariations($product_id){

        $product = $this->getById($product_id,['productToVariations']);

        $hasVariations = $product->variations()->exists();

        return $hasVariations;
    }
    public function deleteProduct($id)
    {
        $product = $this->getById($id);
        if ($product) {
            $product->delete();
        }
    }

}
