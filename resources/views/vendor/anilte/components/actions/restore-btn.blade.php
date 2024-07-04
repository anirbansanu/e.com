{{-- resources/views/vendor/anilte/components/actions/restore-btn.blade.php --}}
@props(['route','routeParams'=> [], 'icon'=>null,'label'])
{{-- @can($route) --}}

<a href="{{ route($route, $routeParams) }}" class="btn btn-sm btn-success font-weight-bold">
    <i class="{{$icon??"fas fa-trash-restore"}}">
    </i>
    {{$label}}
</a>
{{-- @endcan --}}
