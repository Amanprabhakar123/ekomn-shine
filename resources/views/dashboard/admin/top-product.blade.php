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
                                aria-placeholder="Select PRoduct Type">
                                <option value="" selected>Select State</option>
                            </select>
                            <div id="productTypeErr" class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>

                <div class="saveform_footer text-right single-button">
                    <button type="button" id="btnSubmit" class="btn btn-login btnekomn card_f_btn"
                        id="generaltab">Submit</button>
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
                            placeholder: 'Select a category',
                            allowClear: true
                        });


                        let keyValue = entries.map(([key, value]) => {
                            console.log(key, value);
                            return {
                                id: key,
                                text: value
                            };
                        });


                        // Initialize Select2 with options
                        $('#product-type').select2({
                            data: keyValue,
                            placeholder: 'Select a category',
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


        });
    </script>
@endsection
