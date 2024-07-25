{{-- Path = resources/views/vendor/anilte/components/datatables/ajax-datatable.blade.php --}}
<div class="" id="table-container">
    <div class="d-flex flex-row align-items-center justify-content-between">
        <div class="form-group d-flex flex-row">
            <label for="show-entries">Show </label>
            <select id="show-entries" class="form-control select2-single mx-1">
                <option value="5">5</option>
                <option value="10" selected>10</option>
                <option value="20">20</option>
                <option value="50">50</option>
            </select>

        </div>
        <div class="form-group">
            <input type="text" id="search" class="form-control" placeholder="Search...">
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
        const dataTable = new CustomDataTable('table-container', '{{ $fetchUrl }}', {!! json_encode($columns) !!}, `{!! $actionButtons !!}`, {{ $pageSize }});
    });

</script>
@endpush
