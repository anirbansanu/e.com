Certainly! Here is the documentation for the enhanced `CustomDataTable` class:

# `CustomDataTable` Class Documentation

The `CustomDataTable` class is a JavaScript utility for creating dynamic, AJAX-based data tables with features like searching, sorting, pagination, and action buttons (e.g., edit, delete).

## Table of Contents

1. [Constructor](#constructor)
2. [Methods](#methods)
    - [init](#init)
    - [cacheElements](#cacheelements)
    - [bindEvents](#bindevents)
    - [handleSearch](#handlesearch)
    - [handleEntriesChange](#handleentrieschange)
    - [handlePagination](#handlepagination)
    - [handleSort](#handlesort)
    - [handleActions](#handleactions)
    - [editEvent](#editevent)
    - [deleteEvent](#deleteevent)
    - [replacePlaceholders](#replaceplaceholders)
    - [makeDeleteRequest](#makedeleterequest)
    - [handleDeleteSuccess](#handledeletesuccess)
    - [handleDeleteError](#handledeleteerror)
    - [fetchData](#fetchdata)
    - [showLoading](#showloading)
    - [hideLoading](#hideloading)
    - [handleFetchSuccess](#handlefetchsuccess)
    - [handleFetchError](#handlefetcherror)
    - [renderHeader](#renderheader)
    - [renderBody](#renderbody)
    - [createActionButtonsCell](#createactionbuttonscell)
    - [renderPagination](#renderpagination)

## Constructor

### `constructor(elementId, fetchUrl, deleteUrl, columns, actionButtons = null, showEntries = 10)`

- **Parameters**:
  - `elementId` (string): The ID of the table element.
  - `fetchUrl` (string): The URL for fetching data.
  - `deleteUrl` (string): The URL for deleting records.
  - `columns` (array): An array of objects representing the columns.
  - `actionButtons` (string, optional): HTML string for action buttons.
  - `showEntries` (number, optional): Number of entries to show per page.

- **Description**:
  Initializes the class with the provided parameters and sets up the table.

## Methods

### `init`

- **Description**:
  Initializes the table by caching elements, rendering the header, fetching data, and binding events.

### `cacheElements`

- **Description**:
  Caches commonly used DOM elements to minimize query overhead.

### `bindEvents`

- **Description**:
  Binds event listeners for search input, entries per page selection, pagination buttons, column sorting, and action buttons.

### `handleSearch`

- **Description**:
  Handles the search input and fetches data based on the search query.

### `handleEntriesChange`

- **Description**:
  Handles the change in the number of entries per page and fetches data accordingly.

### `handlePagination`

- **Description**:
  Handles pagination button clicks and fetches data for the selected page.

### `handleSort`

- **Description**:
  Handles column sorting and fetches data based on the sort column and direction.

### `handleActions`

- **Description**:
  Handles action button clicks (edit and delete).

### `editEvent`

- **Description**:
  Placeholder for handling the edit action. Customize this method to implement the edit functionality.

### `deleteEvent`

- **Description**:
  Handles the delete action with a confirmation dialog and AJAX request.

### `replacePlaceholders`

- **Parameters**:
  - `url` (string): The URL template with placeholders.
  - `params` (object): The parameters to replace placeholders.

- **Description**:
  Replaces placeholders in the URL template with actual values from the parameters.

### `makeDeleteRequest`

- **Parameters**:
  - `url` (string): The URL for the delete request.

- **Description**:
  Makes an AJAX DELETE request to the provided URL and handles the response.

### `handleDeleteSuccess`

- **Parameters**:
  - `response` (object): The response object from the delete request.

- **Description**:
  Handles successful delete responses and refreshes the table data.

### `handleDeleteError`

- **Parameters**:
  - `xhr` (object): The XMLHttpRequest object from the delete request.

- **Description**:
  Handles errors during the delete request and displays an error message.

### `fetchData`

- **Description**:
  Fetches data from the server with AJAX based on the current page, search query, sort column, and sort direction.

### `showLoading`

- **Description**:
  Displays the loading overlay during data fetching.

### `hideLoading`

- **Description**:
  Hides the loading overlay after data fetching.

### `handleFetchSuccess`

- **Parameters**:
  - `response` (object): The response object from the data fetch request.

- **Description**:
  Handles successful data fetch responses and renders the table body and pagination.

### `handleFetchError`

- **Parameters**:
  - `response` (object): The response object from the data fetch request.

- **Description**:
  Handles errors during the data fetch request and displays an error message.

### `renderHeader`

- **Description**:
  Renders the table header based on the columns configuration.

### `renderBody`

- **Parameters**:
  - `data` (array): The array of data objects to be displayed in the table.

- **Description**:
  Renders the table body with the provided data.

### `createActionButtonsCell`

- **Parameters**:
  - `row` (object): The data object for the current row.

- **Description**:
  Creates and returns a table cell with action buttons.

### `renderPagination`

- **Parameters**:
  - `response` (object): The response object containing pagination data.

- **Description**:
  Renders the pagination controls based on the response data.

---

## Example Usage

```javascript
const columns = [
    { title: 'ID', data: 'id' },
    { title: 'Name', data: 'name' },
    { title: 'Email', data: 'email' }
];

const actionButtons = `
    <button class="btn btn-primary edit-ajax" :data>Edit</button>
    <button class="btn btn-danger delete-ajax" :data>Delete</button>
`;

const dataTable = new CustomDataTable('myTable', '/fetch-data-url', '/delete-data-url', columns, actionButtons, 10);
```

This documentation covers the main methods and functionalities of the `CustomDataTable` class. Customize the class as needed for your specific use case, especially in the placeholder methods like `editEvent`.
