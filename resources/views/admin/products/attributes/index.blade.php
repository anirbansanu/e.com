@extends('layouts.app')

@section('title', 'Attributes')

@section('subtitle', 'Attributes')
@section('content_header_title', 'Attributes')
@section('content_header_subtitle', 'Manage Attributes')

@section('content_body')

    <x-anilte::card headerClass="p-0 border-bottom-0 " bodyClass="" footerClass="custom-footer-class" minimize maximize close>
        <x-slot name="header">
                <x-anilte::tab-nav-item route="admin.products.attributes.index" icon="fas fa-shield-alt">Attributes</x-anilte::tab-nav-item>
                <x-anilte::tab-nav-item route="admin.products.attributes.create" icon="fas fa-plus-square">Create Attributes</x-anilte::tab-nav-item>
        </x-slot>
        <x-slot name="body">
            @php
                $checkboxHtml = function($item) {

                    return "<input type='checkbox' name='has_unit' " . ($item->has_unit ? 'checked' : '') . "
                                                                data-bootstrap-switch=''
                                                                data-size='small'
                                                                data-on-text='Yes'
                                                                data-off-text='No'
                                                                data-on-color='primary bg-gradient-blue'
                                                                data-handle-width='48px'
                                                                data-label-width='8px'
                                                                />";

                };
            @endphp
            <x-anilte::datatable url="{{ route('admin.products.attributes.index') }}" :thead="[
                        ['data' => 'name', 'title' => 'Name', 'sortable' => true],
                        ['data' => 'has_unit', 'title' => 'Has Unit', 'html'=>$checkboxHtml],
                        ['data' => 'updated_at', 'title' => 'Updated At', 'sortable' => true],
                    ]"
                    :tbody="$attributes"
                    :actions="[
                        [
                            'route' => 'admin.products.attributes.edit',
                            'data' => 'edit',
                            'title' => 'Edit',
                            'icon' => 'fas fa-pencil-alt',
                        ],
                        [
                            'route' => 'admin.products.attributes.destroy',
                            'data' => 'delete',
                            'title' => 'Delete',
                            'alertTitle' => 'Delete',
                            'icon' => 'fas fa-trash',
                        ],
                    ]"
                    :entries="$entries" :search="$search" :sort_by="$sort_by" :sort_order="$sort_order"
                    :searchable="true" :showentries="true" :current_page="$attributes->currentPage()" :total="$attributes->total()" :per_page="$attributes->perPage()"
                />


        </x-slot>

    </x-anilte::card>
@stop
 @push('js')
    <script src="{{asset('vendor/bootstrap-switch/js/bootstrap-switch.min.js')}}"></script>
<script>
     $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });
</script>
@endpush

