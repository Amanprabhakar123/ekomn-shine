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
                            <li>Avail technology enabled affordable eCommerce services</li>
                        </ul>
                        <div class="introbtnbox">
                            <a href="https://meet.zoho.in/6VotnvByF2" target="_blank" class="btn btnekomn btnround px-5">Join Our Webinar</a>
                        </div>
                        <p class="mb25">
                            eKomn provides all tools and resources for a successful Online business.
                        </p>
                        <div>To know more,<a href="{{route('contactus')}}" class="a_color mx-1 text_u">contact us</a>today!!</div>
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
                                <a href="{{ route('product.type', ['type' => 'premium']) }}" class="a_color">View All</a>
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
                                <a href="{{ route('product.type', ['type' => 'new-arrivals']) }}" class="a_color">View
                                    All</a>
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
                                <a href="{{ route('product.type', ['type' => 'in-demand']) }}" class="a_color">View All</a>
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
                                <a href="{{ route('product.type', ['type' => 'regular-available']) }}" class="a_color">View
                                    All</a>
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
                <div class="row gx-3" id="appendJusforYou">
                </div>
                <div class="d-flex justify-content-center mt10">
                    <button type="button" id='viewMore' class="btn btnekomn-border btnround">View More</button>
                </div>
            </div>
        </section>
        <section class="adv-section">
            <div class="container">
                <div class="row align-items-center ">
                    <div class="col-sm-12 col-md-6">
                        <div class="advantage">
                            <img src="{{ asset('assets/images/icon/advantageText.svg') }}" alt="">
                            <p class="fs-20 mt30">We literally give wings to your eCommerce enterprise!
                                More than 10K products across leading categories.</p>
                            <div class="d-flex mt40 pt-4 mbspace">
                                <a href="{{route('buyer.register')}}" class="btn btnekomn_dark  py-2 w_300_f btnround">Register Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="advantagecontent">
                            <div class="advstep">
                                <div class="advstephead">
                                    <div class="advhimg">
                                        <img src="{{ asset('assets/images/icon/adv_1.svg') }}" alt="">
                                    </div>
                                    <h3 class="fs-24 m-0">Growth Tools</h3>
                                </div>
                                <ul class="checkpoint ms-3">
                                    <li class="fs-18">Connect your store and put your Online business on auto mode</li>
                                    <li class="fs-18">Expand your business on multiple platforms and channels</li>
                                    <li class="fs-18">We equip you with all tools and business trainings to succeed</li>
                                </ul>
                            </div>
                            <div class="advstep">
                                <div class="advstephead">
                                    <div class="advhimg">
                                        <img src="{{ asset('assets/images/icon/adv_2.svg') }}" alt="">
                                    </div>
                                    <h3 class="fs-24 m-0">Product Sourcing</h3>
                                </div>
                                <ul class="checkpoint ms-3">
                                    <li class="fs-18">Find, Select & Sell profitably</li>
                                    <li class="fs-18">Access to Samples, Dropship, Bulk Orders & Resell programs</li>
                                    <li class="fs-18">Community Sourcing, A program for mutual support and success</li>
                                </ul>
                            </div>
                            <div class="advstep">
                                <div class="advstephead">
                                    <div class="advhimg">
                                        <img src="{{ asset('assets/images/icon/adv_3.svg') }}" alt="">
                                    </div>
                                    <h3 class="fs-24 m-0">Services</h3>
                                </div>
                                <ul class="checkpoint ms-3">
                                    <li class="fs-18">Innovative business solutions designed for Online Sellers</li>
                                    <li class="fs-18">Avail expert help at a click of a button</li>
                                    <li class="fs-18">Prompt support and dedicated account executives</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="commit-section">
            <div class="container">
                <div class="row align-items-center ">
                    <div class="col-sm-12 col-md-6">
                        <div class="advantage">
                            <img src="{{ asset('assets/images/icon/commit.svg') }}" alt="">
                            <p class="fs-20 mt30">Committed to create and support over 1 mm thriving
                                online enterprises in India by 2027.</p>
                            <div class="d-flex mt40 pt-4 mbspace">
                                <a href="{{route('buyer.login')}}" class="btn btnekomn py-2 w_300_f btnround">Let's Join hands. Risk Free!!</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="advantagecontent">
                            <div class="advstep">
                                <div class="commstephead">
                                    <div class="advhimg mb10">
                                        <img src="{{ asset('assets/images/icon/commit_1.svg') }}" alt="">
                                    </div>
                                    <p class="fs-20 text-center m-0">Ever growing catalog of Innovative
                                        and winning products</p>
                                </div>
                            </div>
                            <div class="advstep">
                                <div class="commstephead">
                                    <div class="advhimg mb10">
                                        <img src="{{ asset('assets/images/icon/commit_2.svg') }}" alt="">
                                    </div>
                                    <p class="fs-20 text-center m-0">Competitive wholesale prices &
                                        Assured product quality</p>
                                </div>
                            </div>
                            <div class="advstep">
                                <div class="commstephead">
                                    <div class="advhimg mb10">
                                        <img src="{{ asset('assets/images/icon/commit_3.svg') }}" alt="">
                                    </div>
                                    <p class="fs-20 text-center m-0">Prompt support and help</p>
                                </div>
                            </div>
                            <div class="advstep">
                                <div class="commstephead">
                                    <div class="advhimg mb10">
                                        <img src="{{ asset('assets/images/icon/commit_4.svg') }}" alt="">
                                    </div>
                                    <p class="fs-20 text-center m-0">Business Trainings & Services</p>
                                </div>
                            </div>
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
                                <div class="clientWords" title="The product sourcing services provided by eKomn have been a game-changer for our business. The platform's comprehensive listings and easy-to-use interface made it incredibly simple to find high-quality products in a short time. The added value of online consulting and other tools, helped us in our operational efficiency leading to a 30% increase in our product offerings. Highly recommended!">
                                    <div class="clientimg">
                                        <img src="{{asset('assets/images/web/Ananya-Gupta.png')}}" alt="" />
                                    </div>
                                    <div class="authorName">
                                        <h4>Ananya Gupta</h4>
                                        <span>Founder & CEO Of eMarket India</span>
                                    </div>
                                    <div class="authorContent">
                                        <span class="quote-left fas fa-quote-left me-2"></span>
                                        <span class="authorContentPara">
                                        The product sourcing services provided by eKomn have been a game-changer for our business. The platform's comprehensive listings and easy-to-use interface made it incredibly simple to find high-quality products in a short time. The added value of online consulting and other tools, helped us in our operational efficiency leading to a 30% increase in our product offerings. Highly recommended!
                                        </span>
                                        <span class="quote-left fas fa-quote-right ms-2"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="testimonalBlock">
                                <h3 class="unitext">𝓞𝓾𝓻 𝓒𝓵𝓲𝓮𝓷𝓽 𝓢𝓪𝔂𝓼</h3>
                                <div class="clientWords" title="Thanks to eKomn, we've been able to efficiently source products that align perfectly with our brand’s vision and categories. The platform’s various tools to support online sellers are innovatively designed. Our inventory is auto updated and we are noticing the difference in our revenue!">
                                    <div class="clientimg">
                                        <img src="{{asset('assets/images/web/Ritu-Singh.png')}}" alt="" />
                                    </div>
                                    <div class="authorName">
                                        <h4>Ritu Singh</h4>
                                        <span>Operations Manager of Trends1</span>
                                    </div>
                                    <div class="authorContent">
                                        <span class="quote-left fas fa-quote-left me-2"></span>
                                        <span class="authorContentPara">
                                        Thanks to eKomn, we've been able to efficiently source products that align perfectly with our brand’s vision and categories. The platform’s various tools to support online sellers are innovatively designed. Our inventory is auto updated and we are noticing the difference in our revenue!
                                        </span>
                                        <span class="quote-left fas fa-quote-right ms-2"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="testimonalBlock">
                                <h3 class="unitext">𝓞𝓾𝓻 𝓒𝓵𝓲𝓮𝓷𝓽 𝓢𝓪𝔂𝓼</h3>
                                <div class="clientWords" title="The comprehensive product sourcing services offered byeKomn have streamlined our supply chain challenges. We've been able to source regular available products at competitive pricing, which has enhanced our profitability. The platform’s additional services like review management, is truly pioneering.">
                                    <div class="clientimg">
                                        <img src="{{asset('assets/images/web/Aditya-Roy.png')}}" alt="" />
                                    </div>
                                    <div class="authorName">
                                        <h4>Aditya Roy</h4>
                                        <span>Managing Director of GlobalST</span>
                                    </div>
                                    <div class="authorContent">
                                        <span class="quote-left fas fa-quote-left me-2"></span>
                                        <span class="authorContentPara">
                                        The comprehensive product sourcing services offered byeKomn have streamlined our supply chain challenges. We've been able to source regular available products at competitive pricing, which has enhanced our profitability. The platform’s additional services like review management, is truly pioneering.
                                        </span>
                                        <span class="quote-left fas fa-quote-right ms-2"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="testimonalBlock">
                                <h3 class="unitext">𝓞𝓾𝓻 𝓒𝓵𝓲𝓮𝓷𝓽 𝓢𝓪𝔂𝓼</h3>
                                <div class="clientWords" title="The level of value driven features provided by eKomn platform is exceptional. Their product sourcing options are extensive, and we’ve found some of our best-performing products through eKomn. You can select and launch a new product at a super fast speed and at very low initial cost. The online consulting services and other business tools are super valuable. Highly recommended for all online sellers!!">
                                    <div class="clientimg">
                                        <img src="{{asset('assets/images/web/Neha-Verma.png')}}" alt="" />
                                    </div>
                                    <div class="authorName">
                                        <h4>Neha Verma</h4>
                                        <span>Director of Online Sales Of Bazaar1 Pvt ltd</span>
                                    </div>
                                    <div class="authorContent">
                                        <span class="quote-left fas fa-quote-left me-2"></span>
                                        <span class="authorContentPara">
                                        The level of value driven features provided by eKomn platform is exceptional. Their product sourcing options are extensive, and we’ve found some of our best-performing products through eKomn. You can select and launch a new product at a super fast speed and at very low initial cost. The online consulting services and other business tools are super valuable. Highly recommended for all online sellers!!
                                        </span>
                                        <span class="quote-left fas fa-quote-right ms-2"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="testimonalBlock">
                                <h3 class="unitext">𝓞𝓾𝓻 𝓒𝓵𝓲𝓮𝓷𝓽 𝓢𝓪𝔂𝓼</h3>
                                <div class="clientWords" title=" We are super quick to experiment and launch new products thanks to eKomn platform.  The platform’s intuitive design and extensive product database have made it easy to find exactly what we need. Now, we never run short of our in demand products thanks to eKomns innovative tools. A must have for all online sellers in India.">
                                    <div class="clientimg">
                                        <img src="{{asset('assets/images/web/Amit-Joshi.png')}}" alt="" />
                                    </div>
                                    <div class="authorName">
                                        <h4>Amit Joshi</h4>
                                        <span>Head of Operations of SnapUp Solutions</span>
                                    </div>
                                    <div class="authorContent">
                                        <span class="quote-left fas fa-quote-left me-2"></span>
                                        <span class="authorContentPara">
                                        We are super quick to experiment and launch new products thanks to eKomn platform.  The platform’s intuitive design and extensive product database have made it easy to find exactly what we need. Now, we never run short of our in demand products thanks to eKomns innovative tools. A must have for all online sellers in India.
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
    <script>
        $(document).ready(function() {
            var owl = $('.testimonial_owl.owl-carousel');
            owl.owlCarousel({
                items: 3,
                center: true,
                loop: true,
                margin: 0,
                autoplay: true,
                autoplayTimeout: 10000,
                autoplayHoverPause: true,
                smartSpeed: 600,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 2
                    },
                    1000: {
                        items: 3
                    }
                }
            });
            // Perform an AJAX GET request to fetch category data
            $.ajax({
                    url: '{{ route('categories.list') }}', // URL endpoint for fetching categories
                    type: 'GET', // HTTP method for the request
                    dataType: 'json', // Expected data type of the response
                    success: function(res) {
                        // jQuery object for the primary category menu
                        $menu = $("#primary_category");
                        $mobileMenu = $("#mob_cat_list");

                        // Clear any existing content in the menu
                        $menu.empty();
                        var url = "{{ route('product.category', ['slug' => 'SLUG']) }}";
                        // Check if the response status code is 200 (OK)
                        if (res.data.statusCode == 200) {
                            // Extract the category data from the response
                            let data = res.data.data;

                            // Clear existing content (redundant with the above empty())
                            $menu.empty();
                            $mobileMenu.empty();

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

                                // Begin HTML structure for mobile menu
                                var mobileCategory = '<li class="nav-item">';
                                mobileCategory += `<a class="nav-link collapsed nav-link-arrow" data-bs-toggle="collapse" href="#${category.parent_slug}"
                                                    data-bs-parent="#mob_cat_list" id="components">
                                                    <span class="nav-link-text">${category.parent_name}</span>
                                                    <span class="menu_arrowIcon"><i class="fas fa-angle-right"></i></span>
                                                    </a>`;

                                // Loop through sub-parent categories and build HTML for each
                                $.each(category.sub_parents, function(index, subParent) {
                                    // Begin HTML structure for sub-parent category
                                    var mobilesubParentHtml =
                                        `<ul class="sidenav-second-level collapse" id="${category.parent_slug}" data-bs-parent="#mob_cat_list">`;

                                    // Loop through child categories of the sub-parent
                                    $.each(subParent.children, function(index, child) {
                                        // Add child category links dynamically using its slug and name
                                        mobilesubParentHtml +=
                                            '<li><a class="nav-link" href="' + url
                                            .replace('SLUG', child.child_slug) +
                                            '">' + child.child_name + '</a></li>';
                                    });

                                    // Close the sub-parent's child category list
                                    mobilesubParentHtml += '</ul>';

                                    // Append the sub-parent HTML to the main category structure
                                    mobileCategory += mobilesubParentHtml;
                                });

                                // Append the completed category structure to the mobile menu
                                $mobileMenu.append(mobileCategory);


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
                    if (res.data.statusCode == 200) {
                        var premium = '';
                        var new_arrival = '';
                        var in_demand = '';
                        var regular_available = '';
                        var category = '';
                        var just_for_you = '';
                        // Iterate through each key-value pair in the object
                        $.each(list, function(key, value) {
                            // Print each element in the array
                            $.each(value, function(index, element) {
                                if (key === 'premium') {
                                    premium += `
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

                                if (key === 'new_arrival') {
                                    new_arrival += `
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

                                if (key === 'in_demand') {
                                    in_demand += `
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

                                if (key === 'regular_available') {
                                    regular_available += `
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

                                if (key === 'feature_category') {
                                    category += ` <div class="col-sm-12 col-md-4 mb16">
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
                                            <a href="${product.product_slug}" class="product_image_wraper">
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

                                if (key === 'just_for_you') {

                                    just_for_you += `<div class="col-sm-6 col-md-4 col-lg-2 mb16">
                                                    <div class="ekom_card">
                                                        <a href="${element.product_slug}" class="product_card text_u">
                                                            <div class="product_image_wraper">
                                                                <div class="product_image">
                                                                    <img src="${element.product_image}" class="_pdimg" tabindex="-1">
                                                                </div>
                                                                <div class="gray"></div>
                                                            </div>
                                                            <div class="product_dec">
                                                                <h3 class="product_title bold">${element.product_name}</h3>
                                                                <h5 class="productPrice"><i class="fas fa-rupee-sign fs-12 me-1"></i>${element.product_price}</h5>
                                                            </div>
                                                        </a>
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
                        $('#appendJusforYou').html(just_for_you);
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
                        if (res.data.data.length == 0) {}

                        imagePath.forEach(element => {
                            html += `
                          <div class="carousel-item active" data-bs-interval="10000">
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

        // View more button click event

var perPage = 1;
$('#viewMore').click( function() {
    // alert('clicked');
  perPage ++;

    ApiRequest('view-more?perpage='+perPage, 'GET' )
        .then((res) => {
            let list = res.data.data;
            if (res.data.statusCode == 200) {
                var viewMore = '';
                // Iterate through each key-value pair in the object
                $.each(list, function(key, element) {
                        viewMore += `<div class="col-sm-6 col-md-4 col-lg-2 mb16">
                                                    <div class="ekom_card">
                                                        <a href="${element.product_slug}" class="product_card text_u">
                                                            <div class="product_image_wraper">
                                                                <div class="product_image">
                                                                    <img src="${element.product_image}" class="_pdimg" tabindex="-1">
                                                                </div>
                                                                <div class="gray"></div>
                                                            </div>
                                                            <div class="product_dec">
                                                                <h3 class="product_title bold">${element.product_name}</h3>
                                                                <h5 class="productPrice"><i class="fas fa-rupee-sign fs-12 me-1"></i>${element.product_price}</h5>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>`;
                    
                });
                // console.log(viewMore);
                $('#appendJusforYou').append(viewMore);
            }
        })
        .catch((err) => {
            console.log(err);
        });
});
    </script>
@endsection
