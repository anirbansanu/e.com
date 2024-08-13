// Start of CustomDataTable for handle Ajax Datatable Blade Component
class CustomDataTable {
    constructor(elementId, fetchUrl, deleteUrl, columns, actionButtons = null, showEntries = 10) {
        this.elementId = elementId;
        this.fetchUrl = fetchUrl;
        this.deleteUrl = deleteUrl;
        this.columns = columns;
        this.actionButtons = actionButtons;
        this.showEntries = showEntries;
        this.currentPage = 1;
        this.totalPages = 1;
        this.searchQuery = '';
        this.sortColumn = '';
        this.sortDirection = 'asc';

        this.init();
    }

    init() {
        this.cacheElements();
        this.renderHeader();
        this.fetchData();
        this.bindEvents();
        console.log(`${this.elementId} initiated`);
    }

    cacheElements() {
        this.table = document.querySelector(`#${this.elementId}`);
        this.searchInput = this.table.querySelector('#search');
        this.entriesSelect = this.table.querySelector('#show-entries');
        this.pagination = this.table.querySelector('#pagination');
        this.tbody = this.table.querySelector('tbody');
        this.loadingOverlay = document.querySelector('#loadingOverlay');
    }

    bindEvents() {
        this.searchInput.addEventListener('keyup', () => this.handleSearch());
        this.entriesSelect.addEventListener('change', () => this.handleEntriesChange());
        this.pagination.addEventListener('click', event => this.handlePagination(event));
        this.table.querySelector('thead').addEventListener('click', event => this.handleSort(event));
        this.tbody.addEventListener('click', event => this.handleActions(event));
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
        if (event.target.matches('span')) {
            this.currentPage = event.target.dataset.page;
            this.fetchData();
        }
    }

    handleSort(event) {
        if (event.target.matches('.sortable')) {
            this.sortColumn = event.target.dataset.column;
            this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
            this.fetchData();
        }
    }

    handleActions(event) {
        event.preventDefault();
        if (event.target.matches('.edit-ajax')) {
            this.editEvent(event);
        }
        if (event.target.matches('.delete-ajax')) {
            this.deleteEvent(event);
        }
    }

    editEvent(event) {
        console.log("edit-ajax called");
        // Implement the edit functionality
    }

    deleteEvent(event) {
        const button = event.target;
        const deleteUrl = this.replacePlaceholders(this.deleteUrl, button.dataset);

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
                this.makeDeleteRequest(deleteUrl);
            }
        });
    }

    replacePlaceholders(url, params) {
        return url.replace(/{(\w+)}/g, (_, key) => {
            if (params.hasOwnProperty(key)) {
                return params[key];
            } else {
                throw new Error(`Key "${key}" not found in parameters.`);
            }
        });
    }

    makeDeleteRequest(url) {
        $.ajax({
            url: url,
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: response => this.handleDeleteSuccess(response),
            error: xhr => this.handleDeleteError(xhr)
        });
    }

    handleDeleteSuccess(response) {
        if (response.status === 200) {
            Swal.fire('Deleted!', response.message, 'success');
            this.fetchData();
        } else {
            Swal.fire('Error!', response.message || 'An error occurred while deleting the product.', 'error');
        }
    }

    handleDeleteError(xhr) {
        Swal.fire('Error!', xhr.responseJSON.message || 'An error occurred while deleting the product.', 'error');
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
                sort_order: this.sortDirection
            },
            beforeSend: () => this.showLoading(),
            success: response => this.handleFetchSuccess(response),
            error: response => this.handleFetchError(response)
        });
    }

    showLoading() {
        this.loadingOverlay.style.display = 'block';
    }

    hideLoading() {
        this.loadingOverlay.style.display = 'none';
    }

    handleFetchSuccess(response) {
        this.hideLoading();
        this.renderBody(response.data);
        this.renderPagination(response);
        console.log("CustomDataTable success response", response);
    }

    handleFetchError(response) {
        this.hideLoading();
        console.log("CustomDataTable error response", response);
    }

    renderHeader() {
        const thead = this.table.querySelector('thead');
        thead.innerHTML = `
            <tr>
                ${this.columns.map(column => `<th data-column="${column.data}" class="sortable">${column.title}</th>`).join('')}
                ${this.actionButtons ? '<th>Actions</th>' : ''}
            </tr>
        `;
    }

    renderBody(data) {
        this.tbody.innerHTML = '';
        data.forEach(row => {
            const tr = document.createElement('tr');
            this.columns.forEach(column => {
                const td = document.createElement('td');
                td.textContent = row[column.data];
                tr.appendChild(td);
            });
            if (this.actionButtons) {
                const actionTd = this.createActionButtonsCell(row);
                tr.appendChild(actionTd);
            }
            this.tbody.appendChild(tr);
        });
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

    renderPagination(response) {
        console.log("renderPagination response : ",response);
        response = response.info;
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

