@extends('layouts.app')

@section('title', 'Units')

@section('subtitle', 'Units')
@section('content_header_title', 'Units')
@section('content_header_subtitle', 'Manage Units')

@section('content_body')

    <x-anilte::card headerClass="p-0 border-bottom-0 " bodyClass="" footerClass="custom-footer-class" minimize maximize close>
        <x-slot name="header">
                <x-anilte::tab-nav-item route="admin.products.units.index" icon="fas fa-shield-alt">Units</x-anilte::tab-nav-item>
                <x-anilte::tab-nav-item route="admin.products.units.create" icon="fas fa-plus-square">Create Units</x-anilte::tab-nav-item>
        </x-slot>
        <x-slot name="body">

            <x-anilte::datatable url="{{ route('admin.products.units.index') }}" :thead="[
                        ['data' => 'unit_name', 'title' => 'Unit Name', 'sortable' => true],
                        ['data' => 'updated_at', 'title' => 'Updated At', 'sortable' => true],
                    ]"
                    :tbody="$units"
                    :actions="[
                        [
                            'route' => 'admin.products.units.edit',
                            'data' => 'edit',
                            'title' => 'Edit',
                            'icon' => 'fas fa-pencil-alt',
                        ],
                        [
                            'route' => 'admin.products.units.destroy',
                            'data' => 'delete',
                            'title' => 'Delete',
                            'alertTitle' => 'Delete',
                            'icon' => 'fas fa-trash',
                        ],
                    ]"
                    :entries="$entries" :search="$search" :sort_by="$sort_by" :sort_order="$sort_order"
                    :searchable="true" :showentries="true" :current_page="$units->currentPage()" :total="$units->total()" :per_page="$units->perPage()"
                />


        </x-slot>

    </x-anilte::card>
@stop
@push('js')

@endpush

