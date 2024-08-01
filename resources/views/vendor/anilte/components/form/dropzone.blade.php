<div id="{{ $id }}" class="dropzone-container">
    <div class="dropzone" id="dropzone-{{ $id }}">

    </div>
    <input type="hidden" name="upload_uuid" id="upload_uuid_{{ $id }}">

</div>



@pushOnce('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
<script>
    // Disable Dropzone's auto-discovery feature
    Dropzone.autoDiscover = false;

</script>
@endPushOnce
@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {


        function initializeDropzone(id, url, maxFiles, existingFiles) {
            // // Destroy any existing Dropzone instances

            // var dropzoneElement = document.querySelector(`#dropzone-${id}`);

            // // Check if Dropzone instance already exists
            // if (Dropzone.instances.some(instance => instance.element === dropzoneElement)) {
            //     console.warn(`Dropzone instance already exists for element #dropzone-${id}`);
            //     return;
            // }

            // Check if URL is provided
            if (!url || url.trim() === '') {
                console.warn('Dropzone URL is not provided.');
                return;
            }

            var dropzone = new Dropzone(`#dropzone-${id}`, {
                url: url,
                headers: {
                    'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
                },
                paramName: "file",
                maxFilesize: maxFiles, // MB
                acceptedFiles: ".jpeg,.jpg,.png,.gif",
                parallelUploads: 20,
                autoQueue: true,
                clickable: `#dropzone-${id}`,
                maxFiles: maxFiles,
                dictDefaultMessage: "Drag and drop files here or click to upload",
                init: function() {
                    if (existingFiles.length > 0) {
                        existingFiles.forEach(file => {
                            let mockFile = { name: file.name, size: file.size };
                            this.emit("addedfile", mockFile);
                            this.emit("thumbnail", mockFile, file.thumb);
                            this.emit("complete", mockFile);
                        });
                    }
                },
                accept: function(file, done) {
                    done();
                },
                complete: function(file) {
                    // Custom completion logic
                },
                removedfile: function(file) {
                    // Custom removal logic
                }
            });
            dropzone.on("sending", function(file, xhr, formData) {
                // Attach additional file details to the formData
                formData.append("name", file.name);       // File name
                formData.append("type", file.type);       // MIME type
                formData.append("size", file.size);       // File size in bytes

                // Attach UUID if available
                if (file.upload && file.upload.uuid) {
                    formData.append("uuid", file.upload.uuid);  // UUID if you have it
                }
            });
            dropzone.on("addedfile", function(file) {
                // file.previewElement.querySelector(".start").onclick = function() {
                //     dropzone.enqueueFile(file);
                // };
                console.log("dz addedfile called");
            });

            dropzone.on("totaluploadprogress", function(progress) {
                // document.querySelector(`#total-progress-${id} .progress-bar`).style.width = progress + "%";
            });

            dropzone.on("queuecomplete", function() {
                // document.querySelector(`#total-progress-${id}`).style.opacity = "0";
            });

            dropzone.on("success", function(file, response) {
                console.log("dz success : ",response);
                console.log("dz success file : ",file);
                // Add hidden input with UUID on successful upload
                var uuidInput = document.createElement('input');
                uuidInput.type = 'hidden';
                uuidInput.name = 'uploaded_files[]';
                uuidInput.value = response.uuid;
                document.querySelector(`#dropzone-${id}`).appendChild(uuidInput);

                // Attach UUID to file object for later use
                file.upload.uuid = response.uuid;
            });
            dropzone.on("error", function(file, response) {
                // Display error message using SweetAlert
                console.log("dz error : ",response);
                console.log("dz error file : ",file);
                Swal.fire({
                    icon: 'error',
                    title: 'Upload Failed',
                    text: response.message,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
                // Remove the preview element if an error occurs
                file.previewElement.remove();
            });
            dropzone.on("removedfile", function(file,response) {
                // Delete the file via AJAX
                console.log("dz removedfile : ",response);
                if (file.upload && file.upload.uuid) {
                    $.ajax({
                        url: '{{ route('medias.delete') }}',
                        type: 'POST',
                        data: {
                            _token: document.head.querySelector('meta[name="csrf-token"]').content,
                            uuid: file.upload.uuid
                        },
                        success: function(response) {
                            // Remove the file preview element only on successful deletion
                            file.previewElement.remove();
                            console.log('File deleted successfully.');
                        },
                        error: function(response) {
                            console.error('Failed to delete file.');
                            Swal.fire({
                                icon: 'error',
                                title: 'Deletion Failed',
                                text: 'Failed to delete file.',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true
                            });
                        }
                    });
                }
            });
        }

        initializeDropzone('{{ $id }}', "{{ $url }}", 5, @json($existingFiles));
        // initializeDropzone('edit', "{{ $url }}", 5, edit_existing);
    });
</script>
@endpush
