@props([
    'url' => '',
    'thead' => [],
    'tbody' => [],
    'actions' => [],
    'entries' => 10,
    'search' => '',
    'sort_by' => 'updated_at',
    'sort_order' => 'desc',
    'searchable' => true,
    'showentries' => true,
    'current_page' => 1,
    'total' => 0,
    'per_page' => 10,
])
<div class="container p-0 m-0">
    <div class="d-flex flex-row align-items-center justify-content-between p-0 m-0">
        @if($showentries)
            <form class="form-group m-2 d-flex" action="{{ $url }}" method="GET" id="show-entries-form">
                <label for="exampleSelectRounded0" class="text-primary p-1">Show</label>
                <select class="form-control mt-1 p-0" id="show-entries" name="entries" style="height:30px" onchange="document.getElementById('show-entries-form').submit();">
                    <option @if($entries == 5) selected @endif>5</option>
                    <option @if($entries == 10) selected @endif>10</option>
                    <option @if($entries == 30) selected @endif>30</option>
                    <option @if($entries == 50) selected @endif>50</option>
                    <option @if($entries == 100) selected @endif>100</option>
                </select>
                <label for="exampleSelectRounded0" class="text-primary p-1">entries</label>
            </form>
        @endif

        @if($searchable)
            <form action="{{ $url }}" method="GET" class="form-group m-2">
                <div class="input-group input-group-sm" style="width: 250px;">
                    <input type="text" name="search" id="search" class="form-control float-right" placeholder="Search by Name, Description" value="{{ $search }}">
                    <input type="hidden" class="d-none" name="entries" value="{{ $entries }}">
                    <input type="hidden" class="d-none" name="sort_by" value="{{ $sort_by }}">
                    <input type="hidden" class="d-none" name="sort_order" value="{{ $sort_order }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-default">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        @endif
    </div>
    <table class="table table-hover text-nowrap border" id="index-dataTable" data-url="{{ $url }}" style="width: 100%">
        <thead class="border-top">
        <tr>
            <th>Sl No</th>
            @foreach($thead as $_index=>$th)
                @if (isset($th['sortable']) && $th['sortable'] == true)
                    <th href="{{ url($url, ['query' => $query, 'sort_by' => $th['data'], 'sort_order' => ($sort_by == $th['data'] && $sort_order == 'asc') ? 'desc' : 'asc']) }}">{{ $th['title'] }}</th>
                @else
                    <th>{{ $th['title'] ?? ""}}</th>
                @endif

            @endforeach
            @if (count($actions)>0)
                <th>Actions</th>
            @endif
        </tr>
        </thead>
        <tbody>
            @foreach($tbody as $tbody_index=>$_item)
                <tr data-index="{{$tbody_index}}">
                    <td>{{ ($current_page - 1) * $per_page + $loop->iteration }}</td>
                    @foreach($thead as $_index=>$th)
                        <td data-th="{{$th['title']??""}}">{{$_item[$th['data']]??""}}</td>
                    @endforeach

                    <td data-th="{{$th['title']??""}}">
                        @foreach($actions as $action)
                            <a href="{{ route($action['route'], $_item['id']) }}" class="btn {{$action['btn-class']}} btn-sm"

                            @if ($action['data']='delete')
                                data-alert-title="{{ __('Delete '.$_item['name']??"") }}"
                                data-confirm="{{ __('Confirm') }}"
                                data-cancel="{{ __('Cancel') }}"
                                title="{{ __('Delete') }}"
                            @endif
                            >
                                <i class="{{$action['icon']}}">
                                </i>
                                {{$action['title']??""}}
                            </a>

                        @endforeach
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{-- Add pagination links --}}
    <div class="d-flex justify-content-between mt-3">
        <div>
            Showing {{ $tbody->firstItem() }} to {{ $tbody->lastItem() }} of {{ $total }} entries
        </div>
        <div>
            {{ $tbody->appends(request()->query())->links("vendor.pagination.bootstrap-4") }}
        </div>
    </div>
</div>
