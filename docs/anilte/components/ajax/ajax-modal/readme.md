### Blade Component Documentation

#### Blade Component: `ajax-modal.blade.php`

This Blade component creates a modal form that can be used with the `ModalFormHandler` JavaScript class for AJAX-based form submission. The modal includes dynamic IDs, titles, and form actions/methods.

##### Blade Component Structure

```blade
<!-- resources/views/vendor/anilte/components/modals/ajax-modal.blade.php -->
<div class="modal" id="{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="{{ $id }}Label" aria-hidden="true">
    <form class="modal-dialog {{ $size ?? 'modal-lg' }}" id="{{ $formId }}" data-method="{{ $method }}" data-action="{{ $action }}">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="{{ $id }}Label">{{ $title }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{ $slot }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="{{ $buttonId }}">Save changes</button>
            </div>
        </div>
    </form>
</div>
@pushOnce('js')
<script src="{{ asset('anilte/ModalFormHandler.js') }}"></script>
@endPushOnce
@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize the ModalFormHandler for each modal instance
        window.{{ $id }} = new ModalFormHandler('#{{ $id }}', `#{{ $formId }}`, `#{{ $buttonId }}`, '.close');
    });
</script>
@endpush
```

##### Parameters

- **$id**: The ID of the modal.
- **$formId**: The ID of the form inside the modal.
- **$size** (optional): The size of the modal dialog (default is 'modal-lg').
- **$method**: The HTTP method for form submission (e.g., POST, PUT).
- **$action**: The action URL for form submission.
- **$title**: The title of the modal.
- **$buttonId**: The ID of the form submission button.
- **$slot**: The content inside the modal body.

### Usage Example

#### Blade Template

```blade
<!-- Example usage of the ajax-modal component -->
<x-anilte::components.modals.ajax-modal 
    id="exampleModal" 
    formId="exampleForm" 
    method="POST" 
    action="/submit-url" 
    title="Example Modal" 
    buttonId="submitBtn">
    
    <!-- Modal Body Content -->
    <div class="form-group">
        <label for="exampleInput">Example Input</label>
        <input type="text" class="form-control" id="exampleInput" name="example">
    </div>

</x-anilte::components.modals.ajax-modal>
```

#### JavaScript Initialization

The modal form handler is automatically initialized when the document is loaded.

```javascript
document.addEventListener('DOMContentLoaded', function () {
    // Example of initializing additional modals if needed
    window.exampleModal = new ModalFormHandler('#exampleModal', '#exampleForm', '#submitBtn', '.close');
    
    // Adding success event callback
    window.exampleModal.addSuccessEvent(() => {
        console.log('Form submitted successfully!');
    });
});
```

### Explanation

- **Blade Component**: The `ajax-modal.blade.php` component defines the structure of a Bootstrap modal, including dynamic IDs and form attributes.
- **JavaScript Initialization**: The script ensures that the `ModalFormHandler` is initialized for each modal instance by referencing its ID, form ID, and button ID.
- **Dynamic Content**: The modal body content is passed via the `$slot` variable, allowing for flexible and reusable modal designs.

This documentation provides a comprehensive guide on how to use the `ajax-modal` Blade component with the `ModalFormHandler` class for efficient AJAX-based form handling in a Laravel application.



### ModalFormHandler Documentation

#### Class: `ModalFormHandler`

The `ModalFormHandler` class manages modal forms, including displaying, submitting, and handling validation errors. It integrates with Bootstrap modals and jQuery for AJAX requests.

##### Constructor

```javascript
constructor(modalSelector, formSelector, submitBtnSelector, closeModalBtnSelector)
```

- **Parameters:**
  - `modalSelector` (String): CSS selector for the modal element.
  - `formSelector` (String): CSS selector for the form element inside the modal.
  - `submitBtnSelector` (String): CSS selector for the form submission button.
  - `closeModalBtnSelector` (String): CSS selector for the modal close button.

##### Methods

1. **`init()`**
   - Initializes the modal by attaching event listeners for showing, hiding, and submitting the form.
   
2. **`addSubmitEvent()`**
   - Adds an event listener to the submit button for form submission.
   
3. **`populateFormData(data)`**
   - Populates the form with provided data.
   - **Parameters:**
     - `data` (Object): Data to populate the form fields.
   
4. **`replacePlaceholders(url, params)`**
   - Replaces placeholders in a URL with provided parameters.
   - **Parameters:**
     - `url` (String): URL with placeholders.
     - `params` (Object): Parameters to replace the placeholders.
   
5. **`showModal(event)`**
   - Handles showing the modal and populating it with data.
   - **Parameters:**
     - `event` (Event): Event triggered when the modal is shown.
   
6. **`hideModal()`**
   - Hides the modal and resets it.
   
7. **`resetModal()`**
   - Resets the modal form and clears validation errors.
   
8. **`submitForm()`**
   - Submits the form via AJAX.
   
9. **`addSuccessEvent(callback)`**
   - Adds a callback function to be executed on successful form submission.
   - **Parameters:**
     - `callback` (Function): Callback function.
   
10. **`onSuccessEvents()`**
    - Executes all success callback functions.
    
11. **`displayValidationErrors(errors)`**
    - Displays validation errors in the form.
    - **Parameters:**
      - `errors` (Object): Validation errors.
      
12. **`clearExistingErrors()`**
    - Clears existing validation errors in the form.
    
13. **`displaySuccessMessage(message)`**
    - Displays a success message using SweetAlert2.
    - **Parameters:**
      - `message` (String): Success message.
      
14. **`displayErrorMessage(message)`**
    - Displays an error message using SweetAlert2.
    - **Parameters:**
      - `message` (String): Error message.

### Usage

#### HTML Structure

Ensure your modal structure matches the expected selectors.

```html
<div id="exampleModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Example Modal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="exampleForm" data-action="/submit-url" data-method="POST">
                    <div class="form-group">
                        <label for="exampleInput">Example Input</label>
                        <input type="text" class="form-control" id="exampleInput" name="example">
                    </div>
                    <button type="submit" id="submitBtn" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
```

#### JavaScript Initialization

Initialize the `ModalFormHandler` with appropriate selectors.

```javascript
document.addEventListener('DOMContentLoaded', function() {
    const formHandler = new ModalFormHandler('#exampleModal', '#exampleForm', '#submitBtn', '.close');

    // Add a success event callback
    formHandler.addSuccessEvent(() => {
        console.log('Form submitted successfully!');
    });
});
```

#### Example Callbacks

You can add multiple success event callbacks.

```javascript
formHandler.addSuccessEvent(() => {
    console.log('First callback executed!');
});

formHandler.addSuccessEvent(() => {
    console.log('Second callback executed!');
});
```

### Explanation

- **Initialization**: The `ModalFormHandler` instance is created with the selectors for the modal, form, submit button, and close button. It sets up event listeners for showing, hiding, and submitting the modal form.
- **Form Data Handling**: The `populateFormData` method fills the form with data when the modal is shown. The `replacePlaceholders` method replaces URL placeholders with actual values.
- **Form Submission**: The `submitForm` method handles form submission via AJAX, including displaying validation errors and success messages.
- **Callback Handling**: The `addSuccessEvent` method allows you to add multiple callbacks to be executed upon successful form submission.

This documentation provides a comprehensive guide on how to use the `ModalFormHandler` class to manage modal forms effectively in a web application.
