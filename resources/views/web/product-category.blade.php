@extends('web.layout.app')
@section('content')
    <div class="ekcontent">
        <section class="ek-section">
            <div class="topSection_w_cat">
                <div class="productFilters">
                    <div class="filterCards ekom_card" id="productFilters">
                        <div class="categoryListAll fscborder">
                            <h4 class="m-0 fs-18 bold">Categories</h4>
                            <ul id="itemListCategory">

                            </ul>
                        </div>
                        <label class="checkbox-item">
                            <input type="checkbox" name="newArrivals" id="newArrivals" value="1"
                                onclick="filterWithCheckbox('newArrivals',this.checked)">
                            <span class="checkbox-text">
                                <i class="fas fa-info-circle me-2"></i>New Arrivals
                            </span>
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" id="productWithVideos" name="productWithVideos"
                                onclick="filterWithCheckbox('productWithVideos',this.checked)">
                            <span class="checkbox-text">
                                <i class="far fa-play-circle me-2"></i>Product with Videos
                            </span>
                        </label>
                        <div class="mt15">
                            <label>Product Near By</label>
                            <div class="inputwithOk">
                                <input type="text" class="form-control" placeholder="Enter Pin Code">
                                <button class="inputokbtn">Ok</button>
                            </div>
                        </div>
                        <div class="mt15">
                            <label>Minimum Stock</label>
                            <div class="inputwithOk">
                                <input type="text" class="form-control" placeholder="Eg. 100" id="minimumStk"
                                    name="minimumStk" value="">
                                <button class="inputokbtn" type="button" id="minimumStock">Ok</button>
                            </div>
                        </div>
                        <div class="mt15">
                            <label>Price (<i class="fas fa-rupee-sign fs-13"></i>)</label>
                            <div class="inputwithOk minmax">
                                <span class="sepminmax">-</span>
                                <input type="text" class="form-control" placeholder="Min" name="min" id="min"
                                    value="">
                                <input type="text" class="form-control" placeholder="Max" name="max" id="max"
                                    value="">
                                <button type="button" class="inputokbtn" id="priceRange">Ok</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="productListing">
                <div class="sub_banner" id="dynamicBanner">
            <!-- load dynamic banner here -->
          </div>
                    <div class="pt-1">
                        <ol class="ekbreadcrumb">
                            <li class="ekbreadcrumb-item"><a href="#">Products</a></li>
                            <li class="ekbreadcrumb-item active" aria-current="page"><span class="me-2">All
                                    Products</span>(<span id='totalProduct'></span> <span>Results</span>)</li>
                        </ol>
                        <div class="h_filterbox">
                            <div class="checkboxdiv">
                                <label class="checkbox-item checkico">
                                    <input type="checkbox" id="selectAllCheckbox">
                                    <span class="checkbox-text"><span class="_checkicon"></span> Select All</span>
                                </label>
                            </div>
                            <button type="button" class="btn filterbtn" onclick="addToInventory('Inventory')"><i
                                    class="fas fa-plus fs-12 me-2"></i>Add to
                                Inventory List</button>
                            <button type="button" class="btn filterbtn" onclick="addToInventory('Download')"><i
                                    class="fas fa-download fs-13 me-2"></i>Download</button>
                            <select class="filterSelect ms-auto">
                                <option value="">Sort By Most Relevent</option>
                            </select>
                        </div>
                    </div>
                    <div class="container-fluid pad_l_r">
                        <div class="row gx-3 allproductbox" id="allproductbox">


                        </div>
                    </div>
                </div>

            </div>

        </section>

    </div>
@endsection
<script type="text/javascript" src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
    // Initialize variables for sorting and filtering options
    let slug = "{{ $slug }}";
    let newArrived = ""; // Sort field for new arrivals (e.g., "true" or "false")
    let productWithVideos = ""; // Filter for products with videos (e.g., "true" or "false")
    let priceRange = ""; // Filter for price range (e.g., "min=10&max=100")
    let minimumStock = ""; // Filter for minimum stock (e.g., "minimumStock=10")
    let maximumStock = ""; // Filter for maximum stock (e.g., "maximumStock=100")
    let contianer = null;
    let page = 1;
    let html = '';

    document.addEventListener('DOMContentLoaded', function() {
        contianer = document.getElementById('allproductbox');
        fetchData();
    });

    $(document).ready(function() {
        $("#selectAllCheckbox").on('click', function() {
            if ($(this).is(':checked')) {
                $(".form-check-input").prop('checked', true);
            } else {
                $(".form-check-input").prop('checked', false);
            }
        });

        // Event handler for price range filter
        $(".inputokbtn").on('click', function() {
            let min = $("#min").val();
            let max = $("#max").val();
            let minimumStk = $("#minimumStk").val();
            page = 1;
            html = '';
            if (min != '' && max != '') {
                priceRange = `min=${min}&max=${max}`;
                fetchData();
            } else if (min == '' && max != '') {
                priceRange = `max=${max}`;
                fetchData();
            } else if (min != '' && max == '') {
                priceRange = `min=${min}`;
                fetchData();
            }else if (minimumStk == '') {
                minimumStock = '';
                fetchData();
            } else {
                minimumStock = `minimumStock=${minimumStk}`;
                fetchData();
            }

        });



        // Fetch categories and populate the menu
        $.ajax({
            url: '{{ route('categories.list') }}', // Endpoint for fetching categories
            type: 'GET', // HTTP method
            dataType: 'json', // Expected data type
            success: function(res) {
                // jQuery object for the category menu
                const $menu = $("#itemListCategory");
                const url = "{{ route('product.category', ['slug' => 'SLUG']) }}";

                if (res.data.statusCode == 200) {
                    const data = res.data.data;

                    // Clear existing content
                    $menu.empty();

                    // Populate menu with categories
                    $.each(data, function(index, category) {
                        const active = slug == category.parent_slug ? 'active' : '';
                        const mainCategoryHtml = `
                            <li class="nav-link ${active}">
                                <a href="${url.replace('SLUG', category.parent_slug)}">${category.parent_name}</a>
                            </li>`;
                        $menu.append(mainCategoryHtml);
                    });
                }
            },
            fail: function() {
                console.log("Error fetching categories");
            }
        });
    });

    
    // Function to fetch filtered data
    function fetchData() {
        // API URL for fetching products
        let apiUrl = `categories/${slug}?&page=${page}&`;

        // Append filters to the API URL
        if (newArrived) apiUrl += `new_arrived=${newArrived}&`;
        if (productWithVideos) apiUrl += `productWithVideos=${productWithVideos}&`;
        if (priceRange) apiUrl += `${priceRange}&`;
        if (minimumStock) apiUrl += `${minimumStock}&`;
        if (maximumStock) apiUrl += `${maximumStock}`;

        // Make API request and handle the response
        ApiRequest(apiUrl, 'GET')
            .then(response => {
                const data = response.data;
                if (data.statusCode == 200) {
                    const products = data.data.productVariations;
                    document.getElementById('totalProduct').innerHTML = products.meta.pagination.total; // Update total product count
                    // Clear previous content before appending new data
                    contianer.innerHTML = ''; // Clear the container

                    // Populate the product listing
                    products.data.forEach(product => {
                        var productId = product.id; // Assuming `product` is your JavaScript object with the `id` property
                        var url = '{{ route('product.details', ':id') }}';
                        var text = '';
                        if(product.is_login == true){
                            text = ` <div class="product_foot d-flex justify-content-between align-items-center">
                                                <button class="btn btnround cardaddinventry" onclick="addToInventory('Inventory', '${product.id}')">Add to Inventory
                                                    List</button>
                                                <button class="btn dow_inve" onclick="addToInventory('Download', '${product.id}')"><img src="{{asset('assets/images/icon/download.png')}}" alt="download-product"></button>
                                            </div>`;
                        }else {
                            text = ` <div class="product_foot d-flex justify-content-between align-items-center">
                                                <a href="${product.login_url}" class="btn btnround cardaddinventry" >Add to Inventory
                                                    List</a>
                                                <a href="${product.login_url}" class="btn dow_inve"><img src="{{asset('assets/images/icon/download.png')}}" alt="download-product"></a>
                                            </div>`;
                        }
                        url = url.replace(':id', productId);
                        html += ` <div class="col-sm-6 col-md-4 col-lg-3 mb16">
                                    <div class="ekom_card">
                                        <div class="product_card">
                                            <a href="${url}" class="text_u">
                                                <div class="product_image_wraper">
                                                    <div class="form-check onimg">
                                                        <input type="checkbox" id="${product.id}" class="form-check-input">
                                                        <label for="prod_1"></label>
                                                    </div>
                                                    <div class="product_image">
                                                        <img src="${product.images}" class="_pdimg"
                                                            tabindex="-1">
                                                    </div>
                                                    <div class="gray"></div>
                                                </div>
                                                <div class="product_dec">
                                                    <h3 class="product_title bold">${product.title}</h3>
                                                    <div class="d-flex justify-content-between stockdiv align-items-center">
                                                        <span><i class="fas fa-warehouse fs-12 opacity-75 me-1"></i>${product.stock} in
                                                            Stock +</span>
                                                        <span><i class="far fa-check-circle fs-13 me-1"></i>
                                                            ${product.availability_status}</span>
                                                    </div>
                                                    <h5 class="productPrice fs-16 bold">${product.price}</h5>
                                                </div>
                                            </a>
                                            ${text}
                                        </div>
                                    </div>
                                </div>`;
                    });

                    contianer.innerHTML = html; // Append the new HTML to the container

                    page++;
                }
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    }

   // Function to check if the user has scrolled to the bottom of the page
    function isScrolledToBottom() {
        return window.innerHeight + window.scrollY >= document.body.offsetHeight;
    }

    // Event listener for scroll events
    window.addEventListener('scroll', () => {
        // If the user has scrolled to the bottom, fetch more data
        if (isScrolledToBottom()) {
            fetchData();
        }
    });

    // Function to filter data based on checkbox input
    function filterWithCheckbox(name, value) {
        if (name == 'newArrivals') {
            newArrived = value ? true : '';
        } else if (name == 'productWithVideos') {
            productWithVideos = value ? true : '';
        }
        page = 1;
        html = '';
        fetchData();
    }
    // Function to filter data based on all data
    function viewAll() {
        slug = 'all';
        page = 1;
        html = '';
        fetchData();
    }
    // Function to add products to inventory or download them as a ZIP file
    function addToInventory(action, id = '') {
        // Object to store selected product variation IDs
        let product_id = {
            variation_id: [],
        };

        // Iterate over each checked checkbox to collect product variation IDs
        $(".form-check-input:checked").each(function() {
            product_id.variation_id.push($(this).attr('id'));
        });

        if(id){
            product_id.variation_id.push(id);
        }

        // If no products are selected, show a warning using Swal
        if (product_id.variation_id.length == 0) {
            Swal.fire({
                title: "No products selected!",
                text: "Please select at least one checkbox.",
                icon: "warning",
                didOpen: () => {
                    // Apply inline CSS to the title
                    const titleElement = Swal.getTitle();
                    titleElement.style.color = 'red';
                    titleElement.style.fontSize = '20px';

                    // Apply inline CSS to the confirm button
                    const confirmButton = Swal.getConfirmButton();
                    confirmButton.style.backgroundColor = '#feca40';
                    confirmButton.style.color = 'white';
                }
            });
            return; // Exit the function early if no products are selected
        }

        // If action is 'Inventory', send a POST request to add products to the inventory
        if (action == 'Inventory') {
            ApiRequest('store/product/inventory', 'POST', {
                    product_id
                })
                .then(response => {
                    // Handle success response
                    if (response.data.statusCode == 200) {
                        Swal.fire({
                            title: "Success!",
                            text: response.data.message,
                            icon: "success",
                            didOpen: () => {
                                const titleElement = Swal.getTitle();
                                titleElement.style.color = 'green';
                                titleElement.style.fontSize = '20px';

                                const confirmButton = Swal.getConfirmButton();
                                confirmButton.style.backgroundColor = '#feca40';
                                confirmButton.style.color = 'white';
                            }
                        });
                    }
                    // Handle error response with status code 201
                    else if (response.data.statusCode == 201) {
                        Swal.fire({
                            title: "Error!",
                            text: response.data.message,
                            icon: "error",
                            didOpen: () => {
                                const titleElement = Swal.getTitle();
                                titleElement.style.color = 'green';
                                titleElement.style.fontSize = '20px';

                                const confirmButton = Swal.getConfirmButton();
                                confirmButton.style.backgroundColor = '#feca40';
                                confirmButton.style.color = 'white';
                            }
                        });
                    }
                    // Handle other error responses
                    else {
                        Swal.fire({
                            title: "Error!",
                            text: response.data.message,
                            icon: "error",
                            didOpen: () => {
                                const titleElement = Swal.getTitle();
                                titleElement.style.color = 'red';
                                titleElement.style.fontSize = '20px';

                                const confirmButton = Swal.getConfirmButton();
                                confirmButton.style.backgroundColor = '#feca40';
                                confirmButton.style.color = 'white';
                            }
                        });
                    }
                });
        }
        // If action is 'Download', download the selected products as a ZIP file
        else if (action == 'Download') { // Corrected the syntax here
            fetch('{{ route('product.inventory.export') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(product_id)
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.blob(); // Convert response to a Blob
                })
                .then(blob => {
                    const url = window.URL.createObjectURL(blob); // Create a URL for the Blob
                    const a = document.createElement('a');
                    a.style.display = 'none';
                    a.href = url;
                    a.download = 'products_' + Date.now() + '.zip'; // Set download file name
                    document.body.appendChild(a);
                    a.click(); // Programmatically click the link to trigger download
                    window.URL.revokeObjectURL(url); // Revoke the URL after download
                })
                .catch(error => {
                    console.error('Error downloading products:', error); // Log any errors
                });
        }
    }

    // banner api call
$('document').ready(function() {
    ApiRequest(`get-banner?type=category&slug=${slug}`, 'GET')
            .then(res => {
                if (res.data.statusCode == 200) {
                    const imagePath = res.data.data;
                    var html = '';
                    if(res.data.data.length == 0){
                    }
                               
                    imagePath.forEach(element => {
                        console.log(element.image_path)
                        html += `
                          
                                 <img src="${element.image_path}" height="300"/>
                               
                            
                            `;
                    });
                    $('#dynamicBanner').html(html);
                } 
            })
            .catch(err => {
                console.log(err);
              
            });

});
</script>
