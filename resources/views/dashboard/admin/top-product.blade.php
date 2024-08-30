@extends('dashboard.layout.app')

@section('content')
    <div class="ek_dashboard">
        <div class="ek_content">
            <div class="card ekcard pa shadow-sm">
                <div class="cardhead">
                    <h3 class="cardtitle">Product by type</h3>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="ek_f_input">
                            <label for="category">Prodcut title</label>
                            <select class="form-select" class="state" id="product-title" multiple>
                                {{-- <option value="" selected>Select State</option> --}}
                            </select>
                            <div id="productTitleErr" class="invalid-feedback"></div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="ek_f_input">
                            <label for="category">Product type</label>
                            <select class="form-select" class="number" id="product-type"
                                aria-placeholder="Select Product Type">
                                <option value="" selected>Select Product Type</option>
                            </select>
                            <div id="productTypeErr" class="invalid-feedback"></div>
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
                            <th>Title</th>
                            <th>Product Type</th>
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
            ApiRequest('get-top-product', 'GET')
                .then((res) => {
                    if (res.data.statusCode == 200) {
                        let data = res.data.data;
                        let typePorduct = res.data.typeProduct;
                        let entries = Object.entries(typePorduct);
                        let options = data.map(item => {
                            return {
                                id: item.id,
                                text: item.title
                            };
                        });

                        // Initialize Select2 with options
                        $('#product-title').select2({
                            data: options,
                            placeholder: 'Select a product',
                            allowClear: true
                        });


                        let keyValue = entries.map(([key, value]) => {
                            return {
                                id: key,
                                text: value
                            };
                        });


                        // Initialize Select2 with options
                        $('#product-type').select2({
                            data: keyValue,
                            placeholder: 'Select a product type',
                            allowClear: true
                        });
                    }
                })
                .catch((err) => {
                    console.log(err);
                });



            $('#btnSubmit').on('click', function() {
                // Create a new FormData object to hold the form data
                var formData = new FormData();

                // Get the values from the input fields
                var product_title = $('#product-title').val();
                var product_type = $('#product-type').val();

                // Append the values to the FormData object
                formData.append('product_title', product_title);
                formData.append('product_type', product_type);

                // Validate the form fields
                if (product_title == '') {
                    // If product title is empty, add 'is-invalid' class to the input field and display an error message
                    $('#product-title').addClass('is-invalid');
                    $('#productTitleErr').text('Product Title is required.');
                } else if (product_type == '') {
                    // If product type is empty, add 'is-invalid' class to the input field and display an error message
                    $('#product-type').addClass('is-invalid');
                    $('#productTypeErr').text('Product Type is required.');
                } else {
                    // If validation passes, make an API request to store the product
                    ApiRequest('store-products', 'POST', formData)
                        .then((res) => {
                            if (res.data.statusCode == 200) {
                                // If the request is successful, show a success message and redirect to the inventory index page
                                Swal.fire({
                                    title: 'Success',
                                    icon: "success",
                                    text: res.data.message,
                                    didOpen: () => {
                                        // Apply inline CSS to the title, content, and confirm button of the SweetAlert
                                        const title = Swal.getTitle();
                                        title.style.fontSize = '25px';
                                        const content = Swal.getHtmlContainer();
                                        const confirmButton = Swal.getConfirmButton();
                                        confirmButton.style.backgroundColor = '#feca40';
                                        confirmButton.style.color = 'white';
                                    }
                                }).then(() => {
                                    // Redirect to the top-product page after the alert is closed
                                    window.location.href = '/top-product';
                                });
                            }
                        });
                }
            });

            ApiRequest('get-top-product-type', 'GET')
                .then((res) => {
                    // console.log(res);
                    if (res.data.statusCode == 200) {
                        let data = res.data.data;
                        if(data.length == 0){
                            $('tbody').append(`
                                <tr>
                                    <td colspan="3" class="text-center">No data found</td>
                                </tr>
                            `);
                        }
                        data.forEach((item) => {
                            // const productTitles = item.product.map(p => `<li><a href="${p.slug}" class="text_u">${p.title.trim()}</a></li><br>`).join('');
                            $('tbody').append(`
                                <tr>
                                    <td><div class="w_500_f wordbreak"><a href="${item.slug}" class="text_u" target="_blank">${item.title}</a></div></td>
                                    <td>${item.type}</td>
                                    <td>
                                        <button class="btn btn-sm btn-danger" onclick="deleteProduct('${item.id}')">Delete</button>
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
                function deleteProduct(id){
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
                                ApiRequest('delete-top-product', 'POST', formData)
                                    .then((res) => {
                                        if (res.data.statusCode == 200) {
                                            Swal.fire({
                                                title: "Deleted!",
                                                text: "Your file has been deleted.",
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
                                                window.location.href = '/top-product';
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
