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
                                    Attributes
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
                                                <span class="w-100 h5">Product Attributeions</span>
                                                <br />
                                                <span class="w-100 "><small>Add product variants like size, color, weight
                                                        and others</small></span>
                                            </span>
                                            <div class="card-tools m-0">
                                                <button type="button" class="btn btn-sm btn-primary " data-toggle="modal" data-target="#products-variants-modal" title="Add Variant">
                                                    <i class="fas fa-plus"></i>
                                                    ADD
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body" id="variant-table-container">
                                        <x-anilte::ajax-datatable
                                            :columns="[['data'=>'attribute_name','title'=>'Attribute Name'],['data'=>'attribute_value','title'=>'Attribute Value'], ['data'=>'unit_name','title'=>'Unit Name'], ['data'=>'updated_at','title'=>'Updated At']]"
                                            fetch-url="{{ route('admin.products.variants.index') }}"
                                            :action-buttons="
                                                '<button class=\'btn btn-sm btn-primary\' data-toggle=\'modal\' data-target=\'#products-variants-update-modal\' :data>Edit</button>
                                                <button class=\'btn btn-sm btn-danger\' :data>Delete</button>'"
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

    <div class="modal fade" id="products-variants-modal">
        <form class="modal-dialog modal-lg" id="add_variant" data-action="{{ route('admin.products.variants.store') }}"
            data-method="post">
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Variant</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

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
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitBtn" data-form="#add_variant">Add</button>
                </div>
            </div>
        </form>
    </div>
    {{-- <div class="modal fade" id="products-variants-update-modal">
        <form class="modal-dialog modal-lg" id="update_variant" data-method="post"
            data-action="{{ route('admin.products.variants.store') }}">
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update Variant</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="">
                            <label for="attribute_name">Attribute</label>
                            <select class="form-control attribute_name select2" name="attribute_name"
                                id="update_attribute_name">

                            </select>
                            @error('attribute_name')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <x-anilte::select2 name="attribute_name" id="update_attribute_name" label="Attribute" label-class=""
                        select-class="custom-class another-class" igroup-size="lg"
                        placeholder="Select an option of attribute..."
                        ajaxRoute="{{ route('admin.products.attributes.json') }}" :useAjax="true" :options="[]" />

                    <x-anilte::input-group id="update_attribute_value" name="attribute_value" label="Attribute Value"
                        value="" placeholder="Enter Attribute Value" :required="true" icon="fas fa-keyboard" />
                    <x-anilte::select2 name="unit_name" id="update_unit_name" label="Units" label-class=""
                        select-class="custom-class another-class" igroup-size="lg"
                        placeholder="Select an option of unit name..."
                        ajaxRoute="{{ route('admin.products.units.json') }}" :useAjax="true" :options="[]" />
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="updateBtn"
                        data-form="#update_variant">Update</button>
                </div>
            </div>
        </form>
    </div> --}}
    <x-anilte::modals.ajax-modal id="products-variants-update-modal" form-id="update_variant" method="post" action="{{ route('admin.products.variants.store') }}" title="Update Variant" button-id="updateBtn">
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <x-anilte::select2 name="attribute_name" id="update_attribute_name" label="Attribute" label-class="" select-class="" igroup-size="lg" placeholder="Select an option of attribute..." ajaxRoute="{{ route('admin.products.attributes.json') }}" :useAjax="true" :options="[]" />
        <x-anilte::input-group id="update_attribute_value" name="attribute_value" label="Attribute Value" value="" placeholder="Enter Attribute Value" :required="true" icon="fas fa-keyboard" />
        <x-anilte::select2 name="unit_name" id="update_unit_name" label="Units" label-class="" select-class="" igroup-size="lg" placeholder="Select an option of unit name..." ajaxRoute="{{ route('admin.products.units.json') }}" :useAjax="true" :options="[]" />
    </x-anilte::modals.ajax-modal>
@endsection
@push('js')
    {{-- <script src="{{ asset('admin/plugins/jquery-validation/jquery.validate.min.js') }}"></script> --}}
    <script src="{{asset("anilte/ajax-form-handler.js")}}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            new AjaxFormHandler('#products-variants-modal', '#add_variant', '#submitBtn');
        });
    </script>
    {{-- @include('admin.products.product_listing.create.step_2_js') --}}

{{-- <script>
    // Usage example:
    const productToVariantDataTable = new AjaxDataTable(
        '{{route("admin.productVariants.ajax.getByProductId")}}/?product_id={{$product->id}}',
        '#productToVariantTableBody',
        [
            { field: '#' },
            { field: 'variant_name' },
            { field: 'variant_value' },
            { field: 'unit_name' },
            { field: 'action' }
        ],
        {
            customActions: [
                { label: `<i class="fas fa-pencil-alt "></i> Edit`, buttonClass: 'btn btn-info mr-2 edit', attributes: `href="{{url('admin/product-variations/ajax/edit')}}" data-modal="#product-to-variants-update-modal"` },
                { label: '<i class="fas fa-trash "></i> Delete', buttonClass: 'btn btn-danger mr-2 delete', attributes: `href="{{url('admin/product-variations/ajax/delete')}}"` }
            ]
        }
    );
    // Fetch data and render it in the table
    productToVariantDataTable.fetchDataAndRender();

    $(document).on('click','.edit',function (ev) {
        ev.preventDefault();
        loading($(this).data('modal'),'show');
        $($(this).data('modal')).modal('show');
        $.ajax({
            url: $(this).attr('href')+"/"+$(this).data('item-id'),
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // If the request is successful, populate the update modal with the retrieved stock data
                    populateUpdateModal($(this).data('modal'),response.data);

                    // toastr["success"](response.message);
                } else {
                    // If the request fails, toastr the error message
                    toastr["error"](response.message);
                }
            },
            error: function(xhr, status, error) {
                toastr["error"](xhr.responseJSON.message);
            },
            complete: () => {
                // Hide loading overlay
                setTimeout(() => {

                    loading($(this).data('modal'),'hide');

                    // Hide loading overlay here
                }, 400);

            }

        });
    });
    $(document).on('click','.delete',function (ev) {
        ev.preventDefault();

        $($(this).data('modal')).modal('show');
        $.ajax({
            url: $(this).attr('href')+"/"+$(this).data('item-id'),
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // If the request is successful, populate the update modal with the retrieved stock data
                    productToVariantDataTable.fetchDataAndRender();
                    toastr["success"](response.message);

                    // toastr["success"](response.message);
                } else {
                    // If the request fails, toastr the error message
                    toastr["error"](response.message);
                }
            },
            error: function(xhr, status, error) {
                toastr["error"](xhr.responseJSON.message);
            }


        });
    });
    function populateUpdateModal(modalId,item) {
        console.log("populateUpdateModal");

        let url = "{{url('admin/product-variations/ajax/update/')}}"+"/"+item.id;
        console.log(url);
        $("#update_variant").attr('data-action',url);
        if(item.has_unit)
        {

            $('#update_unit_id').closest('.form-group').show();

            $('#update_unit_id').val(item.unit_id);
            var $option = $(`<option selected '></option>`).val(item.unit_id).text(item.unit_name);
            $('#update_unit_id').html('');
            $('#update_unit_id').append($option).trigger('change');
        }
        else
        {
            $('#update_unit_id').closest('.form-group').hide();
            $('#update_unit_id').val(null).trigger('change');
        }
        console.log("has_unit",item.has_unit);
        $('#update_attribute_name').html('');
        var $option1 = $('<option selected ></option>').val(item.variation_id).text(item.variant_name);
        $option1.data('has-unit',item.has_unit);
        $('#update_attribute_name').append($option1).trigger('change');

        $('#update_variant_value').val(item.variant_value);

    }
    function loading(selector,$status="show"){
            let el = $(selector + " .modal-content");
            if($status=="hide")
                el.find('.overlay').remove();
            else
                el.append(`<div class="overlay dark"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>`);
    }

    $(document).on('hidden.bs.modal','.modal', function () {
        $(this).find('form').trigger('reset');

        $(this).find("select[name='attribute_name']").val(null).trigger('change');
        $(this).find("select[name='unit_id']").val(null).trigger('change');
    });
    $(document).ready(function() {
        $("#submitBtn").click(function(ev) {
            ev.preventDefault();
            submitFormAjax($(this).data('form'), function(data) {
                // Success callback function

                $('#product-to-variants-modal').modal('hide');
                productToVariantDataTable.fetchDataAndRender();
            }, function(data) {
                // Error callback function
                console.log("Form submission failed!");

            });
        });
        $("#updateBtn").click(function(ev) {
            ev.preventDefault();
            submitFormAjax($(this).data('form'), function(data) {
                // Success callback function

                $('#product-to-variants-update-modal').modal('hide');
                productToVariantDataTable.fetchDataAndRender();
            }, function(data) {
                // Error callback function
                console.log("Form submission failed!");

            });
        });

    });
</script> --}}
@endpush
