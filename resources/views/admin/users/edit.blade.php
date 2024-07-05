@extends('layouts.app')

@section('title', 'Edit User')

@section('subtitle', 'Welcome')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'Users Management')

@section('content_body')
    <x-anilte::card headerClass="p-0 pt-1 border-bottom-0" bodyClass="" footerClass="custom-footer-class" minimize maximize close>
        <x-slot name="header">
            <div class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                <x-anilte::tab-nav-item route="users.index" icon="fas fa-list-alt ">Users</x-anilte::tab-nav-item>

                <x-anilte::tab-nav-item route="users.create" icon="fas fa-plus-square">Create User</x-anilte::tab-nav-item>

                <x-anilte::tab-nav-item route="users.trash" icon="fas fa-trash-alt">Trash</x-anilte::tab-nav-item>
            </div>
        </x-slot>

        <x-slot name="body">
            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <x-adminlte-input name="first_name" label="First Name" placeholder="Enter first name" value="{{ $user->first_name }}" required>
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-blue">
                                    <i class="fas fa-user"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-input name="last_name" label="Last Name" placeholder="Enter last name" value="{{ $user->last_name }}" required>
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-blue">
                                    <i class="fas fa-user"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <x-adminlte-input name="email" type="email" label="Email" placeholder="Enter email" value="{{ $user->email }}" required>
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-blue">
                                    <i class="fas fa-envelope"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-input name="username" id="username" label="Username" placeholder="Generated username" value="{{ $user->username }}" readonly required>
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-blue">
                                    <i class="fas fa-user-tag"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        @php
                            $config = [
                                'placeholder' => 'Select multiple options...',
                                'allowClear' => true,
                            ];
                        @endphp
                        <x-adminlte-select2 id="roles" name="roles[]" label="Roles" label-class="text-dark" igroup-size="md" :config="$config" multiple>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}" {{ in_array($role->name, $userRoles) ? 'selected' : '' }}>{{ $role->name }}</option>
                            @endforeach
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-blue">
                                    <i class="fas fa-tag"></i>
                                </div>
                            </x-slot>
                            <x-slot name="appendSlot">
                                <x-adminlte-button theme="outline-dark" label="Clear" class="bg-gradient-blue border-0" icon="fas fa-lg fa-ban text-gradient-blue" id="clearRoles"/>
                            </x-slot>
                        </x-adminlte-select2>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <x-adminlte-button type="submit" label="Update User" theme="primary" class="btn-block mt-3" icon="fas fa-save"/>
                    </div>
                </div>
            </form>
        </x-slot>
    </x-anilte::card>
@stop

@push('js')
    <script>
        $(document).ready(function() {
            // Clear roles select
            $('#clearRoles').click(function() {
                $('#roles').val(null).trigger('change');
            });

            // Generate username based on first name
            $('input[name="first_name"]').on('input', function() {
                var firstName = $(this).val().toLowerCase().replace(/\s+/g, '');
                if (firstName.length > 0) {
                    $('#username').val(firstName + Math.floor(Math.random() * 10000));
                } else {
                    $('#username').val('');
                }
            });
        });
    </script>
@endpush
