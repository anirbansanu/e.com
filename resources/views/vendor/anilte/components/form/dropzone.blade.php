@props([
    'id' => 'dropzone-id',
    'url' => route('medias.create'),
    'maxFiles' => 5,
    'field' => 'files',
    'existing' => [],
    'isMultiple' => false,
    'removeUrl' => route('medias.delete'),
    'collection' => 'collection_name'
])
<style>
    .dz-with-remove-btn .dz-image {
        position: relative;
    }
    .dz-remove-btn {
        position: absolute;
        top: 5px;
        right: 5px;
        background: red;
        color: white;
        border: none;
        border-radius: 50%;
        cursor: pointer !important;
        font-size: 14px;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
    }
</style>
<div class="dropzone"
    id="{{ $id }}"
    data-url="{{ $url }}"
    data-max-files="{{ $maxFiles }}"
    data-field="{{ $field }}"
    data-existing="{{ json_encode($existing ?? []) }}"
    data-is-multiple="{{ $isMultiple ?? false }}"
    data-remove-url="{{ $removeUrl ?? '' }}"
    data-collection="{{ $collection ?? '' }}"
>
    <div class="dz-message">
        <span>Drop files here or click to upload.</span>
    </div>
    <div class="dz-previews" id='{{ $id }}-previews'></div>
</div>
@pushOnce('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
<script>
    // Disable Dropzone's auto-discovery feature
    Dropzone.autoDiscover = false;


</script>
<script src="{{ asset('anilte/DropzoneManager.js') }}" type="module"></script>
@endPushOnce

@push('js')
<script type="module">
    import DropzoneManager from "{{ asset('anilte/DropzoneManager.js') }}";

    document.addEventListener('DOMContentLoaded', function () {
        const dropzoneElement = document.getElementById('{{ $id }}');
        const isMultiple = dropzoneElement.dataset.isMultiple === 'true';

        new DropzoneManager(
            '{{ $id }}',
            '{{ $url }}',
            {{ $maxFiles }},
            '{{ $field }}',
            {!! json_encode($existing ?? []) !!},
            isMultiple,
            '{{ $removeUrl}}',
            '{{ $collection}}'
        );
    });
</script>
@endpush
