@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Welcome')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'Welcome')

{{-- Content body: main page content --}}

@section('content_body')

    {{-- Setup data for datatables --}}
    @php
        $heads = [
            'ID',
            'Name',
            ['label' => 'Email', 'width' => 40],
            ['label' => 'Updated At', 'width' => 40],
            ['label' => 'Actions', 'no-export' => true, 'width' => 5],
        ];
        $_btns = [
            'btnEdit' => '<button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                <i class="fa fa-lg fa-fw fa-pen"></i>
            </button>',
            'btnDelete' => '<button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                  <i class="fa fa-lg fa-fw fa-trash"></i>
              </button>',
            'btnDetails' => '<button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                   <i class="fa fa-lg fa-fw fa-eye"></i>
               </button>',
        ];

        $config = [
            'data' => $data,
            'order' => [[1, 'asc']],
            'columns' => ['id', 'name', 'email', 'updated_at', ['orderable' => false]],
        ];
        $columns = ['id', 'name', 'email', 'updated_at'];
    @endphp

    {{-- Minimal example / fill data using the component slot --}}
    <x-adminlte-datatable id="table1" :heads="$heads">
        @foreach ($config['data'] as $row)
            <tr>
                @foreach ($columns as $cell)
                    <td>{!! $row[$cell] !!}</td>
                @endforeach
                <td class="d-flex">
                    @foreach ($_btns as $cell)
                    {!! $cell !!}
                    @endforeach
                </td>
            </tr>
        @endforeach
    </x-adminlte-datatable>

    {{-- Compressed with style options / fill data using the plugin config --}}
    <x-adminlte-datatable id="table2" :heads="$heads" head-theme="light" :config="$config" striped hoverable bordered
        compressed />
@stop

{{-- Push extra CSS --}}

@push('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@endpush

{{-- Push extra scripts --}}

@push('js')
    <script>
        console.log("Hi, I'm using the Laravel-AdminLTE package!");
    </script>
@endpush
