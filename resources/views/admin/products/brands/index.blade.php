@extends('admin.layouts.app')
@section('title')
     Brand List
@endsection
@section('css')
<style>
    .sortable-link{
        cursor: pointer !important;
        color: black;
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
                            <div class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                <x-tabs.nav-item route="brands.index" icon="fas fa-list-alt ">Brand List</x-tabs.nav-item>
                                <x-tabs.nav-item route="brands.create" icon="fas fa-plus-square">Add Brand</x-tabs.nav-item>
                            </div>

                        </div>
                        <div class="card-body table-responsive p-0">
                            <div class="row m-0 p-2">

                                <div class="col-sm-12 col-md-6">

                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="d-flex justify-content-end">
                                        <form action="{{ route('brands.index') }}" method="GET">
                                            <div class="input-group input-group-sm" style="width: 250px;">
                                                <input type="text" name="query"
                                                    class="form-control float-right" placeholder="Search by Name, Description" value="{{$query??""}}">
                                                <input type="hidden" class="d-none" name="sort_by" value="{{$sort_by}}">
                                                <input type="hidden" class="d-none" name="sort_order" value="{{$sort_order}}">
                                                <div class="input-group-append">
                                                    <button type="submit" class="btn btn-default">
                                                        <i class="fas fa-search"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                            <!-- This HTML and Blade code for displaying brand list here -->
                            <table class="table table-hover text-nowrap border-top">
                                <thead class="border-top">
                                    <tr>
                                        <th>
                                            SL No.
                                        </th>
                                        <th>
                                            <a class="sortable-link" href="{{ route('brands.index', ['query' => $query, 'sort_by' => 'name', 'sort_order' => ($sort_by == 'name' && $sort_order == 'asc') ? 'desc' : 'asc']) }}">
                                                Name {!! ($sort_by == 'name') ? ($sort_order == 'asc' ? '<i class="fas fa-sort-up"></i>' : '<i class="fas fa-sort-down"></i>') : '<i class="fas fa-sort"></i>' !!}
                                            </a>
                                        </th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>
                                            <a class="sortable-link" href="{{ route('brands.index', ['query' => $query, 'sort_by' => 'updated_at', 'sort_order' => ($sort_by == 'updated_at' && $sort_order == 'asc') ? 'desc' : 'asc']) }}">
                                                Updated At {!! ($sort_by == 'updated_at') ? ($sort_order == 'asc' ? '<i class="fas fa-sort-up"></i>' : '<i class="fas fa-sort-down"></i>') : '<i class="fas fa-sort"></i>' !!}
                                            </a>
                                        </th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($brands as $brand)
                                        <tr>
                                            <td>{{$brands->firstItem() + $loop->index}}</td>
                                            <td>{{ $brand->name }}</td>
                                            <td>{{ $brand->description }}</td>
                                            <td>
                                                <select name="status" data-id="{{ $brand['id'] }}" data-route="{{route('brands.change-status',$brand)}}" id="status"
                                                    class="onChangeStatus">
                                                    <option value="1" data-id="{{ $brand['id'] }}"
                                                        data-type="status"
                                                        {{ $brand['is_active'] == '1' ? 'selected' : '' }}>Active
                                                    </option>
                                                    <option value="0" data-id="{{ $brand['id'] }}"
                                                        data-type="status"
                                                        {{ $brand['is_active'] == '0' ? 'selected' : '' }}>Inactive
                                                    </option>
                                                </select>
                                            </td>
                                            <td>{{ $brand->updated_at }}</td>
                                            <td>

                                                <x-actions.edit-btn route="brands.edit" label="Edit" :route-params="[$brand->id]" />
                                                <x-actions.delete-btn route="brands.destroy" label="Delete" :route-params="[$brand->id]" alertTitle="Delete {{$brand->name}}"/>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table><!-- End table -->
                        </div> <!-- End div.Card Body -->
                        {{$brands->links()}}
                    </div><!-- End div.Card -->
                </div><!-- End div.col -->
            </div><!-- End div.row -->
        </div><!-- End div.container-fluid -->
    </section><!-- End section -->
</div><!-- End div.content-wrapper -->
@endsection
@section('js')
<script src="{{asset('admin/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}"></script>
<script >
    $(document).ready(function(){
        $(document).on('change', '.onChangeStatus', function() {
            var id = $(this).attr("data-id");
            var route = $(this).attr("data-route");
            $.ajax({
                type: "POST",
                url: route,
                data: {
                    "_token": '{{ csrf_token() }}',
                    "is_active": $(this).val(),
                },
                success: function(data) {
                    toastr.success(data.msg);
                },
                error:function(data){
                    toastr.error(data.msg);
                }
            })
        });
    });
</script>
@endsection
