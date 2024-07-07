@extends('layouts.app')

@section('title', 'Website Settings')

@section('subtitle', 'Manage your website settings')
@section('content_header_title', 'Settings')
@section('content_header_subtitle', 'Manage Website Settings')

@section('content_body')
    <x-anilte::card headerClass="p-0 border-bottom-0 " bodyClass="" footerClass="custom-footer-class" minimize maximize
        close>
        <x-slot name="header">
            <x-anilte::tab-nav-item route="admin.settings.roles.index" icon="fas fa-cogs">Roles</x-anilte::tab-nav-item>
            <x-anilte::tabs.nav-item route="admin.roles.create" icon="fas fa-plus-square">Create
                Role</x-anilte::tabs.nav-item>
            @if ($role->exists)
                <x-anilte::tabs.nav-item route="admin.roles.edit" routeParams="{{ $role->id }}" icon="fas fa-edit">Edit
                    Role</x-anilte::tabs.nav-item>
            @endif
        </x-slot>
        <x-slot name="body">
            <form method="POST"
                action="{{ $role->exists ? route('admin.roles.update', $role->id) : route('admin.roles.store') }}">
                @csrf
                @if ($role->exists)
                    @method('put')
                @endif
                <div class="form-group">


                    <label for="first_name">
                        First Name
                    </label>


                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text bg-gradient-blue">
                                <i class="fas fa-user"></i>
                            </div>
                        </div>
                        <input id="first_name" name="first_name" value="" class="form-control" placeholder="Enter first name" required="required">
                        <span class="invalid-feedback" role="alert">
                            invalid field first_name
                        </span>
                    </div>





                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="name" class="control-label">{{ __('Name') }}
                                <span class="text-danger">*</span></label>
                            <x-form.input type="text" name="name"
                                value="{{ $role->exists ? $role->name : old('name') }}" />
                            <x-form.error key="name" />
                        </div>
                        <div class="form-group">
                            <label for="guard_name" class="control-label">{{ __('Gaurd Name') }}
                                <span class="text-danger">*</span></label>
                            <x-form.input type="text" name="guard_name"
                                value="{{ $role->exists ? $role->guard_name : old('guard_name') }}" />
                            <x-form.error key="guard_name" />
                        </div>
                        <div class="form-group">
                            <x-form.submit-and-cancel url="{{ url()->previous() }}" />
                        </div>
                    </div>
                    <div class="col-lg-8">
                        @foreach ($permissions as $key => $value)
                            <div class="form-group">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input check-all" id="{{ $key }}"
                                        value="{{ $key }}">
                                    <label class="form-check-label text-primary"
                                        for="{{ $key }}">{{ __(ucfirst($key)) }}</label>
                                </div>
                                <hr class="mt-1">
                                <div class="row">
                                    @foreach ($value as $g)
                                        <div class="col-md-3">
                                            <div class="checkbox">
                                                <label>
                                                    <?php
                                                    $checked = false;
                                                    if (isset($rolePermissions)) {
                                                        if (in_array($g['name'], $rolePermissions)) {
                                                            $checked = true;
                                                        }
                                                    }
                                                    ?>
                                                    <div class="form-check">
                                                        <input type="checkbox" name="perm[]"
                                                            class="form-check-input {{ $key }}"
                                                            id="p-{{ $g->id }}" value="{{ $g->id }}"
                                                            @if ($checked) checked @endif>
                                                        <label class="form-check-label"
                                                            for="p-{{ $g->id }}">{{ __($g->name) }}</label>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </form>
        </x-slot>

    </x-anilte::card>
@stop

@push('js')
@endpush
