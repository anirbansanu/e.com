@extends('layouts.app')
@section('title', 'Products')

@section('subtitle', 'Products')
@section('content_header_title', 'Products')
@section('content_header_subtitle', 'Manage Products')
@section('css')
@endsection
@section('content_body')
    <x-anilte::card headerClass="p-0 border-bottom-0 " bodyClass="" footerClass="custom-footer-class" minimize maximize
        close>
        <x-slot name="header">
            <x-anilte::tab-nav-item route="admin.products.listing.index" icon="fas fa-shield-alt">Product
                Listing
            </x-anilte::tab-nav-item>
            <x-anilte::tab-nav-item route="admin.products.listing.create" icon="fas fa-plus-square">Create Product
            </x-anilte::tab-nav-item>
        </x-slot>
        <x-slot name="body">
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('admin.products.store.stepOne') }}" method="post">
                        @csrf
                        @isset($product->id)
                            <input type="hidden" class="d-none" value="{{ old('product_id', $product->id) }}"
                                name="product_id" />
                        @endisset

                        <div class="mt-4">

                            <ul class="nav nav-tabs" id="tablist" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link {{ $step == 1 ? 'active' : '' }} {{ isset($step) ? '' : 'active' }}"
                                        id="product-details-tab"
                                        @if (isset($product)) href="{{ route('admin.products.listing.create', ['step' => 1, 'product_id' => $product]) }}" @else href="{{ route('admin.products.listing.create', ['step' => 1]) }}" @endif
                                        aria-selected="true">
                                        Product Details
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ $step == 2 ? 'active' : '' }}" id="variants_tab-tab"
                                        @if (isset($product)) href="{{ route('admin.products.listing.create', ['step' => 2, 'product_id' => $product]) }}" @else href="#variants_tab" @endif>
                                        Variants
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ $step == 3 ? 'active' : '' }}" id="stock-tab"
                                        @if (isset($product)) href="{{ route('admin.products.listing.create', ['step' => 3, 'product_id' => $product]) }}" @else href="#stock-tab-block" @endif>
                                        Stock
                                    </a>
                                </li>

                            </ul>
                            <div class="tab-content p-sm-2 p-lg-3 border-right border-left border-bottom"
                                id="tabListContent">
                                <div class="tab-pane fade active show" id="product-details" role="tabpanel"
                                    aria-labelledby="product-details-tab">

                                    <x-anilte::input-group id="name" name="name" :value="$product->name ?? ''"
                                        placeholder="Enter Name" :required="true" label="Name" icon="fas fa-user-tag" />
                                    @php
                                        $description_config = [
                                            'height' => '100',
                                            'toolbar' => [
                                                // [groupName, [list of button]]
                                                ['style', ['bold', 'italic', 'underline', 'clear']],
                                                ['font', ['strikethrough', 'superscript', 'subscript']],
                                                ['fontsize', ['fontsize']],
                                                ['color', ['color']],
                                                ['para', ['ul', 'ol', 'paragraph']],
                                                ['height', ['height']],
                                                //    ['table', ['table']],
                                                //    ['insert', ['link', 'picture', 'video']],
                                                //    ['view', ['fullscreen', 'codeview', 'help']],
                                                ['view', ['fullscreen']],
                                            ],
                                        ];
                                    @endphp
                                    <x-adminlte-text-editor name="description" label="Description" label-class=""
                                        igroup-size="sm" placeholder="Write some text..." :config="$description_config">
                                        @isset($product->description)
                                            {!! $product->description !!}
                                        @endisset

                                    </x-adminlte-text-editor>


                                    <x-anilte::select2
                                        name="category_id"
                                        id="category"
                                        label="Category"
                                        label-class=""
                                        select-class="custom-class another-class"
                                        igroup-size="lg"
                                        placeholder="Select an option of category..."
                                        ajaxRoute="{{ route('admin.products.categories.json') }}"
                                        :useAjax="true"
                                        :options="isset($product->category) ? [['id' => $product->category->id, 'text' => $product->category->name]] : []"

                                    />

                                    <x-anilte::select2
                                        name="brand_id"
                                        id="brand"
                                        label="Brand"
                                        label-class=""
                                        select-class="custom-class another-class"
                                        igroup-size="lg"
                                        placeholder="Select an option of brand..."
                                        ajaxRoute="{{ route('admin.products.brands.json') }}"
                                        :useAjax="true"
                                        :options="isset($product->brand) ? [['id' => $product->brand->id, 'text' => $product->brand->name]] : []"

                                    />




                                    <x-anilte::select2
                                        name="gender"
                                        id="gender"
                                        label="Gender"
                                        label-class=""
                                        select-class="custom-class another-class"
                                        igroup-size="lg"
                                        placeholder="Select an option of gender..."
                                        :useAjax="false"
                                        :options="[['id' => 'Female', 'text' => 'Female'], ['id' => 'Male', 'text' => 'Male'], ['id' => 'Male & Female', 'text' => 'Male & Female']]"
                                    />




                                    <x-adminlte-input-switch name="is_active" label="Status"
                                        class="d-flex justify-content-end" data-on-text="Active" data-off-text="Inactive"
                                        data-on-color="primary bg-gradient-blue" data-handle-width='51px'
                                        data-label-width='15px' igroup-size="sm" />
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Save & Next</button>
                                    </div>
                                </div>

                            </div>

                        </div>


                    </form>
                </div>

            </div>
        </x-slot>

    </x-anilte::card>



@endsection

