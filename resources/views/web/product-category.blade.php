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
                        <div class="row gx-3 allproductbox">
                            <div class="col-sm-6 col-md-4 col-lg-3 mb16">
                                <div class="ekom_card">
                                    <div class="product_card">
                                        <a href="product-details.html" class="text_u">
                                            <div class="product_image_wraper">
                                                <div class="form-check onimg">
                                                    <input type="checkbox" id="prod_1" class="form-check-input">
                                                    <label for="prod_1"></label>
                                                </div>
                                                <div class="product_image">
                                                    <img src="../assets/images/product/outdoor_2.webp" class="_pdimg"
                                                        tabindex="-1">
                                                </div>
                                                <div class="gray"></div>
                                            </div>
                                            <div class="product_dec">
                                                <h3 class="product_title bold">Back pull point flannelette blue indoor
                                                    leisure chair simple Nordic style</h3>
                                                <div class="d-flex justify-content-between stockdiv align-items-center">
                                                    <span><i class="fas fa-warehouse fs-12 opacity-75 me-1"></i>5,000+ in
                                                        Stock</span>
                                                    <span><i class="far fa-check-circle fs-13 me-1"></i>Regular
                                                        Available</span>
                                                </div>
                                                <h5 class="productPrice fs-16 bold"><i
                                                        class="fas fa-rupee-sign me-1"></i>2999.00</h5>
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
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-3 mb16">
                                <div class="ekom_card">
                                    <div class="product_card">
                                        <a href="product-details.html" class="text_u">
                                            <div class="product_image_wraper">
                                                <div class="form-check onimg">
                                                    <input type="checkbox" id="prod_2" class="form-check-input">
                                                    <label for="prod_2"></label>
                                                </div>
                                                <div class="product_image">
                                                    <img src="../assets/images/product/outdoor_3.webp" class="_pdimg"
                                                        tabindex="-1">
                                                </div>
                                                <div class="gray"></div>
                                            </div>
                                            <div class="product_dec">
                                                <h3 class="product_title bold">Back pull point flannelette blue indoor
                                                    leisure chair simple Nordic style</h3>
                                                <div class="d-flex justify-content-between stockdiv align-items-center">
                                                    <span><i class="fas fa-warehouse fs-12 opacity-75 me-1"></i>5,000+ in
                                                        Stock</span>
                                                    <span><i class="far fa-check-circle fs-13 me-1"></i>Till Stock
                                                        Last</span>
                                                </div>
                                                <h5 class="productPrice fs-16 bold"><i
                                                        class="fas fa-rupee-sign me-1"></i>2999.00</h5>
                                            </div>
                                        </a>
                                        <div class="product_foot d-flex justify-content-between align-items-center">
                                            <button class="btn btnround cardaddinventry">Add to Inventory List</button>
                                            <button class="btn dow_inve"><img src="../assets/images/icon/download.png"
                                                    alt=""></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-3 mb16">
                                <div class="ekom_card">
                                    <div class="product_card">
                                        <a href="product-details.html" class="text_u">
                                            <div class="product_image_wraper">
                                                <div class="form-check onimg">
                                                    <input type="checkbox" id="prod_3" class="form-check-input">
                                                    <label for="prod_3"></label>
                                                </div>
                                                <div class="product_image">
                                                    <img src="../assets/images/product/outdoor_1.webp" class="_pdimg"
                                                        tabindex="-1">
                                                </div>
                                                <div class="gray"></div>
                                            </div>
                                            <div class="product_dec">
                                                <h3 class="product_title bold">Back pull point flannelette blue indoor
                                                    leisure chair simple Nordic style</h3>
                                                <div class="d-flex justify-content-between stockdiv align-items-center">
                                                    <span><i class="fas fa-warehouse fs-12 opacity-75 me-1"></i>...in
                                                        Stock</span>
                                                    <span><i class="far fa-check-circle fs-13 me-1"></i>Availability</span>
                                                </div>
                                                <h5 class="productPrice fs-15 bold"><a href=""
                                                        style="color:inherit">Login to See Price</a></h5>
                                            </div>
                                        </a>
                                        <div class="product_foot d-flex justify-content-between align-items-center">
                                            <button class="btn btnround cardaddinventry">Add to Inventory List</button>
                                            <button class="btn dow_inve"><img src="../assets/images/icon/download.png"
                                                    alt=""></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-3 mb16">
                                <div class="ekom_card">
                                    <div class="product_card">
                                        <a href="product-details.html" class="text_u">
                                            <div class="product_image_wraper">
                                                <div class="form-check onimg">
                                                    <input type="checkbox" id="prod_4" class="form-check-input">
                                                    <label for="prod_4"></label>
                                                </div>
                                                <div class="product_image">
                                                    <img src="../assets/images/product/premium_3.webp" class="_pdimg"
                                                        tabindex="-1">
                                                </div>
                                                <div class="gray"></div>
                                            </div>
                                            <div class="product_dec">
                                                <h3 class="product_title bold">Back pull point flannelette blue indoor
                                                    leisure chair simple Nordic style</h3>
                                                <div class="d-flex justify-content-between stockdiv align-items-center">
                                                    <span><i class="fas fa-warehouse fs-12 opacity-75 me-1"></i>...in
                                                        Stock</span>
                                                    <span><i class="far fa-check-circle fs-13 me-1"></i>Availability</span>
                                                </div>
                                                <h5 class="productPrice fs-15 bold"><a href=""
                                                        style="color:inherit">Login to See Price</a></h5>
                                            </div>
                                        </a>
                                        <div class="product_foot d-flex justify-content-between align-items-center">
                                            <button class="btn btnround cardaddinventry">Add to Inventory List</button>
                                            <button class="btn dow_inve"><img src="../assets/images/icon/download.png"
                                                    alt=""></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-3 mb16">
                                <div class="ekom_card">
                                    <div class="product_card">
                                        <a href="product-details.html" class="text_u">
                                            <div class="product_image_wraper">
                                                <div class="form-check onimg">
                                                    <input type="checkbox" id="prod_5" class="form-check-input">
                                                    <label for="prod_5"></label>
                                                </div>
                                                <div class="product_image">
                                                    <img src="../assets/images/product/outdoor_2.webp" class="_pdimg"
                                                        tabindex="-1">
                                                </div>
                                                <div class="gray"></div>
                                            </div>
                                            <div class="product_dec">
                                                <h3 class="product_title bold">Back pull point flannelette blue indoor
                                                    leisure chair simple Nordic style</h3>
                                                <div class="d-flex justify-content-between stockdiv align-items-center">
                                                    <span><i class="fas fa-warehouse fs-12 opacity-75 me-1"></i>5,000+ in
                                                        Stock</span>
                                                    <span><i class="far fa-check-circle fs-13 me-1"></i>Regular
                                                        Available</span>
                                                </div>
                                                <h5 class="productPrice fs-16 bold"><i
                                                        class="fas fa-rupee-sign me-1"></i>2999.00</h5>
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
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-3 mb16">
                                <div class="ekom_card">
                                    <div class="product_card">
                                        <a href="product-details.html" class="text_u">
                                            <div class="product_image_wraper">
                                                <div class="form-check onimg">
                                                    <input type="checkbox" id="prod_6" class="form-check-input">
                                                    <label for="prod_6"></label>
                                                </div>
                                                <div class="product_image">
                                                    <img src="../assets/images/product/outdoor_3.webp" class="_pdimg"
                                                        tabindex="-1">
                                                </div>
                                                <div class="gray"></div>
                                            </div>
                                            <div class="product_dec">
                                                <h3 class="product_title bold">Back pull point flannelette blue indoor
                                                    leisure chair simple Nordic style</h3>
                                                <div class="d-flex justify-content-between stockdiv align-items-center">
                                                    <span><i class="fas fa-warehouse fs-12 opacity-75 me-1"></i>5,000+ in
                                                        Stock</span>
                                                    <span><i class="far fa-check-circle fs-13 me-1"></i>Till Stock
                                                        Last</span>
                                                </div>
                                                <h5 class="productPrice fs-16 bold"><i
                                                        class="fas fa-rupee-sign me-1"></i>2999.00</h5>
                                            </div>
                                        </a>
                                        <div class="product_foot d-flex justify-content-between align-items-center">
                                            <button class="btn btnround cardaddinventry">Add to Inventory List</button>
                                            <button class="btn dow_inve"><img src="../assets/images/icon/download.png"
                                                    alt=""></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-3 mb16">
                                <div class="ekom_card">
                                    <div class="product_card">
                                        <a href="product-details.html" class="text_u">
                                            <div class="product_image_wraper">
                                                <div class="form-check onimg">
                                                    <input type="checkbox" id="prod_7" class="form-check-input">
                                                    <label for="prod_7"></label>
                                                </div>
                                                <div class="product_image">
                                                    <img src="../assets/images/product/outdoor_1.webp" class="_pdimg"
                                                        tabindex="-1">
                                                </div>
                                                <div class="gray"></div>
                                            </div>
                                            <div class="product_dec">
                                                <h3 class="product_title bold">Back pull point flannelette blue indoor
                                                    leisure chair simple Nordic style</h3>
                                                <div class="d-flex justify-content-between stockdiv align-items-center">
                                                    <span><i class="fas fa-warehouse fs-12 opacity-75 me-1"></i>...in
                                                        Stock</span>
                                                    <span><i class="far fa-check-circle fs-13 me-1"></i>Availability</span>
                                                </div>
                                                <h5 class="productPrice fs-15 bold"><a href=""
                                                        style="color:inherit">Login to See Price</a></h5>
                                            </div>
                                        </a>
                                        <div class="product_foot d-flex justify-content-between align-items-center">
                                            <button class="btn btnround cardaddinventry">Add to Inventory List</button>
                                            <button class="btn dow_inve"><img src="../assets/images/icon/download.png"
                                                    alt=""></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-3 mb16">
                                <div class="ekom_card">
                                    <div class="product_card">
                                        <a href="product-details.html" class="text_u">
                                            <div class="product_image_wraper">
                                                <div class="form-check onimg">
                                                    <input type="checkbox" id="prod_8" class="form-check-input">
                                                    <label for="prod_8"></label>
                                                </div>
                                                <div class="product_image">
                                                    <img src="../assets/images/product/premium_3.webp" class="_pdimg"
                                                        tabindex="-1">
                                                </div>
                                                <div class="gray"></div>
                                            </div>
                                            <div class="product_dec">
                                                <h3 class="product_title bold">Back pull point flannelette blue indoor
                                                    leisure chair simple Nordic style</h3>
                                                <div class="d-flex justify-content-between stockdiv align-items-center">
                                                    <span><i class="fas fa-warehouse fs-12 opacity-75 me-1"></i>...in
                                                        Stock</span>
                                                    <span><i class="far fa-check-circle fs-13 me-1"></i>Availability</span>
                                                </div>
                                                <h5 class="productPrice fs-15 bold"><a href=""
                                                        style="color:inherit">Login to See Price</a></h5>
                                            </div>
                                        </a>
                                        <div class="product_foot d-flex justify-content-between align-items-center">
                                            <button class="btn btnround cardaddinventry">Add to Inventory List</button>
                                            <button class="btn dow_inve"><img src="../assets/images/icon/download.png"
                                                    alt=""></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
    const slug = "{{ $slug }}";




    let new_arrived = ""; // Set the sort field here (e.g. "sku", "stock", "selling_price")
    let productWithVideos = ""; // Set the sort order here (e.g. "asc", "desc")
    let priceRange = ""; // Set the sort order here (e.g. "asc", "desc")
    let minimunStock = ""; // Set the sort order here (e.g. "asc", "desc")
    let maximumStock = ""; // Set the sort order here (e.g. "asc", "desc")

    // Initial fetch of data


    $(document).ready(function() {
        fetchData();
        $("#priceRange").click(function() {
            let min = $("#min").val();
            let max = $("#max").val();
            priceRange = `min=${min}&max=${max}`;
            fetchData();
        });
        $("#minimumStock").click(function() {
            let minimumStk = $("#minimumStk").val();
            minimunStock = `min=${minimumStk}`;
            fetchData();
        });
        // Perform an AJAX GET request to fetch category data
        $.ajax({
                url: '{{ route('categories.list') }}', // URL endpoint for fetching categories
                type: 'GET', // HTTP method for the request
                dataType: 'json', // Expected data type of the response
                success: function(res) {
                    // jQuery object for the primary category menu
                    $menu = $("#itemListCategory");
                    // Clear any existing content in the menu
                    $menu.empty();
                    var url = "{{ route('product.category', ['slug' => 'SLUG']) }}";
                    // Check if the response status code is 200 (OK)
                    if (res.data.statusCode == 200) {
                        // Extract the category data from the response
                        let data = res.data.data;

                        // Clear existing content (redundant with the above empty())
                        $menu.empty();

                        // Iterate through each main category in the data
                        $.each(data, function(index, category) {
                            var active = slug == category.parent_slug ? 'active' :
                                '';
                            // HTML structure for the main category
                            var mainCategoryHtml = '<li class="nav-link ' + active +
                                '">';
                            mainCategoryHtml += '<a href="' + url.replace('SLUG',
                                    category
                                    .parent_slug) + '">' + category.parent_name +
                                '</a>';
                            // Close the sub-list and main category HTML structure
                            mainCategoryHtml += '</li>';
                            // Append the constructed HTML to the menu
                            $menu.append(mainCategoryHtml);
                        });
                    }
                }
            })

            .fail(function() {
                // Log error message to console if AJAX request fails
                console.log("error");
            });

    });
    // Function to fetch data from the server
    function fetchData() {

        // Make an API request to fetch inventory data
        let apiUrl = `categories/${slug}?`;
        if (new_arrived) {
            apiUrl += `new_arrived=${new_arrived}&`;
        }

        if (productWithVideos) {
            apiUrl += `productWithVideos=${productWithVideos}`;
        }
        if (priceRange) {
            apiUrl += `&${priceRange}`;
        }
        if (minimunStock) {
            apiUrl += `&${minimunStock}`;
        }

        ApiRequest(apiUrl, 'GET')
            .then(response => {
                const data = (response.data);
                console.log(data, 'khalid');
                if (data.length === 0) {
                    // dataContainer.innerHTML =
                    //     `<tr><td colspan="10" class="text-center">No data found</td></tr>`;
                } else {
                    // response = (response.meta.pagination);
                    // totalRows = response.total;
                    // updatePagination();
                    // displayData(data);
                }
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    }

    function filterWithCheckbox(name, value) {
        console.log(name, value);
        if (name == 'newArrivals') {
            if (value == true) {
                new_arrived = true;
                fetchData();
            } else {
                new_arrived = '';
                fetchData();

            }
        } else if (name == 'productWithVideos') {
            if (value == true) {
                productWithVideos = true;
                fetchData();
            } else {
                productWithVideos = '';
                fetchData();

            }
        }
    }
</script>
