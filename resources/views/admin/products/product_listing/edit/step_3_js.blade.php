<script type="text/javascript">
    function loading(selector,$status="show"){
            let el = $(selector + " .modal-content");
            if($status=="hide")
                el.find('.overlay').remove();
            else
                el.append(`<div class="overlay dark"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>`);
    }

    function submitFormAjax(formId, successCallback, errorCallback) {
        var form = $('#' + formId);
        var formData = form.serialize();
        window.toastr.clear();
        $.ajax({
            type: form.attr('data-store-method'),
            url: form.attr('data-store-action'),
            data: formData,
            headers: {
            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
            },
            success: function(data) {
                if (data.success && successCallback && typeof successCallback === 'function') {
                    renderDataInTable("#stock-table-body");
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
    $(document).ready(function() {
        $("#submitBtn").click(function() {
            loading('#product-stock-modal','show');
            submitFormAjax("product-stock-form", function(data) {
                // Success callback function

                loading('#product-stock-modal','hide');
                $('#product-stock-modal').modal('hide');
                alert("Form submitted successfully!");

            }, function(data) {
                // Error callback function
                alert("Form submission failed!");

            });
        });
        renderDataInTable("#stock-table-body");
        $(document).on('click', '.default-sku-radio', function() {
            // Get the SKU and product ID from data attributes
            var sku = $(this).data('sku');
            var productId = $(this).data('product_id');
            setDefaultSKU(sku,productId);
        });

        $(document).on('click', '.edit', function(ev) {

            ev.preventDefault();
            var route = $(this).data('route');
            editStockModel(route);

        });

        $("#updateBtn").click(function() {
            loading('#product-stock-update-modal','show');
            submitFormAjax("product-stock-update-form", function(data) {
                // Success callback function
                loading('#product-stock-update-modal','hide');
                $('#product-stock-update-modal').modal('hide');
                alert("Form submitted successfully!");
            }, function(data) {
                // Error callback function
                alert("Form submission failed!");

            });
        });
        $('.modal').on('hidden.bs.modal', function () {
            $(this).find('form').trigger('reset');
            $(".select2-single").val("").trigger('change');
            clearDropZone(editDropzone);
            clearDropZone(myDropzone);

        });

    });



    function renderDataInTable(tbodySelector) {
        let route = $(tbodySelector).data('route');
        $.ajax({
            url: route,
            method: "GET",
            success: function(response) {
                // Clear existing data in the table body
                $(tbodySelector).empty();
                toastr["success"](response.message);
                // Render fetched data
                response.data.forEach(function(item,index) {
                    var row = '<tr>';
                    // Adjust this part according to your data structure
                    row += '<td>' + (index+1) + '</td>';
                    row += '<td>' + item.sku + '</td>';

                    variationkeys.forEach(function (variationKey) {
                        var combination = item.combinations.find(function(combination) {
                            return combination.variant_name === variationKey;
                        });
                        if (combination) {
                            row += `<td>${combination.variant_value} ${combination.unit_name ? combination.unit_name : ""}</td>`;
                        } else {
                            row += '<td></td>';
                        }
                    });

                    row += '<td>' + item.product_price.price + '</td>';

                    row += '<td>' + item.quantity + '</td>';
                    row += `<td>
                                <div class="form-check">
                                <div class="form-check-label d-inline border-primary" >
                                    <input type="radio" class="form-check-input default-sku-radio" name="is_default" ${item.is_default?"checked":""} data-sku="${item.sku}" data-product_id="${item.product_id}">
                                </div>
                                </div>
                            </td>`;
                    row += `<td>
                        <a  class="btn btn-info edit" data-route="{{route('admin.stock.ajax.edit')}}/${item.sku}" data-sku="${item.sku}">
                            <i class="fas fa-pencil-alt">
                            </i>
                            Edit
                        </a>
                        <a class="btn btn-danger" data-route="{{route('admin.stock.ajax.edit')}}/${item.sku}" onclick="return confirm('Are you sure?')">
                            <i class="fas fa-trash">
                            </i>
                            Delete
                        </a>
                    </td>`;
                    row += '</tr>';
                    $(tbodySelector).append(row);
                });
            },
            error: function(xhr, status, error) {
                var errorMessage = 'An error occurred. Please try again later.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                    console.log(xhr.responseJSON);
                }

                toastr["error"](response.errorMessage);
            }
        });
    }

    function setDefaultSKU(sku, productId) {
        window.toastr.clear();
        $.ajax({
            url: '{{ route("admin.stock.ajax.setDefault") }}',
            type: 'POST',
            headers: {
            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
            },
            data: {
                sku: sku,
                product_id: productId,
            },
            dataType: 'json',
            success: function(response) {
                toastr["success"](response.message);
                if (response.success) {
                    // Handle success response
                    console.log(response.message);
                } else {
                    // Handle error response
                    console.error('Failed to set default SKU');
                }
            },
            error: function(xhr, status, error) {
                // Handle AJAX error
                toastr["error"](xhr.responseJSON.message);
                console.error('AJAX Error:', xhr.responseJSON.message);
            }
        });
    }
    function editStockModel(route) {
        $("#product-stock-update-modal").modal('show');
        loading('#product-stock-update-modal','show');
        $.ajax({
            url: route,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // If the request is successful, populate the update modal with the retrieved stock data
                    populateUpdateModal(response.data);
                    // Open the update modal
                    $('#product-stock-update-modal').modal('show');

                    loading('#product-stock-update-modal','hide');
                } else {
                    // If the request fails, toastr the error message
                    toastr["error"](response.message);
                }
            },
            error: function(xhr, status, error) {
                toastr["error"](xhr.responseJSON.message);
            }
        });
    }
    // Function to populate data into update modal
    function populateUpdateModal(stock) {
        // Set product ID
        $('#product-stock-update-modal #update-product-id').val(stock.product_id);

        // Set combinations
        $.each(stock.combinations, function(key, value) {
            $('#update-combinations-'+value.variant_name).val(value.id).trigger('change');
        });

        // Set SKU
        $('#product-stock-update-modal #update-sku').val(stock.sku);

        // Set price
        $('#product-stock-update-modal #update-price').val(stock.product_price);

        // Set quantity
        $('#product-stock-update-modal #update-quantity').val(stock.quantity);

        if(stock.media)
        stock.media.forEach(function(image) {
            // Create a mock file object
            var mockFile =image;
            console.log("mockFile : ",mockFile);
            // Add the mock file to editDropzone
            editDropzone.displayExistingFile(mockFile,mockFile.thumb);


        });



    }

    function updateForm(params) {

    }
</script>
