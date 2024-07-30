@extends('layouts.app')
@section('title', 'Products')

@section('subtitle', 'Products')
@section('content_header_title', 'Products')
@section('content_header_subtitle', 'Manage Products')
@section('css')
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
                    <form action="{{ route('admin.products.listing.create') }}" method="post">
                        @csrf
                        @method('post')
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

                            <div class="tab-pane fade active show" id="variants_tab" role="tabpanel"
                                aria-labelledby="custom-content-below-profile-tab">
                                <div class="card border-0 shadow-none">
                                    <div class="card-header">
                                        <div class="d-flex justify-content-between">
                                            <span class="card-title">
                                                <span class="w-100 h5">Product Variants</span>
                                                <br />
                                                <span class="w-100 "><small>Add product variants like size, color, weight
                                                        and others</small></span>
                                            </span>
                                            <div class="card-tools m-0">
                                                <button type="button" class="btn btn-sm btn-primary " data-toggle="modal" data-target="#productsVariantsModal" title="Add Variant">
                                                    <i class="fas fa-plus"></i>
                                                    ADD
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body" id="variant-table-container">

                                        <x-anilte::ajax-datatable
                                            id="{{'ProductVariantsTable'}}"
                                            :columns="[['data'=>'attribute_name','title'=>'Attribute Name'],['data'=>'attribute_value','title'=>'Attribute Value'], ['data'=>'unit_name','title'=>'Unit Name'], ['data'=>'updated_at','title'=>'Updated At']]"
                                            fetch-url="{{ route('admin.products.variants.byproduct',['slug'=>$product->slug]) }}"
                                            delete-url="{{url('admin/products/variants/{id}')}}"
                                            :action-buttons="'<button class=\'btn btn-sm edit-ajax btn-primary\' data-toggle=\'modal\' data-target=\'#productsVariantsUpdateModal\' :data>Edit</button>
                                                <button class=\'btn btn-sm delete-ajax btn-danger sweet-delete-btn\' :data>Delete</button>'"
                                            :page-size="10"
                                        />

                                    </div>
                                </div> <!-- /add Product Attributeions card -->

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Update & Next</button>
                                </div>
                            </div>

                        </div>

                    </form>
                </div>
            </div>
        </x-slot>
    </x-anilte::card>

    <x-anilte::modals.ajax-modal id="productsVariantsModal" form-id="add_variant" method="post" action="{{ route('admin.products.variants.store') }}" title="Add Variant" button-id="submitBtn">
            <input type="hidden" name="product_id" value="{{ $product->id }}">

            <x-anilte::select2 name="attribute_name" id="attribute_name" label="Attribute" label-class=""
                select-class="custom-class another-class" igroup-size="lg"
                placeholder="Select an option of attribute..."
                ajaxRoute="{{ route('admin.products.attributes.json') }}" :useAjax="true" :options="[]"
                :template="['id' => 'name', 'text' => 'name']"
            />
            <x-anilte::input-group id="attribute_value" name="attribute_value" label="Attribute Value"
                value="" placeholder="Enter Attribute Value" :required="true" icon="fas fa-keyboard" />

            <x-anilte::select2 name="unit_name" style="display: none;" id="unit_name" label="Units" label-class=""
                select-class="custom-class another-class" igroup-size="lg"
                placeholder="Select an option of unit name..."
                ajaxRoute="{{ route('admin.products.units.json') }}"
                :useAjax="true"
                :options="[]"
                :template="['id' => 'name', 'text' => 'name']"
            />

    </x-anilte::modals.ajax-modal>

    <x-anilte::modals.ajax-modal id="productsVariantsUpdateModal" form-id="update_variant" method="PUT" action="{{ url('admin/products/variants/{id}') }}" title="Update Variant" button-id="updateBtn">
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <x-anilte::select2
            name="attribute_name"
            id="update_attribute_name"
            label="Attribute"
            label-class=""
            select-class=""
            igroup-size="lg"
            placeholder="Select an option of attribute..."
            ajaxRoute="{{ route('admin.products.attributes.json') }}"
            :useAjax="true"
            :options="[]"
            :template="['id' => 'name', 'text' => 'name']"
        />
        <x-anilte::input-group
            id="update_attribute_value"
            name="attribute_value"
            label="Attribute Value"
            value=""
            placeholder="Enter Attribute Value"
            :required="true"
            icon="fas fa-keyboard"
        />
        <x-anilte::select2
            name="unit_name"
            id="update_unit_name"
            label="Units"
            label-class=""
            select-class=""
            igroup-size="lg"
            placeholder="Select an option of unit name..."
            ajaxRoute="{{ route('admin.products.units.json') }}"
            :useAjax="true"
            :options="[]"
            :template="['id' => 'name', 'text' => 'name']"
        />
    </x-anilte::modals.ajax-modal>
@endsection
@push('js')

<script>
    $( document ).ready(function () {
        console.log("ProductVariantsTable",{{"ProductVariantsTable"}});
        console.log("productsVariantsModal",{{"productsVariantsModal"}});
        console.log("productsVariantsUpdateModal",{{"productsVariantsUpdateModal"}});

        productsVariantsUpdateModal.addSuccessEvent(() => {
            console.log('fetchData() callback executed from productsVariantsUpdateModal');
            ProductVariantsTable.fetchData();
        });
        productsVariantsModal.addSuccessEvent(()=>{
            console.log('fetchData() callback executed from productsVariantsModal');
            ProductVariantsTable.fetchData();
        });

    });

</script>

@endpush
