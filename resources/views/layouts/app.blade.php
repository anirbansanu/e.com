@extends('adminlte::page')

{{-- Extend and customize the browser title --}}

@section('title')
    {{ config('adminlte.title') }}
    @hasSection('subtitle') | @yield('subtitle') @endif
@stop
@section('adminlte_css')
    @hasSection('css')  @yield('css') @endif
@stop
{{-- Extend and customize the page content header --}}

@section('content_header')
    @hasSection('content_header_title')
        <h1 class="text-muted">
            @yield('content_header_title')

            @hasSection('content_header_subtitle')
                <small class="text-dark">
                    <i class="fas fa-xs fa-angle-right text-muted"></i>
                    @yield('content_header_subtitle')
                </small>
            @endif
        </h1>
    @endif
@stop

{{-- Rename section content to content_body --}}

@section('content')
    @yield('content_body')
@stop

{{-- Create a common footer --}}

@section('footer')
    <div class="float-right">
        Version: {{ config('settings.website_version') }}
    </div>

    <strong>
        <a href="{{ config('app.company_url', '#') }}">
            {{ config('settings.app_name') }}
        </a>
    </strong>
@stop

{{-- Add common Javascript/Jquery code --}}

@push('js')



<script>
    window.Swal = Swal;

    $(document).ready(function() {
        @if(session('success'))

            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
            });
        @endif

        @if(session('error'))

            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: '{{ session('error') }}',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
            });
        @endif

        @if ($errors->any())

            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: '{{ $errors->first() }}',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
            });
        @endif




    });

</script>
@endpush



