@extends('layouts.app')

@section('title', 'Product Listing')

@section('subtitle', 'Product Listing')
@section('content_header_title', 'Product Listing')
@section('content_header_subtitle', 'Manage Product Listing')

@section('content_body')

    <x-anilte::card headerClass="p-0 border-bottom-0 " bodyClass="" footerClass="custom-footer-class" minimize maximize close>
        <x-slot name="header">
                <x-anilte::tab-nav-item route="admin.products.listing.index" icon="fas fa-shield-alt">Product Listing</x-anilte::tab-nav-item>
                <x-anilte::tab-nav-item route="admin.products.listing.create" icon="fas fa-plus-square">Create Product </x-anilte::tab-nav-item>
        </x-slot>
        <x-slot name="body">
            @php
                $checkboxHtml = function($item) {

                    return "<input type='checkbox' name='has_unit' " . ($item->has_unit ? 'checked' : '') . "
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
            <x-anilte::datatable url="{{ route('admin.products.listing.index') }}" :thead="[
                        ['data' => 'name', 'title' => 'Name', 'sortable' => true],
                        ['data' => 'category', 'title' => 'Category', 'html'=>function($product) {
                            return $product->category ? $product->category->name : 'N/A';
                        }],
                        ['data' => 'brand', 'title' => 'Brand', 'html'=>function($product) {
                            return $product->brand ? $product->brand->name : 'N/A';
                        }],
                        ['data' => 'is_active', 'title' => 'Status', 'html'=>$checkboxHtml],
                        ['data' => 'added_by', 'title' => 'Added By', 'html'=>function($product) {
                            return $product->addedBy ? $product->addedBy->username : 'N/A';
                        }],
                        ['data' => 'updated_at', 'title' => 'Updated At', 'sortable' => true, 'html'=>function($product) {
                            return $product->updated_at->diffForHumans() ?? '';
                        }],
                    ]"
                    :tbody="$products"
                    :actions="[
                        [
                            'route' => 'admin.products.listing.edit',
                            'data' => 'edit',
                            'title' => 'Edit',
                            'icon' => 'fas fa-pencil-alt',
                        ],
                        [
                            'route' => 'admin.products.listing.destroy',
                            'data' => 'delete',
                            'title' => 'Delete',
                            'alertTitle' => 'Delete',
                            'icon' => 'fas fa-trash',
                        ],
                    ]"
                    :entries="$entries" :search="$search" :sort_by="$sort_by" :sort_order="$sort_order"
                    :searchable="true" :showentries="true" :current_page="$products->currentPage()" :total="$products->total()" :per_page="$products->perPage()"
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

