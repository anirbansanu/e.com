@extends('layouts.app')

@section('title', 'Create User')

@section('subtitle', 'Welcome')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'Users Management')


@section('content_body')
    <x-anilte::card headerClass="p-0 pt-1 border-bottom-0" bodyClass="" footerClass="custom-footer-class" minimize maximize close>
        <x-slot name="header">
            <div class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                <x-anilte::tab-nav-item route="users.index" icon="fas fa-list-alt ">Users</x-anilte::tab-nav-item>

                <x-anilte::tab-nav-item route="users.create" icon="fas fa-plus-square">Create User</x-anilte::tab-nav-item>

                <x-anilte::tab-nav-item route="users.show" :routeParams="['user'=>$user->id]" icon="fas fa-info">User Details</x-anilte::tab-nav-item>

                <x-anilte::tab-nav-item route="users.trash" icon="fas fa-trash-alt">Trash</x-anilte::tab-nav-item>
            </div>
        </x-slot>

        <x-slot name="body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>First Name:</strong> {{ $user->first_name }}</p>
                    <p><strong>Last Name:</strong> {{ $user->last_name }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Username:</strong> {{ $user->username }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Roles:</strong></p>
                    <ul>
                        @foreach ($user->roles as $role)
                            <li>{{ $role->name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Back to Users</a>
            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Edit User</a>
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
