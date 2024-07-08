@extends('layouts.app')

@section('title', 'Brands')

@section('subtitle', 'Brands')
@section('content_header_title', 'Brands')
@section('content_header_subtitle', 'Manage Brands')

@section('css')
<link rel="stylesheet" href="{{asset('vendor/bootstrap-switch/css/bootstrap3/bootstrap-switch.min.css')}}">

@endsection

@section('content_body')

    <x-anilte::card headerClass="p-0 border-bottom-0 " bodyClass="" footerClass="custom-footer-class" minimize maximize close>
        <x-slot name="header">
                <x-anilte::tab-nav-item route="admin.products.brands.index" icon="fas fa-shield-alt">brands</x-anilte::tab-nav-item>
                <x-anilte::tab-nav-item route="admin.products.brands.create" icon="fas fa-plus-square">Create Permission</x-anilte::tab-nav-item>
        </x-slot>
        <x-slot name="body">
            @php
                $checkboxHtml = function($item) {

                    return "<input type='checkbox' name='is_active' " . ($item->is_active ? 'checked' : '') . "
                                                                data-bootstrap-switch=''
                                                                data-size='small'
                                                                data-on-text='Active'
                                                                data-off-text='Inactive'
                                                                data-handle-width='15px'
                                                                data-label-width='3px'
                                                                />";
                };
            @endphp
            <x-anilte::datatable url="{{ route('admin.products.brands.index') }}" :thead="[
                        ['data' => 'name', 'title' => 'Name', 'sortable' => true],
                        ['data' => 'description', 'title' => 'Description', 'class'=> ' text-truncate', 'style'=>'max-width: 150px;', 'sortable' => true ],
                        ['data' => 'is_active', 'title' => 'Status', 'html'=>$checkboxHtml],
                        ['data' => 'updated_at', 'title' => 'Updated At', 'sortable' => true],
                    ]"
                    :tbody="$brands"
                    :actions="[
                        [
                            'route' => 'admin.products.brands.edit',
                            'data' => 'edit',
                            'title' => 'Edit',
                            'icon' => 'fas fa-pencil-alt',
                        ],
                        [
                            'route' => 'admin.products.brands.destroy',
                            'data' => 'delete',
                            'title' => 'Delete',
                            'alertTitle' => 'Delete',
                            'icon' => 'fas fa-trash',
                        ],
                    ]"
                    :entries="$entries" :search="$search" :sort_by="$sort_by" :sort_order="$sort_order"
                    :searchable="true" :showentries="true" :current_page="$brands->currentPage()" :total="$brands->total()" :per_page="$brands->perPage()"
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

