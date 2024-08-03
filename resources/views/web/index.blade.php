@extends('web.layout.app')
@section('content')
<div class="ekcontent">
    <section class="ek-section">
      <div class="topSection_w_cat">
        <!-- category here  -->
         @include('web.layout.main-category')
        <div class="promotional_banner">
          <div class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-inner">
              <div class="carousel-item active" data-bs-interval="10000">
                <img src="../assets/images/web/banner_1.jpg" class="d-block w-100" />
              </div>
              <div class="carousel-item" data-bs-interval="10000">
                <img src="../assets/images/web/banner_2.jpg" class="d-block w-100" />
              </div>
              <div class="carousel-item" data-bs-interval="10000">
                <img src="../assets/images/web/banner_3.jpg" class="d-block w-100" />
              </div>
              <div class="carousel-item" data-bs-interval="10000">
                <img src="../assets/images/web/banner_4.jpg" class="d-block w-100" />
              </div>
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
                <div class="row gx-3">
                  <div class="col-sm-4">
                    <a href="product-details.html" class="product_card text_u">
                      <div class="product_image_wraper">
                        <div class="product_image">
                          <img src="../assets/images/product/premium_2.webp" class="_pdimg" tabindex="-1">
                        </div>
                        <div class="gray"></div>
                      </div>
                      <div class="product_dec p-0">
                        <h3 class="product_title bold ">Back pull point flannelette blue indoor leisure chair simple Nordic style</h3>
                        <h5 class="productPrice"><i class="fas fa-rupee-sign fs-12 me-1"></i>1000</h5>
                      </div>
                    </a>
                  </div>
                  <div class="col-sm-4">
                    <a href="product-details.html" class="product_card text_u">
                      <div class="product_image_wraper">
                        <div class="product_image">
                          <img src="../assets/images/product/premium_1.webp" class="_pdimg" tabindex="-1">
                        </div>
                        <div class="gray"></div>
                      </div>
                      <div class="product_dec p-0">
                        <h3 class="product_title bold mt5">
                          Activo Compression Socks Get 3 Pairs Legwear For Healthy Lifestyle
                        </h3>
                        <h5 class="productPrice"><i class="fas fa-rupee-sign fs-12 me-1"></i>1000</h5>
                      </div>
                    </a>
                  </div>
                  <div class="col-sm-4">
                    <a href="product-details.html" class="product_card text_u">
                      <div class="product_image_wraper">
                        <div class="product_image">
                          <img src="../assets/images/product/premium_3.webp" class="_pdimg" tabindex="-1">
                        </div>
                        <div class="gray"></div>
                      </div>
                      <div class="product_dec p-0">
                        <h3 class="product_title bold mt5">
                          Twin Size Upholstered Platform Bed with Cartoon Ears Shaped Headboard and Trundle, White
                        </h3>
                        <h5 class="productPrice"><i class="fas fa-rupee-sign fs-12 me-1"></i>1000</h5>
                      </div>
                    </a>
                  </div>
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
                <div class="row gx-3">
                  <div class="col-sm-4">
                    <a href="product-details.html" class="product_card text_u">
                      <div class="product_image_wraper">
                        <div class="product_image">
                          <img src="../assets/images/product/arrival_1.webp" class="_pdimg" tabindex="-1">
                        </div>
                        <div class="gray"></div>
                      </div>
                      <div class="product_dec p-0">
                        <h3 class="product_title bold mt5">
                          True Twin 2 In 1 Wireless Headphones With Powerbank
                        </h3>
                        <h5 class="productPrice"><i class="fas fa-rupee-sign fs-12 me-1"></i>1000</h5>
                      </div>
                    </a>
                  </div>
                  <div class="col-sm-4">
                    <a href="product-details.html" class="product_card text_u">
                      <div class="product_image_wraper">
                        <div class="product_image">
                          <img src="../assets/images/product/arrival_2.jpg" class="_pdimg" tabindex="-1">
                        </div>
                        <div class="gray"></div>
                      </div>
                      <div class="product_dec p-0">
                        <h3 class="product_title bold mt5">
                          Dell WM126 Wireless Mouse
                        </h3>
                        <h5 class="productPrice"><i class="fas fa-rupee-sign fs-12 me-1"></i>1000</h5>
                      </div>
                    </a>
                  </div>
                  <div class="col-sm-4">
                    <a href="product-details.html" class="product_card text_u">
                      <div class="product_image_wraper">
                        <div class="product_image">
                          <img src="../assets/images/product/arrival_3.webp" class="_pdimg" tabindex="-1">
                        </div>
                        <div class="gray"></div>
                      </div>
                      <div class="product_dec p-0">
                        <h3 class="product_title bold mt5">
                          Foldable Outdoor BBQ Table Grilling Stand
                        </h3>
                        <h5 class="productPrice"><i class="fas fa-rupee-sign fs-12 me-1"></i>1000</h5>
                      </div>
                    </a>
                  </div>
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
        <div class="row gx-3">
          <div class="col-sm-12 col-md-4 mb16">
            <div class="ekom_card">
              <div class="ekom_card_head">
                <h2 class="fs-16">Home, Garden & Tools</h2>
                <a href="product_category.html" class="a_color">View All</a>
              </div>
              <div class="ekom_card_body">
                <div class="row gx-3">
                  <div class="col">
                    <div class="product_card">
                      <a href="product_category.html" class="product_image_wraper">
                        <div class="product_image">
                          <img src="../assets/images/product/home_1.webp" class="_pdimg" tabindex="-1">
                        </div>
                        <div class="gray"></div>
                      </a>
                    </div>
                  </div>
                  <div class="col">
                    <div class="product_card">
                      <a href="product_category.html" class="product_image_wraper">
                        <div class="product_image">
                          <img src="../assets/images/product/home_2.webp" class="_pdimg" tabindex="-1">
                        </div>
                        <div class="gray"></div>
                      </a>
                    </div>
                  </div>
                  <div class="col">
                    <div class="product_card">
                      <a href="product_category.html" class="product_image_wraper">
                        <div class="product_image">
                          <img src="../assets/images/product/home_3.webp" class="_pdimg" tabindex="-1">
                        </div>
                        <div class="gray"></div>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-12 col-md-4 mb16">
            <div class="ekom_card">
              <div class="ekom_card_head">
                <h2 class="fs-16">Beauty & Health</h2>
                <a href="product_category.html" class="a_color">View All</a>
              </div>
              <div class="ekom_card_body">
                <div class="row gx-3">
                  <div class="col">
                    <div class="product_card">
                      <a href="product_category.html" class="product_image_wraper">
                        <div class="product_image">
                          <img src="../assets/images/product/beauty_1.webp" class="_pdimg" tabindex="-1">
                        </div>
                        <div class="gray"></div>
                      </a>
                    </div>
                  </div>
                  <div class="col">
                    <div class="product_card">
                      <a href="product_category.html" class="product_image_wraper">
                        <div class="product_image">
                          <img src="../assets/images/product/beauty_2.webp" class="_pdimg" tabindex="-1">
                        </div>
                        <div class="gray"></div>
                      </a>
                    </div>
                  </div>
                  <div class="col">
                    <div class="product_card">
                      <a href="product_category.html" class="product_image_wraper">
                        <div class="product_image">
                          <img src="../assets/images/product/beauty_3.webp" class="_pdimg" tabindex="-1">
                        </div>
                        <div class="gray"></div>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-12 col-md-4 mb16">
            <div class="ekom_card">
              <div class="ekom_card_head">
                <h2 class="fs-16">Outdoor</h2>
                <a href="product_category.html" class="a_color">View All</a>
              </div>
              <div class="ekom_card_body">
                <div class="row gx-3">
                  <div class="col">
                    <div class="product_card">
                      <a href="product_category.html" class="product_image_wraper">
                        <div class="product_image">
                          <img src="../assets/images/product/outdoor_1.webp" class="_pdimg" tabindex="-1">
                        </div>
                        <div class="gray"></div>
                      </a>
                    </div>
                  </div>
                  <div class="col">
                    <div class="product_card">
                      <a href="product_category.html" class="product_image_wraper">
                        <div class="product_image">
                          <img src="../assets/images/product/outdoor_2.webp" class="_pdimg" tabindex="-1">
                        </div>
                        <div class="gray"></div>
                      </a>
                    </div>
                  </div>
                  <div class="col">
                    <div class="product_card">
                      <a href="product_category.html" class="product_image_wraper">
                        <div class="product_image">
                          <img src="../assets/images/product/outdoor_3.webp" class="_pdimg" tabindex="-1">
                        </div>
                        <div class="gray"></div>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-12 col-md-4 mb16">
            <div class="ekom_card">
              <div class="ekom_card_head">
                <h2 class="fs-16">Toys, Kids & Baby</h2>
                <a href="product_category.html" class="a_color">View All</a>
              </div>
              <div class="ekom_card_body">
                <div class="row gx-3">
                  <div class="col">
                    <div class="product_card">
                      <a href="product_category.html" class="product_image_wraper">
                        <div class="product_image">
                          <img src="../assets/images/product/baby_1.webp" class="_pdimg" tabindex="-1">
                        </div>
                        <div class="gray"></div>
                      </a>
                    </div>
                  </div>
                  <div class="col">
                    <div class="product_card">
                      <a href="product_category.html" class="product_image_wraper">
                        <div class="product_image">
                          <img src="../assets/images/product/baby_2.webp" class="_pdimg" tabindex="-1">
                        </div>
                        <div class="gray"></div>
                      </a>
                    </div>
                  </div>
                  <div class="col">
                    <div class="product_card">
                      <a href="product_category.html" class="product_image_wraper">
                        <div class="product_image">
                          <img src="../assets/images/product/baby_3.webp" class="_pdimg" tabindex="-1">
                        </div>
                        <div class="gray"></div>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-12 col-md-4 mb16">
            <div class="ekom_card">
              <div class="ekom_card_head">
                <h2 class="fs-16">Electronocs</h2>
                <a href="product_category.html" class="a_color">View All</a>
              </div>
              <div class="ekom_card_body">
                <div class="row gx-3">
                  <div class="col">
                    <div class="product_card">
                      <a href="product_category.html" class="product_image_wraper">
                        <div class="product_image">
                          <img src="../assets/images/product/arrival_1.webp" class="_pdimg" tabindex="-1">
                        </div>
                        <div class="gray"></div>
                      </a>
                    </div>
                  </div>
                  <div class="col">
                    <div class="product_card">
                      <a href="product_category.html" class="product_image_wraper">
                        <div class="product_image">
                          <img src="../assets/images/product/arrival_2.webp" class="_pdimg" tabindex="-1">
                        </div>
                        <div class="gray"></div>
                      </a>
                    </div>
                  </div>
                  <div class="col">
                    <div class="product_card">
                      <a href="product_category.html" class="product_image_wraper">
                        <div class="product_image">
                          <img src="../assets/images/product/arrival_2.jpg" class="_pdimg" tabindex="-1">
                        </div>
                        <div class="gray"></div>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-12 col-md-4 mb16">
            <div class="ekom_card">
              <div class="ekom_card_head">
                <h2 class="fs-16">Clothing, Shoes & Jewelry</h2>
                <a href="product_category.html" class="a_color">View All</a>
              </div>
              <div class="ekom_card_body">
                <div class="row gx-3">
                  <div class="col">
                    <div class="product_card">
                      <a href="product_category.html" class="product_image_wraper">
                        <div class="product_image">
                          <img src="../assets/images/product/premium_1.webp" class="_pdimg" tabindex="-1">
                        </div>
                        <div class="gray"></div>
                      </a>
                    </div>
                  </div>
                  <div class="col">
                    <div class="product_card">
                      <a href="product_category.html" class="product_image_wraper">
                        <div class="product_image">
                          <img src="../assets/images/product/product_1.jpg" class="_pdimg" tabindex="-1">
                        </div>
                        <div class="gray"></div>
                      </a>
                    </div>
                  </div>
                  <div class="col">
                    <div class="product_card">
                      <a href="product_category.html" class="product_image_wraper">
                        <div class="product_image">
                          <img src="../assets/images/product/product_2.jpg" class="_pdimg" tabindex="-1">
                        </div>
                        <div class="gray"></div>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
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
                <h2>In Demand</h2>
                <a href="product_category.html" class="a_color">View All</a>
              </div>
              <div class="ekom_card_body prod_3">
                <div class="row gx-3">
                  <div class="col-sm-4">
                    <a href="product-details.html" class="product_card text_u">
                      <div class="product_image_wraper">
                        <div class="product_image">
                          <img src="../assets/images/product/premium_2.webp" class="_pdimg" tabindex="-1">
                        </div>
                        <div class="gray"></div>
                      </div>
                      <div class="product_dec p-0">
                        <h3 class="product_title bold mt5">Back pull point flannelette blue indoor leisure chair simple Nordic style</h3>
                        <h5 class="productPrice"><i class="fas fa-rupee-sign fs-12 me-1"></i>1000</h5>
                      </div>
                    </a>
                  </div>
                  <div class="col-sm-4">
                    <a href="product-details.html" class="product_card text_u">
                      <div class="product_image_wraper">
                        <div class="product_image">
                          <img src="../assets/images/product/premium_1.webp" class="_pdimg" tabindex="-1">
                        </div>
                        <div class="gray"></div>
                      </div>
                      <div class="product_dec p-0">
                        <h3 class="product_title bold mt5">
                          Activo Compression Socks Get 3 Pairs Legwear For Healthy Lifestyle
                        </h3>
                        <h5 class="productPrice"><i class="fas fa-rupee-sign fs-12 me-1"></i>1000</h5>
                      </div>
                    </a>
                  </div>
                  <div class="col-sm-4">
                    <a href="product-details.html" class="product_card text_u">
                      <div class="product_image_wraper">
                        <div class="product_image">
                          <img src="../assets/images/product/premium_3.webp" class="_pdimg" tabindex="-1">
                        </div>
                        <div class="gray"></div>
                      </div>
                      <div class="product_dec p-0">
                        <h3 class="product_title bold mt5">
                          Twin Size Upholstered Platform Bed with Cartoon Ears Shaped Headboard and Trundle, White
                        </h3>
                        <h5 class="productPrice"><i class="fas fa-rupee-sign fs-12 me-1"></i>1000</h5>
                      </div>
                    </a>
                  </div>
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
                <div class="row gx-3">
                  <div class="col-sm-4">
                    <a href="product-details.html" class="product_card text_u">
                      <div class="product_image_wraper">
                        <div class="product_image">
                          <img src="../assets/images/product/arrival_1.webp" class="_pdimg" tabindex="-1">
                        </div>
                        <div class="gray"></div>
                      </div>
                      <div class="product_dec p-0">
                        <h3 class="product_title bold mt5">
                          True Twin 2 In 1 Wireless Headphones With Powerbank
                        </h3>
                        <h5 class="productPrice"><i class="fas fa-rupee-sign fs-12 me-1"></i>1000</h5>
                      </div>
                    </a>
                  </div>
                  <div class="col-sm-4">
                    <a href="product-details.html" class="product_card text_u">
                      <div class="product_image_wraper">
                        <div class="product_image">
                          <img src="../assets/images/product/arrival_2.jpg" class="_pdimg" tabindex="-1">
                        </div>
                        <div class="gray"></div>
                      </div>
                      <div class="product_dec p-0">
                        <h3 class="product_title bold mt5">
                          Dell WM126 Wireless Mouse
                        </h3>
                        <h5 class="productPrice"><i class="fas fa-rupee-sign fs-12 me-1"></i>1000</h5>
                      </div>
                    </a>
                  </div>
                  <div class="col-sm-4">
                    <a href="product-details.html" class="product_card text_u">
                      <div class="product_image_wraper">
                        <div class="product_image">
                          <img src="../assets/images/product/arrival_3.webp" class="_pdimg" tabindex="-1">
                        </div>
                        <div class="gray"></div>
                      </div>
                      <div class="product_dec p-0">
                        <h3 class="product_title bold mt5">
                          Foldable Outdoor BBQ Table Grilling Stand
                        </h3>
                        <h5 class="productPrice"><i class="fas fa-rupee-sign fs-12 me-1"></i>1000</h5>
                      </div>
                    </a>
                  </div>
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
                  <h3 class="product_title bold">Back pull point flannelette blue indoor leisure chair simple Nordic style</h3>
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
                  <h3 class="product_title bold ">Back pull point flannelette blue indoor leisure chair simple Nordic style</h3>
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
                  <h3 class="product_title bold ">Back pull point flannelette blue indoor leisure chair simple Nordic style</h3>
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
                  <h3 class="product_title bold ">Back pull point flannelette blue indoor leisure chair simple Nordic style</h3>
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
                  <h3 class="product_title bold ">Back pull point flannelette blue indoor leisure chair simple Nordic style</h3>
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
                  <h3 class="product_title bold ">Back pull point flannelette blue indoor leisure chair simple Nordic style</h3>
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
                  <h3 class="product_title bold ">Back pull point flannelette blue indoor leisure chair simple Nordic style</h3>
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
                  <h3 class="product_title bold ">Back pull point flannelette blue indoor leisure chair simple Nordic style</h3>
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
                  <h3 class="product_title bold ">Back pull point flannelette blue indoor leisure chair simple Nordic style</h3>
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
                  <h3 class="product_title bold ">Back pull point flannelette blue indoor leisure chair simple Nordic style</h3>
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
                  <h3 class="product_title bold ">Back pull point flannelette blue indoor leisure chair simple Nordic style</h3>
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
                  <h3 class="product_title bold ">Back pull point flannelette blue indoor leisure chair simple Nordic style</h3>
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
          We give wings to your eCommerce enterprise! With 10K+ products across top categories, our clients' businesses soar.</p>
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
                      Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nostrum possimus velit similique, iusto libero ut necessitatibus quo porro dolorum explicabo est maiores 
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
                      Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nostrum possimus velit similique, iusto libero ut necessitatibus quo porro dolorum explicabo est maiores 
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