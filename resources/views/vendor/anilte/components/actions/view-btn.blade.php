@props(['route','routeParams'=> [], 'icon','label'])
@can($route)
<a href="{{ route($route, $routeParams) }}" class="btn btn-sm btn-info">
    <i class="{{$icon??"fas fa-folder"}}">
    </i>
    {{$label}}
</a>
@endcan
