class CustomDataTable {
    constructor(elementId, fetchUrl, columns, actionButtons = null, showEntries = 10) {
        this.elementId = elementId;
        this.fetchUrl = fetchUrl;
        this.columns = columns;
        this.actionButtons = actionButtons;
        this.showEntries = showEntries;
        this.currentPage = 1;
        this.searchQuery = '';
        this.sortColumn = '';
        this.sortDirection = 'asc';

        this.init();
    }

    init() {
        this.renderHeader();
        this.bindEvents();
        this.fetchData();
        console.log("CustomDataTable init called");
    }

    bindEvents() {
        const self = this;

        document.querySelector(`#${this.elementId} #search`).addEventListener('keyup', function() {
            self.searchQuery = this.value;
            self.fetchData();
        });

        document.querySelector(`#${this.elementId} #show-entries`).addEventListener('change', function() {
            self.showEntries = this.value;
            self.fetchData();
        });

        document.querySelector(`#${this.elementId}`).addEventListener('click', function(event) {
            if (event.target.matches('#pagination button')) {
                self.currentPage = event.target.dataset.page;
                self.fetchData();
            } else if (event.target.matches('.sortable')) {
                self.sortColumn = event.target.dataset.column;
                self.sortDirection = self.sortDirection === 'asc' ? 'desc' : 'asc';
                self.fetchData();
            }
        });
    }

    fetchData() {
        const self = this;
        $.ajax({
            url: this.fetchUrl,
            method: 'GET',
            data: {
                page: this.currentPage,
                showEntries: this.showEntries,
                search: this.searchQuery,
                sortColumn: this.sortColumn,
                sortDirection: this.sortDirection
            },
            beforeSend: function() {
                document.querySelector(`#loadingOverlay`).style.display = 'block';
            },
            success: function(response) {
                document.querySelector(`#loadingOverlay`).style.display = 'none';
                self.renderBody(response.data);
                self.renderPagination(response);
                console.log("CustomDataTable success response",response);
            },
            error: function(response) {
                document.querySelector(`#loadingOverlay`).style.display = 'none';
                console.log("CustomDataTable error response",response);
            }
        });
    }

    renderHeader() {
        const thead = document.querySelector(`#${this.elementId} thead`);
        thead.innerHTML = `
            <tr>
                ${this.columns.map(column => `<th data-column="${column.data}" class="sortable">${column.title}</th>`).join('')}
                ${this.actionButtons ? '<th>Actions</th>' : ''}
            </tr>
        `;
    }

    renderBody(data) {
        const tbody = document.querySelector(`#${this.elementId} tbody`);
        tbody.innerHTML = '';
        data.forEach(row => {
            const tr = document.createElement('tr');

            // Create table cells for each column
            this.columns.forEach(column => {
                const td = document.createElement('td');
                td.textContent = row[column.data];
                tr.appendChild(td);
            });

            // Create the action buttons cell
            if (this.actionButtons) {
                const actionTd = document.createElement('td');
                actionTd.setAttribute("data-id", row["id"]);
                let dataAttrs = "";
                this.columns.forEach(column => {
                    actionTd.setAttribute(column.data, row[column.data]);
                    dataAttrs += "data-"+column.data+"='"+row[column.data]+"'";
                });
                actionTd.setAttribute("data-id", row['id']);
                dataAttrs += "data-id='"+row['id']+"'";
                actionTd.innerHTML = this.actionButtons.replace(/:data/g, dataAttrs); // Replace :id with actual row id
                tr.appendChild(actionTd);
            }
            tbody.appendChild(tr);
        });
    }

    renderPagination(response) {
        const pagination = document.querySelector(`#${this.elementId} #pagination`);
        pagination.innerHTML = '';
        const currentPage = response.current_page;
        const lastPage = response.last_page;

        if (currentPage > 1) {
            pagination.innerHTML += `<button class="btn btn-secondary" data-page="${currentPage - 1}">Previous</button>`;
        }

        for (let i = 1; i <= lastPage; i++) {
            const btnClass = i === currentPage ? 'btn-primary' : 'btn-secondary';
            pagination.innerHTML += `<button class="btn ${btnClass}" data-page="${i}">${i}</button>`;
        }

        if (currentPage < lastPage) {
            pagination.innerHTML += `<button class="btn btn-secondary" data-page="${currentPage + 1}">Next</button>`;
        }
    }
}

