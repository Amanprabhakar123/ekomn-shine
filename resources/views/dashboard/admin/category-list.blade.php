@extends('dashboard.layout.app')

@section('content')
    <div class="ek_dashboard">
        <div class="ek_content">
            <div class="card ekcard pa shadow-sm">
                <div class="cardhead">
                    <h3 class="cardtitle">Categories by listing</h3>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="ek_f_input">
                            <label for="category">Category</label>
                            <select class="form-select" id="category">
                                <option value="" selected>Select Category</option>
                            </select>
                            <div id="categoryErr" class="invalid-feedback"></div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="ek_f_input">
                            <label for="category">Priority</label>
                            <select class="form-select" id="number" value="">
                                <option value="" selected>Select Priority</option>
                            </select>
                            <div id="priorityErr" class="invalid-feedback"></div>
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="ek_f_input">
                            <label for="category">Product by</label>
                            <select class="form-select " id="productBy" multiple data-max-options="3" placeholder = "Select 3 products">
                            </select>
                            <div id="productByErr" class="invalid-feedback"></div>
                        </div>
                    </div>

                </div>

                <div class="saveform_footer text-right single-button">
                    <button type="button" id="btnSubmit" class="btn btn-login btnekomn card_f_btn"
                        id="generaltab">Submit</button>
                </div>

                <div class="table-responsive tres_border mt-5">

                <table class="normalTable tableSorting whitespace">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Priority</th>
                            <th>Product by</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!--  Data display here Dynamic -->
                    </tbody>
                </table>
            </div>
            </div>

        </div>
        @include('dashboard.layout.copyright')
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            ApiRequest('get-category', 'GET')
                .then((res) => {
                    if (res.data.statusCode == 200) {
                        let data = res.data.data;
                        let priority = res.data.priority;
                        let options = data.map(item => {
                            return {
                                id: item.id,
                                text: item.name
                            };
                        });

                        // Initialize Select2 with options
                        $('#category').select2({
                            data: options,
                            placeholder: 'Select a category',
                            allowClear: true
                        });

                        priority.forEach((item) => {
                            $('#number').append(`<option value="${item}">${item}</option>`);
                        });
                    }
                })
                .catch((err) => {
                    console.log(err);
                });



            /**
             * When the category select box value changes, fetch the products for the selected category
             * and populate the productBy select box with the fetched products
             */
            $('#category').on('change', function() {
                var formData = new FormData();

                formData.append('category', $('#category').val());

                ApiRequest('find-category', 'POST', formData)
                    .then((res) => {
                        if (res.data.statusCode == 200) {
                            let data = res.data.data;
                            let options = data.map(item => {
                                return {
                                    id: item.id,
                                    text: item.title
                                };
                            });

                            $('#productBy').empty();
                            // Initialize Select2 with options
                            $('#productBy').select2({
                                data: options,
                                placeholder: 'Select 3 products',
                                allowClear: true
                            });
                        }
                    })

            });
            var maxOptions = $('#productBy').data('max-options');

            /**
             * Check the number of selected options in the productBy select box
             * If the number of selected options is greater than the maxOptions, deselect the extra options
             */
            $("#productBy").on('change', function() {
                var selectedOptions = $(this).find('option:selected').length;
                if (selectedOptions > maxOptions) {
                    $(this).find('option:selected').each(function(index, option) {
                        if (index >= maxOptions) {
                            $(option).prop('selected', false);
                        }
                    });
                    Swal.fire({
                        title: 'Error',
                        text: "You can only select " + maxOptions + " options",
                        icon: 'error',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                        didOpen: () => {
                            const title = Swal.getTitle();
                            title.style.fontSize = '25px';
                            // Apply inline CSS to the content
                            const content = Swal.getHtmlContainer();
                            // Apply inline CSS to the confirm button
                            const confirmButton = Swal.getConfirmButton();
                            confirmButton.style.backgroundColor = '#feca40';
                            confirmButton.style.color = 'white';
                        }
                    });
                }
            });

            /**
             * When the submit button is clicked, validate the form fields
             * If the form fields are valid, make an API request to store the categories
             */
            $('#btnSubmit').on('click', function() {
                var formData = new FormData();
                var number = $('#number').val();
                var category = $('#category').val();
                var productBy = $('#productBy').val();

                if (category == '') {
                    $('#category').addClass('is-invalid');
                    $('#categoryErr').text('Category are required.');
                } else if (number == '') {
                    $('#number').addClass('is-invalid');
                    $('#priorityErr').text('Priority are required.');
                } else if (productBy == '') {
                    $('#productBy').addClass('is-invalid');
                    $('#productByErr').text('Product are required.');
                } else {
                    formData.append('number', number);
                    formData.append('category', category);
                    formData.append('productBy', productBy);
                    ApiRequest('store-categories', 'POST', formData)
                        .then((res) => {
                            if (res.data.statusCode == 200) {
                                // Redirect to the inventory index page
                                Swal.fire({
                                    title: 'Success',
                                    icon: "success",
                                    text: res.data.message,
                                    didOpen: () => {
                                        const title = Swal.getTitle();
                                        title.style.fontSize = '25px';
                                        // Apply inline CSS to the content
                                        const content = Swal.getHtmlContainer();
                                        // Apply inline CSS to the confirm button
                                        const confirmButton = Swal.getConfirmButton();
                                        confirmButton.style.backgroundColor = '#feca40';
                                        confirmButton.style.color = 'white';
                                    }
                                }).then(() => {
                                    window.location.href = '/category-list';
                                });
                            }else{
                                Swal.fire({
                                    title: 'Error',
                                    icon: "error",
                                    text: res.data.message,
                                    didOpen: () => {
                                        const title = Swal.getTitle();
                                        title.style.fontSize = '25px';
                                        // Apply inline CSS to the content
                                        const content = Swal.getHtmlContainer();
                                        // Apply inline CSS to the confirm button
                                        const confirmButton = Swal.getConfirmButton();
                                        confirmButton.style.backgroundColor = '#feca40';
                                        confirmButton.style.color = 'white';
                                    }
                                });
                            }
                        }).catch(error => {
                            console.error(error);
                        });
                }
            });

            ApiRequest('get-top-category-product', 'GET')
                .then((res) => {
                    // console.log(res);
                    if (res.data.statusCode == 200) {
                        let data = res.data.data;
                        if(data.length == 0){
                            $('tbody').append(`
                                <tr>
                                    <td colspan="4" class="text-center">No data found</td>
                                </tr>
                            `);
                        }
                        data.forEach((item) => {
                            const productTitles = item.product.map(p => `<li><a href="${p.slug}" class="text_u" target="_blank">${p.title.trim()}</a></li><br>`).join('');
                            $('tbody').append(`
                                <tr>
                                    <td>${item.category}</td>
                                    <td>${item.priority}</td>
                                    <td><div class="w_500_f wordbreak">${productTitles}</div></td>
                                    <td>
                                        <button class="btn btn-sm btn-danger" onclick="deleteCategory('${item.topCategoryId}')">Delete</button>
                                    </td>
                                </tr>
                            `);
                        });
                    }
                })
                .catch((err) => {
                    console.log(err);
                });
        });

         /**
         * When the delete link is clicked, show a confirmation dialog
         * If the user confirms the deletion, make an API request to delete the item
         */
        function deleteCategory(id) {
            var formData = new FormData();
                    formData.append('id', id);
                   // First, show the confirmation dialog
                    Swal.fire({
                        title: "Do you want to delete?",
                        text: "You won't be able to revert this!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, delete it!",
                        customClass: {
                            confirmButton: 'swal2-confirm-btn',
                            cancelButton: 'swal2-cancel-btn'
                        },
                        didOpen: () => {
                            const title = Swal.getTitle();
                            title.style.fontSize = '25px';
                            const confirmButton = Swal.getConfirmButton();
                            confirmButton.style.backgroundColor = '#feca40';
                            confirmButton.style.color = 'white';
                        }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Send the delete request only after confirmation
                                ApiRequest('delete-top-category', 'POST', formData)
                                    .then((res) => {
                                        if (res.data.statusCode == 200) {
                                            Swal.fire({
                                                title: "Deleted!",
                                                text: "Your banner has been deleted.",
                                                icon: "success",
                                                didOpen: () => {
                                                    const title = Swal.getTitle();
                                                    title.style.fontSize = '25px';
                                                    // Apply inline CSS to the content
                                                    const content = Swal.getHtmlContainer();
                                                    // Apply inline CSS to the confirm button
                                                    const confirmButton = Swal.getConfirmButton();
                                                    confirmButton.style.backgroundColor = '#feca40';
                                                    confirmButton.style.color = 'white';
                                                }
                                            }).then(() => {
                                                window.location.href = '/category-list';
                                            });
                                        }
                                    })
                                    .catch(error => {
                                        console.error(error);
                                        Swal.fire({
                                            title: "Error!",
                                            text: "There was an error deleting the item.",
                                            icon: "error"
                                        });
                                    });
                            }
                        });

                    
        }
    </script>
@endsection
