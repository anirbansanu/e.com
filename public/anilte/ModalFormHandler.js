
class ModalFormHandler {
    constructor(modalSelector, formSelector, submitBtnSelector, closeModalBtnSelector) {
        this.modal = document.querySelector(modalSelector);
        this.form = document.querySelector(modalSelector +" "+ formSelector);
        this.submitBtn = document.querySelector(modalSelector +" "+ submitBtnSelector);
        this.closeModalBtn = document.querySelector(modalSelector +" "+ closeModalBtnSelector);
        this.init();
    }

    init() {
        $(`#${this.modal.id}`).on('show.bs.modal', this.showModal.bind(this));
        $(`#${this.modal.id}`).on('hidden.bs.modal', this.resetModal.bind(this));
        this.submitBtn.addEventListener('click', this.submitForm.bind(this));
        console.log("ModalFormHandler init called");
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
        console.log("Modal.showModal : ",data);
        this.populateFormData(data);
    }

    hideModal() {
        this.resetModal();
        $(this.modal).modal('hide');
    }
    resetModal() {
        this.form.reset();
        const errorElements = this.modal.querySelectorAll('.error.text-danger');
        errorElements.forEach(element => element.textContent = '');
    }
    submitForm() {
        const formData = new FormData(this.form);
        const method = this.form.dataset.method || 'POST';
        const action = this.form.dataset.action || '';

        fetch(action, {
            method: method,
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.errors) {
                this.displayValidationErrors(data.errors);
            } else {
                this.hideModal();
                this.displaySuccessMessage(data.message);
            }
        })
        .catch(error => {
            this.displayErrorMessage('An unexpected error occurred. Please try again.');
        });
    }

    displayValidationErrors(errors) {
        for (const key in errors) {
            if (errors.hasOwnProperty(key)) {
                const errorElement = this.form.querySelector(`[name="${key}"]`).nextElementSibling;
                if (errorElement) {
                    errorElement.textContent = errors[key][0];
                }
            }
        }
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
