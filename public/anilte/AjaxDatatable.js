// Start of CustomDataTable for handle Ajax Datatable Blade Component

class AjaxDatatable {
    constructor(options) {
        this.options = options;
        this.fetchUrl = this.options.fetchUrl;
        this.deleteUrl = this.options.deleteUrl;
        this.columns = this.options.columns;
        this.actionButtons = this.options.actionButtons || null;

        this.filters = {};
        this.currentPage = 1;
        this.showEntries = 10;
        this.searchQuery = '';
        this.sortColumn = '';
        this.sortDirection = 'asc';

        this.response;

        this.init();
    }

    init() {
        this.cacheElements();
        this.renderHeader();
        this.fetchData();
        this.bindEvents();
        // this.connectWebSocket();
        this.initColumnResizing();
        this.initRowReordering();
        this.initColumnReordering();
        this.freezeColumns();

        console.log(`${this.element.id} AjaxDatatable initiated`);
        console.log(`The options are : `,this.options);

    }
    cacheElements() {

        console.log(`elements caching... `);

        this.element = document.querySelector(this.options.elementId);
        this.table = this.element.querySelector('table');
        this.tbody = this.table.querySelector('tbody');

        this.searchInput = this.element.querySelector(this.options.searchInput);
        this.entriesSelect = this.element.querySelector(this.options.entriesSelect);
        this.pagination = this.element.querySelector(this.options.pagination);

        this.loadingOverlay = document.querySelector('#loadingOverlay');

        console.log(`${this.element.id} elements cached `);
    }

    bindEvents() {
        this.searchInput.addEventListener('keyup', () => this.handleSearch());
        this.entriesSelect.addEventListener('change', () => this.handleEntriesChange());
        this.pagination.addEventListener('click', event => this.handlePagination(event));
        this.table.querySelector('thead').addEventListener('click', event => this.handleSort(event));
        this.tbody.addEventListener('click', event => this.handleActions(event));
        this.tbody.addEventListener('dblclick', event => this.handleInlineEdit(event));
        this.table.querySelectorAll('.filter-input').forEach(filterInput => {
            filterInput.addEventListener('change', () => this.handleFilterChange());
        });
        this.table.querySelectorAll('.column-toggle').forEach(toggle => {
            toggle.addEventListener('change', () => this.toggleColumnVisibility(toggle.dataset.column, toggle.checked));
        });
        const bulkAction = this.table.querySelector('#bulk-action');
        const exportCsv = this.table.querySelector('#export-csv');
        const exportExcel = this.table.querySelector('#export-excel');

        if (bulkAction) {
            bulkAction.addEventListener('change', () => this.handleBulkAction());
        }

        if (exportCsv) {
            exportCsv.addEventListener('click', () => this.exportData('csv'));
        }

        if (exportExcel) {
            exportExcel.addEventListener('click', () => this.exportData('excel'));
        }

        console.log(`${this.element.id} events binded `);
    }

    renderHeader() {
        const thead = this.table.querySelector('thead');
        thead.innerHTML = `
            <tr>
                <th><input type="checkbox" id="select-all"></th> <!-- Bulk select checkbox -->
                ${this.columns.map(column => `<th data-column="${column.data}" class="sortable">${column.title}</th>`).join('')}
                ${this.actionButtons ? '<th>Actions</th>' : ''}
            </tr>
        `;
        this.table.querySelector('#select-all').addEventListener('change', () => this.toggleSelectAll());

        console.log(`${this.element.id} header rendered `);
    }

    fetchData() {
        $.ajax({
            url: this.fetchUrl,
            method: 'GET',
            data: {
                page: this.currentPage,
                entries: this.showEntries,
                search: this.searchQuery,
                sort_by: this.sortColumn,
                sort_order: this.sortDirection,
                filters: this.filters
            },
            beforeSend: () => this.showLoading(),
            success: response => this.handleFetchSuccess(response),
            error: response => this.handleFetchError(response)
        });
    }

    handleFetchSuccess(response) {
        this.hideLoading();
        this.response = response;
        this.renderBody(this.response.data);
        this.renderPagination();

        console.log(`${this.element.id} on success response `,this.response);

    }

    handleFetchError(response) {
        console.error('Fetch Error:', response);
        Swal.fire('Error!', response.responseJSON.message || 'An error occurred while deleting the product.', 'error');
    }

    createActionButtonsCell(row) {
        const actionTd = document.createElement('td');
        let dataAttrs = "";
        this.columns.forEach(column => {
            actionTd.setAttribute(column.data, row[column.data]);
            dataAttrs += `data-${column.data}='${row[column.data]}' `;
        });
        actionTd.setAttribute("data-id", row['id']);
        dataAttrs += `data-id='${row['id']}' `;
        actionTd.innerHTML = this.actionButtons.replace(/:data/g, dataAttrs.trim());
        return actionTd;
    }

    renderBody(data) {
        this.tbody.innerHTML = '';
        data.forEach(row => {
            const tr = document.createElement('tr');
            tr.setAttribute('draggable', true); // Enable row dragging

            tr.innerHTML += `<td><input type="checkbox" class="select-row" data-id="${row.id}"></td>`;
            this.columns.forEach(column => {
                const td = document.createElement('td');
                td.textContent = row[column.data];
                td.setAttribute('title', td.textContent); // Add tooltip to each cell
                tr.appendChild(td);
            });
            if (this.actionButtons) {
                const actionTd = this.createActionButtonsCell(row);
                tr.appendChild(actionTd);
            }
            this.tbody.appendChild(tr);
        });
    }

    toggleSelectAll() {
        const selectAllCheckbox = this.table.querySelector('#select-all');
        const rowCheckboxes = this.tbody.querySelectorAll('.select-row');
        rowCheckboxes.forEach(checkbox => checkbox.checked = selectAllCheckbox.checked);
    }

    handleBulkAction() {
        const selectedIds = Array.from(this.tbody.querySelectorAll('.select-row:checked')).map(checkbox => checkbox.dataset.id);
        const action = this.table.querySelector('#bulk-action').value;

        if (action === 'delete') {
            Swal.fire({
                title: 'Are you sure?',
                text: `You won't be able to revert this!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete them!'
            }).then(result => {
                if (result.isConfirmed) {
                    this.bulkDelete(selectedIds);
                }
            });
        }
    }

    bulkDelete(ids) {
        $.ajax({
            url: this.deleteUrl,
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: { ids: ids },
            success: response => this.handleDeleteSuccess(response),
            error: xhr => this.handleDeleteError(xhr)
        });
    }

    handleDeleteSuccess(response) {
        if (response.status === 200) {
            Swal.fire('Deleted!', response.message, 'success');
            this.fetchData();
        } else {
            Swal.fire('Error!', response.message || 'An error occurred while deleting the item.', 'error');
        }
    }

    handleDeleteError(xhr) {
        Swal.fire('Error!', xhr.responseJSON.message || 'An error occurred while deleting the item.', 'error');
    }

    handleSearch() {
        this.searchQuery = this.searchInput.value;
        this.fetchData();
    }

    handleEntriesChange() {
        this.showEntries = this.entriesSelect.value;
        this.fetchData();
    }

    handlePagination(event) {
        event.preventDefault();
        if (event.target.matches('a')) {
            this.currentPage = event.target.dataset.page;
            this.fetchData();
        }
    }

    handleSort(event) {
        if (event.target.matches('.sortable')) {
            const column = event.target.dataset.column;
            this.sortColumn = column;
            this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
            this.fetchData();
        }
    }

    handleActions(event) {
        if (event.target.matches('.btn-delete')) {
            const id = event.target.closest('tr').querySelector('[data-id]').dataset.id;
            this.deleteRow(id);
        }
    }

    deleteRow(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: `You won't be able to revert this!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then(result => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `${this.deleteUrl}/${id}`,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: response => this.handleDeleteSuccess(response),
                    error: xhr => this.handleDeleteError(xhr)
                });
            }
        });
    }

    handleInlineEdit(event) {
        if (event.target.matches('td')) {
            const td = event.target;
            const originalValue = td.textContent;
            td.setAttribute('contenteditable', true);
            td.focus();

            td.addEventListener('blur', () => {
                td.removeAttribute('contenteditable');
                const newValue = td.textContent;

                if (newValue !== originalValue) {
                    this.saveInlineEdit(td, newValue);
                }
            }, { once: true });
        }
    }

    saveInlineEdit(td, newValue) {
        const row = td.closest('tr');
        const columnName = this.columns[td.cellIndex].data;
        const id = row.querySelector('[data-id]').dataset.id;

        const originalContent = td.textContent;
        this.showCellLoading(td);

        $.ajax({
            url: `${this.fetchUrl}/${id}`,
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                [columnName]: newValue
            },
            success: response => this.hideCellLoading(td, newValue),
            error: response => this.hideCellLoading(td, originalContent)
        });
    }

    showCellLoading(td) {
        td.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
    }

    hideCellLoading(td, originalContent) {
        td.textContent = originalContent;
    }

    handleFilterChange() {
        this.filters = {};
        this.element.querySelectorAll('.filter-input').forEach(filterInput => {
            const column = filterInput.dataset.column;
            const value = filterInput.value;
            if (value) {
                this.filters[column] = value;
            }
        });
        this.fetchData();
    }

    toggleColumnVisibility(column, visible) {
        const index = this.columns.findIndex(col => col.data === column);
        this.table.querySelectorAll(`tr th:nth-child(${index + 2}), tr td:nth-child(${index + 2})`).forEach(cell => {
            cell.style.display = visible ? '' : 'none';
        });
    }

    exportData(format) {
        const params = new URLSearchParams({
            search: this.searchQuery,
            sort_by: this.sortColumn,
            sort_order: this.sortDirection,
            filters: this.filters
        }).toString();

        window.location.href = `${this.fetchUrl}/export-${format}?${params}`;
    }

    // connectWebSocket() {
    //     const socket = new WebSocket('ws://your-websocket-url');

    //     socket.onmessage = event => {
    //         const data = JSON.parse(event.data);
    //         if (data.type === 'table_update') {
    //             this.fetchData();
    //         }
    //     };
    // }

    initColumnResizing() {
        this.table.querySelectorAll('th').forEach(th => {
            const resizer = document.createElement('div');
            resizer.className = 'resizer';
            th.appendChild(resizer);
            this.setupResizer(resizer, th);
        });
    }

    setupResizer(resizer, th) {
        let startX, startWidth;

        const mouseMoveHandler = e => {
            const width = startWidth + e.clientX - startX;
            th.style.width = `${width}px`;
        };

        const mouseUpHandler = () => {
            document.removeEventListener('mousemove', mouseMoveHandler);
            document.removeEventListener('mouseup', mouseUpHandler);
        };

        const mouseDownHandler = e => {
            startX = e.clientX;
            startWidth = th.offsetWidth;

            document.addEventListener('mousemove', mouseMoveHandler);
            document.addEventListener('mouseup', mouseUpHandler);
        };

        resizer.addEventListener('mousedown', mouseDownHandler);
    }

    initRowReordering() {
        const rows = this.tbody.querySelectorAll('tr');
        rows.forEach(row => {
            row.addEventListener('dragstart', this.dragStart.bind(this));
            row.addEventListener('dragover', this.dragOver.bind(this));
            row.addEventListener('drop', this.drop.bind(this));
            row.addEventListener('dragend', this.dragEnd.bind(this));
        });
    }

    dragStart(event) {
        event.dataTransfer.setData('text/plain', event.target.rowIndex);
        event.target.style.opacity = 0.5;
    }

    dragOver(event) {
        event.preventDefault();
    }

    drop(event) {
        const fromIndex = event.dataTransfer.getData('text/plain');
        const toIndex = event.target.closest('tr').rowIndex;

        if (fromIndex !== toIndex) {
            this.tbody.insertBefore(this.tbody.rows[fromIndex - 1], this.tbody.rows[toIndex]);
        }
    }

    dragEnd(event) {
        event.target.style.opacity = '';
    }

    initColumnReordering() {
        const headers = this.table.querySelectorAll('th');
        headers.forEach(th => {
            th.setAttribute('draggable', true);
            th.addEventListener('dragstart', this.columnDragStart.bind(this));
            th.addEventListener('dragover', this.columnDragOver.bind(this));
            th.addEventListener('drop', this.columnDrop.bind(this));
        });
    }

    columnDragStart(event) {
        event.dataTransfer.setData('text/plain', event.target.cellIndex);
    }

    columnDragOver(event) {
        event.preventDefault();
    }

    columnDrop(event) {
        const fromIndex = event.dataTransfer.getData('text/plain');
        const toIndex = event.target.cellIndex;

        if (fromIndex !== toIndex) {
            const rows = this.table.querySelectorAll('tr');
            rows.forEach(row => {
                const fromCell = row.cells[fromIndex];
                const toCell = row.cells[toIndex];
                row.insertBefore(fromCell, toCell);
            });
        }
    }

    freezeColumns() {
        const firstColumn = this.table.querySelector('th:nth-child(1)');
        firstColumn.classList.add('frozen-column');
        this.table.querySelectorAll('td:nth-child(1)').forEach(td => {
            td.classList.add('frozen-column');
        });
    }

    showLoading() {
        this.loadingOverlay.style.display = 'block';
    }

    hideLoading() {
        this.loadingOverlay.style.display = 'none';
    }

    renderPagination() {
        console.log("renderPagination response : ",this.response);
        let response = this.response.info;
        this.currentPage = response.current_page;
        this.totalPages = response.last_page;

        this.pagination.innerHTML = '';
        const currentPage = response.current_page;
        const lastPage = response.last_page;

        const pageLinksContainer = document.createElement('ul');
        pageLinksContainer.classList.add('pagination','m-0');

        this.pagination.innerHTML += `<div> <p>Show ${currentPage} of ${lastPage}</p> </div>`;

        pageLinksContainer.innerHTML += `<li class="page-item ${currentPage > 1 ? "" :"disabled"}"><span class="page-link" ${currentPage > 1 ? "disabled" :""} data-page="${currentPage - 1}">Previous</span></li>`;


        for (let i = 1; i <= lastPage; i++) {
            const btnClass = i === currentPage ? 'btn-secondary' : 'btn-primary';
            pageLinksContainer.innerHTML += `<li class="page-item ${i === currentPage ? "disabled" :""}"> <span class="page-link btn" data-page="${i}">${i}</span> </li> `;
        }


        pageLinksContainer.innerHTML += `<li class="page-item ${currentPage < lastPage ? "" :"disabled"}"> <span class="page-link" ${currentPage < lastPage ? "disabled" :""} data-page="${currentPage + 1}">Next</span> </li>`;

        this.pagination.appendChild(pageLinksContainer);
    }
}

// End of CustomDataTable for handle Ajax Datatable Blade Component
