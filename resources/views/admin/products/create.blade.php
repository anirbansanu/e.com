@extends('admin.layouts.app')
@section('title')
    Add Product
@endsection
@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{asset('admin/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('admin/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css')}}">
{{-- DropZone css  --}}
<link rel="stylesheet" href="{{asset('admin/plugins/dropzone/dropzone.css')}}" />
@endsection
@section('content')
    <div class="content-wrapper pt-3">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary card-tabs">
                            <div class="card-header  p-0 pt-1">
                                <div class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                    <x-tabs.nav-item route="products.index" icon="fas fa-list-alt ">Product List</x-tabs.nav-item>
                                    <x-tabs.nav-item route="products.create" icon="fas fa-plus-square">Add Product</x-tabs.nav-item>
                                    <x-tabs.nav-item route="products.trash" icon="fas fa-trash">Trash List</x-tabs.nav-item>
                                </div>
                            </div>
                            <form action="{{route('products.store')}}" method="POST">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card card-primary card-outline">
                                                <div class="card-header">
                                                    <h3 class="card-title">
                                                        Product Info
                                                    </h3>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Name</label>
                                                        <input type="text" class="form-control" value="{{ old('name') }}"
                                                            name="name" id="name" placeholder="Enter name" >
                                                            @error('name')
                                                                <span class="error text-danger">{{ $message }}</span>
                                                            @enderror

                                                    </div>

                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Description</label>
                                                        <textarea name="description" class="form-control" id="description" >{{ old('description') }}</textarea>
                                                        @error('description')
                                                            <span class="error text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="category">Category</label>
                                                        <select class="form-control select2bs4" name="category_id" id="category">
                                                            <option value="">Select Category</option>
                                                        </select>
                                                        @error('category_id')
                                                            <span class="error text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="brand">Brand</label>
                                                        <select class="form-control select" name="brand_id" id="brand">
                                                            <option value="">Select Brand</option>
                                                        </select>
                                                        @error('brand')
                                                            <span class="error text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="price">Price</label>
                                                        <input type="number" class="form-control" id="price" name="price" value="{{ old('price') }}" required>
                                                        @error('price')
                                                            <span class="error text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="gender">Gender</label>
                                                        <select class="form-control select2-multiple" name="gender" id="gender" >
                                                            <option value="">Select Gender</option>
                                                            <option value="female" {{old('gender')=='female'?'selected':''}}>Female</option>
                                                            <option value="male" {{old('gender')=='male'?'selected':''}}>Male</option>
                                                        </select>
                                                        @error('gender')
                                                            <span class="error text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="feature">Feature</label>
                                                        <input type="text" class="form-control" id="feature" name="feature" value="{{ old('feature') }}">
                                                        @error('feature')
                                                            <span class="error text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="is_active">Status </label><br>
                                                        <input type="checkbox" name="is_active" checked=""
                                                                data-bootstrap-switch=""
                                                                data-size="large"
                                                                data-on-text="Active"
                                                                data-off-text="Inactive"
                                                                data-handle-width="80px"
                                                                data-label-width="25px"
                                                                />
                                                        @error('is_active')
                                                            <span class="error text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div> <!-- /add product card -->
                                        </div> <!-- /.col-md-6 Product Info-->
                                        <div class="col-md-6">
                                            <div class="card card-primary card-outline">
                                                <div class="card-header">
                                                    <h3 class="card-title">
                                                        Product Variantions
                                                    </h3>
                                                    <div class="card-tools m-0">
                                                        <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#product-to-variantions-modal" title="Add Variation">
                                                        <i class="fas fa-plus"></i>
                                                        </button>
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
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="product_variantions_input_table">

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div> <!-- /add Product Variantions card -->

                                            <div class="card card-primary card-outline">
                                                <div class="card-header">
                                                    <h3 class="card-title">
                                                        Product Files
                                                    </h3>
                                                    <div class="card-tools m-0">
                                                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                                        <i class="fas fa-minus"></i>
                                                        </button>
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
                                            </div> <!-- /add product files card -->

                                        </div> <!-- /.col-md-6 Product Variantions-->

                                    </div>    <!-- /.row -->
                                </div><!-- /.card-body -->
                                <div class="card-footer d-flex justify-content-end">
                                    <button type="submit" id="settingUpdate" class="btn btn-primary">Save Product</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>
    <div class="modal fade" id="product-to-variantions-modal">
        <form class="modal-dialog modal-lg">
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
                    <button type="button" class="btn btn-primary" id="product-to-variant-add-btn">Add</button>
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

{{-- Color Picker , Select 2 , And Update Variants --}}
<script >
    $(document).ready(function(){

        $('#category').select2({
            width: '100%',
            theme: 'bootstrap4',
            ajax: {
                url: "{{route('categories.json')}}",
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
                        results: data.data.map(function(category) {
                            return {
                                id: category.id,
                                text: category.name
                            };
                        }),
                        pagination: {
                            more: data.current_page < data.last_page
                        }
                    };
                },
                cache: true
            },
            placeholder : 'Select a category',


        });
        $('#brand').select2({
            width: '100%',
            theme: 'bootstrap4',
            ajax: {
                url: "{{route('brands.json')}}",
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
                        results: data.data.map(function(brand) {
                            return {
                                id: brand.id,
                                text: brand.name
                            };
                        }),
                        pagination: {
                            more: data.current_page < data.last_page
                        }
                    };
                },
                cache: true
            },
            placeholder : 'Select a brand',


        });
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
        $('.select2-multiple').select2({
            width: '100%',
            theme: 'bootstrap4',

            placeholder : 'Select a category',


        });
        $(document).on('keyup', '#name', (ev) => {
            let nameValue = $('#name').val();
            let slug = slugify(nameValue);
            $('#slug').val(slug);
        });
        $("input[data-bootstrap-switch]").each(function(){
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
            $(this).on('switchChange.bootstrapSwitch', function(event, state) {
                onSwitchChange(state);
            });
        });
        // Retrieve data from local storage
        var storedData = [];
        function updateTableContent() {
            $('#product_variantions_input_table').html("");
            storedData.forEach(function(data, index) {
                var newRow = $(`<tr data-index="${index}">`);
                newRow.append($('<td>').html(`${index + 1}`));
                newRow.append($('<td>').html(data.variant_name + '<input type="hidden" name="variantions[variation_id][]" value="' + data.variation_id + '"/>'));
                newRow.append($('<td>').html(data.variant_value + '<input type="hidden" name="variantions[variant_value][]" value="' + data.variant_value + '"/>'));
                newRow.append($('<td>').html(`${data.unit_name ?data.unit_name: ""} <input type="hidden" name="variantions[unit_id][]" value="${data.unit_id ?data.unit_id : ""}"/>` ));
                newRow.append($('<td>').html(' <a href="#" class="btn btn-info btn-sm delete"><i class="fas fa-trash"></i></a>'));

                // Append the new row
                $('#product_variantions_input_table').append(newRow);
            });
        }
        $('#product-to-variant-add-btn').on("click", function(ev) {

            if (!$("#product-to-variantions-modal form").valid()) {
                return ;
            }
            var variant_id = $('#product-to-variantions-modal #variant_id').val();
            var variant_value = $('#product-to-variantions-modal #variant_value').val();
            var unit_id = $('#product-to-variantions-modal #unit_id').val();

            var variant_name = $('#product-to-variantions-modal #variant_id').find(':selected').text();
            var unit_name = $('#product-to-variantions-modal #unit_id').find(':selected').text();

            $('#product-to-variantions-modal').modal('hide');
            // Push the new data to the array
            storedData.push({
                variation_id: variant_id,
                variant_value: variant_value,
                unit_id: unit_id,
                variant_name: variant_name,
                unit_name: unit_name
            });
            console.log(storedData);
            updateTableContent();


        });

        $('#product_variantions_input_table').on('click', '.delete', function(ev) {
            // Find the closest <tr> element and remove it

            $(this).closest('tr').remove();
            let indexToDelete = $(this).closest('tr').data('index');
            storedData.splice(indexToDelete, 1);

            updateTableContent();
            // If you want to update local storage after deletion, you can do that here
            // For example, updateLocalStorageData();
        });

        $('#product-to-variantions-modal').on('hidden.bs.modal', function() {
            // Reset all input values when the modal is hidden
            console.log('hidden.bs.modal');
            $('#product-to-variantions-modal form')[0].reset();
            // Reset Select2 dropdowns
            $('#variant_id').val(null).trigger('change');
            $('#unit_id').val(null).trigger('change');
        });

        $('#variant_id').on('change', function(ev) {
            let value = $('#variant_id').find(':selected').text();
            var data = $('#variant_id').find(':selected').data('has-unit');
            console.log(data);
            console.log('data : '+typeof data);
            if(data)
            $('#unit_id').closest('.form-group').show();
            else
            $('#unit_id').closest('.form-group').hide();

        });
    });
    function slugify(text) {
        return text.toString().toLowerCase()
            .replace(/\s+/g, '_')           // Replace spaces with -
            .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
            .replace(/\-\-+/g, '-')         // Replace multiple - with single -
            .replace(/^-+/, '')             // Trim - from start of text
            .replace(/-+$/, '');            // Trim - from end of text
    }
</script>

{{-- validation --}}
<script>
    $(document).ready(function () {
        // Initialize the form validation
        $("#product-to-variantions-modal form").validate({
            rules: {
                variant_id: {
                    required: true
                },
                variant_value: {
                    required: true
                },

                unit_id: {
                    required: function(element) {
                        // Check if the selected variant requires the unit
                        var selectedVariant = $(element).closest('form').find('#variant_id :selected');
                        console.log("valdation unit_id"+$(selectedVariant).data('has-unit'));
                        return selectedVariant && $(selectedVariant).data('has-unit');
                    }
                }
            },
            messages: {
                variant_id: {
                    required: "Please select a variant"
                },
                variant_value: {
                    required: "Please enter a variant value"
                },
                unit_id: {
                    required: "Please select a unit"
                }
            },
            errorElement: "span",
            errorClass: "error text-danger",
            highlight: function (element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function (element) {

                $(element).closest('.form-group').removeClass('has-error');
            },
            errorPlacement: function (error, element) {
                console.log($(element).hasClass('select2'));
                if ($(element).hasClass('select2')) {
                    error.insertAfter(element.closest('div'));
                } else {
                    error.insertAfter(element);
                }
            },
            success: function (label, element) {
                // Remove the error message on successful validation
                $(element).closest('.form-group').find('.error').remove();
            }
        });

        // Add custom validation for select elements (optional)
        $.validator.addMethod("valueNotEquals", function (value, element, arg) {
            return arg !== value;
        }, "Please select a value");

        $(".variant_id, .unit_id").on('change', function () {
            $(this).valid(); // Trigger validation on change
        });

    });
</script>

{{-- DropZone  --}}
<script src="{{asset('admin/plugins/dropzone/dropzone.js')}}"></script>

{{-- Upload Files  --}}
<script>
    var existing = [];
    @if(isset($product) && $product->hasMedia('image'))
        @forEach($product->getMedia('image') as $media)
            existing.push({
                name: "{!! $media->name !!}",
                size: "{!! $media->size !!}",
                type: "{!! $media->mime_type !!}",
                uuid: "{!! $media->getCustomProperty('uuid'); !!}",
                thumb: "{!! $media->getUrl('thumb'); !!}",
                collection_name: "{!! $media->collection_name !!}"
            });
        @endforeach
    @endif
    // DropzoneJS Demo Code Start
    Dropzone.autoDiscover = false

    // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
    var previewNode = document.querySelector("#template")
    previewNode.id = ""
    var previewTemplate = previewNode.parentNode.innerHTML
    previewNode.parentNode.removeChild(previewNode)

    var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
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
            @if(isset($product) && $product->hasMedia('image'))
            existing.forEach(media => {
                dzInit(this, media, media.thumb);
            });
            @endif
        },
        accept: function (file, done) {
            console.log("accept");
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
                file, existing, '{!! url("product/remove-media") !!}',
                'image', '{!! isset($product) ? $product->id : 0 !!}', '{!! url("uploads/clear") !!}', '{!! csrf_token() !!}'
            );
        }
    });

    myDropzone.on("addedfile", function(file) {
        // Hookup the start button
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

@endsection
