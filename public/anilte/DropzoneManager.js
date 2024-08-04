class DropzoneManager {
    constructor(id, url, maxFiles, field, existing = [], isMultiple = false, removeUrl = '', collection = '') {
        this.id = id;
        this.url = url;
        this.maxFiles = maxFiles;
        this.field = field;
        this.existing = existing;
        this.isMultiple = isMultiple;
        this.removeUrl = removeUrl;  // URL for removing files
        this.collection = collection;  // Collection name for backend

        this.initializeDropzone();
    }

    initializeDropzone() {
        Dropzone.autoDiscover = false;

        const previewNode = document.querySelector(`#${this.id} .dz-previews`);
        previewNode.id = "";
        const previewTemplate = previewNode.parentNode.innerHTML;
        previewNode.parentNode.removeChild(previewNode);

        const dropzoneElement = document.getElementById(this.id);
        const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;

        console.log('Initializing Dropzone with the following parameters:', {
            url: this.url,
            maxFiles: this.maxFiles,
            field: this.field,
            existing: this.existing,
            isMultiple: this.isMultiple,
            removeUrl: this.removeUrl,
            collection: this.collection
        });

        const self = this;
        this.myDropzone = new Dropzone(dropzoneElement, {
            url: this.url,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            params: {
                field: this.field
            },
            // thumbnailWidth: 80,
            // thumbnailHeight: 80,
            parallelUploads: 20,
            // previewTemplate: previewTemplate,
            autoQueue: true,
            // previewsContainer: `#${this.id}-previews`,
            maxFiles: this.maxFiles - this.existing.length,

            init: function() {
                if (self.existing.length > 0) {
                    self.existing.forEach(media => {
                        self.dzInit(this, media, media.thumb);
                    });
                }
            },
            accept: function(file, done) {
                self.dzAccept(file, done);
            },
            sending: function(file, xhr, formData) {
                if (self.isMultiple) {
                    self.dzSendingMultiple(file, formData, csrfToken);
                } else {
                    self.dzSending(file, formData, csrfToken);
                }
            },
            maxfilesexceeded: function(file) {
                self.dzMaxfile(file);
            },
            complete: function(file) {
                self.dzComplete(file);
            },
            removedfile: function(file) {
                if (self.isMultiple) {
                    self.dzRemoveFileMultiple(file);
                } else {
                    self.dzRemoveFile(file);
                }
            }
        });

        this.setupEventHandlers();
    }

    setupEventHandlers() {
        const self = this;
        this.myDropzone.on("addedfile", function(file) {
            // file.previewElement.querySelector(".start").onclick = function() {
            //     self.myDropzone.enqueueFile(file);
            // };
            self.dzAddRemoveButton(file);

        });

        this.myDropzone.on("totaluploadprogress", function(progress) {
            // document.querySelector("#total-progress .progress-bar").style.width = progress + "%";
        });

        this.myDropzone.on("queuecomplete", function(progress) {
            // document.querySelector("#total-progress").style.opacity = "0";
        });

        // document.querySelector("#actions .start").onclick = function() {
        //     self.myDropzone.enqueueFiles(self.myDropzone.getFilesWithStatus(Dropzone.ADDED));
        // };

        // document.querySelector("#actions .cancel").onclick = function() {
        //     self.myDropzone.removeAllFiles(true);
        // };
    }

    dzInit(_this, mockFile, thumb) {
        _this.options.addedfile.call(_this, mockFile);
        _this.options.thumbnail.call(_this, mockFile, thumb);
        mockFile.previewElement.classList.add('dz-success');
        mockFile.previewElement.classList.add('dz-complete');
    }

    dzAccept(file, done) {
        const ext = file.name.split('.').pop().toLowerCase();
        if (['jpg', 'png', 'gif', 'jpeg', 'bmp'].indexOf(ext) === -1) {
            const thumbnail = document.querySelector(`#${this.id} .dz-preview.dz-file-preview .dz-image:last`);
            const icon = `/path/to/icons/${ext}.png`;
            thumbnail.style.backgroundImage = `url(${icon})`;
            thumbnail.style.backgroundSize = 'contain';
        }
        done();
    }

    dzSending(file, formData, csrf) {
        console.log('Sending file:', file);
        file.previewElement.children[0].value = file.upload.uuid;
        formData.append('_token', csrf);
        formData.append('field', this.field);
        formData.append('uuid', file.upload.uuid);
    }

    dzSendingMultiple(file, formData, csrf) {
        console.log('Sending multiple files:', file);
        $(file.previewElement).prepend('<input type="hidden" name="image[]">');
        file.previewElement.children[0].value = file.upload.uuid;
        file.previewElement.children[0].id = file.upload.uuid;

        formData.append('_token', csrf);
        formData.append('field', this.field);
        formData.append('uuid', file.upload.uuid);
    }

    dzMaxfile(file) {
        console.log('Max file exceeded:', file);
        this.myDropzone.removeAllFiles();
        this.myDropzone.addFile(file);
    }

    dzComplete(file) {
        if (file._removeLink) {
            file._removeLink.textContent = this.myDropzone.options.dictRemoveFile;
        }
        if (file.previewElement) {
            file.previewElement.classList.add("dz-complete");
        }
    }
    dzAddRemoveButton(file) {
        const removeButton = Dropzone.createElement("<button class='dz-remove-btn'>✖</button>");
        removeButton.addEventListener("click", function(e) {
            e.preventDefault();
            e.stopPropagation();
            this.myDropzone.removeFile(file);
        }.bind(this));
        file.previewElement.appendChild(removeButton);
        file.previewElement.classList.add('dz-with-remove-btn');
    }
    dzRemoveFile(file) {
        console.log('Removing file from backend:', file.upload.uuid);
        if (file.previewElement && file.previewElement.parentNode) {
            file.previewElement.parentNode.removeChild(file.previewElement);
        }
        if (file.upload) {
            const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
            const self = this;
            console.log("self.removeUrl : ",self.removeUrl);
            console.log("self.csrfToken : ",csrfToken);
            $.ajax({
                url: self.removeUrl,
                type: 'POST',
                data: {
                    _token: csrfToken,
                    id: self.modelId,
                    collection: self.collection,
                    uuid: file.upload.uuid
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: `${response.message}`,
                    });
                },
                error: function(jqXHR) {
                    console.warn('Error removing file:', jqXHR);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: `${jqXHR.responseJSON.message}`,
                    });
                }
            });
        }
    }

    dzRemoveFileMultiple(file) {
        if (file.previewElement && file.previewElement.parentNode) {
            file.previewElement.parentNode.removeChild(file.previewElement);
        }
        if (file.upload) {
            const self = this;
            console.log('Removing multiple files from backend:', file.upload.uuid);

            $.post(this.removeUrl, {
                _token: self.csrfToken,
                id: self.modelId,
                collection: self.collection,
                uuid: file.upload.uuid
            }).done(function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: `${response.message}`,
                });
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                console.warn('Error removing files:', jqXHR);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: `${jqXHR.responseJSON.message}`,
                });
            });
        }
    }
}

// Export the DropzoneManager class
export default DropzoneManager;
