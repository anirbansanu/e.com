@extends('admin.layouts.app')
@section('title')
     Brand List

@endsection
@section('css')
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
                                <x-tabs.nav-item route="brands.index" icon="fas fa-list-alt ">Brand List</x-tabs.nav-item>
                                <x-tabs.nav-item route="brands.create" icon="fas fa-plus-square">Add Brand</x-tabs.nav-item>
                                <x-tabs.nav-item route="brands.edit" route-params="{{$brand->id}}" icon="fas fa-list-alt ">Edit Brand</x-tabs.nav-item>


                            </ul>
                        </div>
                        <div class="card-body ">
                            <!-- This HTML and Blade code for brand edit form here -->
                            <form action="{{ route('brands.update', $brand) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <!-- Form fields for name, description, etc. -->
                                <div class="form-group">
                                    <label for="name">Name :</label>
                                    <input type="text" name="name" class="form-control" value="{{ old("name",$brand->name) }}" required>
                                    @error('name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="description">Description :</label>
                                    <textarea name="description" class="form-control" required>{{ old("description",$brand->description) }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{-- <div class="form-group">
                                    <div class="my-dropzone border " >
                                        <DIV class="dz-message needsclick">
                                            Drop files here or click to upload.<BR>
                                            <SPAN class="note needsclick">(This is just a demo dropzone. Selected
                                            files are <STRONG>not</STRONG> actually uploaded.)</SPAN>
                                          </DIV>
                                    </div>
                                    @error('description')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div> --}}

                                <div class="form-group">
                                    <label for="is_active">Status :</label><br>
                                    <input type="checkbox" name="is_active" {{ $brand->is_active ? "checked":'' }}
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
                                    <button type="submit" class="btn btn-primary ">Update Brand</button>
                                </div>
                            </form>
                        </div> <!-- End div.Card Body -->
                    </div><!-- End div.Card -->
                </div><!-- End div.col -->
            </div><!-- End div.row -->

        </div><!-- End div.container-fluid -->
    </section><!-- End section -->
</div><!-- End div.content-wrapper -->
@endsection
@section('js')
<script src="{{ asset('admin/plugins/jquery-validation/jquery.validate.min.js') }}"></script>

<script src="{{asset('admin/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}"></script>

<script >
    $(document).ready(function(){

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
</script>
<script src="{{asset("admin\plugins\dropzone\dropzone.js")}}"></script>

<script>
    // Dropzone has been added as a global variable.
    const dropzone = new Dropzone("div.my-dropzone", {
            url: 'files',
            maxFilesize: 12,
            renameFile: function(file) {
                var dt = new Date();
                var time = dt.getTime();
               return time+file.name;
            },
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            addRemoveLinks: true,
            timeout: 50000,
            success: function(file, response)
            {
                console.log(response);
            },
            error: function(file, response)
            {
               return false;
            }
        });

</script>
@endsection
{{-- removedfile: function(file)
            {
                var name = file.upload.filename;
                $.ajax({
                    headers: {
                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            },
                    type: 'POST',
                    url: '{{ url("image/delete") }}',
                    data: {filename: name},
                    success: function (data){
                        console.log("File has been successfully removed!!");
                    },
                    error: function(e) {
                        console.log(e);
                    }});
                    var fileRef;
                    return (fileRef = file.previewElement) != null ?
                    fileRef.parentNode.removeChild(file.previewElement) : void 0;
            }, --}}
