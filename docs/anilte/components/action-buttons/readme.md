Sure! Here is the documentation for using the `DeleteButton` and `EditButton` components in your Laravel application.

### DeleteButton Component

The `DeleteButton` component is used to render a button that triggers a SweetAlert confirmation dialog before performing a delete action.

#### Component Usage

To use the `DeleteButton` component in your Blade views, you need to pass the required attributes:

```html
<x-anilte::delete-btn
    :route="$action['route']"
    :routeParams="[$_item['id']]"
    :icon="$action['icon'] ?? 'fas fa-trash'"
    :label="$action['title'] ?? 'Delete'"
    :alertTitle="$action['alertTitle'] ?? 'Are you sure?'"
    :text="$action['text'] ?? 'You will not be able to recover this record!'"
    :iconType="$action['iconType'] ?? 'warning'"
    :cancelBtn="$action['cancelBtn'] ?? true"
    :confirmText="$action['confirmText'] ?? 'Yes, delete it!'"
    :cancelText="$action['cancelText'] ?? 'Cancel'"
/>
```

#### Available Attributes

- `route` (string, required): The named route to which the delete request will be sent.
- `routeParams` (array, optional): The parameters required by the route. Default is an empty array.
- `icon` (string, optional): The icon class for the button. Default is `fas fa-trash`.
- `label` (string, optional): The label text for the button. Default is `Delete`.
- `alertTitle` (string, optional): The title for the SweetAlert dialog. Default is `Are you sure?`.
- `text` (string, optional): The text for the SweetAlert dialog. Default is `You will not be able to recover this record!`.
- `iconType` (string, optional): The icon type for the SweetAlert dialog. Default is `warning`.
- `cancelBtn` (boolean, optional): Whether to show the cancel button in the SweetAlert dialog. Default is `true`.
- `confirmText` (string, optional): The text for the confirm button in the SweetAlert dialog. Default is `Yes, delete it!`.
- `cancelText` (string, optional): The text for the cancel button in the SweetAlert dialog. Default is `Cancel`.

### EditButton Component

The `EditButton` component is used to render a button that navigates to an edit form.

#### Component Usage

To use the `EditButton` component in your Blade views, you need to pass the required attributes:

```html
<x-anilte.edit-button
    :route="$action['route']"
    :routeParams="[$_item['id']]"
    :icon="$action['icon'] ?? 'fas fa-pencil-alt'"
    :label="$action['title'] ?? 'Edit'"
/>
```

#### Available Attributes

- `route` (string, required): The named route to which the edit request will be sent.
- `routeParams` (array, optional): The parameters required by the route. Default is an empty array.
- `icon` (string, optional): The icon class for the button. Default is `fas fa-pencil-alt`.
- `label` (string, optional): The label text for the button. Default is `Edit`.

### Example Usage

Here is an example of how you can use both `DeleteButton` and `EditButton` components in a Blade view:

```html
<table>
    <tr>
        <td>
            <x-anilte.edit-button
                :route="route('edit', ['id' => $item->id])"
                :routeParams="[$item->id]"
                :icon="'fas fa-edit'"
                :label="'Edit'"
            />
        </td>
        <td>
            <x-anilte::delete-btn
                :route="route('delete', ['id' => $item->id])"
                :routeParams="[$item->id]"
                :icon="'fas fa-trash-alt'"
                :label="'Delete'"
                :alertTitle="'Are you sure?'"
                :text="'This action is irreversible!'"
                :iconType="'warning'"
                :cancelBtn="true"
                :confirmText="'Yes, delete it!'"
                :cancelText="'No, keep it'"
            />
        </td>
    </tr>
</table>
```

### Documentation for `RestoreButton` and `ViewButton` Components

The `RestoreButton` and `ViewButton` components are designed to generate action buttons in your Laravel application using Blade components. The `RestoreButton` is used to restore soft-deleted items, while the `ViewButton` is used to view item details.

#### Usage

##### Blade Component Usage

To use the `RestoreButton` and `ViewButton` components in your Blade templates, use the following syntax:

**RestoreButton:**
```html
<x-anilte::restore-btn route="your.restore.route" :routeParams="['id' => $id]" icon="optional-icon-class" label="Optional Label"/>
```

**ViewButton:**
```html
<x-anilte::view-btn route="your.view.route" :routeParams="['id' => $id]" icon="optional-icon-class" label="Optional Label"/>
```

- **route**: (string) The name of the route that handles the action.
- **routeParams**: (array) Optional parameters to pass to the route. Default is an empty array.
- **icon**: (string) Optional icon class for the button. Default is provided.
- **label**: (string) Optional label for the button. Default is provided.

##### Example

Here's an example of using the `RestoreButton` and `ViewButton` in a Blade template:

```html
<x-anilte::restore-btn route="users.restore" :routeParams="['id' => $user->id]" label="Restore User"/>
<x-anilte::view-btn route="users.show" :routeParams="['id' => $user->id]" label="View User"/>
```

In this example, the buttons will use the routes named `users.restore` and `users.show`, passing the `id` of the user as a route parameter.

#### Installation

1. **Component Views**:

Create a new Blade view file at `resources/views/vendor/anilte/components/actions/restore-btn.blade.php` with the following content:

```html
@props(['route', 'routeParams' => [], 'icon' => null, 'label'])
<a href="{{ route($route, $routeParams) }}" class="btn btn-sm btn-success font-weight-bold">
    <i class="{{ $icon ?? 'fas fa-trash-restore' }}"></i>
    {{ $label }}
</a>
```

Create a new Blade view file at `resources/views/vendor/anilte/components/actions/view-btn.blade.php` with the following content:

```html
@props(['route', 'routeParams' => [], 'icon' => null, 'label'])
<a href="{{ route($route, $routeParams) }}" class="btn btn-sm btn-primary font-weight-bold">
    <i class="{{ $icon ?? 'fas fa-eye' }}"></i>
    {{ $label }}
</a>
```

2. **Component Classes**:

Create a new PHP class at `app/View/Components/Anilte/RestoreButton.php` with the following content:

```php
<?php

namespace App\View\Components\Anilte;

use Illuminate\View\Component;

class RestoreButton extends Component
{
    public $route;
    public $routeParams;
    public $icon;
    public $label;

    public function __construct($route, $routeParams = [], $icon = 'fas fa-undo', $label = 'Restore')
    {
        $this->route = $route;
        $this->routeParams = $routeParams;
        $this->icon = $icon;
        $this->label = $label;
    }

    public function render()
    {
        return view('vendor.anilte.components.actions.restore-btn');
    }
}
```

Create a new PHP class at `app/View/Components/Anilte/ViewButton.php` with the following content:

```php
<?php

namespace App\View\Components\Anilte;

use Illuminate\View\Component;

class ViewButton extends Component
{
    public $route;
    public $routeParams;
    public $icon;
    public $label;

    public function __construct($route, $routeParams = [], $icon = 'fas fa-eye', $label = 'View')
    {
        $this->route = $route;
        $this->routeParams = $routeParams;
        $this->icon = $icon;
        $this->label = $label;
    }

    public function render()
    {
        return view('vendor.anilte.components.actions.view-btn');
    }
}
```

3. **Service Provider**:

Update the `AnilteServiceProvider` to include the `RestoreButton` and `ViewButton` components. The service provider should be located at `app/Providers/AnilteServiceProvider.php`:

```php
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\View\Components\Anilte\AnilteDatatable;
use App\View\Components\Anilte\Card;
use App\View\Components\Anilte\TabNavItem;
use App\View\Components\Anilte\DeleteButton;
use App\View\Components\Anilte\EditButton;
use App\View\Components\Anilte\RestoreButton;
use App\View\Components\Anilte\ViewButton;

class AnilteServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        $components = [
            'datatable' => AnilteDatatable::class,
            'card' => Card::class,
            'tab-nav-item' => TabNavItem::class,
            'delete-btn' => DeleteButton::class,
            'edit-btn' => EditButton::class,
            'restore-btn' => RestoreButton::class,
            'view-btn' => ViewButton::class,
        ];

        foreach ($components as $alias => $component) {
            Blade::component("anilte::$alias", $component);
        }
    }
}
```

#### Adding Routes

Make sure you have the necessary routes defined in your `web.php`:

```php
use App\Http\Controllers\UserController;

Route::get('/users/trash', [UserController::class, 'trash'])->name('users.trash');
Route::post('/users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
Route::delete('/users/{id}/force-delete', [UserController::class, 'forceDelete'])->name('users.forceDelete');
Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
```

#### Controller Methods

Ensure your `UserController` has the necessary methods to handle the restore, force delete, and show actions:

```php
<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function trash()
    {
        $data = User::onlyTrashed()->paginate(10);
        $entries = 10;
        $search = request()->input('search', '');
        $sort_by = request()->input('sort_by', 'id');
        $sort_order = request()->input('sort_order', 'asc');

        return view('users.trash', compact('data', 'entries', 'search', 'sort_by', 'sort_order'));
    }

    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();

        return redirect()->route('users.trash')->with('success', 'User restored successfully');
    }

    public function forceDelete($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->forceDelete();

        return redirect()->route('users.trash')->with('success', 'User deleted permanently');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }
}
```

### Conclusion

This documentation covers the installation and usage of the `RestoreButton`,`ViewButton`, `DeleteButton` and `EditButton` components in a Laravel application. By following these steps, you can easily implement action buttons in your views, allowing for seamless restoration and viewing of items.

