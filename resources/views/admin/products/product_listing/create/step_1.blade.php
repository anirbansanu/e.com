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
                        <form action="{{route('products.store.stepOne')}}" method="post">
                            @csrf
                            @isset ($product->id)
                            <input type="hidden" class="d-none" value="{{ old('product_id',$product->id) }}" name="product_id" />
                            @endisset
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
                                        <div class="tab-pane fade active show" id="product-details" role="tabpanel" aria-labelledby="product-details-tab">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Name</label>
                                                <input type="text" class="form-control" value="{{ old('name',$product->name??"") }}"
                                                    name="name" id="name" placeholder="Enter name" >
                                                    @error('name')
                                                        <span class="error text-danger">{{ $message }}</span>
                                                    @enderror

                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Description</label>
                                                <textarea name="description" class="form-control" id="description" >{{ old('description',$product->description??"") }}</textarea>
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
                                                <label for="gender">Gender</label>
                                                <select class="form-control select2-single" name="gender" id="gender" data-placeholder="Select a gender">
                                                    <option value="">Select Gender</option>
                                                    <option value="female" {{old('gender',$product->gender??"")=='female'?'selected':''}}>Female</option>
                                                    <option value="male" {{old('gender',$product->gender??"")=='male'?'selected':''}}>Male</option>
                                                </select>
                                                @error('gender')
                                                    <span class="error text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="feature">Feature</label>
                                                <input type="text" class="form-control" id="feature" name="feature" value="{{ old('feature',$product->feature??"") }}">
                                                @error('feature')
                                                    <span class="error text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="is_active">Status </label><br>
                                                <input type="checkbox" name="is_active" @isset($product){{$product->is_active?"checked":""}}@endisset
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
                                            <div class="d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary" >Save & Next</button>
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
