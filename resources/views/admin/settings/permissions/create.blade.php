@extends('layouts.app')

@section('title', 'Website Settings')

@section('subtitle', 'Manage your website settings')
@section('content_header_title', 'Settings')
@section('content_header_subtitle', 'Manage Website Settings')

@section('content_body')
    <x-anilte::card headerClass="p-0 border-bottom-0 " bodyClass="" footerClass="custom-footer-class" minimize maximize close>
        <x-slot name="header">
                <x-anilte::tab-nav-item route="admin.settings.permissions.index" icon="fas fa-cogs">Permissions</x-anilte::tab-nav-item>
                <x-anilte::tab-nav-item route="admin.settings.permissions.create" icon="fas fa-cogs">Create Permission</x-anilte::tab-nav-item>
        </x-slot>
        <x-slot name="body">
            <form method="POST" action="{{ isset($permission->exists) && $permission->exists ? route('admin.settings.permissions.update', $permission->id) : route('admin.settings.permissions.store') }}">
                @csrf
                @if(isset($permission->exists) && $permission->exists)
                    @method('put')
                @endif
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">

                            <x-anilte::input-group
                                id="name"
                                name="name"
                                value="{{ isset($permission->exists) && $permission->exists ? $permission->name : old('name') }}"
                                placeholder="Enter name"
                                :required="true"
                                label="Name"
                                icon="fas fa-user-tag"
                            />

                            <x-anilte::input-group
                                id="guard_name"
                                name="guard_name"
                                value="{{ isset($permission->exists) && $permission->exists ? $permission->guard_name : old('guard_name') }}"
                                placeholder="Enter Guard Name"
                                :required="true"
                                label="Guard Name"
                                icon="fas fa-user-tag"
                            />


                            <x-anilte::input-group
                                id="group_name"
                                name="group_name"
                                value="{{ isset($permission->exists) && $permission->exists ? $permission->group_name : old('group_name') }}"
                                placeholder="Enter Group Name"
                                :required="true"
                                label="Group Name"
                                icon="fas fa-user-tag"
                            />


                            <x-anilte::input-group
                                id="group_order"
                                name="group_order"
                                value="{{ isset($permission->exists) && $permission->exists ? $permission->group_order : old('group_order') }}"
                                placeholder="Enter Group Order"
                                :required="true"
                                label="Group Order"
                                icon="fas fa-user-tag"
                            />
                            <div class="form-group d-flex justify-content-between">
                                <x-adminlte-button type="back" label="Back" theme="primary bg-gradient-blue" class="btn-md mt-3" icon="fas fa-arrow-left"/>
                                <x-adminlte-button type="submit" label="Create Permission" theme="primary bg-gradient-blue" class="btn-md mt-3" icon="fas fa-save"/>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            @foreach($roles as $key => $value)
                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input check-all" id="{{ $key }}" value="{{ $key }}">
                                        <label class="form-check-label text-primary" for="{{ $key }}">{{ __(ucfirst($key)) }}</label>
                                    </div>
                                    <hr class="mt-1">
                                    <div class="row">
                                        @foreach($value as $g)
                                            <div class="col-md-3">
                                                <div class="checkbox">
                                                    <label>
                                                        <?php
                                                        $checked = false;
                                                        // if (isset($rolePermissions)) {
                                                        //     if (in_array($g['name'] , $rolePermissions)) $checked = true;
                                                        // }
                                                        ?>
                                                        <div class="form-check">
                                                            <input type="checkbox" name="perm[]" class="form-check-input {{ $key }}" id="p-{{ $g->id }}" value="{{ $g->id }}" @if($checked) checked @endif>
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

</script>
@endpush
