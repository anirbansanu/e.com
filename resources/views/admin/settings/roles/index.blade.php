@extends('layouts.app')

@section('title', 'Website Settings')

@section('subtitle', 'Manage your website settings')
@section('content_header_title', 'Settings')
@section('content_header_subtitle', 'Manage Website Settings')

@section('content_body')
    <x-anilte::card headerClass="p-0 border-bottom-0 " bodyClass="" footerClass="custom-footer-class" minimize maximize close>
        <x-slot name="header">
                <x-anilte::tab-nav-item route="admin.settings.roles.index" icon="fas fa-cogs">Roles</x-anilte::tab-nav-item>
                <x-anilte::tab-nav-item route="admin.settings.roles.create" icon="fas fa-plus-square">Create Role</x-anilte::tab-nav-item>
        </x-slot>
        <x-slot name="body">
            <x-anilte::datatable
                url="{{ route('admin.settings.roles.index') }}"
                :thead="[['data'=>'name','title'=>'Name'],
                        // ['data'=>'permissions','title'=>'Permissions']
                        ]"
                :tbody="$roles"
                :actions="[
                    ['route'=>'admin.settings.roles.edit','data'=>'edit','title'=>'Edit','btn-class'=>'btn-info','icon'=>'fas fa-pencil-alt'],
                    ['route'=>'admin.settings.roles.destroy','data'=>'delete','title'=>'Delete','btn-class'=>'btn-danger btn-delete','icon'=>'fas fa-trash',]
                ]"
            />
        </x-slot>

    </x-anilte::card>
@stop

@push('js')

@endpush
