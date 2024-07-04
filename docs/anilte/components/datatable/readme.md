## Component: `AnilteDatatable`

The `AnilteDatatable` component is a versatile and dynamic table component designed to handle various data representation needs in a Laravel application. It supports sorting, searching, pagination, and customizable actions.

### Props

 - **url** **(string, default: ''):** The URL to which the form actions (like sorting and searching) will be submitted.

 - **thead** **(array, default: []):** Array of table headers. Each header should be an associative array with keys like `title` and `data`, and optionally `sortable`.

 - **tbody** **(array, default: []):** Array of table body rows. Each row should be an associative array where the keys correspond to the `data` values specified in the `thead`.

 - **actions** **(array, default: []):** Array of actions to be applied to each row. Each action should be an associative array with keys like `route`, `data`, `icon`, `title`, `alertTitle`, `text`, `iconType`, `cancelBtn`, `confirmText`, `cancelText`, and `btn-class`.

 - **entries** **(int, default: 10):** Number of entries to show per page.

 - **search** **(string, default: ''):** Search query string.

 - **sort_by** **(string, default: 'updated_at'):** The column to sort by.

 - **sort_order** **(string, default: 'desc'):** The order of sorting (`asc` or `desc`).

 - **searchable** **(bool, default: true):** Whether the table is searchable.

 - **showentries** **(bool, default: true):** Whether to show the entries selection dropdown.

 - **current_page** **(int, default: 1):** The current page number.

 - **total** **(int, default: 0):** The total number of entries.

 - **per_page** **(int, default: 10):** The number of entries per page.

### Usage

To use the `AnilteDatatable` component, include it in your Blade template as shown below:

```html
<x-anilte-datatable 
    :url="$url"
    :thead="$thead"
    :tbody="$tbody"
    :actions="$actions"
    :entries="$entries"
    :search="$search"
    :sort_by="$sort_by"
    :sort_order="$sort_order"
    :searchable="$searchable"
    :showentries="$showentries"
    :current_page="$current_page"
    :total="$total"
    :per_page="$per_page"
/>
```

### Example

Here's an example of how you might define and use the `AnilteDatatable` component in your Blade template.

#### Blade Template

```html
<x-anilte-datatable 
    :url="route('your.route')"
    :thead="[
        ['title' => 'Name', 'data' => 'name', 'sortable' => true],
        ['title' => 'Email', 'data' => 'email'],
        ['title' => 'Created At', 'data' => 'created_at', 'sortable' => true]
    ]"
    :tbody="$users"
    :actions="[
        ['route' => 'users.edit', 'data' => 'edit', 'icon' => 'fas fa-pencil-alt', 'title' => 'Edit'],
        ['route' => 'users.destroy', 'data' => 'delete', 'icon' => 'fas fa-trash', 'title' => 'Delete', 'alertTitle' => 'Delete User', 'text' => 'Are you sure you want to delete this user?', 'iconType' => 'warning', 'cancelBtn' => true, 'confirmText' => 'Yes, delete it!', 'cancelText' => 'Cancel']
    ]"
    :entries="10"
    :search="$search"
    :sort_by="$sort_by"
    :sort_order="$sort_order"
    :searchable="true"
    :showentries="true"
    :current_page="$current_page"
    :total="$total"
    :per_page="$per_page"
/>
```

### Component Class

Here's the PHP class for the `AnilteDatatable` component:

```php
<?php

namespace App\View\Components\Anilte;

use Illuminate\View\Component;

class AnilteDatatable extends Component
{
    public $url;
    public $thead;
    public $tbody;
    public $actions;
    public $entries;
    public $search;
    public $sort_by;
    public $sort_order;
    public $searchable;
    public $showentries;
    public $current_page;
    public $total;
    public $per_page;

    public function __construct(
        $url = '',
        $thead = [],
        $tbody = [],
        $actions = [],
        $entries = 10,
        $search = '',
        $sort_by = 'updated_at',
        $sort_order = 'desc',
        $searchable = true,
        $showentries = true,
        $current_page = 1,
        $total = 0,
        $per_page = 10
    ) {
        $this->url = $url;
        $this->thead = $thead;
        $this->tbody = $tbody;
        $this->actions = $actions;
        $this->entries = $entries;
        $this->search = $search;
        $this->sort_by = $sort_by;
        $this->sort_order = $sort_order;
        $this->searchable = $searchable;
        $this->showentries = $showentries;
        $this->current_page = $current_page;
        $this->total = $total;
        $this->per_page = $per_page;
    }

    public function render()
    {
        return view('vendor.anilte.components.datatables.datatable');
    }
}
```

### Customization

You can customize the component by passing different props values. The `thead` array defines the headers, and each header can be marked as sortable. The `tbody` array contains the data for each row. The `actions` array defines the actions available for each row, such as edit and delete.

### Conclusion

The `AnilteDatatable` component is designed to be flexible and easy to use, providing a robust solution for displaying and interacting with tabular data in Laravel applications. By passing different prop values, you can customize the table to fit your specific requirements.
