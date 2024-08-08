@extends('dashboard.layout.app')

@section('content')
<div class="ek_dashboard">
  <div class="ek_content">
    <div class="card ekcard pa pt-2 shadow-sm">
      <input type="hidden" name="order_type" id="order_type" value = "1">
      <input type="hidden" name="order_id" id="order_id" value = "">
      <ul class="nav nav-underline ekom_tab" role="tablist">
        <li class="nav-item" role="presentation">
          <a class="nav-link active" id="dropship-tab" data-bs-toggle="tab" data-bs-target="#dropship" role="tab" aria-controls="dropship" aria-selected="true">Dropship Order</a>
        </li>
        <li class="nav-item" role="presentation">
          <a class="nav-link" id="bulk-tab" data-bs-toggle="tab" data-bs-target="#bulk" role="tab" aria-controls="bulk" aria-selected="false">Bulk Order</a>
        </li>
        <li class="nav-item" role="presentation">
          <a class="nav-link" id="resell-tab" data-bs-toggle="tab" data-bs-target="#resell" role="tab" aria-controls="resell" aria-selected="false">Resell</a>
        </li>
      </ul>
      <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="dropship" role="tabpanel" aria-labelledby="dropship-tab" tabindex="0">
          <form>
            <div class="addProductForm">
              <div class="o_bannerimg">
                <img src="{{asset('assets/images/order/order-banner-1.jpg')}}" alt="" style="width: 100%;" />
              </div>
              <section class="sectionspace">
                <h4 class="subheading">Customer Details</h4>
                <div class="row">
                  <div class="col-sm-12 col-md-4">
                    <div class="ek_group">
                      <label class="eklabel req">
                        <span>Full Name:<span class="req_star">*</span></span>
                      </label>
                      <div class="ek_f_input">
                        <input type="text" class="form-control" id="full_name" placeholder="Enter Full Name" />
                        <div id="full_nameErr" class="invalid-feedback"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4">
                    <div class="ek_group">
                      <label class="eklabel req"><span>Email Address:</span></label>
                      <div class="ek_f_input">
                        <input type="text" id="email" class="form-control" placeholder="Email Address" />
                        <div id="emailErr" class="invalid-feedback"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4">
                    <div class="ek_group">
                      <label class="eklabel req">
                        <span>Phone Number:<span class="req_star">*</span></span>
                      </label>
                      <div class="ek_f_input">
                        <input type="text" id="mobile"  class="form-control" placeholder="Phone Number" />
                        <div id="mobileErr" class="invalid-feedback"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4">
                    <div class="ek_group">
                      <label class="eklabel req">
                        <span>Store Order:</span>
                      </label>
                      <div class="ek_f_input">
                        <input type="text" id="storeOrder"  class="form-control" placeholder="Channel Order ID like Amazon" />
                        <div id="storeOrderErr" class="invalid-feedback"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
              <section class="sectionspace">
                <h4 class="subheading">Delivery Address</h4>
                <div class="row">
                  <div class="col-sm-12 col-md-12">
                    <div class="ek_group">
                      <label class="eklabel req">
                        <span>Street Address:<span class="req_star">*</span></span>
                      </label>
                      <div class="ek_f_input">
                        <input type="text" id="address" class="form-control" placeholder="Enter Street Address" />
                        <div id="addressErr" class="invalid-feedback"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4">
                    <div class="ek_group">
                      <label class="eklabel req">
                        <span>State:<span class="req_star">*</span></span>
                      </label>
                      <div class="ek_f_input">
                        <select class="form-select" class="state" id="state">
                          <option value="" selected>Select State</option>
                        </select>
                        <div id="stateErr" class="invalid-feedback"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4">
                    <div class="ek_group">
                      <label class="eklabel req">
                        <span>City:<span class="req_star">*</span></span>
                      </label>
                      <div class="ek_f_input">
                        <select class="form-select" id="city">
                          <option value="" selected>Select City</option>
                        </select>
                        <div id="cityErr" class="invalid-feedback"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4">
                    <div class="ek_group">
                      <label class="eklabel req">
                        <span>Pin Code:<span class="req_star">*</span></span>
                      </label>
                      <div class="ek_f_input">
                        <input type="text" id="pin_code" class="form-control" placeholder="Enter Pin Code" />
                        <div id="pin_codeErr" class="invalid-feedback"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
              <section class="sectionspace">
                <h4 class="subheading subheadingFlex">
                  Billing Address
                  <div class="fw-normal">
                    <input class="form-check-input" type="checkbox" id="sameas" />
                    <label for="sameas" class="w-normal m-0">Same as delivery address</label>
                  </div>
                </h4>
                <div class="row">
                  <div class="col-sm-12 col-md-12">
                    <div class="ek_group">
                      <label class="eklabel req">
                        <span>Street Address:<span class="req_star">*</span></span>
                      </label>
                      <div class="ek_f_input">
                        <input type="text" id="b_address"  class="form-control" placeholder="Enter Street Address" />
                        <div id="b_addressErr" class="invalid-feedback"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4">
                    <div class="ek_group">
                      <label class="eklabel req">
                        <span>State:<span class="req_star">*</span></span>
                      </label>
                      <div class="ek_f_input">
                        <select class="form-select" class="state" id="b_state">
                          <option value="" selected>Select State</option>

                        </select>
                        <div id="b_stateErr" class="invalid-feedback"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4">
                    <div class="ek_group">
                      <label class="eklabel req">
                        <span>City:<span class="req_star">*</span></span>
                      </label>
                      <div class="ek_f_input">
                        <select class="form-select" id="b_city">
                          <option value="" selected>Select City</option>
                        </select>
                        <div id="b_cityErr" class="invalid-feedback">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4">
                    <div class="ek_group">
                      <label class="eklabel req">
                        <span>Pin Code:<span class="req_star">*</span></span>
                      </label>
                      <div class="ek_f_input">
                        <input type="text" id="b_pin_code" class="form-control" placeholder="Enter Pin Code" />
                        <div id="b_pin_codeErr" class="invalid-feedback"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
              <section class="sectionspace pb-2">
                <div class="ek_group mb-1">
                  <label class="eklabel m-0">
                    <span>Product SKU :<span class="req_star">*</span></span>
                  </label>
                  <div class="ek_f_input sku_inline">
                      <div class="sku_list">
                          <input type="text" class="form-control" name="sku" id="sku"  value="" placeholder="Enter Product SKU" />
                          <div id="skuError" class="invalid-feedback"></div>
                      </div>
                      <button class="btn addSkuBtn mt-0 btn-sm px-3 bold" type="button"
                          id="addDropshipSKU">Add</button>
                  </div>
                </div>
                <div class="d-flex justify-content-between">
                  <h4 class="subheading mb-2">Product Details</h4>
                  <div class="upload-original-invoice">
                    <input type="file" id="UploadInvoice" class="upload_invoice" accept=".pdf" style="display: none;">
                    <div class="d-flex gap-2 align-items-center">
                      <div class="UploadInvoiceName fs-14 opacity-75" id=""></div>
                      <div id="UploadInvoiceErr" class="text-danger"></div>
                      <label for="UploadInvoice" class="file-label invice m-0">
                        <span class="file-label-text">Upload Original Invoice</span>
                      </label>
                    </div>
                  </div>
                </div>
                <div class="table-responsive">
                  <table class="payInvoiceTable" id="dropshipInvoice">
                    <thead>
                      <tr>
                        <th>Product Title</th>
                        <th class="text-center">Stock</th>
                        <th class="text-center">SKU</th>
                        <th class="text-center">HSN</th>
                        <th class="text-center">Qty</th>
                        <th class="text-right">Price/piece</th>
                        <th class="text-right">GST%</th>
                        <th class="text-right">Total Price</th>
                      </tr>
                    </thead>
                    <tbody>
                      <!-- Dynamic table data -->
                    </tbody>
                  </table>
                </div>
                <div class="text-right d-flex justify-content-end mt30">
                  <button type="button" id="dropship-order" class="btn btn-login btnekomn card_f_btn payment_button"><i class="fas fa-rupee-sign me-1"></i>0.00 Pay</button>
                </div>
              </section>
            </div>
          </form>
        </div>
        <div class="tab-pane fade" id="bulk" role="tabpanel" aria-labelledby="bulk-tab" tabindex="0">
          
          <form action="#">
            <div class="addProductForm">
          
              <div class="addProductForm">
                <div class="o_bannerimg">
                  <img src="assets/images/order/order-banner-1.jpg" alt="" style="width: 100%;" />
                </div>
                <section class="sectionspace">
                  <h4 class="subheading">Customer Details</h4>
                  <div class="row">
                    <div class="col-sm-12 col-md-4">
                      <div class="ek_group">
                        <label class="eklabel req">
                          <span>Full Name:<span class="req_star">*</span></span>
                        </label>
                        <div class="ek_f_input">
                          <input type="text" class="form-control" value="{{ auth()->user()->companyDetails->business_name }}" readonly="readonly" />
                          <span class="text-danger hide">errr message</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                      <div class="ek_group">
                        <label class="eklabel req"><span>Email Address:</span></label>
                        <div class="ek_f_input">
                          <input type="text" class="form-control" value="{{ auth()->user()->companyDetails->email}}" readonly="readonly" />
                          <span class="text-danger hide">errr message</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                      <div class="ek_group">
                        <label class="eklabel req">
                          <span>Phone Number:<span class="req_star">*</span></span>
                        </label>
                        <div class="ek_f_input">
                          <input type="text" class="form-control" value="{{auth()->user()->companyDetails->mobile_no}}" readonly="readonly" />
                          <span class="text-danger hide">errr message</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </section>
                <section class="sectionspace">
                  <h4 class="subheading">Delivery Address</h4>
                  <div class="row">
                    <div class="col-sm-12 col-md-12">
                      <div class="ek_group">
                        <label class="eklabel req">
                          <span>Street Address:<span class="req_star">*</span></span>
                        </label>
                        <div class="ek_f_input">
                          <input type="text" class="form-control" value="{{ isset($delivery_address) ? $delivery_address->address_line1 : '' }}" readonly="readonly" />
                          <span class="text-danger hide">errr message</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                      <div class="ek_group">
                        <label class="eklabel req">
                          <span>State:<span class="req_star">*</span></span>
                        </label>
                        <div class="ek_f_input">
                          <input type="text" class="form-control" value="{{ isset($delivery_address) ? $delivery_address->state : '' }}" readonly="readonly" />
                          <span class="text-danger hide">errr message</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                      <div class="ek_group">
                        <label class="eklabel req">
                          <span>City:<span class="req_star">*</span></span>
                        </label>
                        <div class="ek_f_input">
                          <input type="text" class="form-control" value="{{ isset($delivery_address) ? $delivery_address->city : '' }}" readonly="readonly" />
                          <span class="text-danger hide">errr message</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                      <div class="ek_group">
                        <label class="eklabel req">
                          <span>Pin Code:<span class="req_star">*</span></span>
                        </label>
                        <div class="ek_f_input">
                          <input type="text" id="pinCodeBulk" class="form-control" value="{{ isset($delivery_address) ? $delivery_address->pincode : '' }}" readonly="readonly" />
                          <span class="text-danger hide">errr message</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </section>
                <section class="sectionspace">
                  <h4 class="subheading subheadingFlex">
                    Billing Address
                  </h4>
                  <div class="row">
                    <div class="col-sm-12 col-md-12">
                      <div class="ek_group">
                        <label class="eklabel req">
                          <span>Street Address:<span class="req_star">*</span></span>
                        </label>
                        <div class="ek_f_input">
                          <input type="text" class="form-control" value="{{ isset($billing_address) ? $billing_address->address_line1 : '' }}" readonly="readonly" />
                          <span class="text-danger hide">errr message</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                      <div class="ek_group">
                        <label class="eklabel req">
                          <span>State:<span class="req_star">*</span></span>
                        </label>
                        <div class="ek_f_input">
                          <input type="text" class="form-control" value="{{ isset($billing_address) ? $billing_address->state : '' }}" readonly="readonly" />
                          <span class="text-danger hide">errr message</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                      <div class="ek_group">
                        <label class="eklabel req">
                          <span>City:<span class="req_star">*</span></span>
                        </label>
                        <div class="ek_f_input">
                          <input type="text" class="form-control" value="{{ isset($billing_address) ? $billing_address->city : '' }}" readonly="readonly" />
                          <span class="text-danger hide">errr message</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                      <div class="ek_group">
                        <label class="eklabel req">
                          <span>Pin Code:<span class="req_star">*</span></span>
                        </label>
                        <div class="ek_f_input">
                          <input type="text" class="form-control" value="{{ isset($billing_address) ? $billing_address->pincode : '' }}" readonly="readonly" />
                          <span class="text-danger hide">errr message</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </section>
                <section class="sectionspace">
                  <div class="row">
                    <div class="col-sm-12 col-md-4">
                      <div class="ek_group">
                        <label class="eklabel req">
                          <span>GST Number:<span class="req_star">*</span></span>
                        </label>
                        <div class="ek_f_input">
                          <input type="text" class="form-control" value="{{auth()->user()->companyDetails->gst_no}}" readonly="readonly" />
                          <span class="text-danger hide">errr message</span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="ek_group mb-1">
                    <label class="eklabel m-0">
                      <span>Product SKU :<span class="req_star">*</span></span>
                    </label>
                    <div class="ek_f_input sku_inline">
                      <div class="sku_list">
                          <input type="text" class="form-control" name="sku2" id="sku2"  value="" placeholder="Enter Product SKU" />
                          <div id="sku2Error" class="invalid-feedback"></div>
                      </div>
                      <button class="btn addSkuBtn mt-0 btn-sm px-3 bold" type="button"
                          id="addBulkSKU">Add</button>
                    </div>
                  </div>
                  {{--<div class="d-flex justify-content-between">
                    <h4 class="subheading mb-2">Product Details</h4>
                    <div class="upload-original-invoice">
                      <input type="file" id="UploadInvoiceBulk" class="upload_invoice" accept=".pdf" style="display: none;">
                      <div class="d-flex gap-2 align-items-center">
                        <div class="UploadInvoiceName fs-14 opacity-75"></div>
                        <div id="UploadInvoiceBulkErr" class="text-danger"></div>
                        <label for="UploadInvoiceBulk" class="file-label invice m-0">
                          <span class="file-label-text">Upload Original Invoice</span>
                        </label>
                      </div>
                    </div>
                  </div>--}}
                  <div class="table-responsive">
                    <table class="payInvoiceTable" id="bulkInvoice">
                      <thead>
                        <tr>
                          <th>Product Title</th>
                          <th class="text-center">Stock</th>
                          <th>SKU</th>
                          <th>HSN</th>
                          <th class="text-center">Qty</th>
                          <th class="text-right">Price/piece</th>
                          <th class="text-right">GST%</th>
                          <th class="text-right">Total Price</th>
                        </tr>
                      </thead>
                      <tbody>
                        <!-- Dynamic table data -->
                      </tbody>
                    </table>
                  </div>
                  <div class="text-right d-flex justify-content-end mt30">
                    <button type="button" id="bulk-order" class="btn btn-login btnekomn card_f_btn payment_button"><i class="fas fa-rupee-sign me-1"></i>0.00 Pay</button>
                  </div>
                </section>
              </div>
            </div>
          </form>
        </div>
        <div class="tab-pane fade" id="resell" role="tabpanel" aria-labelledby="resell-tab" tabindex="0">
          <form action="">
            <div class="addProductForm">
              <div class="o_bannerimg">
                <img src="assets/images/order/order-banner-1.jpg" alt="" style="width: 100%;" />
              </div>
              <section class="sectionspace">
                <h4 class="subheading">Customer Details</h4>
                <div class="row">
                  <div class="col-sm-12 col-md-4">
                    <div class="ek_group">
                      <label class="eklabel req">
                        <span>Full Name:<span class="req_star">*</span></span>
                      </label>
                      <div class="ek_f_input">
                        <input type="text" id="resell-full-name" class="form-control" placeholder="Enter Full Name" />
                        <div id="resell-full-nameErr" class="invalid-feedback"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4">
                    <div class="ek_group">
                      <label class="eklabel req"><span>Email Address:</span></label>
                      <div class="ek_f_input">
                        <input type="text" id="resell-email" class="form-control" placeholder="Email Address" />
                        <div id="resell-emailErr" class="invalid-feedback"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4">
                    <div class="ek_group">
                      <label class="eklabel req">
                        <span>Phone Number:<span class="req_star">*</span></span>
                      </label>
                      <div class="ek_f_input">
                        <input type="text" id="resell-mobile" class="form-control" placeholder="Phone Number" />
                        <div id="resell-mobileErr" class="invalid-feedback"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4">
                    <div class="ek_group">
                      <label class="eklabel req">
                        <span>Store Order:</span>
                      </label>
                      <div class="ek_f_input">
                        <input type="text" id="storeOrderReseller"  class="form-control" placeholder="Channel Order ID like Amazon" />
                        <div id="storeOrderResellerErr" class="invalid-feedback"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
              <section class="sectionspace">
                <h4 class="subheading">Delivery Address</h4>
                <div class="row">
                  <div class="col-sm-12 col-md-12">
                    <div class="ek_group">
                      <label class="eklabel req">
                        <span>Street Address:<span class="req_star">*</span></span>
                      </label>
                      <div class="ek_f_input">
                        <input type="text" id="resell-d-address" class="form-control" placeholder="Enter Street Address" />
                        <div id="resell-d-addressErr" class="invalid-feedback"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4">
                    <div class="ek_group">
                      <label class="eklabel req">
                        <span>State:<span class="req_star">*</span></span>
                      </label>
                      <div class="ek_f_input">
                        <select class="form-select" id="resell-d-state">
                          <option value="" selected>Select State</option>
                        </select>
                        <div id="resell-d-stateErr" class="invalid-feedback"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4">
                    <div class="ek_group">
                      <label class="eklabel req">
                        <span>City:<span class="req_star">*</span></span>
                      </label>
                      <div class="ek_f_input">
                        <select class="form-select" id="resell-d-city">
                          <option value="" selected>Select City</option>
                        </select>
                        <div id="resell-d-cityErr" class="invalid-feedback"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4">
                    <div class="ek_group">
                      <label class="eklabel req">
                        <span>Pin Code:<span class="req_star">*</span></span>
                      </label>
                      <div class="ek_f_input">
                        <input type="text" class="form-control" id="resell-d-pincode" placeholder="Enter Pin Code" />
                        <div id="resell-d-pincodeErr" class="invalid-feedback"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
              <section class="sectionspace">
                <h4 class="subheading subheadingFlex">
                  Billing Address
                  <div class="fw-normal">
                    <input class="form-check-input" type="checkbox" id="sameas_3" />
                    <div id="resell-b-addressErr" class="invalid-feedback"></div>
                    <label for="sameas_3" class="fw-normal m-0">Same as delivery address</label>
                  </div>
                </h4>
                <div class="row">
                  <div class="col-sm-12 col-md-12">
                    <div class="ek_group">
                      <label class="eklabel req">
                        <span>Street Address:<span class="req_star">*</span></span>
                      </label>
                      <div class="ek_f_input">
                        <input type="text" class="form-control" id="resell-b-address" placeholder="Enter Street Address" />
                        <div id="resell-b-addressErr" class="invalid-feedback"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4">
                    <div class="ek_group">
                      <label class="eklabel req">
                        <span>State:<span class="req_star">*</span></span>
                      </label>
                      <div class="ek_f_input">
                        <select class="form-select" id="resell-b-state">
                          <option value="" selected>Select State</option>
                        </select>
                        <div id="resell-b-stateErr" class="invalid-feedback"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4">
                    <div class="ek_group">
                      <label class="eklabel req">
                        <span>City:<span class="req_star">*</span></span>
                      </label>
                      <div class="ek_f_input">
                        <select class="form-select" id="resell-b-city">
                          <option value="" selected>Select City</option>
                        </select>
                        <div id="resell-b-cityErr" class="invalid-feedback"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4">
                    <div class="ek_group">
                      <label class="eklabel req">
                        <span>Pin Code:<span class="req_star">*</span></span>
                      </label>
                      <div class="ek_f_input">
                        <input type="text" class="form-control" id="resell-b-pincode" placeholder="Enter Pin Code" />
                        <div id="resell-b-pincodeErr" class="invalid-feedback"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
              <section class="sectionspace">
                <div class="ek_group mb-1">
                    <label class="eklabel m-0">
                      <span>Product SKU :<span class="req_star">*</span></span>
                    </label>
                    <div class="ek_f_input sku_inline">
                      <div class="sku_list">
                          <input type="text" class="form-control" name="sku3" id="sku3"  value="" placeholder="Enter Product SKU" />
                          <div id="sku3Error" class="invalid-feedback"></div>
                      </div>
                      <button class="btn addSkuBtn mt-0 btn-sm px-3 bold" type="button"
                          id="addResellerSKU">Add</button>
                    </div>
                  </div>
                <div class="d-flex justify-content-between">
                  <h4 class="subheading mb-2">Product Details</h4>
                  <div class="upload-original-invoice">
                  <span class="" style="padding-left: 20px; font-size:12px">(Optional)</span>
                    <input type="file" id="UploadInvoiceResell" class="upload_invoice" accept=".pdf" style="display: none;">
                    <div class="d-flex gap-2 align-items-center">
                      <div class="UploadInvoiceName fs-14 opacity-75"></div>
                      <div id="UploadInvoiceResellErr" class="text-danger"></div>
                      <label for="UploadInvoiceResell" class="file-label invice m-0">
                        <span class="file-label-text">Upload Original Invoice</span>
                      </label>
                    </div>
                  </div>
                </div>
                <div class="table-responsive">
                  <table class="payInvoiceTable" id="resellInvoice">
                    <thead>
                      <tr>
                        <th>Product Title</th>
                        <th class="text-center">Stock</th>
                        <th>SKU</th>
                        <th>HSN</th>
                        <th class="text-center">Qty</th>
                        <th class="text-right">Price/piece</th>
                        <th class="text-right">GST%</th>
                        <th class="text-right">Total Price</th>
                      </tr>
                    </thead>
                    <tbody>
                      <!-- Dynamic table data -->
                    </tbody>
                  </table>
                </div>
                <div class="text-right d-flex justify-content-end mt30">
                  <button type="button" id="resell-order" class="btn btn-login btnekomn card_f_btn payment_button"><i class="fas fa-rupee-sign me-1"></i>0.00 Pay</button>
                </div>
              </section>
            </div>
          </form>
        </div>
    </div>
  </div>
  @include('dashboard.layout.copyright')
</div>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
  // Upload Invoice 
  document.addEventListener('change', function(event) {
    if (event.target.classList.contains('upload_invoice')) {
      const invoice = event.target.closest('.upload-original-invoice');
      const invoiceName = invoice.querySelector('.UploadInvoiceName');
      const invoicefileName = event.target.files[0]?.name || '';
      invoiceName.textContent = invoicefileName;
    }
  });
  // end upload Invoice
</script>
<script>
  $(document).ready(function() {
    const businessNameRegex = /^[a-zA-Z0-9 ,.\\-]+$/;
    const gstRegex = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/;
    const nameRegex = /^[a-zA-Z\s\-\.']+$/;
    const addressRegex = /^[a-zA-Z0-9\s,.'\-\/]+$/;
    const pinCodeRegex = /^[0-9]{6}$/;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const mobileRegex = /^[6-9]\d{9}$/;

    // Droship Order Validation

    ApiRequest('state-city-list', 'GET')
      .then(res => {
        const stateList = res.data.state;
        stateList.forEach(state => {
          $('#state').append(`<option value="${state.id}">${state.name}</option>`);
          $('#b_state').append(`<option value="${state.id}">${state.name}</option>`);
        });

      })
      .catch(error => {
        console.error(error);
      });

    $('#state').change(function() {
      const stateId = $(this).val();
      $('#city').html('<option value="">Select City</option>');
      ApiRequest(`state-city-list/?id=${stateId}`, 'GET')
        .then(res => {
          const cityList = res.data.city;
          cityList.forEach(city => {
            $('#city').append(`<option value="${city.id}">${city.name}</option>`);
          });
        })
        .catch(error => {
          console.error(error);
        });
    });

    $('#b_state').change(function() {
      const stateId = $(this).val();
      $('#b_city').html('<option value="">Select City</option>');
      ApiRequest(`state-city-list/?id=${stateId}`, 'GET')
        .then(res => {
          const cityList = res.data.city;
          cityList.forEach(city => {
            $('#b_city').append(`<option value="${city.id}">${city.name}</option>`);
          });
        })
        .catch(error => {
          console.error(error);
        });
    });

    var checkbtn = document.getElementById('sameas');
    checkbtn.addEventListener('change', function() {
      if ($(this).prop("checked")) {
        // Code to execute when checkbox is checked
        $('#b_address').val($('#address').val()).attr('disabled', true);
        $('#b_state').val($('#state').val()).attr('disabled', true);
        var selectedOption = $('#city option:selected');
        var value = selectedOption.val();
        var text = selectedOption.text();
        $('#b_city').append(`<option value="${value}" selected>${text}</option>`).attr('disabled', true);
        $('#b_pin_code').val($('#pin_code').val()).attr('disabled', true);
      } else {
        // Code to execute when checkbox is unchecked
        $('#b_address').val('').attr('disabled', false);
        $('#b_state').val('').attr('disabled', false);
        $('#b_city').html('<option value="">Select City</option>').attr('disabled', false);
        $('#b_pin_code').val('').attr('disabled', false);
      }
    });


    function clearError() {
      const fields = ['full_name', 'email', 'mobile', 'address', 'state', 'city', 'pin_code', 'b_pin_code', 'b_address', 'b_state', 'b_city', 'b_pin_code', 'b_pin_code'];
      fields.forEach(field => {
        $(`#${field}`).removeClass('is-invalid');
        $(`#${field}Err`).text('');
      });
    }

    $('#dropship-order').click(function() {
      var isvalid = true;
      clearError();
      if (!$('#full_name').val()) {
        $('#full_name').addClass('is-invalid');
        $('#full_nameErr').text('Please enter full name');
        isvalid = false;
      } else if (!nameRegex.test($('#full_name').val())) {
        $('#full_name').addClass('is-invalid');
        $('#full_nameErr').text('Please enter valid full name');
        isvalid = false;
      }

      if ($('#email').val()) {
       if(!emailRegex.test($('#email').val())) {
        $('#email').addClass('is-invalid');
        $('#emailErr').text('Please enter valid email');
        isvalid = false;
      }
    }

      if (!$('#mobile').val()) {
        $('#mobile').addClass('is-invalid');
        $('#mobileErr').text('Please enter phone');
        isvalid = false;
      } else if (!mobileRegex.test($('#mobile').val())) {
        $('#mobile').addClass('is-invalid');
        $('#mobileErr').text('Please enter valid phone');
        isvalid = false;
      }

      if (!$('#address').val()) {
        $('#address').addClass('is-invalid');
        $('#addressErr').text('Please enter address');
        isvalid = false;
      } else if (!addressRegex.test($('#address').val())) {
        $('#address').addClass('is-invalid');
        $('#addressErr').text('Please enter valid address');
        isvalid = false;
      }

      if (!$('#state').val()) {
        $('#state').addClass('is-invalid');
        $('#stateErr').text('Please enter state');
        isvalid = false;
      }

      if (!$('#city').val()) {
        $('#city').addClass('is-invalid');
        $('#cityErr').text('Please enter city');
        isvalid = false;
      }

      if (!$('#pin_code').val()) {
        $('#pin_code').addClass('is-invalid');
        $('#pin_codeErr').text('Please enter pin code');
        isvalid = false;
      } else if (!pinCodeRegex.test($('#pin_code').val())) {
        $('#pin_code').addClass('is-invalid');
        $('#pin_codeErr').text('Please enter valid pin code');
        isvalid = false;
      }

      if (!$('#b_address').val()) {
        $('#b_address').addClass('is-invalid');
        $('#b_addressErr').text('Please enter address');
        isvalid = false
      } 
      // else if (!addressRegex.test($('#b_address').val())) {
      //   $('#b_address').addClass('is-invalid');
      //   $('#b_addressErr').text('Please enter valid address');
      //   isvalid = false;
      // }

      if (!$('#b_state').val()) {
        $('#b_state').addClass('is-invalid');
        $('#b_stateErr').text('Please enter state');
        isvalid = false;
      }

      if (!$('#b_city').val()) {
        $('#b_city').addClass('is-invalid');
        $('#b_cityErr').text('Please enter city');
        isvalid = false;
      }

      if (!$('#b_pin_code').val()) {
        $('#b_pin_code').addClass('is-invalid');
        $('#b_pin_codeErr').text('Please enter pin code');
        isvalid = false;
      } else if (!pinCodeRegex.test($('#b_pin_code').val())) {
        $('#b_pin_code').addClass('is-invalid');
        $('#b_pin_codeErr').text('Please enter valid pin code');
        isvalid = false;
      }
      

      const fileInput = $('#UploadInvoice')[0];
      const file = fileInput.files[0];
      // Check if a file is selected
      if (!file) {
        $('#UploadInvoiceErr').text('Please upload an invoice file.');
        isvalid = false;
      }
      fileInput.addEventListener('change', function() {
        const file = fileInput.files[0];
        // Check if a file is selected
        if (file) {
          $('#UploadInvoiceErr').text('');
          isvalid = true;
        }
      });

      //--------------------Dropship Order Submit--------------------
      
      if(isvalid){
        var formData = new FormData();
        formData.append('full_name', $('#full_name').val());
        formData.append('email', $('#email').val());
        formData.append('mobile', $('#mobile').val());
        formData.append('store_order', $('#storeOrder').val());
        formData.append('address', $('#address').val());
        formData.append('state', $('#state').val());
        formData.append('city', $('#city').val());
        formData.append('pincode', $('#pin_code').val());
        formData.append('b_address', $('#b_address').val());
        formData.append('b_state', $('#b_state').val());
        formData.append('b_city', $('#b_city').val());
        formData.append('b_pincode', $('#b_pin_code').val());
        formData.append('invoice', file);
        formData.append('order_type', $('#order_type').val());
        formData.append('order_id', $('#order_id').val());
        $(this).attr('disabled',true);
        ApiRequest('orders', 'POST', formData)
          .then(response => {
            if (response.data.statusCode == 200) {
              const payment = response.data.data;
              $('#order_id').val(payment.order_id);
              var options = {
                  "key": "{{env('RAZORPAY_KEY')}}", // Enter the Key ID generated from the Dashboard
                  "amount": payment.total_amount, // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
                  "currency": payment.currency,
                  "name": "{{env('APP_NAME')}}", //your business name
                  "description": "Create payment for order by Ekomn Platform",
                  "image": "{{asset('assets/images/Logo.svg')}}",
                  "order_id": payment.razorpy_order_id, //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
                  "callback_url": "{{route('order.payment.success')}}",
                  "prefill": { //We recommend using the prefill parameter to auto-fill customer's contact information especially their phone number
                      "name": payment.full_name, //your customer's name
                      "email": payment.email, //your customer's email
                      "contact": payment.mobile_number //Provide the customer's phone number for better conversion rates 
                  },
                  "notes": {
                      "address": "Gurugram, Haryana India"
                  },
                  "theme": {
                      "color": "#FECA40"
                  }
              };
              var rzp1 = new Razorpay(options);
              rzp1.open();
            }
            else if (response.data.statusCode == 422) {
              $(this).attr('disabled',false);
                const field = response.data.key;
                $(`#${field}`).addClass('is-invalid');
                $(`#${field}Err`).text(response.data.message);
            } else if(response.data.statusCode == 201){
              $(this).attr('disabled',false);
               // Handle error
               Swal.fire({
                    title: 'Error',
                    text: response.data.message,
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
          })
          .catch(error => {
            $(this).attr('disabled',false);
            console.error(error);
          });
      }
    });

  //--------------------Bulk Order Submit--------------------

    $('#bulk-order').click(function() {
      clearError();
      var formData = new FormData();
      formData.append('order_type', $('#order_type').val());
      formData.append('pincode', $('#pinCodeBulk').val());
      formData.append('order_id', $('#order_id').val());
      $(this).attr('disabled',true);
      ApiRequest('orders', 'POST', formData)
          .then(response => {
            if (response.data.statusCode == 200) {
              const payment = response.data.data;
              $('#order_id').val(payment.order_id);
              var options = {
                  "key": "{{env('RAZORPAY_KEY')}}", // Enter the Key ID generated from the Dashboard
                  "amount": payment.total_amount, // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
                  "currency": payment.currency,
                  "name": "{{env('APP_NAME')}}", //your business name
                  "description": "Create payment for order by Ekomn Platform",
                  "image": "{{asset('assets/images/Logo.svg')}}",
                  "order_id": payment.razorpy_order_id, //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
                  "callback_url": "{{route('order.payment.success')}}",
                  "prefill": { //We recommend using the prefill parameter to auto-fill customer's contact information especially their phone number
                      "name": payment.full_name, //your customer's name
                      "email": payment.email, //your customer's email
                      "contact": payment.mobile_number //Provide the customer's phone number for better conversion rates 
                  },
                  "notes": {
                      "address": "Gurugram, Haryana India"
                  },
                  "theme": {
                      "color": "#FECA40"
                  }
              };
              var rzp1 = new Razorpay(options);
              rzp1.open();
            }
            else if (response.data.statusCode == 422) {
            $(this).attr('disabled',false);
                const field = response.data.key;
                $(`#${field}`).addClass('is-invalid');
                $(`#${field}Err`).text(response.data.message);
            } else if(response.data.statusCode == 201){
            $(this).attr('disabled',false);
               // Handle error
               Swal.fire({
                    title: 'Error',
                    text: response.data.message,
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
          })
          .catch(error => {
            $(this).attr('disabled',false);
            console.error(error);
          });
    });

    // Resell Order 

    ApiRequest('state-city-list', 'GET')
      .then(res => {
        const stateList = res.data.state;
        stateList.forEach(state => {
          $('#resell-d-state').append(`<option value="${state.id}">${state.name}</option>`);
          $('#resell-b-state').append(`<option value="${state.id}">${state.name}</option>`);
        });

      })
      .catch(error => {
        console.error(error);
      });

      
    $('#resell-d-state').change(function() {
      const stateId = $(this).val();
      $('#resell-d-city').html('<option value="">Select City</option>');
      ApiRequest(`state-city-list/?id=${stateId}`, 'GET')
        .then(res => {
          const cityList = res.data.city;
          cityList.forEach(city => {
            $('#resell-d-city').append(`<option value="${city.id}">${city.name}</option>`);
          });
        })
        .catch(error => {
          console.error(error);
        });
    });

    $('#resell-b-state').change(function() {
      const stateId = $(this).val();
      $('#resell-b-city').html('<option value="">Select City</option>');
      ApiRequest(`state-city-list/?id=${stateId}`, 'GET')
        .then(res => {
          const cityList = res.data.city;
          cityList.forEach(city => {
            $('#resell-b-city').append(`<option value="${city.id}">${city.name}</option>`);
          });
        })
        .catch(error => {
          console.error(error);
        });
    });

    var checkbtn3 = document.getElementById('sameas_3');
    checkbtn3.addEventListener('change', function() {
      if ($(this).prop("checked")) {
        // Code to execute when checkbox is checked
        $('#resell-b-address').val($('#resell-d-address').val()).attr('disabled', true);
        $('#resell-b-state').val($('#resell-d-state').val()).attr('disabled', true);
        var selectedOption = $('#resell-d-city option:selected');
        var value = selectedOption.val();
        var text = selectedOption.text();
        $('#resell-b-city').append(`<option value="${value}" selected>${text}</option>`).attr('disabled', true);
        $('#resell-b-pincode').val($('#resell-d-pincode').val()).attr('disabled', true);
      } else {
        // Code to execute when checkbox is unchecked
        $('#resell-b-address').val('').attr('disabled', false);
        $('#resell-b-state').val('').attr('disabled', false);
        $('#resell-b-city').html('<option value="">Select City</option>').attr('disabled', false);
        $('#resell-b-pincode').val('').attr('disabled', false);
      }
    });
  

    function clearErrorResell() {
      const fields = ['resell-full-name', 'resell-email', 'resell-mobile', 'resell-d-address', 'resell-d-state', 'resell-d-city', 'resell-d-pincode', 'resell-b-address', 'resell-b-state', 'resell-b-city', 'resell-b-pincode'];
      fields.forEach(field => {
        $(`#${field}`).removeClass('is-invalid');
        $(`#${field}Err`).text('');
      });
    }

    // Resell Order Validation
    $('#resell-order').click(function() {
      var isvalid = true;
      clearErrorResell();
      if (!$('#resell-full-name').val()) {
        $('#resell-full-name').addClass('is-invalid');
        $('#resell-full-nameErr').text('Please enter full name');
        isvalid = false;
      } else if (!nameRegex.test($('#resell-full-name').val())) {
        $('#resell-full-name').addClass('is-invalid');
        $('#resell-full-nameErr').text('Please enter valid full name');
        isvalid = false;
      }

      if ($('#resell-email').val()) {
        if (!emailRegex.test($('#resell-email').val())) {
        $('#resell-email').addClass('is-invalid');
        $('#resell-emailErr').text('Please enter valid email address');
        isvalid = false;
      }
    }

      if (!$('#resell-mobile').val()) {
        $('#resell-mobile').addClass('is-invalid');
        $('#resell-mobileErr').text('Please enter phone number');
        isvalid = false;
      } else if (!mobileRegex.test($('#resell-mobile').val())) {
        $('#resell-mobile').addClass('is-invalid');
        $('#resell-mobileErr').text('Please enter valid phone number');
        isvalid = false;
      }

      if (!$('#resell-d-address').val()) {
        $('#resell-d-address').addClass('is-invalid');
        $('#resell-d-addressErr').text('Please enter address');
        isvalid = false;
      } 
      // else if (!addressRegex.test($('#resell-d-address').val())) {
      //   $('#resell-d-address').addClass('is-invalid');
      //   $('#resell-d-addressErr').text('Please enter valid address');
      //   isvalid = false;
      // }

      if (!$('#resell-d-state').val()) {
        $('#resell-d-state').addClass('is-invalid');
        $('#resell-d-stateErr').text('Please enter state');
        isvalid = false;
      }

      if (!$('#resell-d-city').val()) {
        $('#resell-d-city').addClass('is-invalid');
        $('#resell-d-cityErr').text('Please enter city');
        isvalid = false;
      }

      if (!$('#resell-d-pincode').val()) {
        $('#resell-d-pincode').addClass('is-invalid');
        $('#resell-d-pincodeErr').text('Please enter pin code');
        isvalid = false;
      } else if (!pinCodeRegex.test($('#resell-d-pincode').val())) {
        $('#resell-d-pincode').addClass('is-invalid');
        $('#resell-d-pincodeErr').text('Please enter valid pin code');
        isvalid = false;
      }

      if (!$('#resell-b-address').val()) {
        $('#resell-b-address').addClass('is-invalid');
        $('#resell-b-addressErr').text('Please enter address');
        isvalid = false;
      } else if (!addressRegex.test($('#resell-b-address').val())) {
        $('#resell-b-address').addClass('is-invalid');
        $('#resell-b-addressErr').text('Please enter valid address');
        isvalid = false;
      }

      if (!$('#resell-b-state').val()) {
        $('#resell-b-state').addClass('is-invalid');
        $('#resell-b-stateErr').text('Please enter state');
        isvalid = false;
      }

      if (!$('#resell-b-city').val()) {
        $('#resell-b-city').addClass('is-invalid');
        $('#resell-b-cityErr').text('Please enter city');
        isvalid = false;
      }

      if (!$('#resell-b-pincode').val()) {
        $('#resell-b-pincode').addClass('is-invalid');
        $('#resell-b-pincodeErr').text('Please enter pin code');
        isvalid = false;
      } else if (!pinCodeRegex.test($('#resell-b-pincode').val())) {
        $('#resell-b-pincode').addClass('is-invalid');
        $('#resell-b-pincodeErr').text('Please enter valid pin code');
        isvalid = false;
      }

      const fileInputResell = $('#UploadInvoiceResell')[0];
      const file = fileInputResell.files[0];
      // Check if a file is selected
      // if (!file) {
      //   $('#UploadInvoiceResellErr').text('Please upload an invoice file.');
      //   isvalid = false;
      // }
      fileInputResell.addEventListener('change', function() {
        const file = fileInputResell.files[0];
        // Check if a file is selected
        if (file) {
          $('#UploadInvoiceResellErr').text('');
          isvalid = true;
        }
      });


      //--------------------Resell Order Submit--------------------
      if(isvalid){
        var formData = new FormData();
        formData.append('full_name', $('#resell-full-name').val());
        formData.append('email', $('#resell-email').val());
        formData.append('mobile', parseInt($('#resell-mobile').val()));
        formData.append('store_order', $('#storeOrderReseller').val());
        formData.append('address', $('#resell-d-address').val());
        formData.append('state', $('#resell-d-state').val());
        formData.append('city', $('#resell-d-city').val());
        formData.append('pincode', parseInt($('#resell-d-pincode').val()));
        formData.append('b_address', $('#resell-b-address').val());
        formData.append('b_state', $('#resell-b-state').val());
        formData.append('b_city', $('#resell-b-city').val());
        formData.append('b_pincode', parseInt($('#resell-b-pincode').val()));
        if (file) {
          formData.append('invoice', file);
        }
        formData.append('order_type', $('#order_type').val());
        formData.append('order_id', $('#order_id').val());
        $(this).attr('disabled',true);
        ApiRequest('orders', 'POST', formData)
          .then(response => {
            if (response.data.statusCode == 200) {
              const payment = response.data.data;
              $('#order_id').val(payment.order_id);
              var options = {
                  "key": "{{env('RAZORPAY_KEY')}}", // Enter the Key ID generated from the Dashboard
                  "amount": payment.total_amount, // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
                  "currency": payment.currency,
                  "name": "{{env('APP_NAME')}}", //your business name
                  "description": "Create payment for order by Ekomn Platform",
                  "image": "{{asset('assets/images/Logo.svg')}}",
                  "order_id": payment.razorpy_order_id, //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
                  "callback_url": "{{route('order.payment.success')}}",
                  "prefill": { //We recommend using the prefill parameter to auto-fill customer's contact information especially their phone number
                      "name": payment.full_name, //your customer's name
                      "email": payment.email, //your customer's email
                      "contact": payment.mobile_number //Provide the customer's phone number for better conversion rates 
                  },
                  "notes": {
                      "address": "Gurugram, Haryana India"
                  },
                  "theme": {
                      "color": "#FECA40"
                  }
              };
              var rzp1 = new Razorpay(options);
              rzp1.open();
            }
            else if (response.data.statusCode == 422) {
              $(this).attr('disabled',false);
                const field = response.data.key;
                $(`#${field}`).addClass('is-invalid');
                $(`#${field}Err`).text(response.data.message);
            } else if(response.data.statusCode == 201){
              $(this).attr('disabled',false);
               // Handle error
               Swal.fire({
                    title: 'Error',
                    text: response.data.message,
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
          })
          .catch(error => {
            $(this).attr('disabled',false);
            console.error(error);
          });
      }
  });

  });
    // update order type script 
    const tabMapping = {
        'dropship-tab': 1,
        'bulk-tab': 2,
        'resell-tab': 3
    };

    // Check if the quantity is changed
    let isQuantityChanged = false;
    let hiddenInput = document.getElementById("order_type");
      document.querySelectorAll('a[data-bs-toggle="tab"]').forEach(tab => {
          tab.addEventListener('shown.bs.tab', function(event) {
              const activeTabId = event.target.id;
              const numericValue = tabMapping[activeTabId];
              $('#dropship-order').attr('disabled',false);
              $('#bulk-order').attr('disabled',false);
              $('#resell-order').attr('disabled',false);
              $('#order_id').val('');
                hiddenInput.value = numericValue;
                if (hiddenInput.value == 1) {
                    var getQntyId = document.querySelectorAll('.stockQnty');
                    var uniqueIds = new Set();
                  if(isQuantityChanged){
                      getQntyId.forEach(function (element) {
                          var id = element.id;
                          if (!uniqueIds.has(id)) {
                              uniqueIds.add(id);
                              ApiRequest(`product/cart/update/quantity`, 'POST', {
                                  cart_id: id,
                                  quantity: 1,
                                  order_type: hiddenInput.value
                              }).then(response => {
                                fetchDropshipOrderSku();
                              }).catch(error => {
                                  console.error(error);
                                
                              });
                          }
                      });
                      isQuantityChanged = false;
                  }
                }else {
                  fetchDropshipOrderSku();
                }
          }); 
    });
  
    //----------------------------------------------------------------------

    // Add/Remove Dropship SKU
    document.addEventListener("DOMContentLoaded", function() {
        const addSKUButton = document.querySelector("#addDropshipSKU");
        addSKUButton.addEventListener("click", function() {
            var sku = document.getElementById('sku').value;
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            if (sku == '') {
                $('#sku').addClass('is-invalid');
                $('#skuError').text('Please enter sku for search product');
                return;
            }
            $('#sku').removeClass('is-invalid');
            $('#skuError').text('');
            ApiRequest('product/search/sku', 'POST', {
                sku: sku
            }).then(response => {
                if (response.data.statusCode == 200) {
                    fetchDropshipOrderSku();
                    document.getElementById('sku').value = '';
                } else {
                    // Handle error
                    Swal.fire({
                    title: 'Error',
                    text: response.data.message,
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
            }).catch(error => {
              console.error(error);
                   // Handle error
                   Swal.fire({
                    title: 'Error',
                    text: 'Product out of stock or Something went wrong !',
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
            });
        });
    });

    // Add/Remove Bulk SKU
    document.addEventListener("DOMContentLoaded", function() {
        const addSKUButton = document.querySelector("#addBulkSKU");
        addSKUButton.addEventListener("click", function() {
            var sku = document.getElementById('sku2').value;
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            if (sku == '') {
                $('#sku2').addClass('is-invalid');
                $('#sku2Error').text('Please enter sku for search product');
                return;
            }
            $('#sku2').removeClass('is-invalid');
            $('#sku2Error').text('');
            ApiRequest('product/search/sku', 'POST', {
                sku: sku
            }).then(response => {
                if (response.data.statusCode == 200) {
                    fetchDropshipOrderSku();
                    document.getElementById('sku').value = '';
                } else {
                    // Handle error
                    Swal.fire({
                    title: 'Error',
                    text: response.data.message,
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
            }).catch(error => {
              console.error(error);
                   // Handle error
                   Swal.fire({
                    title: 'Error',
                    text: 'Product out of stock or Something went wrong !',
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
            });
        });
    });

    // Add/Remove Reseller SKU
    document.addEventListener("DOMContentLoaded", function() {
        const addSKUButton = document.querySelector("#addResellerSKU");
        addSKUButton.addEventListener("click", function() {
            var sku = document.getElementById('sku3').value;
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            if (sku == '') {
                $('#sku3').addClass('is-invalid');
                $('#sku3Error').text('Please enter sku for search product');
                return;
            }
            $('#sku2').removeClass('is-invalid');
            $('#sku2Error').text('');
            ApiRequest('product/search/sku', 'POST', {
                sku: sku
            }).then(response => {
                if (response.data.statusCode == 200) {
                    fetchDropshipOrderSku();
                    document.getElementById('sku').value = '';
                } else {
                    // Handle error
                    Swal.fire({
                    title: 'Error',
                    text: response.data.message,
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
            }).catch(error => {
              console.error(error);
                   // Handle error
                   Swal.fire({
                    title: 'Error',
                    text: 'Product out of stock or Something went wrong !',
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
            });
        });
    });
    // end

    // when the page is loaded fetch cart data 
    $(document).ready(function() {
        fetchDropshipOrderSku();
    });

    $('#pin_code').on('blur', function() {
      if (this.value.length == 6) {
        $('#pin_code').removeClass('is-invalid');
        $('#pin_codeErr').text('');
        fetchDropshipOrderSku();
      } else {
        $('#pin_code').addClass('is-invalid');
        $('#pin_codeErr').text('Pincode should be 6 digits');
        return;
      }
    });

    $('#resell-d-pincode').on('blur', function() {
      if (this.value.length == 6) {
        $('#resell-d-pincode').removeClass('is-invalid');
        $('#resell-d-pincodeErr').text('');
        fetchDropshipOrderSku();
      } else {
        $('#resell-d-pincode').addClass('is-invalid');
        $('#resell-d-pincodeErr').text('Pincode should be 6 digits');
        return;
      }
    });
   
    // functiomn for fetch sku data from add to cart api
    function fetchDropshipOrderSku() {
        var url = 'product/cart/list';
        var gstAmout = 0;
        var totalCost = 0;
        var shippingCost = 0;
        var otherCost = 0;
        let order_type = $('#order_type').val();
        let pincode = '';
        if(order_type == 1){
          pincode = $('#pin_code').val();
        }if(order_type == 2){
          pincode = $('#pinCodeBulk').val();
        }else if(order_type == 3){
          pincode = $('#resell-d-pincode').val();
        }
        ApiRequest(url, 'POST', {
          pincode: pincode,
          order_type: order_type
        }).then(response => {
            if (response.data.statusCode == 200) {
                // Handle the successful response here
                const $dropshipInvoice = $('.payInvoiceTable tbody');
                var products = response.data.data.data;

                // Clear the existing rows if needed
                $dropshipInvoice.empty();
                // Check if response.data exists and is an array
                if (products) {
                    products.forEach(product => {
                        var amount = product.gstAmount.toFixed(2) || 0;
                        gstAmout += parseFloat(amount);
                        overAllCost = parseFloat(product.overAllCost) || 0;
                        shippingCost += parseFloat(product.shippingCost) || 0;
                        otherCost += parseFloat(product.otherCost) || 0;
                        $('.payment_button').html('<i class="fas fa-rupee-sign me-1"></i>'+overAllCost.toFixed(2)+' Pay');
                        const $dropshipInvoiceRow = $('<tr></tr>').html(`
                    <td>
                        <div class="productTitle_t3 bold">
                            <i class="fas fa-minus-circle pointer text-danger me-1" onClick="deleteSkuProduct('${product.product_id}')"></i>${product.title}
                        </div>
                    </td>
                    <td class="text-center">${product.stock}</td>
                    <td>${product.sku}</td>
                    <td>${product.hsn}</td>
                    <td class="text-center"><input type="text" class="stock_t" onfocusout="updateQuantity('${product.id}', this)" value="${product.quantity}" /></td>
                    <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>${product.price_per_piece}</td>
                    <td class="text-right">${product.gst_percentage} %</td>
                    <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>${product.priceWithGst.toFixed(2)}</td>
                    <input type="hidden" id="${product.id}" class="stockQnty" value="">
                `);
                        $dropshipInvoice.prepend($dropshipInvoiceRow); // Add new row at the beginning
                    });

                    const additionalRows = `
                                         <tr>
                                            <td colspan="7" class="text-right">GST</td>
                                            <td class="text-right w_200_f"><i class="fas fa-rupee-sign fs-12 me-1"></i>${gstAmout.toFixed(2)}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="7" class="text-right">Shipping Cost</td>
                                            <td class="text-right w_200_f"><i class="fas fa-rupee-sign fs-12 me-1"></i>${shippingCost.toFixed(2)}</td>
                                        </tr>
                                       
                                        <tr>
                                            <td colspan="7" class="text-right">Other Charges
                                                <div class="dropdown info_inline">
                                                    <i class="fas fa-info-circle opacity-50 pointer" data-bs-toggle="dropdown" aria-expanded="false"></i>
                                                    <div class="dropdown-menu fs-13 px-2 py-1 text-muted">
                                                        Package Cost, Labour Charges, Platform Fee & Payment Processing Fee
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-right w_200_f"><i class="fas fa-rupee-sign fs-12 me-1"></i>${otherCost.toFixed(2)}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="7" class="text-right bold">Total Order Cost</td>
                                            <td class="text-right w_200_f bold"><i class="fas fa-rupee-sign fs-12 me-1"></i>${overAllCost.toFixed(2)}</td>
                                        </tr>`;

                    $dropshipInvoice.append(additionalRows); // Add additional rows at the end

                } else {
                    const $dropshipInvoice = $('.payInvoiceTable tbody');
                    $dropshipInvoice.empty();
                    const $dropshipInvoiceRow = $('<tr></tr>').html(
                `<td colspan="8" class="text-center">No Record Found</td>`);
                $dropshipInvoice.prepend(
                $dropshipInvoiceRow);
                }
            }else{
              const $dropshipInvoice = $('.payInvoiceTable tbody');
                    $dropshipInvoice.empty();
                    const $dropshipInvoiceRow = $('<tr></tr>').html(
                `<td colspan="8" class="text-center">No Record Found</td>`);
                $dropshipInvoice.prepend(
                $dropshipInvoiceRow);
            }
        }).catch(data => {
            const $dropshipInvoice = $('.payInvoiceTable tbody');
            $dropshipInvoice.empty();

            const $dropshipInvoiceRow = $('<tr></tr>').html(
                `<td colspan="8" class="text-center">No Record Found</td>`);
            $dropshipInvoice.prepend(
                $dropshipInvoiceRow);

        });

    }


    // function for update quantity
    function updateQuantity(id, element) {
        let order_type = $('#order_type').val();
        $('#order_id').val('');
        var quantity = element.value;
        if(order_type != 1){
            isQuantityChanged = true;
        }
        ApiRequest(`product/cart/update/quantity`, 'POST', {
            cart_id: id,
            quantity: quantity,
            order_type: order_type
        }).then(response => {
            if (response.data.statusCode == 200) {
                fetchDropshipOrderSku();
            } else {
                Swal.fire({
                    title: 'Error',
                    text: response.data.message,
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
        }).catch(error => {
            console.error(error);
            Swal.fire({
                title: 'Error',
                text: 'Something went wrong !',
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
        });
    }

    // function for delete sku product
    function deleteSkuProduct(id) {
        var csrfToken = $('input[name="_token"]').val();
        Swal.fire({
                title: 'Confirmation',
                text: 'Are you sure you want to remove this product from your cart?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, remove it!',
                cancelButtonText: 'Cancel',
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
            }).then((result) => {
            if (result.isConfirmed) {

              ApiRequest(`product/remove/cart/${id}`, 'DELETE').then(response => {
                if (response.data.statusCode == 200) {
                    fetchDropshipOrderSku();
                    Swal.fire({
                        title: 'Success',
                        text: response.data.message,
                        icon: 'success',
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
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: response.data.message,
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
            }).catch(error => {
                console.error(error);
                Swal.fire({
                    title: 'Error',
                    text: 'Something went wrong !',
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
            });
            }

        });

    }
</script>
@endsection
