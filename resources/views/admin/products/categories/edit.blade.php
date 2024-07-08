@extends('admin.layouts.app')
@section('title')
     Category List

@endsection
@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .my-dropzone {
        position: relative;
        width: 100%;
        height: 200px; /* Set an appropriate height */
        border: 2px dashed #ddd;
        background: white;
        padding: 20px;
        box-sizing: border-box;
        color: #eae9e9;
    }

</style>
<link rel="stylesheet" href="{{asset('admin/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">

@endsection
@section('content')
<div class="content-wrapper pt-3">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-tabs">
                        <div class="card-header p-0 pt-1">

                            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                <x-tabs.nav-item route="categories.index" icon="fas fa-list-alt ">Category List</x-tabs.nav-item>
                                <x-tabs.nav-item route="categories.create" icon="fas fa-plus-square">Add Category</x-tabs.nav-item>
                                <x-tabs.nav-item route="categories.edit" route-params="{{$category->id}}" icon="fas fa-list-alt ">Edit Category</x-tabs.nav-item>

                                
                            </ul>
                        </div>
                        <div class="card-body ">
                            <!-- This HTML and Blade code for category edit form here -->
                            <form action="{{ route('categories.update', $category) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <!-- Form fields for name, description, etc. -->
                                <div class="form-group">
                                    <label for="name">Name :</label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ old("name",$category->name) }}" required>
                                    @error('name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Slug</label>
                                    <input type="text" class="form-control" value="{{ old('slug',$category->slug) }}"
                                        name="slug" id="slug" placeholder="Auto generated" readonly >
                                        @error('slug')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                </div>
                                <div class="form-group">
                                    <label for="description">Description </label>
                                    <textarea name="description" class="form-control" required>{{ old("description",$category->description) }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="parent_id">Parent Category</label>
                                    <select class="form-control" name="parent_id" id="parent_id">
                                        <option value="">Select Parent Category</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="is_active">Status </label><br>
                                    <input type="checkbox" name="is_active" {{ $category->is_active ? "checked":'' }}
                                            data-bootstrap-switch=""
                                            data-on-text="Active"
                                            data-off-text="Inactive"
                                            data-handle-width="55px"
                                            data-label-width="15px"
                                    />
                                    @error('is_active')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="w-100 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary ">Update Category</button>
                                </div>
                            </form>
                        </div> <!-- End div.Card Body -->
                    </div><!-- End div.Card -->
                </div><!-- End div.col -->
            </div><!-- End div.row -->
            @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        </div><!-- End div.container-fluid -->
    </section><!-- End section -->
</div><!-- End div.content-wrapper -->
@endsection
@section('js')
<script src="{{ asset('admin/plugins/jquery-validation/jquery.validate.min.js') }}"></script>

<script src="{{asset('admin/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}"></script>

<script src="{{asset('admin/plugins/select2/js/select2.min.js')}}"></script>

<script >
    $(document).ready(function(){
        @if ($category->parent)
            var $option =  $("<option selected></option>").val('{{$category->parent->id?? ""}}').text("{{ $category->parent->name ?? "" }}") ;
            $('#parent_id').append($option).trigger('change');
        @endif

        $('#parent_id').select2({
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
            placeholder : 'Select a parent category',

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
            } else {
                console.log("Switch is OFF",state);
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
<script src="{{asset("admin/plugins/dropzone/dropzone.js")}}"></script>

<script>
    // // Dropzone has been added as a global variable.
    // const dropzone = new Dropzone("div.my-dropzone", {
    //     url: "/file/post",
    //     maxFilesize: 5, // Set maximum file size in megabytes
    //     acceptedFiles: ".png, .jpg, .jpeg, .gif", // Specify allowed file types
    //     addRemoveLinks: true, // Show remove links on each file preview
    //     success: function(file, response) {
    //         // Handle successful file upload
    //         console.log(response);
    //     },
    //     error: function(file, response) {
    //         // Handle errors during file upload
    //         console.log(response);
    //     }
    // });

</script>
@endsection
