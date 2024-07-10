@extends('layouts.app')

@section('title', 'Website Settings')

@section('subtitle', 'Manage your website settings')
@section('content_header_title', 'Settings')
@section('content_header_subtitle', 'Manage Website Settings')

@section('content_body')
    <x-anilte::card headerClass="p-0 border-bottom-0 " bodyClass="" footerClass="custom-footer-class" minimize maximize close>
        <x-slot name="header">
                <x-anilte::tab-nav-item route="admin.settings.permissions.index" icon="fas fa-shield-alt">Permissions</x-anilte::tab-nav-item>
                <x-anilte::tab-nav-item route="admin.settings.permissions.create" icon="fas fa-plus-square">Create Permission</x-anilte::tab-nav-item>
                @if(isset($permission->exists) && $permission->exists)
                    <x-anilte::tab-nav-item route="admin.settings.permissions.edit" routeParams="{{$permission->id}}" icon="fas fa-edit">Edit Permission</x-anilte::tab-nav-item>
                @endif
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



                            <div id="single-name-input">
                                <x-anilte::input-group
                                    id="name"
                                    name="name"
                                    value="{{ isset($permission->exists) && $permission->exists ? $permission->name : old('name') }}"
                                    placeholder="Enter name"
                                    label="Name"
                                    icon="fas fa-user-tag"
                                />
                            </div>

                            <div id="bulk-names-input" style="display: none;">
                                <x-anilte::input-group
                                    id="permission_names"
                                    name="permission_names"
                                    placeholder="Enter permission names separated by comma (,)"
                                    label="Permission Names"
                                    icon="fas fa-user-tag"
                                    value="{{ old('permission_names') }}"
                                />
                            </div>

                            <x-adminlte-input-switch
                                id="enable_bulk_update"
                                name="enable_bulk_update"
                                label="Enable Bluk Update"
                                class="d-flex justify-content-end"
                                data-on-text="Yes"
                                data-off-text="No"
                                data-on-color="primary bg-gradient-blue"
                                data-handle-width='51px'
                                data-label-width='15px'
                                igroup-size="sm"
                                :checked="old('enable_bulk_update')"
                                
                            />
                            <x-anilte::input-group
                                id="guard_name"
                                name="guard_name"
                                value="{{ isset($permission->exists) && $permission->exists ? $permission->guard_name : old('guard_name') }}"
                                placeholder="Enter Guard Name"
                                :required="true"
                                label="Guard Name"
                                icon="fas fa-user-shield"
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
                                <x-adminlte-button type="submit" :label="isset($permission->exists) && $permission->exists ? 'Update Permission' : 'Create Permission'" theme="primary bg-gradient-blue" class="btn-md mt-3" icon="fas fa-save"/>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            @foreach($roles as $key => $value)
                                <div class="form-group">
                                    <div class="pl-3 pb-2 mb-2 border-bottom border-primary font-weight-bold rounded-pill">
                                        <div class="form-check ml-1">
                                            <input type="checkbox" class="form-check-input check-all border border-primary shadow-sm" id="{{ $key }}" value="{{ $key }}">
                                            <label class="form-check-label text-primary" for="{{ $key }}">{{ __(ucfirst($key)) }}</label>
                                        </div>
                                    </div>
                                    <div class="row ml-4">
                                        @foreach($value as $g)
                                            <div class="col-md-3 ">
                                                <div class="checkbox">
                                                    <label>
                                                        <div class="form-check ">
                                                            <input
                                                                type="checkbox"
                                                                name="roles[]"
                                                                class="form-check-input {{ $key }} border border-primary shadow-sm"
                                                                id="p-{{ $g->id }}"
                                                                value="{{ $g->id }}"
                                                                @if(isset($rolesByPermission) && in_array($g->id, $rolesByPermission)) checked @endif
                                                            />
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






        $('#enable_bulk_update').on('switchChange.bootstrapSwitch', function(event, state) {
                onSwitchChange(state);
        });
        function onSwitchChange(state) {
            if (state) {
                console.log("Switch is ON", state);
                $('#single-name-input').hide();
                $('#bulk-names-input').show();
            } else {
                console.log("Switch is OFF", state);
                $('#single-name-input').show();
                $('#bulk-names-input').hide();
            }
        }
    });

</script>
@endpush
