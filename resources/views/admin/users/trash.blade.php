@extends('layouts.app')

{{-- Customize layout sections --}}
@section('subtitle', 'Welcome')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'Deleted Users Management')

{{-- Content body: main page content --}}
@section('content_body')

    {{-- Setup data for datatables using anilte --}}
    <x-anilte::card headerClass="p-0 border-bottom-0" bodyClass="p-0" footerClass="custom-footer-class" minimize maximize close>
        <x-slot name="header">
            <div class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                <x-anilte::tab-nav-item route="users.index" icon="fas fa-list-alt">Users</x-anilte::tab-nav-item>
                <x-anilte::tab-nav-item route="users.create" icon="fas fa-plus-square">Create User</x-anilte::tab-nav-item>
                <x-anilte::tab-nav-item route="users.trash" icon="fas fa-trash-alt" active>Trash</x-anilte::tab-nav-item>
            </div>
        </x-slot>
        <x-slot name="body">
            <x-anilte::datatable
                url="{{ route('users.trash') }}"
                :thead="[['data'=>'name','title'=>'Name','sortable'=>true],
                        ['data'=>'email','title'=>'Email','sortable'=>true],
                        ['data'=>'deleted_at','title'=>'Deleted At']]"
                :tbody="$data"
                :actions="[['route'=>'users.restore','data'=>'restore','title'=>'Restore','btn-class'=>'btn-success','icon'=>'fas fa-undo'],
                           ['route'=>'users.forceDelete','data'=>'delete','title'=>'Force Delete','btn-class'=>'btn-danger','icon'=>'fas fa-trash-alt']]"
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
    </x-anilte::card>

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
