### Card Component Documentation

This documentation provides an overview of the `Card` component in your Laravel application using the AdminLTE template. The `Card` component allows you to easily create customizable cards with optional header, body, and footer sections. Additionally, it supports dynamic features such as minimize, maximize, and close buttons.

#### Component Class

The `Card` component class is located in the `App\View\Components\Anilte` namespace. Here is the class definition:

```php
namespace App\View\Components\Anilte;

use Illuminate\View\Component;

class Card extends Component
{
    public $cardClass;
    public $headerClass;
    public $bodyClass;
    public $footerClass;
    public $minimize;
    public $maximize;
    public $close;

    public function __construct(
        $cardClass = '',
        $headerClass = '',
        $bodyClass = '',
        $footerClass = '',
        $minimize = null,
        $maximize = null,
        $close = null
    ) {
        $this->cardClass = $cardClass;
        $this->headerClass = $headerClass;
        $this->bodyClass = $bodyClass;
        $this->footerClass = $footerClass;
        $this->minimize = $minimize;
        $this->maximize = $maximize;
        $this->close = $close;
    }

    public function render()
    {
        return view('vendor.anilte.components.cards.card');
    }
}
```

#### Blade View

The corresponding Blade view for the `Card` component is located at `resources/views/vendor/anilte/components/cards/card.blade.php`. Here is the Blade view definition:

```blade
@props([
    'cardClass' => '',
    'headerClass' => '',
    'bodyClass' => '',
    'footerClass' => '',
    'header' => null,
    'body' => null,
    'footer' => null,
    'minimize' => null,
    'maximize' => null,
    'close' => null
])

<div class="card card-primary {{ $cardClass }}">
    @if ($header)
        <div class="card-header {{ $headerClass }}">
            <div class="d-flex justify-content-between align-items-center">
                {{ $header }}
                <div class="card-tools">
                    @isset($minimize)
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    @endisset
                    @isset($maximize)
                        <button type="button" class="btn btn-tool" data-card-widget="maximize" title="Maximize">
                            <i class="fas fa-expand"></i>
                        </button>
                    @endisset
                    @isset($close)
                        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                            <i class="fas fa-times"></i>
                        </button>
                    @endisset
                </div>
            </div>
        </div>
    @endif
    @if ($body)
        <div class="card-body {{ $bodyClass }}">
            {{ $body }}
        </div>
    @endif
    @if ($footer)
        <div class="card-footer {{ $footerClass }}">
            {{ $footer }}
        </div>
    @endif
</div>
```

### How to Use the Card Component

To use the `Card` component in your Blade views, you can simply include the component and pass the desired parameters. Below is an example of how to use the `Card` component:

#### Example Usage

```blade
    <x-anilte-card headerClass="p-2" bodyClass="p-0" footerClass="custom-footer-class" minimize maximize close>
        <x-slot name="header">
            <span class="card-title">Card Title</span>
        </x-slot>
        <x-slot name="body">
            <x-anilte-datatable
                url="{{ route('users.index') }}"
                :thead="[['data'=>'name','title'=>'Name'],
                        ['data'=>'email','title'=>'Email'],
                        ['data'=>'updated_at','title'=>'Updated At']]"
                :tbody="$data"
                :actions="[['route'=>'users.edit','data'=>'edit','title'=>'Edit','btn-class'=>'btn-info','icon'=>'fas fa-pencil-alt'],
                ['route'=>'users.destroy','data'=>'delete','title'=>'Delete','btn-class'=>'btn-danger btn-delete','icon'=>'fas fa-trash', ]]"
                :entries="$entries"
                :search="$search"
                :sort_by="$sort_by"
                :sort_order="$sort_order"
                :searchable="true"
                :showentries="true"
                :current_page="$data->currentPage()"
                :total="$data->total()"
                :per_page="$data->perPage()"
            />
        </x-slot>
        <x-slot name="footer">
            <div>This is a sample footer</div>
        </x-slot>
    </x-anilte-card>
```

### Parameters

- `cardClass`: Additional CSS classes for the card element.
- `headerClass`: Additional CSS classes for the card header.
- `bodyClass`: Additional CSS classes for the card body.
- `footerClass`: Additional CSS classes for the card footer.
- `header`: Content for the card header.
- `body`: Content for the card body.
- `footer`: Content for the card footer.
- `minimize`: Show the minimize button if set to `true`.
- `maximize`: Show the maximize button if set to `true`.
- `close`: Show the close button if set to `true`.

### Additional Notes

- The `minimize`, `maximize`, and `close` buttons are dynamically rendered based on the presence of their respective parameters.
- The `header`, `body`, and `footer` parameters allow you to insert any HTML content into the respective sections of the card.

### Conclusion

The `Card` component is a flexible and powerful way to create card elements in your Laravel application using the AdminLTE template. By utilizing the dynamic features and customizable classes, you can easily tailor the appearance and functionality of the card to suit your needs.
