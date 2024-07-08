@extends('admin.layouts.app')
@section('title')
    Add Variations
@endsection
@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{asset('admin/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('admin/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css')}}">
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
                                    <x-tabs.nav-item route="admin.variations.index" icon="fas fa-list-alt ">Variations List</x-tabs.nav-item>
                                    <x-tabs.nav-item route="admin.variations.create" icon="fas fa-plus-square">Add Variations</x-tabs.nav-item>
                                    <x-tabs.nav-item route="admin.variations.trash" icon="fas fa-trash">Trash List</x-tabs.nav-item>
                                </div>
                            </div>
                            <form action="{{route('admin.variations.store')}}" method="POST">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Name</label>
                                        <input type="text" class="form-control" value="{{ old('name') }}"
                                            name="name" id="name" placeholder="Enter name" />
                                            @error('name')
                                                <span class="error text-danger">{{ $message }}</span>
                                            @enderror

                                    </div>


                                    <div class="form-group">
                                        <label for="has_unit">Has Unit</label>
                                        <select class="form-control" name="has_unit" id="has_unit">
                                            <option value="1" {{ old('has_unit') == '1' ? 'selected' : '' }}>Yes</option>
                                            <option value="0" {{ old('has_unit') == '0' ? 'selected' : '' }}>No</option>
                                        </select>
                                        @error('has_unit')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" id="settingUpdate" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
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
<script >
    $(document).ready(function(){
        $('.my-colorpicker2').colorpicker()

        $('.my-colorpicker2').on('colorpickerChange', function(event) {
            $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
        });
        $('#category').select2({
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
        function onSwitchChange(state) {
            if (state) {
            console.log("Switch is ON",state);
            // Perform actions when switch is ON
            } else {
            console.log("Switch is OFF",state);
            // Perform actions when switch is OFF
            }
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
