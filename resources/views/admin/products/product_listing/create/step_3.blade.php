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
                        <form action="{{route('products.store.stepThree')}}" method="post">
                            @csrf
                            <input type="hidden" name="product_id" value="{{$product->id??""}}"/>
                            <div class="card card-primary card-tabs">
                                <div class="card-header  p-0 pt-1">
                                    <div class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                        <x-tabs.nav-item route="products.index" icon="fas fa-list-alt ">Product List</x-tabs.nav-item>
                                        <x-tabs.nav-item route="products.create" icon="fas fa-plus-square">Add Product</x-tabs.nav-item>
                                        <x-tabs.nav-item route="products.trash" icon="fas fa-trash">Trash List</x-tabs.nav-item>
                                    </div>
                                </div>
                                <div class="card-body mt-4">

                                    <ul class="nav nav-tabs" id="tablist" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link {{$step==1?"active":""}} {{isset($step)?"":"active"}}" id="product-details-tab" @if(isset($product)) href="{{route('products.create',["step"=>1,"product_id"=>$product])}}" @else href="{{route('products.create',["step"=>1])}}" @endif aria-selected="true">
                                                Product Details
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{$step==2?"active":""}}" id="variants_tab-tab"  @if(isset($product)) href="{{route('products.create',["step"=>2,"product_id"=>$product])}}" @else href="#variants_tab" @endif >
                                                Variants
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{$step==3?"active":""}}" id="stock-tab" @if(isset($product)) href="{{route('products.create',["step"=>3,"product_id"=>$product])}}" @else href="#stock-tab-block" @endif >
                                                Stock
                                            </a>
                                        </li>

                                    </ul>
                                    <div class="tab-content p-sm-2 p-lg-3 border-right border-left border-bottom" id="tabListContent">

                                        <div class="tab-pane fade active show" id="stock-tab-block" role="tabpanel"
                                            aria-labelledby="custom-content-below-profile-tab">
                                            <div class="card border-0 shadow-none">
                                                <div class="card-header">
                                                    <div class="d-flex justify-content-between">
                                                        <span class="card-title">
                                                            <span class="w-100 h5">Product Stock</span>
                                                            <br/>
                                                            <span class="w-100 "><small>Add combinations of variations with stock</small></span>
                                                        </span>
                                                        <div class="card-tools m-0">
                                                            <button type="button" class="btn btn-sm btn-primary " data-toggle="modal" data-target="#product-stock-modal" title="Add Variation">
                                                            <i class="fas fa-plus"></i>
                                                            ADD
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body" data-hx="init" data-hx-method="post" data-hx-target="#stock_table" data-hx-route="">
                                                    <table class="table table-hover text-nowrap border" id="stock_table" >
                                                        <thead class="border-top">

                                                        </thead>
                                                        <tbody id="stock-table-body" data-route="{{route('admin.stock.ajax.get')}}?product_id={{$product->id}}">

                                                        </tbody>
                                                    </table>
                                                    <div class="d-flex justify-content-end mt-4">
                                                        <button type="submit" class="btn btn-primary" >Submit</button>
                                                    </div>
                                                </div>

                                            </div> <!-- /add Product Variantions card -->


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

    <div class="modal fade" id="product-stock-modal" >
        <form class="modal-dialog modal-xl" id="product-stock-form" data-update-action="{{route('admin.stock.ajax.update')}}" data-store-action="{{route('admin.stock.ajax.store')}}" data-store-method="post" data-update-method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><strong>Add Stock</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="product_id" id="product-id" value="{{$product->id}}" data-product-name="{{$product->name}}"/>
                    <div class="row">
                        @php
                            $groupByVariations = $product->groupByVariation();
                        @endphp
                        @forelse ($groupByVariations as $key=>$item)
                            <div class="col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="{{$key}}">{{$key}}</label>
                                    <select class="form-control select2-single" data-placeholder="{{"Select ".$key}}" id="combinations.{{$key}}" name="combinations[{{$key}}]">
                                        <option value="">{{"Select ".$key}}</option>
                                        @forelse ($item as $element)
                                            <option value="{{$element->id}}" data-suggestive-sku="{{substr($element->variant_name, 0, 1)}}{{$element->variant_value}}">{{$element->variant_name." ".$element->variant_value." ".$element->unit_name}}</option>
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
                                <input class="form-control" type="text" name="sku" id="sku" placeholder="Enter sku">
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
                                <input type="text" class="form-control" name="price" id="price" placeholder="Enter price" >
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <input type="text" class="form-control" name="quantity" id="quantity" placeholder="Enter quantity" >
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="actions" class="row">
                            <div class="col-lg-6">
                                <div class="btn-group w-100">
                                    <span class="btn btn-sm btn-success col fileinput-button dz-clickable">
                                        <i class="fas fa-plus"></i>
                                        <span>Add</span>
                                    </span>
                                    <span class="btn btn-sm btn-primary col start">
                                        <i class="fas fa-upload"></i>
                                        <span>Upload</span>
                                    </span>
                                    <span class="btn btn-sm btn-warning col cancel">
                                        <i class="fas fa-times-circle"></i>
                                        <span>Cancel</span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-6 d-flex align-items-center">
                                <div class="fileupload-process w-100">
                                    <div id="total-progress" class="progress progress-striped active" role="progressbar" aria-valuemin="0"
                                        aria-valuemax="100" aria-valuenow="0">
                                        <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress=""></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table table-striped files" id="previews" >
                            <div id="template" class="row mt-2" data-field="image">
                                <div class="col-auto">
                                    <span class="preview"><img src="data:," alt data-dz-thumbnail /></span>
                                </div>
                                <div class="col d-flex align-items-center">
                                    <p class="mb-0">
                                        <span class="lead" data-dz-name></span>
                                        (<span data-dz-size></span>)
                                    </p>
                                    <strong class="error text-danger" data-dz-errormessage></strong>
                                </div>
                                <div class="col-4 d-flex align-items-center">
                                    <div class="progress progress-striped active w-100" role="progressbar" aria-valuemin="0" aria-valuemax="100"
                                        aria-valuenow="0">
                                        <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                                    </div>
                                </div>
                                <div class="col-auto d-flex align-items-center">
                                    <div class="btn-group">
                                        <a class="btn btn-primary start">
                                            <i class="fas fa-upload"></i>
                                            <span></span>
                                        </a>
                                        <a data-dz-remove class="btn btn-warning cancel">
                                            <i class="fas fa-times-circle"></i>
                                            <span></span>
                                        </a>
                                        <a data-dz-remove class="btn btn-danger delete">
                                            <i class="fas fa-trash"></i>
                                            <span></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>


                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitBtn">Add</button>
                </div>
            </div>
        </form>
    </div>
    <div class="modal fade" id="product-stock-update-modal" >
        <form class="modal-dialog modal-xl" id="product-stock-update-form" data-update-action="{{route('admin.stock.ajax.update')}}" data-update-method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><strong>Edit Stock</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="product_id" id="update-product-id" value="{{$product->id}}" data-product-name="{{$product->name}}"/>
                    <div class="row">
                        @php
                            $groupByVariations = $product->groupByVariation();
                        @endphp
                        @forelse ($groupByVariations as $key=>$item)
                            <div class="col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="{{$key}}">{{$key}}</label>
                                    <select class="form-control select2-single" data-placeholder="{{"Select ".$key}}" id="update-combinations-{{$key}}" name="combinations[{{$key}}]">
                                        <option value="">{{"Select ".$key}}</option>
                                        @forelse ($item as $element)
                                            <option value="{{$element->id}}" data-suggestive-sku="{{substr($element->variant_name, 0, 1)}}{{$element->variant_value}}">{{$element->variant_name." ".$element->variant_value." ".$element->unit_name}}</option>
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
                                <input class="form-control" type="text" name="sku" id="update-sku" placeholder="Enter sku">
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
                                <input type="text" class="form-control" name="price" id="update-price" placeholder="Enter price" >
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <input type="text" class="form-control" name="quantity" id="update-quantity" placeholder="Enter quantity" >
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="edit-actions" class="row">
                            <div class="col-lg-6">
                                <div class="btn-group w-100">
                                    <span class="btn btn-sm btn-success col edit-fileinput-button dz-clickable">
                                        <i class="fas fa-plus"></i>
                                        <span>Add</span>
                                    </span>
                                    <span class="btn btn-sm btn-primary col start">
                                        <i class="fas fa-upload"></i>
                                        <span>Upload</span>
                                    </span>
                                    <span class="btn btn-sm btn-warning col cancel">
                                        <i class="fas fa-times-circle"></i>
                                        <span>Cancel</span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-6 d-flex align-items-center">
                                <div class="fileupload-process w-100">
                                    <div id="edit-total-progress" class="progress progress-striped active" role="progressbar" aria-valuemin="0"
                                        aria-valuemax="100" aria-valuenow="0">
                                        <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress=""></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table table-striped files" id="edit-previews" >
                            <div id="edit-template" class="row mt-2" data-field="image">
                                <div class="col-auto">
                                    <span class="preview"><img src="data:," alt data-dz-thumbnail /></span>
                                </div>
                                <div class="col d-flex align-items-center">
                                    <p class="mb-0">
                                        <span class="lead" data-dz-name></span>
                                        (<span data-dz-size></span>)
                                    </p>
                                    <strong class="error text-danger" data-dz-errormessage></strong>
                                </div>
                                <div class="col-4 d-flex align-items-center">
                                    <div class="progress progress-striped active w-100" role="progressbar" aria-valuemin="0" aria-valuemax="100"
                                        aria-valuenow="0">
                                        <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                                    </div>
                                </div>
                                <div class="col-auto d-flex align-items-center">
                                    <div class="btn-group">
                                        <a class="btn btn-primary start">
                                            <i class="fas fa-upload"></i>
                                            <span></span>
                                        </a>
                                        <a data-dz-remove class="btn btn-warning cancel">
                                            <i class="fas fa-times-circle"></i>
                                            <span></span>
                                        </a>
                                        <a data-dz-remove class="btn btn-danger delete">
                                            <i class="fas fa-trash"></i>
                                            <span></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>


                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="update-submitBtn">Update</button>
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

@include('admin.products.product_listing.create.step_3_js')
<script>
//Stock generater start

        var varitions = {!! count($product->productToVariations) > 0 ? json_encode($product->groupByVariation()) : [] !!};
        console.log(varitions);
        // Extract variant_name and id from the data
        const variantData = {};

        for (const item in varitions) {
            console.log("item : ",item);
            if (varitions.hasOwnProperty(item)) {
                let temp = [];
                varitions[item].forEach(element => {
                    temp.push({
                        "text":element.variant_name,
                        "id": element.id
                    });
                });
                variantData[item] = temp;
            }
        }

        console.log("variantData",variantData);
        let variationkeys = Object.keys(varitions);
        updateheader();
        var templateData = {};

        function updateheader(){
            $('#stock_table tbody').html();
            let variationkeys = Object.keys(varitions);
            let newRow = $("<tr>");
            newRow.append($("<th>").text("#"));
            newRow.append($("<th>").text("SKU"));
            for(let i=0;i<variationkeys.length;i++)
                newRow.append($("<th>").text(variationkeys[i]));
            newRow.append($("<th>").text("Price"));
            newRow.append($("<th>").text("Quantity"));
            newRow.append($("<th>").text("Is Default"));
            newRow.append($("<th>").text("Action"));
            $('#stock_table thead').append(newRow);
        }


//Stock generater end
</script>


{{-- Select 2 , And Update Variants --}}
<script >
    $(document).ready(function(){

        $('.variant_id').select2({
            width: '100%',
            theme: 'bootstrap4',
            ajax: {
                url: "{{route('admin.variations.json')}}",
                type: "POST",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    console.log(params);
                    return {
                        q: params.term,
                        page: params.page || 1
                    };
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                processResults: function(data) {
                    return {
                        results: data.data.map(function(item) {
                            return {
                                id: item.id,
                                text: item.name,
                                customData: item.has_unit
                            };
                        }),
                        pagination: {
                            more: data.current_page < data.last_page
                        }
                    };
                },

                cache: true
            },

            placeholder : 'Select a variant',
            templateSelection: function (data, container) {
                // Add custom attributes to the <option> tag for the selected option
                $(data.element).attr('data-has-unit', data.customData?true:false);
                return data.text;
            },

        });
        $('.unit_id').select2({
            width: '100%',
            theme: 'bootstrap4',
            ajax: {
                url: "{{route('admin.product_units.json')}}",
                type: "POST",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    console.log(params);
                    return {
                        q: params.term,
                        page: params.page || 1
                    };
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                processResults: function(data) {
                    return {
                        results: data.data.map(function(unit) {
                            return {
                                id: unit.id,
                                text: unit.unit_name
                            };
                        }),
                        pagination: {
                            more: data.current_page < data.last_page
                        }
                    };
                },
                cache: true
            },
            placeholder : 'Select a unit',


        });
        $('.select2-single').select2({
            width: '100%',
            theme: 'bootstrap4',

            placeholder : $(this).data('placeholder'),


        });
        $('[name="auto_generate_sku"]').on('change',function (ev) {
            console.log("auto_generate_sku");
            var suggestiveSku="";
            console.log($(this).is(':checked'));
            $('[name="sku"]').val('');
            if ($(this).is(':checked'))
            {
                $('.select2-single').each(function( index ) {
                    if ($(this).val() !== '') {
                        // Get the selected option's data-suggestive-sku attribute
                        suggestiveSku += "-"+$(this).find('option:selected').data('suggestive-sku');
                    }

                });
                let productName=$('#product-id').data('product-name');
                console.log(productName);
                productName = productName.substring(0, 3);
                productName = productName.replace(/\s/g, '');
                productName = productName.toUpperCase();

                // productName attached to suggestiveSku
                suggestiveSku = productName+suggestiveSku;

                // Log  with the suggestiveSku value
                console.log(suggestiveSku);
                $('[name="sku"]').val(suggestiveSku);

            }
            else
            {
                $('[name="sku"]').val('');
            }
        });

    });

</script>

{{-- DropZone  --}}
<script src="{{asset('admin/plugins/dropzone/dropzone.js')}}"></script>

{{-- Upload Files  --}}
<script>
    var existing = [];

    // DropzoneJS Demo Code Start
    Dropzone.autoDiscover = false

    // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
    var previewNode = document.querySelector("#template")
    previewNode.id = ""
    var previewTemplate = previewNode.parentNode.innerHTML
    previewNode.parentNode.removeChild(previewNode)

    var myDropzone = new Dropzone('div#product-stock-modal', { // Make the whole body a dropzone
        url: "{{route('medias.create')}}", // Set the url
        headers: {
        'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
        },
        // Include additional parameters
        params: {
            field: 'image'
        },
        thumbnailWidth: 80,
        thumbnailHeight: 80,
        parallelUploads: 20,
        previewTemplate: previewTemplate,
        autoQueue: false, // Make sure the files aren't queued until manually added
        previewsContainer: "#previews", // Define the container to display the previews
        clickable: ".fileinput-button", // Define the element that should be used as click trigger to select files.
        maxFiles: 5 - existing.length,
        init: function () {
            if(existing.length > 0)
            existing.forEach(media => {
                dzInit(this, media, media.thumb);
            });
        },
        accept: function (file, done) {
            dzAccept(file, done, this.element, "{!!config('medialibrary.icons_folder')!!}");
        },
        sending: function (file, xhr, formData) {
            dzSendingMultiple(file.previewElement, file, formData, '{!! csrf_token() !!}');
            console.log("sending");
            console.log(formData);
            // Show the total progress bar when upload starts
            document.querySelector("#total-progress").style.opacity = "1"
            // And disable the start button
            file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
        },
        maxfilesexceeded: function (file) {
            console.log("maxfilesexceeded");
            console.log(file);
            existing[0].mockFile = '';
            dzMaxfile(file.previewElement, file);
        },
        complete: function (file) {
            console.log("complete");
            console.log(file);

            dzCompleteMultiple(file.previewElement, file);
            existing[0] ?  (existing[0].mockFile = file) : "" ;

        },
        removedfile: function (file) {
            console.log("removedfile");
            console.log(file);
            dzRemoveFileMultiple(
                file, existing, '{!! route("admin.stock.ajax.remove.media") !!}',
                'image', '{!! isset($product) ? $product->id : 0 !!}', '{!! url("uploads/clear") !!}', '{!! csrf_token() !!}'
            );
        }
    });

    myDropzone.on("addedfile", function(file) {
        // Hookup the start button
        console.log("addedfile",file);
        file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file) }
    });

    // Update the total progress bar
    myDropzone.on("totaluploadprogress", function(progress) {
        document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
    });

    // Hide the total progress bar when nothing's uploading anymore
    myDropzone.on("queuecomplete", function(progress) {
        document.querySelector("#total-progress").style.opacity = "0"
    });

    // Setup the buttons for all transfers
    // The "add files" button doesn't need to be setup because the config
    // `clickable` has already been specified.
    document.querySelector("#actions .start").onclick = function() {
        myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
    }
    document.querySelector("#actions .cancel").onclick = function() {
        myDropzone.removeAllFiles(true)
    }
// DropzoneJS Demo Code End
</script>
{{-- Edit Upload Files  --}}
<script>
    var edit_existing = [];

    // DropzoneJS Demo Code Start
    Dropzone.autoDiscover = false

    // Get the edit-template HTML and remove it from the doumenthe edit-template HTML and remove it from the doument
    var edit_previewNode = document.querySelector("#edit-template")
    edit_previewNode.id = ""
    var editPreviewNode = edit_previewNode.parentNode.innerHTML
    edit_previewNode.parentNode.removeChild(edit_previewNode)

    var editDropzone = new Dropzone('div#product-stock-update-modal', { // Make the whole body a dropzone
        url: "{{route('medias.create')}}", // Set the url
        headers: {
        'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
        },
        // Include additional parameters
        params: {
            field: 'image'
        },
        thumbnailWidth: 80,
        thumbnailHeight: 80,
        parallelUploads: 20,
        previewTemplate: editPreviewNode,
        autoQueue: false, // Make sure the files aren't queued until manually added
        previewsContainer: "#edit-previews", // Define the container to display the previews
        clickable: ".edit-fileinput-button", // Define the element that should be used as click trigger to select files.
        maxFiles: 5 - edit_existing.length,
        init: function () {
            if (edit_existing.length > 0) {
                edit_existing.forEach(media => {
                    dzInit(this, media, media.thumb);

                });
            }
        },
        accept: function (file, done) {
            dzAccept(file, done, this.element, "{!!config('medialibrary.icons_folder')!!}");
        },
        sending: function (file, xhr, formData) {
            dzSendingMultiple(file.previewElement, file, formData, '{!! csrf_token() !!}');
            console.log("sending");
            console.log(formData);
            // Show the total progress bar when upload starts
            document.querySelector("#edit-total-progress").style.opacity = "1";
            // And disable the start button
            file.previewElement.querySelector(".start").classList.add('disabled');
        },
        maxfilesexceeded: function (file) {
            console.log("maxfilesexceeded");
            console.log(file);
            edit_existing[0].mockFile = '';
            dzMaxfile(file.previewElement, file);
        },
        complete: function (file) {
            console.log("complete");
            console.log(file);

            dzCompleteMultiple(file.previewElement, file);
            edit_existing[0] ?  (edit_existing[0].mockFile = file) : "" ;

        },
        removedfile: function (file) {
            console.log("removedfile");
            console.log(file);
            dzRemoveFileMultiple(
                file, edit_existing, '{!! url("product/remove-media") !!}',
                'image', '{!! isset($product) ? $product->id : 0 !!}', '{!! url("uploads/clear") !!}', '{!! csrf_token() !!}'
            );
        }
    });

    editDropzone.on("addedfile", function(file) {
        // Hookup the start button
        console.log("addedfile",file);
        if(file.uuid)
        {
            file.previewElement.querySelector(".start").classList.add('disabled');
            file.previewElement.querySelector(".cancel").classList.add('disabled');
        }
        file.previewElement.querySelector(".start").onclick = function() { editDropzone.enqueueFile(file) }
    });

    // Update the total progress bar
    editDropzone.on("totaluploadprogress", function(progress) {
        document.querySelector("#edit-total-progress .progress-bar").style.width = progress + "%"
    });

    // Hide the total progress bar when nothing's uploading anymore
    editDropzone.on("queuecomplete", function(progress) {
        document.querySelector("#edit-total-progress").style.opacity = "0"
    });

    // Setup the buttons for all transfers
    // The "add files" button doesn't need to be setup because the config
    // `clickable` has already been specified.
    document.querySelector("#edit-actions .start").onclick = function() {
        editDropzone.enqueueFiles(editDropzone.getFilesWithStatus(Dropzone.ADDED))
    }
    document.querySelector("#edit-actions .cancel").onclick = function() {
        editDropzone.removeAllFiles(true)
    }
    function clearDropZone(dz) {
        console.log(dz);
        dz.removeAllFiles();
        var previewContainer = document.getElementById("edit-previews");
        previewContainer.innerHTML = "";
        var previewContainer = document.getElementById("previews");
        previewContainer.innerHTML = "";
    }
// DropzoneJS Demo Code End
</script>
@endsection
