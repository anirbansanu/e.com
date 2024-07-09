@extends('layouts.app')

@section('title', 'Categories')

@section('subtitle', 'Categories')
@section('content_header_title', 'Categories')
@section('content_header_subtitle', 'Manage Categories')

@section('content_body')

    <x-anilte::card headerClass="p-0 border-bottom-0 " bodyClass="" footerClass="custom-footer-class" minimize maximize close>
        <x-slot name="header">
                <x-anilte::tab-nav-item route="admin.products.categories.index" icon="fas fa-shield-alt">Categories</x-anilte::tab-nav-item>
                <x-anilte::tab-nav-item route="admin.products.categories.create" icon="fas fa-plus-square">Create Categories</x-anilte::tab-nav-item>
        </x-slot>
        <x-slot name="body">
            @php
                $checkboxHtml = function($item) {

                    return "<input type='checkbox' name='is_active' " . ($item->is_active ? 'checked' : '') . "
                                                                data-bootstrap-switch=''
                                                                data-size='small'
                                                                data-on-text='Active'
                                                                data-off-text='Inactive'
                                                                data-on-color='primary bg-gradient-blue'
                                                                data-handle-width='48px'
                                                                data-label-width='8px'
                                                                />";

                };
            @endphp
            <x-anilte::datatable url="{{ route('admin.products.categories.index') }}" :thead="[
                        ['data' => 'name', 'title' => 'Name', 'sortable' => true],
                        ['data' => 'description', 'title' => 'Description', 'class'=> ' text-truncate', 'style'=>'max-width: 150px;', 'sortable' => true ],
                        ['data' => 'is_active', 'title' => 'Status', 'html'=>$checkboxHtml],
                        ['data' => 'updated_at', 'title' => 'Updated At', 'sortable' => true],
                    ]"
                    :tbody="$categories"
                    :actions="[
                        [
                            'route' => 'admin.products.categories.edit',
                            'data' => 'edit',
                            'title' => 'Edit',
                            'icon' => 'fas fa-pencil-alt',
                        ],
                        [
                            'route' => 'admin.products.categories.destroy',
                            'data' => 'delete',
                            'title' => 'Delete',
                            'alertTitle' => 'Delete',
                            'icon' => 'fas fa-trash',
                        ],
                    ]"
                    :entries="$entries" :search="$search" :sort_by="$sort_by" :sort_order="$sort_order"
                    :searchable="true" :showentries="true" :current_page="$categories->currentPage()" :total="$categories->total()" :per_page="$categories->perPage()"
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

