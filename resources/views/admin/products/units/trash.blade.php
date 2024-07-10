@extends('admin.layouts.app')
@section('title')
     Product Unit Trash List
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
                                <x-tabs.nav-item route="admin.product_units.index" icon="fas fa-list-alt ">Product Unit List</x-tabs.nav-item>
                                <x-tabs.nav-item route="admin.product_units.create" icon="fas fa-plus-square">Add Product Unit</x-tabs.nav-item>
                                <x-tabs.nav-item route="admin.product_units.trash" icon="fas fa-trash">Trash List</x-tabs.nav-item>
                            </div>

                        </div>
                        <div class="card-body table-responsive p-0">
                            <div class="row m-0 p-2">

                                <div class="col-sm-12 col-md-6">

                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="d-flex justify-content-end">
                                        <form action="{{ route('admin.product_units.index') }}" method="GET">
                                            <div class="input-group input-group-sm" style="width: 250px;">
                                                <input type="text" name="query"
                                                    class="form-control float-right" placeholder="Search by Unit Name" value="{{$query??""}}">
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
                            <!-- This HTML and Blade code for displaying category list here -->
                            <table class="table table-hover text-nowrap border-top">
                                <thead class="border-top">
                                    <tr>
                                        <th>Sl no.</th>
                                        <th>
                                            <a class="sortable-link" href="{{ route('admin.product_units.index', ['query' => $query, 'sort_by' => 'unit_name', 'sort_order' => ($sort_by == 'unit_name' && $sort_order == 'asc') ? 'desc' : 'asc']) }}">
                                                Unit Name {!! ($sort_by == 'unit_name') ? ($sort_order == 'asc' ? '<i class="fas fa-sort-up"></i>' : '<i class="fas fa-sort-down"></i>') : '<i class="fas fa-sort"></i>' !!}
                                            </a>
                                        </th>

                                        <th>Deleted At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($product_units as $product_unit)
                                        <tr>
                                            <td>{{ $product_unit->id }}</td>
                                            <td>{{ $product_unit->unit_name }}</td>

                                            <td>{{ $product_unit->deleted_at }}</td>
                                            <td>
                                                <x-actions.edit-btn route="admin.product_units.untrash" label="Restore" :route-params="[$product_unit->id]" />
                                                <x-actions.delete-btn route="admin.product_units.forceDelete" label="Delete" :route-params="[$product_unit->id]" alertTitle="Force delete {{$product_unit->unit_name}}"/>


                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table><!-- End table -->
                        </div> <!-- End div.Card Body -->
                        {{$product_units->links()}}
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
