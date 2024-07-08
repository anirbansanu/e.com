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

        $(document).on('click', ".btn-sw", function (e) {
            e.preventDefault();
            let me = $(this);
            let url = me.attr('href');
            console.log("btn-sweetalert");
            console.log(url);
            Swal.fire({
                title: me.data('alert-title'),
                text: me.data('text'),
                icon: me.data('icon'),
                showCancelButton: me.data('cancel-btn'),
                confirmButtonText: me.data('confirm-text'),
                cancelButtonText: me.data('cancel-text'),
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        method: 'POST',
                        beforeSend: function(xhr) {
                            xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                        },
                        data: {
                            _method: 'DELETE', // Method spoofing for DELETE request
                        },
                        success: function (response) {
                            let data = response;
                            console.log(data);
                            if (data.error) {
                                Swal.fire(data.message, '', 'warning');
                            } else {
                                Swal.fire(data.message, '', 'success').then(function() {
                                    window.location.reload(); // Reload window after success
                                });
                            }
                        },
                        error: function (error) {
                            Swal.fire(error.responseJSON.message, '', "warning");
                            console.log(error);
                        }
                    });
                }
            });
        });


    });

</script>
@endpush



