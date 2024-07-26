<!-- resources/views/vendor/anilte/components/modals/ajax-modal.blade.php -->
<div class="modal fade" id="{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="{{ $id }}Label" aria-hidden="true">
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
<script src="{{asset("anilte/ModalFormHandler.js")}}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize the ModalFormHandler for each modal instance
        new ModalFormHandler('#products-variants-update-modal', 'form', '#updateBtn', '.close');
    });
</script>
@endPushOnce
