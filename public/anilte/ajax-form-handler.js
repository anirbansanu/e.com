class AjaxFormHandler {
    constructor(modalSelector, formSelector, submitBtnSelector) {
        this.modalSelector = modalSelector ? modalSelector : null;
        this.form = document.querySelector(modalSelector+" "+formSelector);
        this.submitBtn = document.querySelector(modalSelector+" "+submitBtnSelector);
        this.init();
    }

    init() {
        console.log("AjaxFormHandler init called ");
        this.submitBtn.addEventListener('click', (event) => {
            event.preventDefault();
            this.handleSubmit();
        });
    }

    handleSubmit() {
        const formData = new FormData(this.form);
        const action = this.form.dataset.action;
        const method = this.form.dataset.method || 'POST';

        this.clearErrors();

        fetch(action, {
            method: method,
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(errors => {
                    this.handleErrors(errors);
                    throw new Error('Validation failed');
                });
            }
            return response.json();
        })
        .then(data => {
            this.handleSuccess(data);
        })
        .catch(error => {
            this.handleFailure(error);
        });
    }

    handleErrors(errors) {
        if (errors.errors) {
            for (let [field, messages] of Object.entries(errors.errors)) {
                const input = this.form.querySelector(`[name="${field}"]`);
                if (input) {
                    const errorContainer = document.createElement('div');
                    errorContainer.classList.add('invalid-feedback');
                    errorContainer.textContent = messages.join(', ');
                    input.classList.add('is-invalid');
                    input.parentElement.appendChild(errorContainer);
                }
            }
        } else {
            this.handleFailure({ message: 'An unexpected error occurred' });
        }
    }

    handleSuccess(data) {
        if (this.modalSelector) {
            $(this.modalSelector).modal('hide');
        }
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

    handleFailure(error) {
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

    clearErrors() {
        this.form.querySelectorAll('.is-invalid').forEach(input => {
            input.classList.remove('is-invalid');
        });
        this.form.querySelectorAll('.invalid-feedback').forEach(errorContainer => {
            errorContainer.remove();
        });
    }
}

