@extends('layouts.app')

@section('title', 'Permissions')

@section('subtitle', 'Manage your Permissions')
@section('content_header_title', 'Settings')
@section('content_header_subtitle', 'Manage Permissions')

@section('content_body')
    <x-anilte::card headerClass="p-0 border-bottom-0 " bodyClass="" footerClass="custom-footer-class" minimize maximize close>
        <x-slot name="header">
            <x-anilte::tab-nav-item route="admin.settings.permissions.index" icon="fas fa-cogs">Permissions</x-anilte::tab-nav-item>
            <x-anilte::tab-nav-item route="admin.settings.permissions.create" icon="fas fa-cogs">Create Permission</x-anilte::tab-nav-item>
        </x-slot>
        <x-slot name="body">

            <x-anilte::datatable
                url="{{ route('admin.settings.permissions.index') }}"
                :thead="[['data'=>'name','title'=>'Name','sortable'=>true],
                        ['data'=>'guard_name','title'=>'Guard Name','sortable'=>true],
                        ['data'=>'group_name','title'=>'Group Name','sortable'=>true],
                        ['data'=>'updated_at','title'=>'Updated At','sortable'=>true]]"
                :tbody="$permissions"
                :actions="[
                    ['route'=>'admin.settings.permissions.edit','data'=>'edit','title'=>'Edit','icon'=>'fas fa-pencil-alt'],
                    ['route'=>'admin.settings.permissions.destroy','data'=>'delete','title'=>'Delete','alertTitle'=>'Delete','icon'=>'fas fa-trash' ]
                ]"
                :entries="$entries"
                :search="$search"
                :sort_by="$sort_by"
                :sort_order="$sort_order"
                :searchable="true"
                :showentries="true"
                :current_page="$permissions->currentPage()"
                :total="$permissions->total()"
                :per_page="$permissions->perPage()"
            />

        </x-slot>

    </x-anilte::card>
@stop

@push('js')

@endpush
