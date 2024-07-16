@extends('admin.layouts.app')
@section('title')
    Add Product
@endsection
@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{asset('admin/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('admin/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css')}}">
<link rel="stylesheet" href="{{asset('admin/plugins/bs-stepper/css/bs-stepper.min.css')}}">
{{-- DropZone css  --}}
<link rel="stylesheet" href="{{asset('admin/plugins/dropzone/dropzone.css')}}" />
@endsection
@section('content')
    <div class="content-wrapper pt-3">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{route('admin.products.listing.store.stepTwo')}}" method="post">
                            @csrf
                            @method("post")
                            <input type="hidden" name="product_id" value="{{$product->id}}">
                            <div class="card card-primary card-tabs">
                                <div class="card-header  p-0 pt-1">
                                    <div class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                        <x-tabs.nav-item route="admin.products.listing.index" icon="fas fa-list-alt ">Product List</x-tabs.nav-item>
                                        <x-tabs.nav-item route="admin.products.listing.create" icon="fas fa-plus-square">Add Product</x-tabs.nav-item>
                                        <x-tabs.nav-item route="admin.products.listing.trash" icon="fas fa-trash">Trash List</x-tabs.nav-item>
                                    </div>
                                </div>
                                <div class="card-body mt-4">

                                    <ul class="nav nav-tabs" id="tablist" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link {{$step==1?"active":""}} {{isset($step)?"":"active"}}" id="product-details-tab" @if(isset($product)) href="{{route('admin.products.listing.create',["step"=>1,"product_id"=>$product])}}" @else href="{{route('admin.products.listing.create',["step"=>1])}}" @endif aria-selected="true">
                                                Product Details
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{$step==2?"active":""}}" id="variants_tab-tab"  @if(isset($product)) href="{{route('admin.products.listing.create',["step"=>2,"product_id"=>$product])}}" @else href="#variants_tab" @endif >
                                                Variants
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{$step==3?"active":""}}" id="stock-tab" @if(isset($product)) href="{{route('admin.products.listing.create',["step"=>3,"product_id"=>$product])}}" @else href="#stock-tab-block" @endif >
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
                                                            <span class="w-100 h5">Product Variantions</span>
                                                            <br/>
                                                            <span class="w-100 "><small>Add product variants like size, color, weight and others</small></span>
                                                        </span>
                                                        <div class="card-tools m-0">
                                                            <button type="button" class="btn btn-sm btn-primary " data-toggle="modal" data-target="#product-to-variantions-modal" title="Add Variation">
                                                            <i class="fas fa-plus"></i>
                                                            ADD
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body" >
                                                    <table class="table table-hover text-nowrap border">
                                                        <thead class="border-top">
                                                            <tr>
                                                                <th>Sl no.</th>
                                                                <th>Name </th>
                                                                <th>Value</th>
                                                                <th>Unit</th>
                                                                <th style="width: 200px">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="productToVariationTableBody">

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div> <!-- /add Product Variantions card -->

                                            <div class="d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary">Save & Next</button>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="modal fade" id="product-to-variantions-modal">
        <form class="modal-dialog modal-lg" id="add_variant" data-action="{{route('admin.productVariations.ajax.store')}}" data-method="post">
            <input type="hidden" name="product_id" value="{{$product->id}}">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Variation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="">
                            <label for="variant_id">Variant</label>
                            <select class="form-control variant_id select2" name="variant_id" id="variant_id">
                                <option value="">Select Variant</option>
                            </select>
                            @error('variant_id')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">

                        <label for="variant_value">Variant Value</label>
                        <input type="text" class="form-control"
                                name="variant_value" id="variant_value" placeholder="Enter variant value" >
                            @error('variant_value')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror

                    </div>
                    <div class="form-group" style="display: none">
                        <div class="">
                            <label for="unit_id">Unit</label>
                            <select class="form-control unit_id select2 " name="unit_id" id="unit_id">

                            </select>
                            @error('unit_id')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitBtn" data-form="#add_variant">Add</button>
                </div>
            </div>
        </form>
    </div>
    <div class="modal fade" id="product-to-variantions-update-modal">
        <form class="modal-dialog modal-lg" id="update_variant" data-method="post">
            <input type="hidden" name="product_id" value="{{$product->id}}">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update Variation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="">
                            <label for="variant_id">Variant</label>
                            <select class="form-control variant_id select2" name="variant_id" id="update_variant_id">

                            </select>
                            @error('variant_id')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">

                        <label for="variant_value">Variant Value</label>
                        <input type="text" class="form-control"
                                name="variant_value" id="update_variant_value" placeholder="Enter variant value" >
                            @error('variant_value')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror

                    </div>
                    <div class="form-group" style="display: none">
                        <div class="">
                            <label for="unit_id">Unit</label>
                            <select class="form-control unit_id select2 " name="unit_id" id="update_unit_id">

                            </select>
                            @error('unit_id')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="updateBtn" data-form="#update_variant">Update</button>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('js')
<script src="{{ asset('admin/plugins/jquery-validation/jquery.validate.min.js') }}"></script>

<script src="{{asset('admin/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}"></script>

<script src="{{asset('admin/plugins/select2/js/select2.min.js')}}"></script>
<script src="{{asset('admin/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')}}"></script>

@include('admin.products.product_listing.create.step_2_js')

<script>
    // Usage example:
    const productToVariationDataTable = new AjaxDataTable(
        '{{route("admin.productVariations.ajax.getByProductId")}}/?product_id={{$product->id}}',
        '#productToVariationTableBody',
        [
            { field: '#' },
            { field: 'variant_name' },
            { field: 'variant_value' },
            { field: 'unit_name' },
            { field: 'action' }
        ],
        {
            customActions: [
                { label: `<i class="fas fa-pencil-alt "></i> Edit`, buttonClass: 'btn btn-info mr-2 edit', attributes: `href="{{url('admin/product-variations/ajax/edit')}}" data-modal="#product-to-variantions-update-modal"` },
                { label: '<i class="fas fa-trash "></i> Delete', buttonClass: 'btn btn-danger mr-2 delete', attributes: `href="{{url('admin/product-variations/ajax/delete')}}"` }
            ]
        }
    );
    // Fetch data and render it in the table
    productToVariationDataTable.fetchDataAndRender();

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
                    productToVariationDataTable.fetchDataAndRender();
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
        $('#update_variant_id').html('');
        var $option1 = $('<option selected ></option>').val(item.variation_id).text(item.variant_name);
        $option1.data('has-unit',item.has_unit);
        $('#update_variant_id').append($option1).trigger('change');

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

        $(this).find("select[name='variant_id']").val(null).trigger('change');
        $(this).find("select[name='unit_id']").val(null).trigger('change');
    });
    $(document).ready(function() {
        $("#submitBtn").click(function(ev) {
            ev.preventDefault();
            submitFormAjax($(this).data('form'), function(data) {
                // Success callback function

                $('#product-to-variantions-modal').modal('hide');
                productToVariationDataTable.fetchDataAndRender();
            }, function(data) {
                // Error callback function
                console.log("Form submission failed!");

            });
        });
        $("#updateBtn").click(function(ev) {
            ev.preventDefault();
            submitFormAjax($(this).data('form'), function(data) {
                // Success callback function

                $('#product-to-variantions-update-modal').modal('hide');
                productToVariationDataTable.fetchDataAndRender();
            }, function(data) {
                // Error callback function
                console.log("Form submission failed!");

            });
        });

    });
</script>


@endsection
