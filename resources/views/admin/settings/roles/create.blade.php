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
                @if(isset($role))
                    <x-anilte::tab-nav-item route="admin.settings.roles.edit" routeParams="{{$role->id}}" icon="fas fa-edit">Edit Role</x-anilte::tab-nav-item>
                @endif
        </x-slot>
        <x-slot name="body">
            <form method="POST" action="{{ isset($role) ? route('admin.settings.roles.update', $role->id) : route('admin.settings.roles.store') }}">
                @csrf
                @if(isset($role))
                    @method('put')
                @endif

                <div class="row">
                    <div class="col-lg-4">

                        <x-anilte::input-group
                            id="name"
                            name="name"
                            value="{{ isset($role->exists) && $role->exists ? $role->name : old('name') }}"
                            placeholder="Enter Name"
                            :required="true"
                            label="Name"
                            icon="fas fa-user-tag"
                        />

                        <x-anilte::input-group
                            id="guard_name"
                            name="guard_name"
                            value="{{ isset($role->exists) && $role->exists ? $role->guard_name : old('guard_name') }}"
                            placeholder="Enter Guard Name"
                            :required="true"
                            label="Guard Name"
                            icon="fas fa-user-shield"
                        />

                        <div class="form-group d-flex justify-content-between">
                            <x-adminlte-button type="back" label="Back" theme="primary bg-gradient-blue" class="btn-md mt-3" icon="fas fa-arrow-left"/>
                            <x-adminlte-button type="submit" label="Create Role" theme="primary bg-gradient-blue" class="btn-md mt-3" icon="fas fa-save"/>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        @foreach($permissions as $key => $value)
                            <div class="form-group">
                                <div class="pl-1 pb-2 mb-2 border-bottom border-primary font-weight-bold">
                                    <div class="form-check ml-1">
                                        <input type="checkbox" class="form-check-input check-all" id="{{ $key }}" value="{{ $key }}">
                                        <label class="form-check-label text-primary" for="{{ $key }}">{{ __(ucfirst($key)) }}</label>
                                    </div>
                                </div>
                                <hr class="mt-1">
                                <div class="row">
                                    @foreach($value as $g)
                                        <div class="col-md-3">
                                            <div class="checkbox">
                                                <label>

                                                    <div class="form-check">
                                                        <input type="checkbox"
                                                                name="perm[]"
                                                                class="form-check-input {{ $key }}"
                                                                id="p-{{ $g->id }}"
                                                                value="{{ $g->name }}"
                                                                @if(isset($rolePermissions) && in_array($g->id, $rolePermissions)) checked @endif>
                                                        <label class="form-check-label" for="p-{{ $g->id }}">{{ __($g->name) }}</label>
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
<script >
    $(document).ready(function(){
        $(function () {
            $('.check-all').change(function () {
                var me = $(this);
                if(me.prop('checked')) {
                    $('.' + me.val()).prop('checked', true);
                } else {
                    $('.' + me.val()).prop('checked', false);
                }
            });
        });


        $(document).on('keyup', '#name', (ev) => {
            let nameValue = $('#name').val();
            let slug = slugify(nameValue);
            $('#slug').val(slug);
        });
        $("input[data-bootstrap-switch]").each(function(){
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
            $(this).on('switchChange.bootstrapSwitch', function(event, state) {
                onSwitchChange(state);
            });
        });
        function onSwitchChange(state) {
            if (state) {
            console.log("Switch is ON",state);
            // Perform actions when switch is ON
            } else {
            console.log("Switch is OFF",state);
            // Perform actions when switch is OFF
            }
        }
    });
    function slugify(text) {
    return text.toString().toLowerCase()
        .replace(/\s+/g, '_')           // Replace spaces with -
        .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
        .replace(/\-\-+/g, '-')         // Replace multiple - with single -
        .replace(/^-+/, '')             // Trim - from start of text
        .replace(/-+$/, '');            // Trim - from end of text
    }
</script>
@endpush
