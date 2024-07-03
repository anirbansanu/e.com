@props(['route','routeParams'=> [], 'icon'=>null,'label'=>null])
@can($route)
<a href="{{ route($route, $routeParams) }}" class="btn btn-sm btn-info">
    <i class="{{$icon??"fas fa-pencil-alt"}}">
    </i>
    {{$label ?? ""}}
</a>
@endcan

