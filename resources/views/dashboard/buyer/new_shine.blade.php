@extends('dashboard.layout.app')
@section('content')
@section('title')
New Shine
@endsection

<div class="ek_dashboard">
    <div class="ek_content">
      <div class="card ekcard pa shadow-sm">
        <div class="cardhead" style="text-align: right;">
          <h3 class="cardtitle">New Shine</h3>
          <div class="showTotalBox _productID">
            <div>Batch Value: 
              <i class="fas fa-rupee-sign fs-13 me-1"></i>
              <strong><span class="batch_amount text-white"></span></strong>
            </div>
            <div>Target Value: 
              <strong><i class="fas fa-rupee-sign fs-13 me-1"></i>1000-2000</strong>
            </div>
          </div>
        </div>
        <div>
          <ul class="nav nav-underline ekom_tab" role="tablist">
            <li class="nav-item" role="presentation">
              <a class="nav-link active" id="request_1-tab" href="#request_1" data-bs-toggle="tab" data-bs-target="#request_1" role="tab"
                aria-controls="request_1" aria-selected="true">Request 1</a>
            </li>
            <li class="nav-item" role="presentation">
              <a class="nav-link" id="request_2-tab" href="#request_2" data-bs-toggle="tab" data-bs-target="#request_2" role="tab"
                aria-controls="request_2" aria-selected="false">Request 2</a>
            </li>
            <li class="nav-item" role="presentation">
              <a class="nav-link" id="request_3-tab" href="#request_3" data-bs-toggle="tab" data-bs-target="#request_3" role="tab"
                aria-controls="request_3" aria-selected="false">Request 3</a>
            </li>
            <li class="nav-item" role="presentation">
              <a class="nav-link" id="request_4-tab" href="#request_4" data-bs-toggle="tab" data-bs-target="#request_4" role="tab"
               aria-controls="request_4" aria-selected="false">Request 4</a>
            </li>
            <li class="nav-item" role="presentation">
              <a class="nav-link" id="request_5-tab" href="#request_5" data-bs-toggle="tab" data-bs-target="#request_5" role="tab"
               aria-controls="request_5" aria-selected="false">Request 5</a>
            </li>
          </ul>
          <div class="tab-content" id="pills-tabContent">
            {{-- <input type="hidden" class="form-control" name="user_id" id="userId" value="{{ auth()->user()->id }}"> --}}
            <div class="tab-pane fade show active" id="request_1" role="tabpanel" aria-labelledby="request_1-tab"
              tabindex="0">
              <div class="ek_shine">
                {{-- <form action="" methot="post" enctype="multipart/form-data">
                  @csrf --}}
                  <div class="addProductForm">
                    <input type="hidden" class="form-control" name="batch_id[]" id="batchId1">
                    <input type="hidden" class="form-control" name="request_no[]" id="requestId1">
                    <div class="row">
                      <div class="col-sm-12 col-md-12">
                        <div class="ek_group">
                          <label class="eklabel req"><span>Product Name:</span></label>
                          <div class="ek_f_input">
                            <input type="text" class="form-control"
                            name="product_name[]" id="product_name" placeholder="Actual product name as listed on the requested platform." required />
                            <span class="text-danger hide">Error message</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12 col-md-4">
                        <div class="ek_group">
                          <label class="eklabel req"><span>Platform :</span></label>
                          <div class="ek_f_input">
                            <select class="form-select" name="platform[]" id="platform" required>
                              <option value="" selected>Select One</option>
                              <option value="flipkart">Flipkart</option>
                              <option value="amazon">Amazon</option>
                              <option value="jiomart">JioMart</option>
                              <option value="ajio">Ajio</option>
                              <option value="meesho">Meesho</option>
                              <option value="myntra">Myntra</option>
                              <option value="nykaa">Nykaa</option>
                              <option value="shopsy">Shopsy</option>
                              <option value="website">Website</option>
                              <option value="">Other</option>
                            </select>
                            <span class="text-danger hide">errr message</span>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12 col-md-4">
                        <div class="ek_group">
                          <label class="eklabel req"><span>Product URL/Link :</span></label>
                          <div class="ek_f_input">
                            <input type="text" class="form-control" name="product_link[]" id="product_link" placeholder="Product page url/link." />
                            <span class="text-danger hide">errr message</span>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12 col-md-4">
                        <div class="ek_group">
                          <label class="eklabel req"><span>Product ID/ASIN:</span></label>
                          <div class="ek_f_input">
                            <input type="text" class="form-control" name="product_id[]" id="product_id" placeholder="Platform specific ID." />
                            <span class="text-danger hide">errr message</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12 col-md-4">
                        <div class="ek_group">
                          <label class="eklabel req"><span>Seller/Brand Name :</span></label>
                          <div class="ek_f_input">
                            <input type="text" class="form-control" name="seller_name[]" id="seller_name" placeholder="Your brand/seller name."><span
                              class="text-danger hide">errr message</span>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12 col-md-8">
                        <div class="ek_group">
                          <label class="eklabel req"><span>Product Search Term :</span></span></label>
                          <div class="ek_f_input">
                            <input type="text" class="form-control"
                              name="search_term[]" id="search_term" placeholder="To search your product on requested platform." />
                            <span class="text-danger hide">errr message</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12 col-md-4">
                        <div class="ek_group">
                          <label class="eklabel req"><span>Product amount :<i
                                class="fas fa-info-circle fa-5x me-3 fs-13"
                                title="Share total product amount including shipping charges, if any. Any mismatch may lead to your request gettng declined."></i></span></label>
                          <div class="ek_f_input">
                            <input type="text" class="form-control"
                              name="amount[]" id="amount" placeholder="Total product amount." />
                            <span class="text-danger hide">errr message</span>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12 col-md-5">
                        <div class="ek_group">
                          <label class="eklabel req"><span>Feedback/Review Title :</span></label>
                          <div class="ek_f_input">
                            <input type="text" class="form-control"
                              name="feedback_title[]" id="feedback_title" placeholder="Title of your feedback review." />
                            <span class="text-danger hide">errr message</span>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12 col-md-3">
                        <div class="ek_group">
                          <label class="eklabel req">Review Rating :</label>
                          <div class="star-rating">
                            <div class="ek_f_input">
                              <div class="star-rating">
                                <span class="star" data-value="1">&#9733;</span>
                                <span class="star" data-value="2">&#9733;</span>
                                <span class="star" data-value="3">&#9733;</span>
                                <span class="star" data-value="4">&#9733;</span>
                                <span class="star" data-value="5">&#9733;</span>
                              </div>
                              <input type="hidden" class="review_rating" name="review_rating"[] id="review_rating" value="">
                              <h6 class="text-danger hide error-message">Error message</h6>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-12 col-md-12">
                          <div class="ek_group">
                            <label class="eklabel req"><span>Feedback/Review comment :</span></label>
                            <div class="ek_f_input">
                              <textarea class="form-control"
                                name="feedback_comment[]" id="feedback_comment" placeholder="Share feedback comment or review of your product as you would like it to be published. A genuine feedback is not more than few lines."></textarea>
                              <span class="text-danger hide">errr message</span>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="saveform_footer">
                        <button type="button" class="btn btn-login btnekomn card_f_btn previous_Tab" id="cancelButton">
                          <i class="fas fa-times me-3 fs-13"></i>Cancel
                        </button>
                          <button type="button" class="btn btn-login btnekomn card_f_btn" id="shinetab1">Save & Next</button>
                      </div>
                    </div>
                  </div>
                {{-- </form> --}}
              </div>
            </div>
            <div class="tab-pane fade" id="request_2" role="tabpanel" aria-labelledby="request_2-tab" tabindex="0">
              <div class="ek_shine">
                {{-- <form action="" methot="post" enctype="multipart/form-data">
                  @csrf --}}
                  <div class="addProductForm">
                    <input type="hidden" class="form-control" name="batch_id[]" id="batchId2">
                    <input type="hidden" class="form-control" name="request_no[]" id="requestId2">
                    <div class="row">
                      <div class="col-sm-12 col-md-12">
                        <div class="ek_group">
                          <label class="eklabel req"><span>Product Name:</span></label>
                          <div class="ek_f_input">
                            <input type="text" class="form-control"
                            name="product_name[]" id="product_name" placeholder="Actual product name as listed on the requested platform." required />
                            <span class="text-danger hide">Error message</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12 col-md-4">
                        <div class="ek_group">
                          <label class="eklabel req"><span>Platform :</span></label>
                          <div class="ek_f_input">
                            <select class="form-select" name="platform[]" id="platform" required>
                              <option value="" selected>Select One</option>
                              <option value="flipkart">Flipkart</option>
                              <option value="amazon">Amazon</option>
                              <option value="jiomart">JioMart</option>
                              <option value="ajio">Ajio</option>
                              <option value="meesho">Meesho</option>
                              <option value="myntra">Myntra</option>
                              <option value="nykaa">Nykaa</option>
                              <option value="shopsy">Shopsy</option>
                              <option value="website">Website</option>
                              <option value="">Other</option>
                            </select>
                            <span class="text-danger hide">errr message</span>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12 col-md-4">
                        <div class="ek_group">
                          <label class="eklabel req"><span>Product URL/Link :</span></label>
                          <div class="ek_f_input">
                            <input type="text" class="form-control" name="product_link[]" id="product_link" placeholder="Product page url/link." />
                            <span class="text-danger hide">errr message</span>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12 col-md-4">
                        <div class="ek_group">
                          <label class="eklabel req"><span>Product ID/ASIN:</span></label>
                          <div class="ek_f_input">
                            <input type="text" class="form-control" name="product_id[]" id="product_id" placeholder="Platform specific ID." />
                            <span class="text-danger hide">errr message</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12 col-md-4">
                        <div class="ek_group">
                          <label class="eklabel req"><span>Seller/Brand Name :</span></label>
                          <div class="ek_f_input">
                            <input type="text" class="form-control" name="seller_name[]" id="seller_name" placeholder="Your brand/seller name."><span
                              class="text-danger hide">errr message</span>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12 col-md-8">
                        <div class="ek_group">
                          <label class="eklabel req"><span>Product Search Term :</span></span></label>
                          <div class="ek_f_input">
                            <input type="text" class="form-control"
                              name="search_term[]" id="search_term" placeholder="To search your product on requested platform." />
                            <span class="text-danger hide">errr message</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12 col-md-4">
                        <div class="ek_group">
                          <label class="eklabel req"><span>Product amount :<i
                                class="fas fa-info-circle fa-5x me-3 fs-13"
                                title="Share total product amount including shipping charges, if any. Any mismatch may lead to your request gettng declined."></i></span></label>
                          <div class="ek_f_input">
                            <input type="text" class="form-control"
                              name="amount[]" id="amount" placeholder="Total product amount." />
                            <span class="text-danger hide">errr message</span>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12 col-md-5">
                        <div class="ek_group">
                          <label class="eklabel req"><span>Feedback/Review Title :</span></label>
                          <div class="ek_f_input">
                            <input type="text" class="form-control"
                              name="feedback_title[]" id="feedback_title" placeholder="Title of your feedback review." />
                            <span class="text-danger hide">errr message</span>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12 col-md-3">
                        <div class="ek_group">
                          <label class="eklabel req">Review Rating :</label>
                          <div class="star-rating">
                            <div class="ek_f_input">
                              <div class="star-rating">
                                <span class="star" data-value="1">&#9733;</span>
                                <span class="star" data-value="2">&#9733;</span>
                                <span class="star" data-value="3">&#9733;</span>
                                <span class="star" data-value="4">&#9733;</span>
                                <span class="star" data-value="5">&#9733;</span>
                              </div>
                              <input type="hidden" class="review_rating" name="review_rating[]" id="review_rating" value="">
                              <h6 class="text-danger hide error-message">Error message</h6>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-12 col-md-12">
                          <div class="ek_group">
                            <label class="eklabel req"><span>Feedback/Review comment :</span></label>
                            <div class="ek_f_input">
                              <textarea class="form-control"
                                name="feedback_comment[]" id="feedback_comment" placeholder="Share feedback comment or review of your product as you would like it to be published. A genuine feedback is not more than few lines."></textarea>
                              <span class="text-danger hide">errr message</span>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="saveform_footer">
                        <button type="button" class="btn btn-login btnekomn card_f_btn previous_Tab"><i
                            class="fas fa-arrow-left me-3 fs-13"></i>Back</button>
                        {{-- <button type="button" class="btn btn-login btnekomn card_f_btn next_Tab">Save & Next</button> --}}
                        <button type="button" class="btn btn-login btnekomn card_f_btn" id="shinetab2">Save & Next</button>
                      </div>
                    </div>
                  </div>
                {{-- </form> --}}
              </div>
            </div>
            <div class="tab-pane fade" id="request_3" role="tabpanel" aria-labelledby="request_3-tab" tabindex="0">
              <div class="ek_shine">
                {{-- <form action="" methot="post"> --}}
                  <div class="addProductForm">
                    <input type="hidden" class="form-control" name="batch_id[]" id="batchId3">
                    <input type="hidden" class="form-control" name="request_no[]" id="requestId3">
                    <div class="row">
                      <div class="col-sm-12 col-md-12">
                        <div class="ek_group">
                          <label class="eklabel req"><span>Product Name:</span></label>
                          <div class="ek_f_input">
                            <input type="text" class="form-control"
                            name="product_name[]" id="product_name" placeholder="Actual product name as listed on the requested platform." required />
                            <span class="text-danger hide">Error message</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12 col-md-4">
                        <div class="ek_group">
                          <label class="eklabel req"><span>Platform :</span></label>
                          <div class="ek_f_input">
                            <select class="form-select" name="platform[]" id="platform" required>
                              <option value="" selected>Select One</option>
                              <option value="flipkart">Flipkart</option>
                              <option value="amazon">Amazon</option>
                              <option value="jiomart">JioMart</option>
                              <option value="ajio">Ajio</option>
                              <option value="meesho">Meesho</option>
                              <option value="myntra">Myntra</option>
                              <option value="nykaa">Nykaa</option>
                              <option value="shopsy">Shopsy</option>
                              <option value="website">Website</option>
                              <option value="">Other</option>
                            </select>
                            <span class="text-danger hide">errr message</span>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12 col-md-4">
                        <div class="ek_group">
                          <label class="eklabel req"><span>Product URL/Link :</span></label>
                          <div class="ek_f_input">
                            <input type="text" class="form-control" name="product_link[]" id="product_link" placeholder="Product page url/link." />
                            <span class="text-danger hide">errr message</span>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12 col-md-4">
                        <div class="ek_group">
                          <label class="eklabel req"><span>Product ID/ASIN:</span></label>
                          <div class="ek_f_input">
                            <input type="text" class="form-control" name="product_id[]" id="product_id" placeholder="Platform specific ID." />
                            <span class="text-danger hide">errr message</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12 col-md-4">
                        <div class="ek_group">
                          <label class="eklabel req"><span>Seller/Brand Name :</span></label>
                          <div class="ek_f_input">
                            <input type="text" class="form-control" name="seller_name[]" id="seller_name" placeholder="Your brand/seller name."><span
                              class="text-danger hide">errr message</span>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12 col-md-8">
                        <div class="ek_group">
                          <label class="eklabel req"><span>Product Search Term :</span></span></label>
                          <div class="ek_f_input">
                            <input type="text" class="form-control"
                              name="search_term[]" id="search_term" placeholder="To search your product on requested platform." />
                            <span class="text-danger hide">errr message</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12 col-md-4">
                        <div class="ek_group">
                          <label class="eklabel req"><span>Product amount :<i
                                class="fas fa-info-circle fa-5x me-3 fs-13"
                                title="Share total product amount including shipping charges, if any. Any mismatch may lead to your request gettng declined."></i></span></label>
                          <div class="ek_f_input">
                            <input type="text" class="form-control"
                              name="amount[]" id="amount" placeholder="Total product amount." />
                            <span class="text-danger hide">errr message</span>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12 col-md-5">
                        <div class="ek_group">
                          <label class="eklabel req"><span>Feedback/Review Title :</span></label>
                          <div class="ek_f_input">
                            <input type="text" class="form-control"
                              name="feedback_title[]" id="feedback_title" placeholder="Title of your feedback review." />
                            <span class="text-danger hide">errr message</span>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12 col-md-3">
                        <div class="ek_group">
                          <label class="eklabel req">Review Rating :</label>
                          <div class="star-rating">
                            <div class="ek_f_input">
                              <div class="star-rating">
                                <span class="star" data-value="1">&#9733;</span>
                                <span class="star" data-value="2">&#9733;</span>
                                <span class="star" data-value="3">&#9733;</span>
                                <span class="star" data-value="4">&#9733;</span>
                                <span class="star" data-value="5">&#9733;</span>
                              </div>
                              <input type="hidden" class="review_rating" name="review_rating[]" id="review_rating" value="">
                              <h6 class="text-danger hide error-message">Error message</h6>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-12 col-md-12">
                          <div class="ek_group">
                            <label class="eklabel req"><span>Feedback/Review comment :</span></label>
                            <div class="ek_f_input">
                              <textarea class="form-control"
                                name="feedback_comment[]" id="feedback_comment" placeholder="Share feedback comment or review of your product as you would like it to be published. A genuine feedback is not more than few lines."></textarea>
                              <span class="text-danger hide">errr message</span>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="saveform_footer">
                        <button type="button" class="btn btn-login btnekomn card_f_btn previous_Tab"><i
                            class="fas fa-arrow-left me-3 fs-13"></i>Back</button>
                        {{-- <button type="button" class="btn btn-login btnekomn card_f_btn next_Tab">Save & Next</button> --}}
                        <button type="button" class="btn btn-login btnekomn card_f_btn" id="shinetab3">Save & Next</button>
                      </div>
                    </div>
                  </div>
                {{-- </form> --}}
              </div>
            </div>
            <div class="tab-pane fade" id="request_4" role="tabpanel" aria-labelledby="request_4-tab" tabindex="0">
              <div class="ek_shine">
                {{-- <form action="" methot="post"> --}}
                  <div class="addProductForm">
                    <input type="hidden" class="form-control" name="batch_id[]" id="batchId4">
                    <input type="hidden" class="form-control" name="request_no[]" id="requestId4">
                    <div class="row">
                      <div class="col-sm-12 col-md-12">
                        <div class="ek_group">
                          <label class="eklabel req"><span>Product Name:</span></label>
                          <div class="ek_f_input">
                            <input type="text" class="form-control"
                            name="product_name[]" id="product_name" placeholder="Actual product name as listed on the requested platform." required />
                            <span class="text-danger hide">Error message</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12 col-md-4">
                        <div class="ek_group">
                          <label class="eklabel req"><span>Platform :</span></label>
                          <div class="ek_f_input">
                            <select class="form-select" name="platform[]" id="platform" required>
                              <option value="" selected>Select One</option>
                              <option value="flipkart">Flipkart</option>
                              <option value="amazon">Amazon</option>
                              <option value="jiomart">JioMart</option>
                              <option value="ajio">Ajio</option>
                              <option value="meesho">Meesho</option>
                              <option value="myntra">Myntra</option>
                              <option value="nykaa">Nykaa</option>
                              <option value="shopsy">Shopsy</option>
                              <option value="website">Website</option>
                              <option value="">Other</option>
                            </select>
                            <span class="text-danger hide">errr message</span>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12 col-md-4">
                        <div class="ek_group">
                          <label class="eklabel req"><span>Product URL/Link :</span></label>
                          <div class="ek_f_input">
                            <input type="text" class="form-control" name="product_link[]" id="product_link" placeholder="Product page url/link." />
                            <span class="text-danger hide">errr message</span>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12 col-md-4">
                        <div class="ek_group">
                          <label class="eklabel req"><span>Product ID/ASIN:</span></label>
                          <div class="ek_f_input">
                            <input type="text" class="form-control" name="product_id[]" id="product_id" placeholder="Platform specific ID." />
                            <span class="text-danger hide">errr message</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12 col-md-4">
                        <div class="ek_group">
                          <label class="eklabel req"><span>Seller/Brand Name :</span></label>
                          <div class="ek_f_input">
                            <input type="text" class="form-control" name="seller_name[]" id="seller_name" placeholder="Your brand/seller name."><span
                              class="text-danger hide">errr message</span>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12 col-md-8">
                        <div class="ek_group">
                          <label class="eklabel req"><span>Product Search Term :</span></span></label>
                          <div class="ek_f_input">
                            <input type="text" class="form-control"
                              name="search_term[]" id="search_term" placeholder="To search your product on requested platform." />
                            <span class="text-danger hide">errr message</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12 col-md-4">
                        <div class="ek_group">
                          <label class="eklabel req"><span>Product amount :<i
                                class="fas fa-info-circle fa-5x me-3 fs-13"
                                title="Share total product amount including shipping charges, if any. Any mismatch may lead to your request gettng declined."></i></span></label>
                          <div class="ek_f_input">
                            <input type="text" class="form-control"
                              name="amount[]" id="amount" placeholder="Total product amount." />
                            <span class="text-danger hide">errr message</span>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12 col-md-5">
                        <div class="ek_group">
                          <label class="eklabel req"><span>Feedback/Review Title :</span></label>
                          <div class="ek_f_input">
                            <input type="text" class="form-control"
                              name="feedback_title[]" id="feedback_title" placeholder="Title of your feedback review." />
                            <span class="text-danger hide">errr message</span>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12 col-md-3">
                        <div class="ek_group">
                          <label class="eklabel req">Review Rating :</label>
                          <div class="star-rating">
                            <div class="ek_f_input">
                              <div class="star-rating">
                                <span class="star" data-value="1">&#9733;</span>
                                <span class="star" data-value="2">&#9733;</span>
                                <span class="star" data-value="3">&#9733;</span>
                                <span class="star" data-value="4">&#9733;</span>
                                <span class="star" data-value="5">&#9733;</span>
                              </div>
                              <input type="hidden" class="review_rating" name="review_rating[]" id="review_rating" value="">
                              <h6 class="text-danger hide error-message">Error message</h6>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-12 col-md-12">
                          <div class="ek_group">
                            <label class="eklabel req"><span>Feedback/Review comment :</span></label>
                            <div class="ek_f_input">
                              <textarea class="form-control"
                                name="feedback_comment[]" id="feedback_comment" placeholder="Share feedback comment or review of your product as you would like it to be published. A genuine feedback is not more than few lines."></textarea>
                              <span class="text-danger hide">errr message</span>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="saveform_footer">
                        <button type="button" class="btn btn-login btnekomn card_f_btn previous_Tab"><i
                            class="fas fa-arrow-left me-3 fs-13"></i>Back</button>
                        {{-- <button type="button" class="btn btn-login btnekomn card_f_btn next_Tab">Save & Next</button> --}}
                        <button type="button" class="btn btn-login btnekomn card_f_btn" id="shinetab4">Save & Next</button>
                      </div>
                    </div>
                  </div>
                {{-- </form> --}}
              </div>
            </div>
            <div class="tab-pane fade" id="request_5" role="tabpanel" aria-labelledby="request_5-tab" tabindex="0">
              <div class="ek_shine">
                {{-- <form action="" methot="post"> --}}
                  <div class="addProductForm">
                    <input type="hidden" class="form-control" name="batch_id[]" id="batchId5">
                    <input type="hidden" class="form-control" name="request_no[]" id="requestId5">
                    <div class="row">
                      <div class="col-sm-12 col-md-12">
                        <div class="ek_group">
                          <label class="eklabel req"><span>Product Name:</span></label>
                          <div class="ek_f_input">
                            <input type="text" class="form-control"
                            name="product_name[]" id="product_name" placeholder="Actual product name as listed on the requested platform." required />
                            <span class="text-danger hide">Error message</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12 col-md-4">
                        <div class="ek_group">
                          <label class="eklabel req"><span>Platform :</span></label>
                          <div class="ek_f_input">
                            <select class="form-select" name="platform[]" id="platform" required>
                              <option value="" selected>Select One</option>
                              <option value="flipkart">Flipkart</option>
                              <option value="amazon">Amazon</option>
                              <option value="jiomart">JioMart</option>
                              <option value="ajio">Ajio</option>
                              <option value="meesho">Meesho</option>
                              <option value="myntra">Myntra</option>
                              <option value="nykaa">Nykaa</option>
                              <option value="shopsy">Shopsy</option>
                              <option value="website">Website</option>
                              <option value="">Other</option>
                            </select>
                            <span class="text-danger hide">errr message</span>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12 col-md-4">
                        <div class="ek_group">
                          <label class="eklabel req"><span>Product URL/Link :</span></label>
                          <div class="ek_f_input">
                            <input type="text" class="form-control" name="product_link[]" id="product_link" placeholder="Product page url/link." />
                            <span class="text-danger hide">errr message</span>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12 col-md-4">
                        <div class="ek_group">
                          <label class="eklabel req"><span>Product ID/ASIN:</span></label>
                          <div class="ek_f_input">
                            <input type="text" class="form-control" name="product_id[]" id="product_id" placeholder="Platform specific ID." />
                            <span class="text-danger hide">errr message</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12 col-md-4">
                        <div class="ek_group">
                          <label class="eklabel req"><span>Seller/Brand Name :</span></label>
                          <div class="ek_f_input">
                            <input type="text" class="form-control" name="seller_name[]" id="seller_name" placeholder="Your brand/seller name."><span
                              class="text-danger hide">errr message</span>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12 col-md-8">
                        <div class="ek_group">
                          <label class="eklabel req"><span>Product Search Term :</span></span></label>
                          <div class="ek_f_input">
                            <input type="text" class="form-control"
                              name="search_term[]" id="search_term" placeholder="To search your product on requested platform." />
                            <span class="text-danger hide">errr message</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12 col-md-4">
                        <div class="ek_group">
                          <label class="eklabel req"><span>Product amount :<i
                                class="fas fa-info-circle fa-5x me-3 fs-13"
                                title="Share total product amount including shipping charges, if any. Any mismatch may lead to your request gettng declined."></i></span></label>
                          <div class="ek_f_input">
                            <input type="text" class="form-control"
                              name="amount[]" id="amount" placeholder="Total product amount." />
                            <span class="text-danger hide">errr message</span>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12 col-md-5">
                        <div class="ek_group">
                          <label class="eklabel req"><span>Feedback/Review Title :</span></label>
                          <div class="ek_f_input">
                            <input type="text" class="form-control"
                              name="feedback_title[]" id="feedback_title" placeholder="Title of your feedback review." />
                            <span class="text-danger hide">errr message</span>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12 col-md-3">
                        <div class="ek_group">
                          <label class="eklabel req">Review Rating :</label>
                          <div class="star-rating">
                            <div class="ek_f_input">
                              <div class="star-rating">
                                <span class="star" data-value="1">&#9733;</span>
                                <span class="star" data-value="2">&#9733;</span>
                                <span class="star" data-value="3">&#9733;</span>
                                <span class="star" data-value="4">&#9733;</span>
                                <span class="star" data-value="5">&#9733;</span>
                              </div>
                              <input type="hidden" class="review_rating" name="review_rating[]" id="review_rating" value="">
                              <h6 class="text-danger hide error-message">Error message</h6>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-12 col-md-12">
                          <div class="ek_group">
                            <label class="eklabel req"><span>Feedback/Review comment :</span></label>
                            <div class="ek_f_input">
                              <textarea class="form-control"
                                name="feedback_comment[]" id="feedback_comment" placeholder="Share feedback comment or review of your product as you would like it to be published. A genuine feedback is not more than few lines."></textarea>
                              <span class="text-danger hide">errr message</span>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="saveform_footer">
                        <button type="button" class="btn btn-login btnekomn card_f_btn previous_Tab"><i
                            class="fas fa-arrow-left me-3 fs-13"></i>Back</button>
                        <button type="button" class="btn btn-login btnekomn card_f_btn" id="submitShineForm">Submit</button>
                      </div>
                    </div>
                  </div>
                {{-- </form> --}}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="ek_db_footer">&copy; 2024 ekomn.com, All Rights Reserved</div>
@include('dashboard.layout.copyright')
</div>
<script>
  // Go Back
  document.getElementById('cancelButton').addEventListener('click', function() {
    window.location.href = "{{ route('my-shine') }}";
  });
  
  // Star rating
    document.addEventListener('DOMContentLoaded', () => {
      function setupStarRating(tab) {
          const stars = tab.querySelectorAll('.star');
          const reviewRatingInput = tab.querySelector('.review_rating');
  
          stars.forEach(star => {
              star.addEventListener('click', () => {
                  const rating = parseInt(star.getAttribute('data-value'));
                  if (rating >= 4 && rating <= 5) { // Validate rating between 4 and 5
                      reviewRatingInput.value = rating; // Store the rating value in the hidden input
                      stars.forEach((s, index) => {
                          if (index < rating) {
                              s.classList.add('active');
                          } else {
                              s.classList.remove('active');
                          }
                      });
                  } else {
                    // Show SweetAlert2 modal if the rating is out of range
                      Swal.fire({
                          title: 'Invalid Rating',
                          text: 'Please select a rating between 4 and 5.',
                          icon: 'warning',
                          confirmButtonText: 'OK',
                          customClass: {
                            confirmButton: 'custom-confirm-btn'
                          }
                      });
                  }
              });
  
              star.addEventListener('mouseover', () => {
                  const rating = parseInt(star.getAttribute('data-value'));
                  stars.forEach((s, index) => {
                      if (index < rating) {
                          s.classList.add('hover');
                      } else {
                          s.classList.remove('hover');
                      }
                  });
              });
  
              star.addEventListener('mouseout', () => {
                  stars.forEach(s => {
                      s.classList.remove('hover');
                  });
              });
          });
      }
  
      // Setup star rating for each tab
      document.querySelectorAll('.tab-pane').forEach(tab => {
          setupStarRating(tab);
      });
  
    // Generate Batch ID & Request Number
    function generateUniqueBatchId() {
        const letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        const digits = '0123456789';
  
        let batchId = '';
        for (let i = 0; i < 2; i++) {
            batchId += letters.charAt(Math.floor(Math.random() * letters.length));
        }
        for (let i = 0; i < 4; i++) {
            batchId += digits.charAt(Math.floor(Math.random() * digits.length));
        }
        return batchId;
    }
  
    function setBatchAndRequestIds() {
      let uniqueBatchId;
      do {
          uniqueBatchId = generateUniqueBatchId();
      } while (localStorage.getItem(uniqueBatchId)); // Check if ID is unique using localStorage
  
      localStorage.setItem(uniqueBatchId, true); // Mark this ID as used
  
      // Set the same batch ID in all batch ID fields
      for (let i = 1; i <= 5; i++) {
          const batchIdField = document.getElementById(`batchId${i}`);
          if (batchIdField) {
              batchIdField.value = uniqueBatchId; // Set the batch ID in all fields
          }
      }
  
      // Set request IDs in corresponding fields
      for (let i = 1; i <= 5; i++) {
          const requestIdField = document.getElementById(`requestId${i}`);
          if (requestIdField) {
              requestIdField.value = `${uniqueBatchId}${i}`; // Set request ID with batch ID and number
          }
      }
    }
  
    setBatchAndRequestIds();
    });
  
    $(document).ready(function() {
      // Initial setup
      init();
  
      function init() {
          updateTotalAmount();
          bindTabEvents();
          bindSubmitEvent();
      }
  
      function bindTabEvents() {
          for (let i = 1; i <= 5; i++) {
              $(`#shinetab${i}`).click(function() {
                  handleTabClick(i);
              });
          }
      }
  
      function handleTabClick(tabIndex) {
          let isValid = validateForm(tabIndex);
  
          if (isValid) {
              navigateToNextTab(tabIndex);
          }
      }
  
      function navigateToNextTab(currentTabIndex) {
          let nextTabIndex = currentTabIndex + 1;
  
          $(`#request_${currentTabIndex}`).removeClass('show active');
          $(`#request_${nextTabIndex}`).addClass('show active');
  
          $(`a[href="#request_${currentTabIndex}"]`).removeClass('active');
          $(`a[href="#request_${nextTabIndex}"]`).addClass('active');
      }
  
      function bindSubmitEvent() {
          $('#submitShineForm').click(function() {
              if (validateForm(5)) {
                  submitForm();
              }
          });
      }
  
      function validateForm(formNumber) {
          let isValid = true;
  
          // Clear previous error messages
          $('.text-danger').addClass('hide');
  
          const validations = [
              { selector: `#request_${formNumber} #product_name`, rules: ['required', 'maxLength:300', 'noNumbers', 'noEmails', 'noUrls'], message: 'Product Name is required and cannot contain invalid characters.' },
              { selector: `#request_${formNumber} #platform`, rules: ['required'], message: 'Platform is required.' },
              { selector: `#request_${formNumber} #product_link`, rules: ['required', 'isValidURL'], message: 'Valid Product URL/Link is required.' },
              { selector: `#request_${formNumber} #product_id`, rules: ['required', 'maxLength:30', 'noNumbers', 'noEmails', 'noUrls'], message: 'Product ID/ASIN is required and cannot contain invalid characters.' },
              { selector: `#request_${formNumber} #seller_name`, rules: ['required', 'maxLength:20', 'noNumbers', 'noEmails', 'noUrls'], message: 'Seller/Brand Name is required and cannot contain invalid characters.' },
              { selector: `#request_${formNumber} #search_term`, rules: ['required', 'maxLength:200', 'noNumbers', 'noEmails', 'noUrls'], message: 'Product Search Term is required and cannot contain invalid characters.' },
              { selector: `#request_${formNumber} #amount`, rules: ['required', 'isPositiveNumber'], message: 'Valid Product Amount is required.' },
              { selector: `#request_${formNumber} #feedback_title`, rules: ['required', 'maxLength:50', 'noNumbers', 'noEmails', 'noUrls'], message: 'Feedback/Review Title is required and cannot contain invalid characters.' },
              { selector: `#request_${formNumber} #review_rating`, rules: ['required'], message: 'Review Rating is required.' },
              { selector: `#request_${formNumber} #feedback_comment`, rules: ['required', 'maxLength:300', 'noNumbers', 'noEmails', 'noUrls'], message: 'Feedback Comment is required and cannot contain invalid characters.' }
          ];
  
          for (let validation of validations) {
              if (!applyValidation(validation.selector, validation.rules)) {
                  showError(validation.selector, validation.message);
                  isValid = false;
              }
          }
          return isValid;
      }
  
      function applyValidation(selector, rules) {
          let value = $(selector).val().trim();
  
          for (let rule of rules) {
              if (rule === 'required' && value === '') return false;
              if (rule.startsWith('maxLength:') && value.length > parseInt(rule.split(':')[1])) return false;
              if (rule === 'noNumbers' && /^[\d\s\+\-()]+$/.test(value)) return false;
              if (rule === 'noEmails' && /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) return false;
              if (rule === 'noUrls' && /^(https?:\/\/[^\s$.?#].[^\s]*)$/i.test(value)) return false;
              if (rule === 'isValidURL' && !isValidURL(value)) return false;
              if (rule === 'isPositiveNumber' && (isNaN(value) || parseFloat(value) <= 0)) return false;
          }
          return true;
      }
  
      function submitForm() {
      const totalAmount = updateTotalAmount(); // Get the updated total amount

      if (totalAmount < 1000 || totalAmount > 2000) {
        Swal.fire({
            title: 'Invalid Batch Value Limit',
            text: 'The total Batch Value must be between 1000 and 2000.',
            icon: 'warning',
            confirmButtonText: 'OK',
            customClass: {
                confirmButton: 'custom-confirm-btn'
            }
        });
        return; // Stop further execution
      }
      // Show confirmation dialog before proceeding with form submission
      Swal.fire({
          title: 'Are you sure?',
          text: "Do you want to submit this Shine Request?",
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: 'Yes, submit it!',
          cancelButtonText: 'No, cancel!',
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          customClass: {
              confirmButton: 'custom-confirm-btn',
              cancelButton: 'custom-cancel-btn'
          }
      }).then((result) => {
          if (result.isConfirmed) {
              // If user confirms, proceed with form submission
              const formData = new FormData();
              // Append CSRF token to formData
              const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
              formData.append('_token', csrfToken);  // Add CSRF token to the request
              
              for (let i = 1; i <= 5; i++) {
                  collectFormData(formData, i.toString());
              }
  
              $.ajax({
                  url: 'shine-products',
                  type: 'POST',
                  data: formData,
                  processData: false,
                  contentType: false,
                  success: function(response) {
                      showSuccessMessage();
                  },
                  error: function(response) {
                      showErrorMessage();
                  }
              });
          }
      });
    }
  
    function showSuccessMessage() {
      Swal.fire({
          title: 'Success!',
          text: 'Your Shine Request submitted successfully! Now complete your Assigne Shine first...',
          icon: 'success',
          confirmButtonText: 'OK',
          customClass: {
              confirmButton: 'custom-confirm-btn'
          }
      }).then((result) => {
          if (result.isConfirmed) {
              window.location.href = '{{ route('my-shine') }}';
          }
      });
    }
  
    function showErrorMessage() {
      Swal.fire({
          title: 'Error!',
          text: 'There was an error submitting your form. Please try again.',
          icon: 'error',
          confirmButtonText: 'OK',
          customClass: {
              confirmButton: 'custom-error-btn'
          }
      });
    }
  
  
    function validateForm(formNumber) {
        let isValid = true;
  
        // Regular expressions for validation
        const numberRegex = /^[\d\s\+\-()]+$/; // Contains numbers
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Simple email pattern
        const urlRegex = /^(https?:\/\/[^\s$.?#].[^\s]*)$/i; // Simple URL pattern
  
        const productName = $(`#request_${formNumber} #product_name`).val().trim();
        if (productName === "") {
            showError(`request_${formNumber} #product_name`, "Product Name is required.");
            isValid = false;
        } else if (productName.length > 300) {
            showError(`request_${formNumber} #product_name`, "Product Name cannot exceed 300 characters.");
            isValid = false;
        } else if (numberRegex.test(productName)) {
            showError(`request_${formNumber} #product_name`, "Invailid Input.");
            isValid = false;
        } else if (emailRegex.test(productName)) {
            showError(`request_${formNumber} #product_name`, "Product Name cannot contain an email address.");
            isValid = false;
        } else if (urlRegex.test(productName)) {
            showError(`request_${formNumber} #product_name`, "Product Name cannot contain a URL.");
            isValid = false;
        }
  
        const platform = $(`#request_${formNumber} #platform`).val();
        if (platform === "") {
            showError(`request_${formNumber} #platform`, "Platform is required.");
            isValid = false;
        }
  
        const productLink = $(`#request_${formNumber} #product_link`).val().trim();
        if (productLink === "" || !isValidURL(productLink)) {
            showError(`request_${formNumber} #product_link`, "Valid Product URL/Link is required.");
            isValid = false;
        }
  
        const productId = $(`#request_${formNumber} #product_id`).val().trim();
        if (productId === "") {
            showError(`request_${formNumber} #product_id`, "Product ID/ASIN is required.");
            isValid = false;
        } else if (productId.length > 30) {
            showError(`request_${formNumber} #product_id`, "Product ID/ASIN cannot exceed 30 characters.");
            isValid = false;
        } else if (numberRegex.test(productId)) {
            showError(`request_${formNumber} #product_id`, "Invailid Input.");
            isValid = false;
        } else if (emailRegex.test(productId)) {
            showError(`request_${formNumber} #product_id`, "Product ID/ASIN cannot contain an email address.");
            isValid = false;
        } else if (urlRegex.test(productId)) {
            showError(`request_${formNumber} #product_id`, "Product ID/ASIN cannot contain a URL.");
            isValid = false;
        }
  
        const sellerName = $(`#request_${formNumber} #seller_name`).val().trim();
        if (sellerName === "") {
            showError(`request_${formNumber} #seller_name`, "Seller/Brand Name is required.");
            isValid = false;
        } else if (sellerName.length > 20) {
            showError(`request_${formNumber} #seller_name`, "Seller/Brand Name cannot exceed 20 characters.");
            isValid = false;
        } else if (numberRegex.test(sellerName)) {
            showError(`request_${formNumber} #seller_name`, "Invailid Input.");
            isValid = false;
        } else if (emailRegex.test(sellerName)) {
            showError(`request_${formNumber} #seller_name`, "Seller/Brand Name cannot contain an email address.");
            isValid = false;
        } else if (urlRegex.test(sellerName)) {
            showError(`request_${formNumber} #seller_name`, "Seller/Brand Name cannot contain a URL.");
            isValid = false;
        }
  
        const searchTerm = $(`#request_${formNumber} #search_term`).val().trim();
        if (searchTerm === "") {
            showError(`request_${formNumber} #search_term`, "Product Search Term is required.");
            isValid = false;
        } else if (searchTerm.length > 200) {
            showError(`request_${formNumber} #search_term`, "Product Search Term cannot exceed 200 characters.");
            isValid = false;
        } else if (numberRegex.test(searchTerm)) {
            showError(`request_${formNumber} #search_term`, "Invailid Input.");
            isValid = false;
        } else if (emailRegex.test(searchTerm)) {
            showError(`request_${formNumber} #search_term`, "Product Search Term cannot contain an email address.");
            isValid = false;
        } else if (urlRegex.test(searchTerm)) {
            showError(`request_${formNumber} #search_term`, "Product Search Term cannot contain a URL.");
            isValid = false;
        }
  
        const amount = $(`#request_${formNumber} #amount`).val().trim();
        if (amount === "" || isNaN(amount) || parseFloat(amount) <= 0) {
            showError(`request_${formNumber} #amount`, "Valid Product Amount is required.");
            isValid = false;
        } else if (amount <=100) {
            showError(`request_${formNumber} #amount`, "Amount must be at least 100.");
            isValid = false;
        } else if (amount >=500) {
            showError(`request_${formNumber} #amount`, "Amount cannot exceed 500.");
            isValid = false;
        }
  
        const feedbackTitle = $(`#request_${formNumber} #feedback_title`).val().trim();
        if (feedbackTitle === "") {
            showError(`request_${formNumber} #feedback_title`, "Feedback/Review Title is required.");
            isValid = false;
        } else if (feedbackTitle.length > 50) {
            showError(`request_${formNumber} #feedback_title`, "Feedback/Review cannot exceed 50 characters.");
            isValid = false;
        } else if (numberRegex.test(feedbackTitle)) {
            showError(`request_${formNumber} #feedback_title`, "Invailid Input.");
            isValid = false;
        } else if (emailRegex.test(feedbackTitle)) {
            showError(`request_${formNumber} #feedback_title`, "Feedback/Review cannot contain an email address.");
            isValid = false;
        } else if (urlRegex.test(feedbackTitle)) {
            showError(`request_${formNumber} #feedback_title`, "Feedback/Review cannot contain a URL.");
            isValid = false;
        }
  
        const reviewRating = $(`#request_${formNumber} #review_rating`).val();
        if (reviewRating === "") {
            showError(`request_${formNumber} #review_rating`, "Review Rating is required.");
            isValid = false;
        }
        
        const feedbackComment = $(`#request_${formNumber} #feedback_comment`).val();
            if (feedbackComment === "") {
            showError(`request_${formNumber} #feedback_comment`, "Feedback Comment is required.");
            isValid = false;
        } else if (feedbackComment.length > 300) {
            showError(`request_${formNumber} #feedback_comment`, "Feedback Comment cannot exceed 300 characters.");
            isValid = false;
        } else if (numberRegex.test(feedbackComment)) {
            showError(`request_${formNumber} #feedback_comment`, "Invailid Input.");
            isValid = false;
        } else if (emailRegex.test(feedbackComment)) {
            showError(`request_${formNumber} #feedback_comment`, "Feedback Comment cannot contain an email address.");
            isValid = false;
        } else if (urlRegex.test(feedbackComment)) {
            showError(`request_${formNumber} #feedback_comment`, "Feedback Comment cannot contain a URL.");
            isValid = false;
        }
  
        return isValid;
    }
  
    function collectFormData(formData, formNumber) {
        formData.append('batchid[]', $(`#batchId${formNumber}`).val());
        formData.append('request_no[]', $(`#requestId${formNumber}`).val());
        formData.append('product_name[]', $(`#request_${formNumber} #product_name`).val());
        formData.append('platform[]', $(`#request_${formNumber} #platform`).val());
        formData.append('product_link[]', $(`#request_${formNumber} #product_link`).val());
        formData.append('product_id[]', $(`#request_${formNumber} #product_id`).val());
        formData.append('seller_name[]', $(`#request_${formNumber} #seller_name`).val());
        formData.append('search_term[]', $(`#request_${formNumber} #search_term`).val());
        formData.append('amount[]', $(`#request_${formNumber} #amount`).val());
        formData.append('feedback_title[]', $(`#request_${formNumber} #feedback_title`).val());
        formData.append('review_rating[]', $(`#request_${formNumber} #review_rating`).val());
        formData.append('feedback_comment[]', $(`#request_${formNumber} #feedback_comment`).val());
    }
  
    function showError(elementId, errorMessage) {
        $(`#${elementId}`).siblings('.text-danger').removeClass('hide').text(errorMessage);
    }
  
    function isValidURL(string) {
        try {
            new URL(string);
            return true;
        } catch (_) {
            return false;
        }
    }
  
    function updateTotalAmount() {
      let totalAmount = 0;
  
      // Log the beginning of the function execution
      console.log('updateTotalAmount called');
      $('input[name="amount[]"]').each(function() {
          const amount = parseFloat($(this).val());
          console.log(`Processed amount: ${amount}`); // Log each amount being processed
          if (!isNaN(amount)) {
              totalAmount += amount;
          }
      });
      console.log(`Total Amount: ${totalAmount}`); // Log the total amount
      $('.batch_amount').text(`${totalAmount.toFixed(2)}`);
      return totalAmount;
    }
  // Bind the update function to input events on the amount fields
  $('input[name="amount[]"]').on('input', updateTotalAmount);
  // Optionally call updateTotalAmount on page load to set the initial value
  $(document).ready(updateTotalAmount);
});
</script>
@endsection