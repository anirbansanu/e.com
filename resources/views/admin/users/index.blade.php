@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Welcome')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'Users Management')

{{-- Content body: main page content --}}

@section('content_body')

    {{-- Setup data for datatables using anilte--}}


    <x-anilte::card headerClass="p-0 border-bottom-0" bodyClass="p-0" footerClass="custom-footer-class" minimize maximize close>
        <x-slot name="header">
                <x-anilte::tab-nav-item route="users.index" icon="fas fa-list-alt ">Users</x-anilte::tab-nav-item>

                <x-anilte::tab-nav-item route="users.create" icon="fas fa-plus-square">Create User</x-anilte::tab-nav-item>

                <x-anilte::tab-nav-item route="users.trash" icon="fas fa-trash-alt">Trash</x-anilte::tab-nav-item>

        </x-slot>
        <x-slot name="body">
            <x-anilte::datatable
                url="{{ route('users.index') }}"
                :thead="[['data'=>'first_name','title'=>'First Name','sortable'=>true],
                        ['data'=>'last_name','title'=>'Last Name','sortable'=>true],
                        ['data'=>'username','title'=>'Username','sortable'=>true],
                        ['data'=>'email','title'=>'Email','sortable'=>true],
                        ['data'=>'updated_at','title'=>'Updated At','sortable'=>true]]"
                :tbody="$data"
                :actions="[
                    ['route' => 'users.show', 'data' => 'view', 'icon' => 'fas fa-eye', 'title' => 'View'],
                    ['route'=>'users.edit','data'=>'edit','title'=>'Edit','icon'=>'fas fa-pencil-alt'],

                    ['route'=>'users.destroy','data'=>'delete','title'=>'Delete','alertTitle'=>'Delete','icon'=>'fas fa-trash' ]
                ]"
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
        </x-slot>
        {{-- <x-slot name="footer">
            <div>This is a sample footer</div>
        </x-slot> --}}
    </x-anilte::card>
        {{-- Compressed with style options / fill data using the plugin config --}}
        {{-- <x-adminlte-datatable id="table1" :heads="$heads" head-theme="light" :config="$config" striped hoverable bordered compressed/> --}}


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
