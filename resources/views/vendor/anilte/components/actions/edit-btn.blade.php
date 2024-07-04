{{-- resources/views/vendor/anilte/components/actions/edit-btn.blade.php --}}
@props(['route', 'routeParams' => [], 'icon' => 'fas fa-pencil-alt', 'label' => 'Edit'])

{{-- @can($route) --}}
    <a href="{{ route($route, $routeParams) }}" class="btn btn-sm btn-info font-weight-bold">
        <i class="{{ $icon }}"></i>
        {{ $label }}
    </a>
{{-- @endcan --}}
