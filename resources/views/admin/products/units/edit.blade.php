@extends('layouts.app')
@section('title', 'Units')

@section('subtitle', 'Units')
@section('content_header_title', 'Units')
@section('content_header_subtitle', 'Manage Units')
@section('css')
@endsection
@section('content_body')
    <x-anilte::card headerClass="p-0 border-bottom-0 " bodyClass="" footerClass="custom-footer-class" minimize maximize close>
        <x-slot name="header">
                <x-anilte::tab-nav-item route="admin.products.units.index" icon="fas fa-shield-alt">Units</x-anilte::tab-nav-item>
                <x-anilte::tab-nav-item route="admin.products.units.create" icon="fas fa-plus-square">Create Units</x-anilte::tab-nav-item>
                <x-anilte::tab-nav-item route="admin.products.units.edit" routeParams="{{ $unit->id }}" icon="fas fa-plus-square">Edit Unit <small>( {{$unit->unit_name }} )</small> </x-anilte::tab-nav-item>
        </x-slot>
        <x-slot name="body">
            <form action="{{route('admin.products.units.store')}}" method="POST">
                @csrf

                <x-anilte::input-group
                    id="unit_name"
                    name="unit_name"
                    value="{{ $unit->unit_name ?? old('unit_name') }}"
                    placeholder="Enter unit name"
                    :required="true"
                    label="Unit Name"
                    icon="fas fa-user-tag"
                />




                    <div class="form-group d-flex justify-content-between">
                        <x-adminlte-button type="back" label="Back" theme="primary bg-gradient-blue" class="btn-md mt-3" icon="fas fa-arrow-left"/>
                        <x-adminlte-button type="submit" label="Update Unit" theme="primary bg-gradient-blue" class="btn-md mt-3" icon="fas fa-save"/>
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
