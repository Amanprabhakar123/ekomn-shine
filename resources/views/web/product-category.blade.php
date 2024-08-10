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
                    <div class="pt-1">
                        <ol class="ekbreadcrumb">
                            <li class="ekbreadcrumb-item"><a href="#">Products</a></li>
                            <li class="ekbreadcrumb-item active" aria-current="page"><span class="me-2">All
                                    Products</span>(3,711 <span>Results</span>)</li>
                        </ol>
                        <div class="h_filterbox">
                            <div class="checkboxdiv">
                                <label class="checkbox-item checkico">
                                    <input type="checkbox" id="selectAllCheckbox">
                                    <span class="checkbox-text"><span class="_checkicon"></span> Select All</span>
                                </label>
                            </div>
                            <button type="button" class="btn filterbtn"><i class="fas fa-plus fs-12 me-2"></i>Add to
                                Inventory List</button>
                            <button type="button" class="btn filterbtn"><i
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
<script type="text/javascript" src="{{ asset('assets/js/request.js') }}"></script>

<script>
    // Initialize variables for sorting and filtering options
    const slug = "{{ $slug }}";
    let newArrived = ""; // Sort field for new arrivals (e.g., "true" or "false")
    let productWithVideos = ""; // Filter for products with videos (e.g., "true" or "false")
    let priceRange = ""; // Filter for price range (e.g., "min=10&max=100")
    let minimumStock = ""; // Filter for minimum stock (e.g., "minimumStock=10")
    let maximumStock = ""; // Filter for maximum stock (e.g., "maximumStock=100")

    $(document).ready(function() {
        // Initial data fetch
        fetchData();

        // Event handler for price range filter
        $("#priceRange").click(function() {
            let min = $("#min").val();
            let max = $("#max").val();
            priceRange = `min=${min}&max=${max}`;
            fetchData();
        });

        // Event handler for minimum stock filter
        $("#minimumStock").click(function() {
            let minimumStk = $("#minimumStk").val();
            minimumStock = `minimumStock=${minimumStk}`;
            fetchData();
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
        let apiUrl = `categories/${slug}?`;

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
                var container = $("#allproductbox");
                container.empty()
                if (data.statusCode == 200) {
                    const products = data.data.productVariations;
                    let html = '';
                    // console.log(products.data);

                    // Populate the product listing
                    products.data.forEach(product => {
                        var productId = product
                            .id; // Assuming `product` is your JavaScript object with the `id` property
                        var url = '{{ route('product.details', ':id') }}';
                        url = url.replace(':id', productId);
                        html += ` <div class="col-sm-6 col-md-4 col-lg-3 mb16">
                                <div class="ekom_card">
                                    <div class="product_card">
                                        <a href="${url}" class="text_u">
                                            <div class="product_image_wraper">
                                                <div class="form-check onimg">
                                                    <input type="checkbox" id="prod_1" class="form-check-input">
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
                                                <h5 class="productPrice fs-16 bold"><i
                                                        class="fas fa-rupee-sign me-1"></i>${product.price}</h5>
                                            </div>
                                        </a>
                                        <div class="product_foot d-flex justify-content-between align-items-center">
                                            <a href="" class="btn btnround cardaddinventry">Add to Inventory
                                                List</a>
                                            <button class="btn dow_inve"><img src="../assets/images/icon/download.png"
                                                    alt=""></button>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                    });
                    console.log(html);
                    container.append(html);
                }

            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    }

    // Function to filter data based on checkbox input
    function filterWithCheckbox(name, value) {
        if (name == 'newArrivals') {
            newArrived = value ? true : '';
        } else if (name == 'productWithVideos') {
            productWithVideos = value ? true : '';
        }
        fetchData();
    }
</script>
