@extends('layouts.app')
@section('title', 'Attributes')

@section('subtitle', 'Attributes')
@section('content_header_title', 'Attributes')
@section('content_header_subtitle', 'Manage Attributes')
@section('css')
@endsection
@section('content_body')
    <x-anilte::card headerClass="p-0 border-bottom-0 " bodyClass="" footerClass="custom-footer-class" minimize maximize close>
        <x-slot name="header">
                <x-anilte::tab-nav-item route="admin.products.attributes.index" icon="fas fa-shield-alt">Attributes</x-anilte::tab-nav-item>
                <x-anilte::tab-nav-item route="admin.products.attributes.create" icon="fas fa-plus-square">Create Attributes</x-anilte::tab-nav-item>
        </x-slot>
        <x-slot name="body">
            <form action="{{route('admin.products.attributes.store')}}" method="POST">
                @csrf

                <x-anilte::input-group
                    id="name"
                    name="name"
                    value=""
                    placeholder="Enter Name"
                    :required="true"
                    label="Name"
                    icon="fas fa-user-tag"
                />

                <x-adminlte-input-switch name="has_unit"
                    label="Status"
                    class="d-flex justify-content-end"
                    data-on-text="Active"
                    data-off-text="Inactive"
                    data-on-color="primary bg-gradient-blue"
                    data-handle-width='51px'
                    data-label-width='15px'
                    igroup-size="sm"
                />


               



                    <div class="form-group d-flex justify-content-between">
                        <x-adminlte-button type="back" label="Back" theme="primary bg-gradient-blue" class="btn-md mt-3" icon="fas fa-arrow-left"/>
                        <x-adminlte-button type="submit" label="Create Attribute" theme="primary bg-gradient-blue" class="btn-md mt-3" icon="fas fa-save"/>
                    </div>
            </form>
        </x-slot>

    </x-anilte::card>

@endsection
{{-- @section('js')
<script src="{{ asset('admin/plugins/jquery-validation/jquery.validate.min.js') }}"></script>

<script src="{{asset('admin/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}"></script>
<script >
    $(document).ready(function(){

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
@endsection --}}
