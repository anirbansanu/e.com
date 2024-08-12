@extends('layouts.app')
@section('title', 'Products')

@section('subtitle', 'Products')
@section('content_header_title', 'Products')
@section('content_header_subtitle', 'Manage Products')
@section('css')
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />

@endsection
@section('content_body')
    <x-anilte::card headerClass="p-0 border-bottom-0 " bodyClass="" footerClass="custom-footer-class" minimize maximize close>
        <x-slot name="header">
            <x-anilte::tab-nav-item route="admin.products.listing.index" icon="fas fa-shield-alt">Product
                Listing
            </x-anilte::tab-nav-item>
            <x-anilte::tab-nav-item route="admin.products.listing.create" icon="fas fa-plus-square">
                Create Product
            </x-anilte::tab-nav-item>
            <x-anilte::tab-nav-item route="admin.products.listing.edit" routeParams="{{ $product->id }}" icon="fas fa-plus-square">
                Edit Product
            </x-anilte::tab-nav-item>
        </x-slot>
        <x-slot name="body">
            <div class="row">
                <div class="col-md-12">

                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <ul class="nav nav-tabs" id="tablist" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link {{ $step == 1 ? 'active' : '' }} {{ isset($step) ? '' : 'active' }}"
                                    id="product-details-tab"
                                    href="{{ route('admin.products.listing.edit', ['listing' => $product, 'step' => 1]) }}"
                                    aria-selected="true">
                                    Product Details
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $step == 2 ? 'active' : '' }}" id="variants_tab-tab"
                                    href="{{ route('admin.products.listing.edit', ['listing' => $product, 'step' => 2]) }}">
                                    Variants
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $step == 3 ? 'active' : '' }}" id="stock-tab"
                                    href="{{ route('admin.products.listing.edit', ['listing' => $product, 'step' => 3]) }}">
                                    Stock
                                </a>
                            </li>

                        </ul>
                        <div class="tab-content p-sm-2 p-lg-3 border-right border-left border-bottom" id="tabListContent">
                            <form action="{{ route('admin.products.listing.create') }}" method="post">
                                @csrf
                                @method('post')
                                <div class="tab-pane fade active show" id="stock-tab-block" role="tabpanel"
                                    aria-labelledby="custom-content-below-profile-tab">
                                    <div class="card border-0 shadow-none">
                                        <div class="card-header">
                                            <div class="d-flex justify-content-between">
                                                <span class="card-title">
                                                    <span class="w-100 h5">Product Stock</span>
                                                    <br />
                                                    <span class="w-100 "><small>Add combinations of variations with
                                                            stock</small></span>
                                                </span>
                                                <div class="card-tools m-0">
                                                    <button type="button" class="btn btn-sm btn-primary " data-toggle="modal"
                                                        data-target="#productStockModal" title="Add Variation">
                                                        <i class="fas fa-plus"></i>
                                                        ADD
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body" id="stockTableContainer">
                                            <x-anilte::ajax-datatable
                                                id="{{'stockTable'}}"
                                                :columns="[
                                                    [
                                                        'data' => 'combosInString',
                                                        'title' => 'Combinations',
                                                        
                                                    ],
                                                    ['data'=>'price','title'=>'Price'],
                                                    ['data'=>'sku','title'=>'SKU'],
                                                    ['data'=>'quantity','title'=>'Quantity'],
                                                    ['data'=>'updated_at','title'=>'Updated At']
                                                ]"
                                                fetch-url="{{ route('admin.products.stocks.byproduct',['slug'=>$product->slug]) }}"
                                                delete-url="{{url('admin/products/stocks/{id}')}}"
                                                :action-buttons="'<button class=\'btn btn-sm edit-ajax btn-primary\' data-toggle=\'modal\' data-target=\'#productsVariantsUpdateModal\' :data>Edit</button>
                                                    <button class=\'btn btn-sm delete-ajax btn-danger sweet-delete-btn\' :data>Delete</button>'"
                                                :page-size="10"
                                            />
                                        </div>
                                        <x-anilte::loader.round-loader />

                                    </div> <!-- /add Product Variantions card -->


                                </div>
                            </form>
                        </div>

                </div>

            </div>


        </x-slot>
    </x-anilte::card>
@endsection
@push('modals')
    <x-anilte::modals.ajax-modal id="productStockModal" size="modal-xl" form-id="productStockModalForm" method="post" action="{{ route('admin.products.stocks.store') }}" title="Add Stock" button-id="submitBtn">
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <div class="row">


                @php
                    $groupByVariants = $product->groupByVariants();
                @endphp
                @forelse ($groupByVariants as $key=>$variants)

                    @php
                        $variantsdata = json_decode($variants, true);
                        $select2_options = array_map(function($item) {
                            return [
                                'id' => $item['id'],
                                'text' => $item['attribute_value'] . ' ' . $item['unit_name']
                            ];
                        }, $variantsdata);

                    @endphp
                    <div class="col-md-4 col-lg-3">
                        <x-anilte::select2
                            name="combinations[{{$key}}]"
                            id="{{$key}}"
                            label="{{ $key }}"
                            label-class="text"
                            select-class="custom-class another-class"
                            igroup-size="lg"
                            placeholder="Select {{ $key }}..."
                            :options="$select2_options"
                            :template="['id' => 'id', 'text' => 'text']"
                        />
                    </div>
                @empty
                    No Variants
                @endforelse


            <div class="col-md-6 col-lg-4">
                <x-anilte::input-group
                    id="sku"
                    name="sku"
                    label="SKU"
                    value=""
                    placeholder="Enter SKU"
                    :required="true" icon="fas fa-keyboard"
                />
            </div>
            <div class="col-md-6 col-lg-4">
                <x-anilte::input-group
                    id="price"
                    name="price"
                    label="Price"
                    value=""
                    placeholder="Enter price"
                    :required="true"
                    icon="fas fa-keyboard"
                />
            </div>
            <div class="col-md-6 col-lg-4">
                <x-anilte::input-group
                    id="quantity"
                    name="quantity"
                    label="Quantity"
                    value=""
                    placeholder="Enter quantity"
                    :required="true"
                    icon="fas fa-keyboard"
                />
            </div>
            <div class="col-md-6 col-lg-4">
                <x-adminlte-input-switch
                    name="is_active"
                    label="Status"
                    class="d-flex justify-content-end"
                    data-on-text="Active"
                    data-off-text="Inactive"
                    data-on-color="primary bg-gradient-blue"
                    data-handle-width='51px'
                    data-label-width='15px'
                    igroup-size="sm"
                />
            </div>
            <div class="col-12">
                {{-- <x-anilte::medias.dropzone id="createDropzone" url="{{ route('medias.create') }}" max-files="5" :existing-files="[]" /> --}}
                <x-anilte.form.dropzone
                    id="create-dropzone"
                    url="{{ route('medias.create') }}"
                    max-files="5"
                    field="image"
                    :is-multiple="true"
                    removeUrl="{{ route('medias.delete') }}"
                    collection="image"
                    :existing="[]"
                />
            </div>
        </div>
    </x-anilte::modals.ajax-modal>

    <x-anilte::modals.ajax-modal id="productStockUpdateModal" size="modal-xl" form-id="productStockUpdateModalForm" method="put" action="{{ url('admin/products/stocks/{sku}') }}" title="Edit Stock" button-id="update-submitBtn">
        <input type="hidden" name="product_id" id="update-product-id" value="{{ $product->id }}"
                        data-product-name="{{ $product->name }}" />
        <div class="row">
            @php
                $groupByVariants = $product->groupByVariants();
            @endphp
            @forelse ($groupByVariants as $key=>$item)
                <div class="col-md-6 col-lg-4">
                    <div class="form-group">
                        <label for="{{ $key }}">{{ $key }}</label>
                        <select class="form-control select2-single"
                            data-placeholder="{{ 'Select ' . $key }}"
                            id="update-combinations-{{ $key }}"
                            name="combinations[{{ $key }}]">
                            <option value="">{{ 'Select ' . $key }}</option>
                            @forelse ($item as $element)
                                <option value="{{ $element->id }}"
                                    data-suggestive-sku="{{ substr($element->variant_name, 0, 1) }}{{ $element->variant_value }}">
                                    {{ $element->variant_name . ' ' . $element->variant_value . ' ' . $element->unit_name }}
                                </option>
                            @empty
                            @endforelse

                        </select>
                        @error('variant_id')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            @empty
                No Variants
            @endforelse
            <div class="col-md-6 col-lg-4">
                <div class="mb-3 position-relative">
                    <label class="form-label" for="sku">
                        SKU
                    </label>
                    <input class="form-control" type="text" name="sku" id="update-sku"
                        placeholder="Enter sku">
                </div>

                <label class="form-check">
                    <input type="checkbox" name="auto_generate_sku" class="form-check-input ">
                    <span class="form-check-label">
                        Auto generate SKU?
                    </span>
                </label>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="text" class="form-control" name="price" id="update-price"
                        placeholder="Enter price">
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="text" class="form-control" name="quantity" id="update-quantity"
                        placeholder="Enter quantity">
                </div>
            </div>
            <div class="col-12">
                <x-anilte.form.dropzone
                    id="edit-dropzone"
                    url="{{ route('medias.create') }}"
                    max-files="5"
                    field="image"
                    :is-multiple="true"
                    removeUrl="{{ route('medias.delete') }}"
                    collection="image"
                    :existing="[]"
                />
            </div>
        </div>

    </x-anilte::modals.ajax-modal>
@endpush
@push('js')

@endpush
