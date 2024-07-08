<script>
    // Define the AjaxDataTable component
    class AjaxDataTable {
        constructor(endpoint, tableBodySelector, columns, options = {}) {
            this.endpoint = endpoint;
            this.tableBodySelector = tableBodySelector;
            this.columns = columns;
            this.options = options;
        }

        fetchDataAndRender() {

            this.loading();
            $.ajax({
                url: this.endpoint,
                method: 'GET',
                success: (response) => {
                    this.renderDataInTable(response.data);
                },
                error: (xhr, status, error) => {
                    var errorMessage = 'An error occurred. Please try again later.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                        console.log(xhr.responseJSON);
                    }

                    toastr["error"](response.errorMessage);
                },
                complete: () => {
                    // Hide loading overlay
                    setTimeout(() => {
                        // Render fetched data
                        this.loading('hide');

                        // Hide loading overlay here
                    }, 500);

                }
            });
        }

        renderDataInTable(data) {
            // Clear existing data in the table body
            $(this.tableBodySelector).empty();

            // Render fetched data
            data.forEach((item, index) => {
                let row = '<tr>';
                this.columns.forEach((column) => {
                    if (column.field === '#') {
                        row += `<td>${index + 1}</td>`;
                    } else if (column.field === 'action') {
                        row += `<td>${this.renderActionButtons(item)}</td>`;
                    } else {
                        row += `<td>${item[column.field] || ""}</td>`;
                    }
                });
                row += '</tr>';
                $(this.tableBodySelector).append(row);
            });
        }

        renderActionButtons(item) {

            if (this.options.customActions && this.options.customActions.length > 0) {
                let actionsHtml = '';
                this.options.customActions.forEach((action) => {
                    let attributes = action.attributes || '';
                    actionsHtml += `<button class="${action.buttonClass}" onclick="${action.clickHandler || ""}(${item.id || ""})" data-item-id="${item.id}" ${attributes}>${action.label}</button>`;
                });
                return actionsHtml;
            } else {
                return ``;
            }
        }

        loading($status="show"){
            let el = $(this.tableBodySelector).closest('.card');
            if($status=="hide")
                el.find('.overlay').remove();
            else
                el.append(`<div class="overlay dark"><i class="fas fa-2x fa-sync-alt rotate"></i></div>`);
        }
    }




</script>

{{-- Color Picker , Select 2 , And Update Variants --}}

<script >
    $(document).ready(function(){


        $('.variant_id').select2({
            width: '100%',
            theme: 'bootstrap4',
            ajax: {
                url: "{{route('admin.variations.json')}}",
                type: "POST",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    console.log(params);
                    return {
                        q: params.term,
                        page: params.page || 1
                    };
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                processResults: function(data) {
                    return {
                        results: data.data.map(function(item) {
                            return {
                                id: item.id,
                                text: item.name,
                                customData: item.has_unit
                            };
                        }),
                        pagination: {
                            more: data.current_page < data.last_page
                        }
                    };
                },

                cache: true
            },

            placeholder : 'Select a variant',
            templateSelection: function (data, container) {
                // Add custom attributes to the <option> tag for the selected option
                $(data.element).attr('data-has-unit', data.customData?true:false);
                return data.text;
            },

        });
        $('.unit_id').select2({
            width: '100%',
            theme: 'bootstrap4',
            ajax: {
                url: "{{route('admin.product_units.json')}}",
                type: "POST",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    console.log(params);
                    return {
                        q: params.term,
                        page: params.page || 1
                    };
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                processResults: function(data) {
                    return {
                        results: data.data.map(function(unit) {
                            return {
                                id: unit.id,
                                text: unit.unit_name
                            };
                        }),
                        pagination: {
                            more: data.current_page < data.last_page
                        }
                    };
                },
                cache: true
            },
            placeholder : 'Select a unit',


        });
        $('.select2-single').select2({
            width: '100%',
            theme: 'bootstrap4',

            placeholder : $(this).data('placeholder'),


        });



        $('#product-to-variant-add-btn').on("click", function(ev) {

            if (!$("#product-to-variantions-modal form").valid()) {
                return ;
            }
            var variant_id = $('#product-to-variantions-modal #variant_id').val();
            var variant_value = $('#product-to-variantions-modal #variant_value').val();
            var unit_id = $('#product-to-variantions-modal #unit_id').val();

            var variant_name = $('#product-to-variantions-modal #variant_id').find(':selected').text();
            var unit_name = $('#product-to-variantions-modal #unit_id').find(':selected').text();

            $('#product-to-variantions-modal').modal('hide');
            // Push the new data to the array
            storedData.push({
                variation_id: variant_id,
                variant_value: variant_value,
                unit_id: unit_id,
                variant_name: variant_name,
                unit_name: unit_name
            });
            console.log(storedData);
            updateTableContent();


        });

        $('#product_variantions_input_table').on('click', '.delete', function(ev) {
            // Find the closest <tr> element and remove it

            $(this).closest('tr').remove();
            let indexToDelete = $(this).closest('tr').data('index');
            storedData.splice(indexToDelete, 1);

            updateTableContent();
            // If you want to update local storage after deletion, you can do that here
            // For example, updateLocalStorageData();
        });



        $('#variant_id').on('change', function(ev) {
            let value = $('#variant_id').find(':selected').text();
            var data = $('#variant_id').find(':selected').data('has-unit');

            if(data)
            $('#unit_id').closest('.form-group').show();
            else
            $('#unit_id').closest('.form-group').hide();

        });
        $('#update_variant_id').on('change', function(ev) {
            let value = $('#update_variant_id').find(':selected').text();
            var data = $('#update_variant_id').find(':selected').data('has-unit');

            if(data)
            $('#update_unit_id').closest('.form-group').show();
            else
            $('#update_unit_id').closest('.form-group').hide();

        });


    });

</script>


<script>
    function submitFormAjax(formId, successCallback, errorCallback) {
        var form = $(formId);
        var formData = form.serialize();
        var route = form.attr('data-action')
        
        window.toastr.clear();
        $.ajax({
            type: form.attr('data-method'),
            url: form.attr('data-action'),
            data: formData,
            headers: {
            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
            },
            success: function(data) {
                if (data.success && successCallback && typeof successCallback === 'function') {

                    successCallback(data);

                    toastr["success"](data.message);
                } else if (data.success==false && errorCallback && typeof errorCallback === 'function') {
                    errorCallback(data);
                    handleValidationErrors(data.errors);

                    toastr["error"](data.message);
                }

            },
            error: function(xhr, status) {
                errorCallback(xhr.responseJSON.errors);
                handleValidationErrors(xhr.responseJSON.errors);
                window.toastr.clear();
                toastr["error"](xhr.responseJSON.message);
            }
        });
    }

    function handleValidationErrors(errors) {
        $('.invalid-feedback').remove();
        $.each(errors, function (key, value) {
            $("#" + key).addClass('is-invalid');

            $("#" + key).parent("div").append(`<span class="invalid-feedback">${value[0]}</span>`);
        });
    }





</script>
