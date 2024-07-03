{{-- Table --}}

<div class="table-responsive">

    <div class="d-flex flex-row align-items-center justify-content-between m-2">
        <form class="form-group m-0 d-flex" action="{{route("users.index")}}" method="GET" id="show-entries-form">
            <label for="exampleSelectRounded0" class="text-primary p-1">show</label>
            <select class="form-control mt-1 p-0" id="show-entries" name="entries" style="height:30px" onchange="document.getElementById('show-entries-form').submit();" >
                <option>5</option>
                <option>10</option>
                <option>30</option>
                <option>50</option>
                <option>100</option>
            </select>
            <label for="exampleSelectRounded0" class="text-primary p-1">entries </label>
        </form>
        <form action="{{route("users.index")}}" method="GET" class="form-group m-0">
            <div class="input-group input-group-sm" style="width: 250px;">
                <input type="text" name="search" id="search" class="form-control float-right" placeholder="Search by Name, Description" value="">
                <input type="hidden" class="d-none" name="sort_by" value="updated_at">
                <input type="hidden" class="d-none" name="sort_order" value="desc">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>

<table id="{{ $id }}" style="width:100%" {{ $attributes->merge(['class' => $makeTableClass()]) }}>

    {{-- Table head --}}
    <thead @isset($headTheme) class="thead-{{ $headTheme }}" @endisset>
        <tr>
            @foreach($heads as $th)
                <th @isset($th['classes']) class="{{ $th['classes'] }}" @endisset
                    @isset($th['width']) style="width:{{ $th['width'] }}%" @endisset
                    @isset($th['no-export']) dt-no-export @endisset>
                    {{ is_array($th) ? ($th['label'] ?? '') : $th }}
                </th>
            @endforeach
        </tr>
    </thead>

    {{-- Table body --}}
    <tbody>{{ $slot }}</tbody>

    {{-- Table footer --}}
    @if(isset($withFooter) && $withFooter)
        <tfoot @isset($footerTheme) class="thead-{{ $footerTheme }}" @endisset>
            <tr>
                @foreach($heads as $th)
                    <th>{{ is_array($th) ? ($th['label'] ?? '') : $th }}</th>
                @endforeach
            </tr>
        </tfoot>
    @endif

</table>

</div>

{{-- Add plugin initialization and configuration code --}}

@push('js')
<script>

    $(() => {
        $('#{{ $id }}').DataTable( @json($config) );
    })

</script>
@endpush

{{-- Add CSS styling --}}

@isset($beautify)
    @push('css')
    <style type="text/css">
        #{{ $id }} tr td,  #{{ $id }} tr th {
            vertical-align: middle;
            text-align: center;
        }
    </style>
    @endpush
@endisset
