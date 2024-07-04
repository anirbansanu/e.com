<!-- resources/views/vendor/anilte/components/tabs/tab-nav-item.blade.php -->
@props(['route', 'icon','routeParams'=>null])
{{-- @can($route) --}}

<div class="nav-item">
    {{-- <a class="nav-link font-weight-bold @activeLink([$route])"  href="{{ route($route,$routeParams) }}" role="tab" aria-controls="{{ $route }}" aria-selected="false"> --}}
    <a class="nav-link font-weight-bold @activeLink($route, 'active')"  href="{{ route($route,$routeParams) }}" role="tab" aria-controls="{{ $route }}" aria-selected="false">
        <i class="{{ $icon }}"></i>
        {{ $slot }}
    </a>
</div>

{{-- @endcan --}}
