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
                <x-anilte::tab-nav-item route="admin.products.listing.index" icon="fas fa-shield-alt">Product Listing</x-anilte::tab-nav-item>
                <x-anilte::tab-nav-item route="admin.products.listing.create" icon="fas fa-plus-square">Create Product </x-anilte::tab-nav-item>
        </x-slot>
        <x-slot name="body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{route('admin.products.store.stepOne')}}" method="post">
                            @csrf
                            @isset ($product->id)
                            <input type="hidden" class="d-none" value="{{ old('product_id',$product->id) }}" name="product_id" />
                            @endisset

                            <div class="mt-4">

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
                                    <div class="tab-pane fade active show" id="product-details" role="tabpanel" aria-labelledby="product-details-tab">

                                        <x-anilte::input-group
                                            id="name"
                                            name="name"
                                            :value="$product->name ?? ''"
                                            placeholder="Enter Name"
                                            :required="true"
                                            label="Name"
                                            icon="fas fa-user-tag"
                                        />
                                        @php
                                            $description_config = [
                                                "height" => "100",
                                                "toolbar" => [
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
                                                        ['view', ['fullscreen', ]]
                                                ],
                                            ]
                                        @endphp
                                        <x-adminlte-text-editor name="description" label="Description" label-class=""
                                            igroup-size="sm" placeholder="Write some text..." :config="$description_config">
                                            @isset($product->description)
                                                {!! $product->description !!}
                                            @endisset

                                        </x-adminlte-text-editor>

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
                                            <label for="gender">Gender</label>
                                            <select class="form-control select2-single" name="gender" id="gender" data-placeholder="Select a gender">
                                                <option value="">Select Gender</option>
                                                <option value="Female" {{old('gender',$product->gender??"")=='Female'?'selected':''}}>Female</option>
                                                <option value="Male" {{old('gender',$product->gender??"")=='Male'?'selected':''}}>Male</option>
                                                <option value="Male & Female" {{old('gender',$product->gender??"")=='Male & Female'?'selected':''}}>Male & Female</option>
                                            </select>
                                            @error('gender')
                                                <span class="error text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>


                                        <x-adminlte-input-switch name="is_active"
                                            label="Status"
                                            class="d-flex justify-content-end"
                                            data-on-text="Active"
                                            data-off-text="Inactive"
                                            data-on-color="primary bg-gradient-blue"
                                            data-handle-width='51px'
                                            data-label-width='15px'
                                            igroup-size="sm"
                                        />
                                        <div class="d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary" >Save & Next</button>
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
                url: "{{route('admin.products.categories.json')}}",
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
                url: "{{route('admin.products.brands.json')}}",
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
        @isset($product)
            var option = $('<option selected ></option>').val("{{$product->category->id}}").text("{{$product->category->name}}");
            $('#category').append(option).trigger('change');

            var option1 = $('<option selected ></option>').val("{{$product->brand->id}}").text("{{$product->brand->name}}");
            $('#brand').append(option1).trigger('change');
        @endisset


        $('.select2-single').select2({
            width: '100%',
            theme: 'bootstrap4',

            placeholder : $(this).data('placeholder'),


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





@endsection
