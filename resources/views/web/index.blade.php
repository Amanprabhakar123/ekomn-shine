@extends('web.layout.app')
@section('content')
    <div class="ekcontent">
        <section class="ek-section">
            <div class="topSection_w_cat">
                <!-- category here  -->
                @include('web.layout.main-category')
                <div class="promotional_banner">
                    <div class="carousel slide carousel-fade" data-bs-ride="carousel">
                        <div class="carousel-inner" id="banner">
                         <!-- dynamic code here -->
                        </div>
                    </div>
                </div>
                <div class="introduction_sec ekom_card">
                    <div class="introbg"></div>
                    <div class="introText">
                        <ul class="checkpoint">
                            <li>Get access to verified winning Products</li>
                            <li>Sell on Multi-channels profitably</li>
                            <li>Learn the art of profitable Dropshipping</li>
                            <li>Learn the art of profitable Dropshipping</li>
                        </ul>
                        <div class="introbtnbox">
                            <button class="btn btnekomn btnround px-5">Join Our Webinar</button>
                        </div>
                        <p class="mb15">
                            eKomn provides all tools and resources for a successful Online business.
                        </p>
                        <div>To know more,<a href="" class="a_color mx-1 text_u">contact us</a>today!!</div>
                    </div>
                </div>
            </div>
        </section>
        <section class="ek-section">
            <div class="container-fluid pad_l_r">
                <div class="row gx-3">
                    <div class="col-sm-12 col-md-6 mb16">
                        <div class="ekom_card">
                            <div class="ekom_card_head">
                                <h2>Premium Products</h2>
                                <a href="product_category.html" class="a_color">View All</a>
                            </div>
                            <div class="ekom_card_body prod_3">
                                <div class="row gx-3" id="premium">
                                   <!-- appned this code premium code dynamic -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 mb16">
                        <div class="ekom_card">
                            <div class="ekom_card_head">
                                <h2>New Arrivals</h2>
                                <a href="product_category.html" class="a_color">View All</a>
                            </div>
                            <div class="ekom_card_body prod_3">
                                <div class="row gx-3" id="new_arrivals">
                                   <!-- dynamic code here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="ek-section featured_bg section_gap">
            <h2 class="sec_main_h">Featured Categories</h2>
            <div class="container-fluid pad_l_r">
                <div class="row gx-3" id="category">
                    <!-- dynamic code here -->
                </div>
            </div>
        </section>
        <section class="ek-section">
            <div class="container-fluid pad_l_r">
                <div class="row gx-3">
                    <div class="col-sm-12 col-md-6 mb16">
                        <div class="ekom_card">
                            <div class="ekom_card_head">
                                <h2>In Demand</h2>
                                <a href="product_category.html" class="a_color">View All</a>
                            </div>
                            <div class="ekom_card_body prod_3">
                                <div class="row gx-3" id="in_demand">
                                    <!-- dynamic code here -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 mb16">
                        <div class="ekom_card">
                            <div class="ekom_card_head">
                                <h2>Regular available</h2>
                                <a href="product_category.html" class="a_color">View All</a>
                            </div>
                            <div class="ekom_card_body prod_3">
                                <div class="row gx-3" id="regular">
                                    <!-- add dynamic data  -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="ek-section section_gap">
            <h2 class="sec_main_h mb15">Just for You</h2>
            <div class="container-fluid pad_l_r">
                <div class="row gx-3">
                    <div class="col-sm-6 col-md-4 col-lg-2 mb16">
                        <div class="ekom_card">
                            <a href="product-details.html" class="product_card text_u">
                                <div class="product_image_wraper">
                                    <div class="product_image">
                                        <img src="../assets/images/product/outdoor_1.webp" class="_pdimg" tabindex="-1">
                                    </div>
                                    <div class="gray"></div>
                                </div>
                                <div class="product_dec">
                                    <h3 class="product_title bold">Back pull point flannelette blue indoor leisure chair
                                        simple Nordic style</h3>
                                    <h5 class="productPrice"><i class="fas fa-rupee-sign fs-12 me-1"></i>1000</h5>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-2 mb16">
                        <div class="ekom_card">
                            <a href="product-details.html" class="product_card text_u">
                                <div class="product_image_wraper">
                                    <div class="product_image">
                                        <img src="../assets/images/product/premium_3.webp" class="_pdimg" tabindex="-1">
                                    </div>
                                    <div class="gray"></div>
                                </div>
                                <div class="product_dec">
                                    <h3 class="product_title bold ">Back pull point flannelette blue indoor leisure chair
                                        simple Nordic style</h3>
                                    <h5 class="productPrice"><i class="fas fa-rupee-sign fs-12 me-1"></i>1000</h5>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-2 mb16">
                        <div class="ekom_card">
                            <a href="product-details.html" class="product_card text_u">
                                <div class="product_image_wraper">
                                    <div class="product_image">
                                        <img src="../assets/images/product/product_2.jpg" class="_pdimg" tabindex="-1">
                                    </div>
                                    <div class="gray"></div>
                                </div>
                                <div class="product_dec">
                                    <h3 class="product_title bold ">Back pull point flannelette blue indoor leisure chair
                                        simple Nordic style</h3>
                                    <h5 class="productPrice"><i class="fas fa-rupee-sign fs-12 me-1"></i>1000</h5>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-2 mb16">
                        <div class="ekom_card">
                            <a href="product-details.html" class="product_card text_u">
                                <div class="product_image_wraper">
                                    <div class="product_image">
                                        <img src="../assets/images/product/arrival_3.webp" class="_pdimg" tabindex="-1">
                                    </div>
                                    <div class="gray"></div>
                                </div>
                                <div class="product_dec">
                                    <h3 class="product_title bold ">Back pull point flannelette blue indoor leisure chair
                                        simple Nordic style</h3>
                                    <h5 class="productPrice"><i class="fas fa-rupee-sign fs-12 me-1"></i>1000</h5>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-2 mb16">
                        <div class="ekom_card">
                            <a href="product-details.html" class="product_card text_u">
                                <div class="product_image_wraper">
                                    <div class="product_image">
                                        <img src="../assets/images/product/arrival_1.webp" class="_pdimg" tabindex="-1">
                                    </div>
                                    <div class="gray"></div>
                                </div>
                                <div class="product_dec">
                                    <h3 class="product_title bold ">Back pull point flannelette blue indoor leisure chair
                                        simple Nordic style</h3>
                                    <h5 class="productPrice"><i class="fas fa-rupee-sign fs-12 me-1"></i>1000</h5>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-2 mb16">
                        <div class="ekom_card">
                            <a href="product-details.html" class="product_card text_u">
                                <div class="product_image_wraper">
                                    <div class="product_image">
                                        <img src="../assets/images/product/outdoor_3.webp" class="_pdimg" tabindex="-1">
                                    </div>
                                    <div class="gray"></div>
                                </div>
                                <div class="product_dec">
                                    <h3 class="product_title bold ">Back pull point flannelette blue indoor leisure chair
                                        simple Nordic style</h3>
                                    <h5 class="productPrice"><i class="fas fa-rupee-sign fs-12 me-1"></i>1000</h5>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-2 mb16">
                        <div class="ekom_card">
                            <a href="product-details.html" class="product_card text_u">
                                <div class="product_image_wraper">
                                    <div class="product_image">
                                        <img src="../assets/images/product/new_1.webp" class="_pdimg" tabindex="-1">
                                    </div>
                                    <div class="gray"></div>
                                </div>
                                <div class="product_dec">
                                    <h3 class="product_title bold ">Back pull point flannelette blue indoor leisure chair
                                        simple Nordic style</h3>
                                    <h5 class="productPrice"><i class="fas fa-rupee-sign fs-12 me-1"></i>1000</h5>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-2 mb16">
                        <div class="ekom_card">
                            <a href="product-details.html" class="product_card text_u">
                                <div class="product_image_wraper">
                                    <div class="product_image">
                                        <img src="../assets/images/product/new_2.webp" class="_pdimg" tabindex="-1">
                                    </div>
                                    <div class="gray"></div>
                                </div>
                                <div class="product_dec">
                                    <h3 class="product_title bold ">Back pull point flannelette blue indoor leisure chair
                                        simple Nordic style</h3>
                                    <h5 class="productPrice"><i class="fas fa-rupee-sign fs-12 me-1"></i>1000</h5>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-2 mb16">
                        <div class="ekom_card">
                            <a href="product-details.html" class="product_card text_u">
                                <div class="product_image_wraper">
                                    <div class="product_image">
                                        <img src="../assets/images/product/new_3.webp" class="_pdimg" tabindex="-1">
                                    </div>
                                    <div class="gray"></div>
                                </div>
                                <div class="product_dec">
                                    <h3 class="product_title bold ">Back pull point flannelette blue indoor leisure chair
                                        simple Nordic style</h3>
                                    <h5 class="productPrice"><i class="fas fa-rupee-sign fs-12 me-1"></i>1000</h5>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-2 mb16">
                        <div class="ekom_card">
                            <a href="product-details.html" class="product_card text_u">
                                <div class="product_image_wraper">
                                    <div class="product_image">
                                        <img src="../assets/images/product/new_4.webp" class="_pdimg" tabindex="-1">
                                    </div>
                                    <div class="gray"></div>
                                </div>
                                <div class="product_dec">
                                    <h3 class="product_title bold ">Back pull point flannelette blue indoor leisure chair
                                        simple Nordic style</h3>
                                    <h5 class="productPrice"><i class="fas fa-rupee-sign fs-12 me-1"></i>1000</h5>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-2 mb16">
                        <div class="ekom_card">
                            <a href="product-details.html" class="product_card text_u">
                                <div class="product_image_wraper">
                                    <div class="product_image">
                                        <img src="../assets/images/product/new_5.webp" class="_pdimg" tabindex="-1">
                                    </div>
                                    <div class="gray"></div>
                                </div>
                                <div class="product_dec">
                                    <h3 class="product_title bold ">Back pull point flannelette blue indoor leisure chair
                                        simple Nordic style</h3>
                                    <h5 class="productPrice"><i class="fas fa-rupee-sign fs-12 me-1"></i>1000</h5>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-2 mb16">
                        <div class="ekom_card">
                            <a href="product-details.html" class="product_card text_u">
                                <div class="product_image_wraper">
                                    <div class="product_image">
                                        <img src="../assets/images/product/premium_2.webp" class="_pdimg" tabindex="-1">
                                    </div>
                                    <div class="gray"></div>
                                </div>
                                <div class="product_dec">
                                    <h3 class="product_title bold ">Back pull point flannelette blue indoor leisure chair
                                        simple Nordic style</h3>
                                    <h5 class="productPrice"><i class="fas fa-rupee-sign fs-12 me-1"></i>1000</h5>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mt10">
                        <button type="button" class="btn btnekomn-border btnround">View More</button>
                    </div>
                </div>
            </div>
        </section>
        <section class="ekAdvantageBlock">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="ekAdvantageImg">
                            <img src="../assets/images/icon/eKomnadv.webp">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="eKomn_commitment">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="ekAdvantageImg">
                            <img src="../assets/images/icon/eKomn_commitment.webp">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="process_sec">
            <div class="process_sec_h text-center">
                <h2 class="sec_main_h mb-2">What Our Clients Say About Us</h2>
                <p class="opacity-75 fs-17">
                    We give wings to your eCommerce enterprise! With 10K+ products across top categories, our clients'
                    businesses soar.</p>
            </div>
            <div class="row justify-content-md-center">
                <div class="col-sm-12 col-md-10">
                    <div class="testimonial_owl owl-carousel owl-theme">
                        <div class="item">
                            <div class="testimonalBlock">
                                <h3 class="unitext">𝓞𝓾𝓻 𝓒𝓵𝓲𝓮𝓷𝓽 𝓢𝓪𝔂𝓼</h3>
                                <div class="clientWords">
                                    <div class="clientimg">
                                        <img src="https://i.postimg.cc/BvNYhMHS/user-img.jpg" alt="" />
                                    </div>
                                    <div class="authorName">
                                        <h4>Junaid Khan</h4>
                                        <span>Founder and CEO</span>
                                    </div>
                                    <div class="authorContent">
                                        <span class="quote-left fas fa-quote-left me-2"></span>
                                        <span class="authorContentPara">
                                            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nostrum possimus velit
                                            similique, iusto libero ut necessitatibus quo porro dolorum explicabo est
                                            maiores
                                        </span>
                                        <span class="quote-left fas fa-quote-right ms-2"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="testimonalBlock">
                                <h3 class="unitext">𝓞𝓾𝓻 𝓒𝓵𝓲𝓮𝓷𝓽 𝓢𝓪𝔂𝓼</h3>
                                <div class="clientWords">
                                    <div class="clientimg">
                                        <img src="https://i.postimg.cc/BvNYhMHS/user-img.jpg" alt="" />
                                    </div>
                                    <div class="authorName">
                                        <h4>Mohd Imtyaj</h4>
                                        <span>Founder and CEO</span>
                                    </div>
                                    <div class="authorContent">
                                        <span class="quote-left fas fa-quote-left me-2"></span>
                                        <span class="authorContentPara">
                                            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nostrum possimus velit
                                            similique, iusto libero ut necessitatibus quo porro dolorum explicabo est
                                            maiores
                                        </span>
                                        <span class="quote-left fas fa-quote-right ms-2"></span>
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
@section('scripts')
<script type="text/javascript" src="{{ asset('assets/js/jquery.min.js') }}"></script>

<script>
    $(document).ready(function() {
        // Perform an AJAX GET request to fetch category data
        $.ajax({
                url: '{{ route('categories.list') }}', // URL endpoint for fetching categories
                type: 'GET', // HTTP method for the request
                dataType: 'json', // Expected data type of the response
                success: function(res) {
                    // jQuery object for the primary category menu
                    $menu = $("#primary_category");

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
                            // HTML structure for the main category
                            var mainCategoryHtml = '<li class="primary_category_list">';
                            mainCategoryHtml += '<a href="' + url.replace('SLUG', category
                                    .parent_slug) +
                                '" class="main_category">' + category.parent_name + '</a>';
                            mainCategoryHtml += '<div class="category_sub_list">';

                            // Iterate through each sub-parent of the main category
                            $.each(category.sub_parents, function(index, subParent) {
                                // HTML structure for each sub-parent
                                var subParentHtml = '<div class="inner_category">';
                                subParentHtml += '<h4>' + subParent.sub_parent_name +
                                    '</h4>';
                                subParentHtml += '<ul class="web_sub_category">';

                                // Iterate through each child category of the sub-parent
                                $.each(subParent.children, function(index, child) {
                                    // HTML structure for each child category
                                    subParentHtml += '<li><a href="' + url
                                        .replace('SLUG', child
                                            .child_slug) + '">' + child
                                        .child_name +
                                        '</a></li>';
                                });

                                // Close the list and sub-parent HTML structure
                                subParentHtml += '</ul></div>';
                                mainCategoryHtml += subParentHtml;
                            });

                            // Close the sub-list and main category HTML structure
                            mainCategoryHtml += '</div></li>';

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

            ApiRequest('top-product-view-home', 'GET')
            .then((res) => {
                let list = res.data.data;
                if(res.data.statusCode == 200){
                    var premium = '';
                    var new_arrival = '';
                    var in_demand = '';
                    var regular_available = '';
                    var category = '';
                    // Iterate through each key-value pair in the object
                    $.each(list, function(key, value) {
                        // Print each element in the array
                        $.each(value, function(index, element) {
                           if(key === 'premium'){
                            premium +=  `
                              <div class="col-sm-4">
                                        <a href="${element.slug}" class="product_card text_u">
                                            <div class="product_image_wraper">
                                                <div class="product_image">
                                                    <img src="${element.product_image}" class="_pdimg"
                                                        tabindex="-1">
                                                </div>
                                                <div class="gray"></div>
                                            </div>
                                            <div class="product_dec p-0">
                                                <h3 class="product_title bold mt5">
                                                   ${element.title}
                                                </h3>
                                                <h5 class="productPrice"><i class="fas fa-rupee-sign fs-12 me-1"></i>${element.price_before_tax}
                                                </h5>
                                            </div>
                                        </a>
                                    </div>
                                 `;
                               }

                               if(key === 'new_arrival'){
                                new_arrival +=  `
                                    <div class="col-sm-4">
                                        <a href="${element.slug}" class="product_card text_u">
                                            <div class="product_image_wraper">
                                                <div class="product_image">
                                                    <img src="${element.product_image}" class="_pdimg"
                                                        tabindex="-1">
                                                </div>
                                                <div class="gray"></div>
                                            </div>
                                            <div class="product_dec p-0">
                                                <h3 class="product_title bold mt5">
                                                   ${element.title}
                                                </h3>
                                                <h5 class="productPrice"><i class="fas fa-rupee-sign fs-12 me-1"></i>${element.price_before_tax}
                                                </h5>
                                            </div>
                                        </a>
                                    </div>
                                    `;
                               }

                               if(key === 'in_demand'){
                                in_demand +=  `
                                          <div class="col-sm-4">
                                        <a href="${element.slug}" class="product_card text_u">
                                            <div class="product_image_wraper">
                                                <div class="product_image">
                                                    <img src="${element.product_image}" class="_pdimg"
                                                        tabindex="-1">
                                                </div>
                                                <div class="gray"></div>
                                            </div>
                                            <div class="product_dec p-0">
                                                <h3 class="product_title bold mt5">
                                                   ${element.title}
                                                </h3>
                                                <h5 class="productPrice"><i class="fas fa-rupee-sign fs-12 me-1"></i>${element.price_before_tax}
                                                </h5>
                                            </div>
                                        </a>
                                    </div>
                                   
                                          `;
                                 }

                               if(key === 'regular_available'){
                                regular_available +=  `
                                    <div class="col-sm-4">
                                        <a href="${element.slug}" class="product_card text_u">
                                            <div class="product_image_wraper">
                                                <div class="product_image">
                                                    <img src="${element.product_image}" class="_pdimg"
                                                        tabindex="-1">
                                                </div>
                                                <div class="gray"></div>
                                            </div>
                                            <div class="product_dec p-0">
                                                <h3 class="product_title bold mt5">
                                                   ${element.title}
                                                </h3>
                                                <h5 class="productPrice"><i class="fas fa-rupee-sign fs-12 me-1"></i>${element.price_before_tax}
                                                </h5>
                                            </div>
                                        </a>
                                    </div>
                                      `;
                               }

                               if(key === 'feature_category'){
                    
                                    category +=  ` <div class="col-sm-12 col-md-4 mb16">
                                    <div class="ekom_card">
                            <div class="ekom_card_head">
                                <h2 class="fs-16">${element.category_name}</h2>
                                <a href="${element.category_link}" class="a_color">View All</a>
                            </div>
                            <div class="ekom_card_body">
                                <div class="row gx-3">`

                                element.products.forEach(product => {
                                    category += `<div class="col">
                                        <div class="product_card">
                                            <a href="product_category.html" class="product_image_wraper">
                                                <div class="product_image">
                                                    <img src="${product.product_image}" class="_pdimg"
                                                        tabindex="-1">
                                                </div>
                                                <div class="gray"></div>
                                            </a>
                                        </div>
                                    </div>`
                                });
                                category += `</div>
                                </div>
                            </div>
                            </div>
                            </div>`;
                             }
                             

                        });
                    });

                    $('#premium').html(premium);
                    $('#new_arrivals').html(new_arrival);
                    $('#in_demand').html(in_demand);
                    $('#regular').html(regular_available);
                    $('#category').html(category);
                }
            })
            .catch((err) => {
                console.log(err);
            });

            ApiRequest('get-banner?type=home', 'GET')
            .then(res => {
                if (res.data.statusCode == 200) {
                    const imagePath = res.data.data;
                    var html = '';
                    if(res.data.data.length == 0){
                    }
                               
                    imagePath.forEach(element => {
                        html += `
                          <div class="carousel-item active" data-bs-interval="5000">
                                <img src="${element.image_path}" class="d-block w-100" />
                            </div>
                            `;
                    });
                    $('#banner').html(html);
                } 
            })
            .catch(err => {
                console.log(err);
              
            });
    });
</script>
@endsection