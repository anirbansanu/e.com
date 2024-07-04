{{--  This is the component blade code of delete button --}}
@props([
    'route',
    'routeParams' => [],
    'icon' => null,
    'label' => null,
    'alertTitle' => "Are you sure?",
    'text' => 'You won\'t be able to revert this!',
    'iconType' => 'warning',
    'cancelBtn' => true,
    'confirmText' => 'Yes, delete it!',
    'cancelText' => 'Cancel'
])

{{-- @can($route) --}}
<a class="btn btn-danger btn-sm btn-sw font-weight-bold"
    data-alert-title="{{ $alertTitle }}"
    data-text="{{ $text }}"
    data-icon="{{ $iconType }}"
    data-cancel-btn="{{ $cancelBtn }}"
    data-confirm-text="{{ $confirmText }}"
    data-cancel-text="{{ $cancelText }}"
    title="Delete"
    href="{{ route($route, $routeParams) }}">
    <i class="{{ $icon ?? 'fas fa-trash' }}"></i>
    {{ $label ?? '' }}
</a>
{{-- @endcan --}}
