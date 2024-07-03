@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Welcome')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'Users Management')

{{-- Content body: main page content --}}

@section('content_body')

    {{-- Setup data for datatables --}}
    @php
        $heads = [
            ['label' => 'Sl.No', 'width' => 8, 'max-width' => '200px'],
            ['label' => 'Name', 'width' => 20],
            ['label' => 'Email', 'width' => 40],
            ['label' => 'Updated At', 'width' => 40],
            ['label' => 'Actions', 'no-export' => true, 'width' => 5],
        ];
        $_btns = [
            'btnDetails' => '<a class="btn btn-xs btn-info mx-1 shadow" title="Details">
                   <i class="fa fa-fw fa-eye"></i>
               </a>',
            'btnEdit' => '<a class="btn btn-xs btn-primary mx-1 shadow" title="Edit">
                <i class="fa fa-fw fa-pen"></i>
            </a>',
            'btnDelete' => '<a class="btn btn-xs btn-danger mx-1 shadow" title="Delete">
                  <i class="fa fa-fw fa-trash"></i>
              </a>',

        ];

        $config = [
            'data' => $data,
            'order' => [[1, 'asc']],
            'columns' => [null, 'name', 'email', 'updated_at'],
        ];
        $columns = ['name', 'email', 'updated_at'];

        $perPage = 5; // Assuming you have a variable that defines the number of rows per page
        $currentPage = request()->get('page', 1);
        $startingSlNo = ($currentPage - 1) * $perPage + 1;
    @endphp
    <x-adminlte-card header-class="fw-bold" body-class="p-0" title="Users Management" theme="primary" icon="fas fa-list-alt" maximizable >

        <x-anilte-datatable
            url="{{ route('users.index') }}"
            :thead="[['data'=>'name','title'=>'Name'],
                    ['data'=>'email','title'=>'Email'],
                    ['data'=>'updated_at','title'=>'Updated At']]"
            :tbody="$data"
            :actions="[['route'=>'users.edit','data'=>'edit','title'=>'Edit','btn-class'=>'btn-info','icon'=>'fas fa-pencil-alt'],
            ['route'=>'users.destroy','data'=>'delete','title'=>'Delete','btn-class'=>'btn-danger btn-delete','icon'=>'fas fa-trash', ]]"
            :entries="request()->get('entries', 10)"
            :search="request()->get('search', '')"
            :sort_by="request()->get('sort_by', 'updated_at')"
            :sort_order="request()->get('sort_order', 'desc')"
            :searchable="true"
            :showentries="true"
            :current_page="$data->currentPage()"
            :total="$data->total()"
            :per_page="$data->perPage()"
        />


        {{-- Compressed with style options / fill data using the plugin config --}}
        {{-- <x-adminlte-datatable id="table1" :heads="$heads" head-theme="light" :config="$config" striped hoverable bordered compressed/> --}}



    </x-adminlte-card>
@stop

{{-- Push extra CSS --}}

@push('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@endpush

{{-- Push extra scripts --}}

@push('js')
    <script>
        console.log("Hi, I'm using the Laravel-AdminLTE package!");
    </script>
@endpush
