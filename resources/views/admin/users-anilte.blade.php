@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Welcome')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'Users Management')

{{-- Content body: main page content --}}

@section('content_body')

    {{-- Setup data for datatables using anilte--}}
    
    <x-adminlte-card header-class="fw-bold" body-class="p-0" title="Users Management" theme="primary" icon="fas fa-list-alt" maximizable >

        <x-anilte-datatable
            url="{{ route('users.index') }}"
            :thead="[['data'=>'name','title'=>'Name'],
                    ['data'=>'email','title'=>'Email'],
                    ['data'=>'updated_at','title'=>'Updated At']]"
            :tbody="$data"
            :actions="[['route'=>'users.edit','data'=>'edit','title'=>'Edit','btn-class'=>'btn-info','icon'=>'fas fa-pencil-alt'],
            ['route'=>'users.destroy','data'=>'delete','title'=>'Delete','btn-class'=>'btn-danger btn-delete','icon'=>'fas fa-trash', ]]"
            :entries="$entries"
            :search="$search"
            :sort_by="$sort_by"
            :sort_order="$sort_order"
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
