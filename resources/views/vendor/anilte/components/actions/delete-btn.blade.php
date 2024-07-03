@props(['route','routeParams'=> [], 'icon'=>null,'label'=>null, 'alertTitle'=>""])
@can($route)
<a class="btn btn-danger btn-sm btn-delete"
        data-alert-title="{{ $alertTitle }}"
        data-confirm="{{ __('Confirm') }}"
        data-cancel="{{ __('Cancel') }}"
        title="Delete"
        href="{{ route($route, $routeParams) }}">
    <i class="{{$icon ?? 'fas fa-trash'}}"></i>
    {{$label ?? ""}}
</a>
@endcan
