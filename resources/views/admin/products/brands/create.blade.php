@extends('admin.layouts.app')
@section('title')
    Add Brand
@endsection
@section('css')
@endsection
@section('content')
    <div class="content-wrapper pt-3">
        <section class="content">
            <div class="container-fluid">
                <div class="row ">
                    <div class="col-md-12">
                        <div class="card card-primary card-tabs">
                            <div class="card-header  p-0 pt-1">
                                <div class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                    <x-tabs.nav-item route="brands.index" icon="fas fa-list-alt ">Brand List</x-tabs.nav-item>
                                    <x-tabs.nav-item route="brands.create" icon="fas fa-plus-square">Add Brand</x-tabs.nav-item>
                                </div>
                            </div>
                            <form action="{{route('brands.store')}}" method="POST">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Name</label>
                                        <input type="text" class="form-control" value="{{ old('name') }}"
                                            name="name" id="name" placeholder="Enter name">
                                            @error('name')
                                                <span class="error text-danger">{{ $message }}</span>
                                            @enderror

                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Description</label>
                                        <textarea name="description" class="form-control" id="description" ></textarea>
                                        @error('description')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{-- <div class="form-group">
                                        <label for="img">Logo:</label>
                                        <input type="file" class="form-control" id="img" name="img" accept="image/*">
                                    </div> --}}
                                    <div class="form-group">
                                        <label for="is_active">Status :</label><br>
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
            // Perform actions when switch is ON
            } else {
            console.log("Switch is OFF",state);
            // Perform actions when switch is OFF
            }
        }
    });
</script>
@endsection
