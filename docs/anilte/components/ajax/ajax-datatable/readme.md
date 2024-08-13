Below is the detailed documentation for the `AjaxDatatable` class, covering its methods, properties, and usage.

---

# **AjaxDatatable Class Documentation**

## **Overview**

The `AjaxDatatable` class is a JavaScript utility designed to handle dynamic data tables in a Laravel Blade component using AJAX. It provides features like searching, sorting, pagination, inline editing, bulk actions, column resizing, and more.

## **Constructor**

### **`constructor(options)`**

Initializes the `AjaxDatatable` class with the provided options.

- **`options`**: An object containing configuration options for the datatable. It includes the following properties:
  - **`elementId`**: The ID of the HTML element containing the table.
  - **`fetchUrl`**: The URL endpoint to fetch table data via AJAX.
  - **`deleteUrl`**: The URL endpoint to handle deletion requests via AJAX.
  - **`columns`**: An array of column definitions for the table. Each column object should have a `data` and `title` property.
  - **`actionButtons`**: Optional HTML string for action buttons. Supports dynamic data attributes using `:data`.

## **Properties**

- **`options`**: Stores the configuration options passed during initialization.
- **`fetchUrl`**: The URL to fetch data for the table.
- **`deleteUrl`**: The URL to handle deletion of rows.
- **`columns`**: An array of columns for the datatable.
- **`actionButtons`**: HTML for action buttons, if provided.
- **`filters`**: An object containing filter values.
- **`currentPage`**: Current page number for pagination.
- **`showEntries`**: Number of entries to show per page.
- **`searchQuery`**: The current search query string.
- **`sortColumn`**: The column used for sorting.
- **`sortDirection`**: The direction of sorting, either 'asc' or 'desc'.
- **`response`**: The AJAX response data.

## **Methods**

### **`init()`**

Initializes the datatable by caching elements, rendering the header, fetching initial data, and binding events.

### **`cacheElements()`**

Caches DOM elements used by the class for later use.

- **`this.element`**: The main wrapper element containing the table.
- **`this.table`**: The table element.
- **`this.tbody`**: The tbody element inside the table.
- **`this.searchInput`**: The search input field.
- **`this.entriesSelect`**: The dropdown to select the number of entries per page.
- **`this.pagination`**: The pagination element.
- **`this.loadingOverlay`**: The overlay element to show loading status.

### **`bindEvents()`**

Binds event listeners to various elements like search input, pagination links, and sorting headers.

### **`renderHeader()`**

Renders the table header with column titles and action buttons. It also sets up the bulk select checkbox.

### **`fetchData()`**

Fetches data from the server using AJAX based on the current state (pagination, sorting, filters).

### **`handleFetchSuccess(response)`**

Handles the successful AJAX response, updates the table body with the new data, and renders pagination.

- **`response`**: The AJAX response data.

### **`handleFetchError(response)`**

Handles errors that occur during the AJAX request and displays an error message.

- **`response`**: The error response object.

### **`createActionButtonsCell(row)`**

Creates a cell containing action buttons for each row.

- **`row`**: The row data.

### **`renderBody(data)`**

Renders the table body with the provided data.

- **`data`**: The data array containing rows.

### **`toggleSelectAll()`**

Handles the logic for the bulk select checkbox, toggling the selection state of all row checkboxes.

### **`handleBulkAction()`**

Handles bulk actions like deletion when the user selects multiple rows and an action.

### **`bulkDelete(ids)`**

Sends a DELETE request for multiple rows.

- **`ids`**: Array of selected row IDs.

### **`handleDeleteSuccess(response)`**

Handles successful deletion of rows, displays a success message, and refreshes the table data.

- **`response`**: The response object from the server.

### **`handleDeleteError(xhr)`**

Handles errors during deletion and displays an error message.

- **`xhr`**: The XMLHttpRequest object containing the error details.

### **`handleSearch()`**

Handles the search input, updating the search query and refreshing the table data.

### **`handleEntriesChange()`**

Handles changes in the number of entries shown per page and refreshes the table data.

### **`handlePagination(event)`**

Handles pagination link clicks, updates the current page, and fetches data for the new page.

- **`event`**: The click event.

### **`handleSort(event)`**

Handles sorting when a column header is clicked. It toggles the sort direction and fetches sorted data.

- **`event`**: The click event.

### **`handleActions(event)`**

Handles action button clicks for individual rows (e.g., delete).

- **`event`**: The click event.

### **`deleteRow(id)`**

Deletes a specific row by sending a DELETE request.

- **`id`**: The ID of the row to delete.

### **`handleInlineEdit(event)`**

Handles inline editing of table cells when double-clicked. It allows editing the content of the cell.

- **`event`**: The click event.

### **`saveInlineEdit(td, newValue)`**

Saves the edited cell value by sending an AJAX request to update the data on the server.

- **`td`**: The table cell element being edited.
- **`newValue`**: The new value of the cell.

### **`showCellLoading(td)`**

Displays a loading spinner in the table cell while the AJAX request is in progress.

- **`td`**: The table cell element.

### **`hideCellLoading(td, originalContent)`**

Hides the loading spinner and restores the cell content after the AJAX request completes.

- **`td`**: The table cell element.
- **`originalContent`**: The original or new content to be displayed in the cell.

### **`handleFilterChange()`**

Handles changes to filter inputs, updates the filters, and fetches filtered data.

### **`toggleColumnVisibility(column, visible)`**

Toggles the visibility of a column based on user input.

- **`column`**: The column key.
- **`visible`**: Boolean indicating whether the column should be visible.

### **`exportData(format)`**

Exports the table data in the specified format (CSV or Excel).

- **`format`**: The format to export data ('csv' or 'excel').

### **`initColumnResizing()`**

Initializes column resizing functionality, allowing users to adjust the width of table columns.

### **`setupResizer(resizer, th)`**

Sets up the resizer for a table column.

- **`resizer`**: The resizer element.
- **`th`**: The table header element.

### **`initRowReordering()`**

Initializes row reordering functionality, allowing users to drag and reorder rows.

### **`initColumnReordering()`**

Initializes column reordering functionality, allowing users to drag and reorder columns.

### **`freezeColumns()`**

Handles freezing specified columns to keep them visible while scrolling horizontally.

---

## **Usage Example**

```javascript
const datatable = new AjaxDatatable({
    elementId: '#datatable',
    fetchUrl: '/api/data',
    deleteUrl: '/api/delete',
    columns: [
        { data: 'id', title: 'ID' },
        { data: 'name', title: 'Name' },
        { data: 'email', title: 'Email' }
    ],
    actionButtons: `
        <button class="btn-edit" :data>Edit</button>
        <button class="btn-delete" :data>Delete</button>
    `
});
```

This example initializes the `AjaxDatatable` class with a basic configuration for a table with ID, Name, and Email columns. It also includes action buttons for editing and deleting rows.

---

This documentation covers the main features and methods provided by the `AjaxDatatable` class. If you need further customization or additional features, you can extend this class as needed.
