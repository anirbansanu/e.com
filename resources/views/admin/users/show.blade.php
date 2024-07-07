@extends('layouts.app')

@section('title', 'User Details')

@section('subtitle', 'Welcome')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'Users Management')

@section('content_body')
    <x-anilte::card headerClass="p-0 border-bottom-0 border-primary" bodyClass="" footerClass="custom-footer-class" minimize maximize close>
        <x-slot name="header">
                <x-anilte::tab-nav-item route="users.index" icon="fas fa-list-alt ">Users</x-anilte::tab-nav-item>

                <x-anilte::tab-nav-item route="users.create" icon="fas fa-plus-square">Create User</x-anilte::tab-nav-item>

                <x-anilte::tab-nav-item route="users.show" :routeParams="['user'=>$user->id]" icon="fas fa-info">User Details</x-anilte::tab-nav-item>

                <x-anilte::tab-nav-item route="users.trash" icon="fas fa-trash-alt">Trash</x-anilte::tab-nav-item>
        </x-slot>

        <x-slot name="body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <strong>First Name:</strong>
                        <p>{{ $user->first_name }}</p>
                    </div>
                    <div class="mb-3">
                        <strong>Last Name:</strong>
                        <p>{{ $user->last_name }}</p>
                    </div>
                    <div class="mb-3">
                        <strong>Email:</strong>
                        <p>{{ $user->email }}</p>
                    </div>
                    <div class="mb-3">
                        <strong>Username:</strong>
                        <p>{{ $user->username }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <strong>Roles:</strong>
                        <ul class="list-unstyled">
                            @foreach ($user->roles as $role)
                                <li class="badge badge-info">{{ $role->name }}</li>
                            @endforeach
                        </ul>
                    </div>
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
        console.log("");
    </script>
@endpush
