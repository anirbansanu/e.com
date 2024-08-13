
class ModalFormHandler {
    constructor(modalSelector, formSelector, submitBtnSelector, closeModalBtnSelector) {
        this.modal = document.querySelector(modalSelector);

        this.form = document.querySelector(modalSelector +" "+ formSelector);
        this.submitBtn = document.querySelector(modalSelector +" "+ submitBtnSelector);
        this.closeModalBtn = document.querySelector(modalSelector +" "+ closeModalBtnSelector);
        this.successCallbacks = [];
        this.action = "";
        this.init();
    }

    init() {
        $(`#${this.modal.id}`).on('show.bs.modal', this.showModal.bind(this));
        $(`#${this.modal.id}`).on('hidden.bs.modal', this.resetModal.bind(this));
        this.submitBtn.addEventListener('click', this.submitForm.bind(this));
        console.log(`${this.modal.id} initiated `);
    }

    addSubmitEvent() {
        this.submitBtn.addEventListener('click', (event) => {
            event.preventDefault();
            this.submitForm();
        });
    }

    populateFormData(data) {
        for (const key in data) {
            if (data.hasOwnProperty(key)) {
                const input = this.form.querySelector(`[name="${key}"]`);
                if ($(input).hasClass('select2')) {
                    let option = new Option(data[key],data[key], true, true);
                    $(input).append(option).trigger('change');
                    console.log("select2 : ",input);
                    continue;
                }
                if (input) {
                    input.value = data[key];

                }
            }
        }
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

    showModal(event) {
        const button = event.relatedTarget;
        const data = {};
        if (button) {
            [...button.attributes].forEach(attr => {
                if (attr.name.startsWith('data-')) {
                    const key = attr.name.substring(5);
                    data[key] = attr.value;
                }
            });
        }
        // Store data for later use in submitForm
        this.form.dataset.modalData = JSON.stringify(data);

        // Parse stored data from showModal
        const modalData = JSON.parse(this.form.dataset.modalData || '{}');

        try {
            this.action = this.replacePlaceholders(this.form.dataset.action || '', modalData);
        } catch (error) {
            console.error(error.message);
            return;
        }
        console.log("this.action : ",this.action);

        console.log("Modal.modalData : ",data);
        this.populateFormData(data);
    }

    hideModal() {
        $(`#${this.modal.id}`).modal('hide');
        console.log(`Modal with id: #${this.modal.id} is hidden`);
    }
    resetModal() {
        this.form.reset();
        this.clearExistingErrors();
    }
    submitForm() {
        const formData = new FormData(this.form);
        const method = this.form.dataset.method || 'POST';
        const action = this.action || '';
        const requestData = Object.fromEntries(formData.entries());
        console.log("requestData : ", requestData);

        $.ajax({
            url: action,
            method: method,
            data: requestData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            success: (data) => {
                console.log("data : ", data);
                if (data.status === 422) {
                    this.displayValidationErrors(data.errors);
                }
                else{
                    this.hideModal();
                    this.displaySuccessMessage(data.message);
                    this.onSuccessEvents();
                }
            },
            error: (jqXHR, textStatus, errorThrown) => {
                console.log("ajax error called : ",jqXHR.responseJSON);
                if (jqXHR.responseJSON.status == 422) {
                    this.displayValidationErrors(jqXHR.responseJSON.errors);
                }
                else{
                    this.displayErrorMessage(jqXHR.responseJSON.message);
                }
            }
        });
    }

    /**
     * Adds a callback function to be executed on success.
     * @param {Function} callback - The callback function to add.
     */
    addSuccessEvent(callback) {
        if (typeof callback === 'function') {
            this.successCallbacks.push(callback);
        } else {
            console.error('Callback is not a function', callback);
        }
    }

    /**
     * Executes all success callback functions.
     */
    onSuccessEvents() {
        this.successCallbacks.forEach(callback => {
            if (typeof callback === 'function') {
                callback();
            } else {
                console.error('Callback is not a function', callback);
            }
        });
    }

    displayValidationErrors(errors) {
        console.log("displayValidationErrors:", errors);

        // Clear existing error messages
        this.clearExistingErrors();

        Object.entries(errors).forEach(([key, messages]) => {
            // Find the input field by name
            const inputField = this.form.querySelector(`[name="${key}"]`);

            if (inputField) {
                // Find the closest form-group parent element
                const formGroup = inputField.closest('.form-group');

                if (formGroup) {
                    // Create or find the error element
                    let errorElement = formGroup.querySelector('.invalid-feedback');

                    if (!errorElement) {
                        errorElement = document.createElement('span');
                        errorElement.classList.add('invalid-feedback','d-block');
                        inputField.classList.add('is-invalid');
                        formGroup.appendChild(errorElement);
                    }

                    // Display the first error message (or all if needed)
                    errorElement.textContent = messages[0];
                } else {
                    console.warn(`Form group for field with name "${key}" not found.`);
                }
            } else {
                console.warn(`Form field with name "${key}" not found.`);
            }
        });
    }

    clearExistingErrors() {
        // Remove all existing error elements
        this.form.querySelectorAll('.error.text-danger').forEach(element => element.remove());
        this.form.querySelectorAll('.is-invalid').forEach(input => {
            input.classList.remove('is-invalid');
        });
        this.form.querySelectorAll('.invalid-feedback').forEach(errorContainer => {
            errorContainer.remove();
        });
    }

    displaySuccessMessage(message) {

        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: message,
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
    }

    displayErrorMessage(message) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: message,
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
    }
}
