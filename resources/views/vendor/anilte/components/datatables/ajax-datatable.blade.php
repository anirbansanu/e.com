{{-- Path = resources/views/vendor/anilte/components/datatables/ajax-datatable.blade.php --}}
<div class="" id="table-container">
    <div class="d-flex flex-row align-items-center justify-content-between">
        <div class="form-group d-flex flex-row align-items-center">
            <label for="show-entries" class="text-primary m-0 mr-1">Show</label>
            <select id="show-entries" class="custom-select w-auto form-control-border bg-light">
                <option value="5">5</option>
                <option value="10" selected>10</option>
                <option value="20">20</option>
                <option value="50">50</option>
            </select>

        </div>
        <div class="form-group">
            <div class="input-group input-group-sm" style="width: 250px;">
                <input type="text" name="search" id="search" class="form-control float-right" placeholder="Search by Name, Description" value="{{ $search??"" }}">
                <input type="hidden" class="d-none" name="entries" value="{{ $entries??"" }}">
                <input type="hidden" class="d-none" name="sort_by" value="{{ $sort_by??"" }}">
                <input type="hidden" class="d-none" name="sort_order" value="{{ $sort_order??"" }}">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <table class="table table-hover text-nowrap border">
        <thead class="border-top">
            <!-- Headers will be loaded here via JavaScript -->
        </thead>
        <tbody>
            <!-- Data will be loaded here via AJAX -->
        </tbody>
    </table>
    <div id="pagination" class="mt-3">
        <!-- Pagination will be loaded here -->
    </div>
</div>
<div class="overlay" id="loadingOverlay" style="display: none;">
    <i class="fas fa-2x fa-sync-alt fa-spin"></i>
</div>

@push('js')
<script src="{{asset("anilte/anilte.js")}}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ajaxDataTable = new CustomDataTable('table-container', '{{ $fetchUrl }}', {!! json_encode($columns) !!}, `{!! $actionButtons !!}`, {{ $pageSize }});
    });

</script>
@endpush
