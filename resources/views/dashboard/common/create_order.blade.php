@extends('dashboard.layout.app')

@section('content')
<div class="ek_dashboard">
  <div class="ek_content">
    <div class="card ekcard pa pt-2 shadow-sm">
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
                        <input type="text" id="mobile" class="form-control" placeholder="Phone Number" />
                        <div id="mobileErr" class="invalid-feedback"></div>
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
                        <span>Stareet Address:<span class="req_star">*</span></span>
                      </label>
                      <div class="ek_f_input">
                        <input type="text" id="address" class="form-control" placeholder="Enter Stareet Address" />
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
                    <label for="sameas" class="w-normal m-0">Same as aelivery address</label>
                  </div>
                </h4>
                <div class="row">
                  <div class="col-sm-12 col-md-12">
                    <div class="ek_group">
                      <label class="eklabel req">
                        <span>Stareet Address:<span class="req_star">*</span></span>
                      </label>
                      <div class="ek_f_input">
                        <input type="text" id="b_address" class="form-control" placeholder="Enter Stareet Address" />
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
                    <span>Product SKU 1:<span class="req_star">*</span></span>
                  </label>
                  <div class="ek_f_input sku_inline">
                      <div class="sku_list">
                          <input type="text" class="form-control" name="sku" id="sku"  value="" placeholder="Enter Product SKU" />
                          <div id="skuError" class="invalid-feedback"></div>
                      </div>
                      <button class="btn addSkuBtn mt-0 btn-sm px-3 bold" type="button"
                          id="addDropshipSKU">Add</button>
                  </div>
                  {{--<div class="ek_f_input sku_inline">
                    <div class="sku_list">
                      <input type="text" class="form-control" placeholder="Enter Product SKU" />
                    </div>
                    <button class="btn addSkuBtn mt-0 btn-sm px-3 bold" type="button" id="addDropshipSKU">Add</button>
                  </div>--}}
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
                      {{--
                      <tr>
                        <td>
                          <div class="productTitle_t3 bold">
                            <i class="fas fa-minus-circle removeDropshipSKU pointer text-danger me-1"></i>Dell WM126 Wireless Mouse
                          </div>
                        </td>
                        <td class="text-center">100</td>
                        <td>K5944RUR</td>
                        <td class="text-center"><input type="text" class="stock_t" value="5" /></td>
                        <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>80.99</td>
                        <td class="text-right">12%</td>
                        <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>454.54</td>
                      </tr>
                      <tr>
                        <td>
                          <div class="productTitle_t3 bold">
                            <i class="fas fa-minus-circle removeDropshipSKU pointer text-danger me-1"></i>Dell WM126 Wireless Mouse
                          </div>
                        </td>
                        <td class="text-center">100</td>
                        <td>K5944RUR</td>
                        <td class="text-center"><input type="text" class="stock_t" value="5" /></td>
                        <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>50.00</td>
                        <td class="text-right">18%</td>
                        <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>454.54</td>
                      </tr>
                      <tr>
                        <td colspan="6" class="text-right">Shipping Cost</td>
                        <td class="text-right w_200_f"><i class="fas fa-rupee-sign fs-12 me-1"></i>454.54</td>
                      </tr>
                      <tr>
                        <td colspan="6" class="text-right">GST</td>
                        <td class="text-right w_200_f"><i class="fas fa-rupee-sign fs-12 me-1"></i>454.54</td>
                      </tr>
                      <tr>
                        <td colspan="6" class="text-right">Other Charges
                          <div class="dropdown info_inline">
                            <i class="fas fa-info-circle opacity-50 pointer" data-bs-toggle="dropdown" aria-expanded="false"></i>
                            <div class="dropdown-menu fs-13 px-2 py-1 text-muted">
                              Package Cost, Labour Charges & Payment Processing Fee
                            </div>
                          </div>
                        </td>
                        <td class="text-right w_200_f"><i class="fas fa-rupee-sign fs-12 me-1"></i>454.54</td>
                      </tr>
                      <tr>
                        <td colspan="6" class="text-right bold">Total Order Cost</td>
                        <td class="text-right w_200_f bold"><i class="fas fa-rupee-sign fs-12 me-1"></i>454.54</td>
                      </tr>
                      --}}
                    </tbody>
                  </table>
                </div>
                <div class="text-right d-flex justify-content-end mt30">
                  <button type="button" id="dropship-order" class="btn btn-login btnekomn card_f_btn"><i class="fas fa-rupee-sign me-1"></i>454.50 Pay</button>
                </div>
              </section>
            </div>
          </form>
        </div>
        <div class="tab-pane fade" id="bulk" role="tabpanel" aria-labelledby="bulk-tab" tabindex="0">
          <form action="">
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
                          <span>Stareet Address:<span class="req_star">*</span></span>
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
                          <input type="text" class="form-control" value="{{ isset($delivery_address) ? $delivery_address->pincode : '' }}" readonly="readonly" />
                          <span class="text-danger hide">errr message</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </section>
                <section class="sectionspace">
                  <h4 class="subheading subheadingFlex">
                    Billing Address
                    <!-- <div class="fw-normal">
                      <input class="form-check-input" type="checkbox" id="sameas_2" />
                      <label for="sameas_2" class="w-normal m-0">Same as aelivery address</label>
                    </div> -->
                  </h4>
                  <div class="row">
                    <div class="col-sm-12 col-md-12">
                      <div class="ek_group">
                        <label class="eklabel req">
                          <span>Stareet Address:<span class="req_star">*</span></span>
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
                      <span>Product SKU 2:<span class="req_star">*</span></span>
                    </label>
                    <div class="ek_f_input sku_inline">
                      <div class="sku_list">
                        <input type="text" class="form-control" placeholder="Enter Product SKU" />
                      </div>
                      <button class="btn addSkuBtn mt-0 btn-sm px-3 bold" type="button" id="addBulkSKU">Add</button>
                    </div>
                  </div>
                  <div class="d-flex justify-content-between">
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
                  </div>
                  <div class="table-responsive">
                    <table class="payInvoiceTable" id="bulkInvoice">
                      <thead>
                        <tr>
                          <th>Product Title</th>
                          <th class="text-center">Stock</th>
                          <th>SKU</th>
                          <th class="text-center">Qty</th>
                          <th class="text-right">Price/piece</th>
                          <th class="text-right">GST%</th>
                          <th class="text-right">Total Price</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>
                            <div class="productTitle_t3 bold">
                              <i class="fas fa-minus-circle removeBulkSKU pointer text-danger me-1"></i>Dell WM126 Wireless Mouse (Bulk)
                            </div>
                          </td>
                          <td class="text-center">100</td>
                          <td>K5944RUR</td>
                          <td class="text-center"><input type="text" class="stock_t" value="5" /></td>
                          <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>80.99</td>
                          <td class="text-right">12%</td>
                          <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>454.54</td>
                        </tr>
                        <tr>
                          <td colspan="6" class="text-right">Shipping Cost</td>
                          <td class="text-right w_200_f"><i class="fas fa-rupee-sign fs-12 me-1"></i>454.54</td>
                        </tr>
                        <tr>
                          <td colspan="6" class="text-right">GST</td>
                          <td class="text-right w_200_f"><i class="fas fa-rupee-sign fs-12 me-1"></i>454.54</td>
                        </tr>
                        <tr>
                          <td colspan="6" class="text-right">Other Charges
                            <div class="dropdown info_inline">
                              <i class="fas fa-info-circle opacity-50 pointer" data-bs-toggle="dropdown" aria-expanded="false"></i>
                              <div class="dropdown-menu fs-13 px-2 py-1 text-muted">
                                Package Cost, Labour Charges & Payment Processing Fee
                              </div>
                            </div>
                          </td>
                          <td class="text-right w_200_f"><i class="fas fa-rupee-sign fs-12 me-1"></i>454.54</td>
                        </tr>
                        <tr>
                          <td colspan="6" class="text-right bold">Total Order Cost</td>
                          <td class="text-right w_200_f bold"><i class="fas fa-rupee-sign fs-12 me-1"></i>454.54</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="text-right d-flex justify-content-end mt30">
                    <button type="button" id="bulk-order" class="btn btn-login btnekomn card_f_btn"><i class="fas fa-rupee-sign me-1"></i>454.50 Pay</button>
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
                </div>
              </section>
              <section class="sectionspace">
                <h4 class="subheading">Delivery Address</h4>
                <div class="row">
                  <div class="col-sm-12 col-md-12">
                    <div class="ek_group">
                      <label class="eklabel req">
                        <span>Stareet Address:<span class="req_star">*</span></span>
                      </label>
                      <div class="ek_f_input">
                        <input type="text" id="resell-d-address" class="form-control" placeholder="Enter Stareet Address" />
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
                    <label for="sameas_3" class="fw-normal m-0">Same as aelivery address</label>
                  </div>
                </h4>
                <div class="row">
                  <div class="col-sm-12 col-md-12">
                    <div class="ek_group">
                      <label class="eklabel req">
                        <span>Stareet Address:<span class="req_star">*</span></span>
                      </label>
                      <div class="ek_f_input">
                        <input type="text" class="form-control" id="resell-b-address" placeholder="Enter Stareet Address" />
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
                    <span>Product SKU 3:<span class="req_star">*</span></span>
                  </label>
                  <div class="ek_f_input sku_inline">
                    <div class="sku_list">
                      <input type="text" class="form-control" placeholder="Enter Product SKU" />
                    </div>
                    <button class="btn addSkuBtn mt-0 btn-sm px-3 bold" type="button" id="addResellSKU">Add</button>
                  </div>
                </div>
                <div class="d-flex justify-content-between">
                  <h4 class="subheading mb-2">Product Details</h4>
                  <div class="upload-original-invoice">
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
                        <th class="text-center">Qty</th>
                        <th class="text-right">Price/piece</th>
                        <th class="text-right">GST%</th>
                        <th class="text-right">Total Price</th>
                      </tr>
                    </thead>
                    <tbody>
                    {{--
                    <tr>
                        <td>
                          <div class="productTitle_t3 bold">
                            <i class="fas fa-minus-circle removeResellSKU pointer text-danger me-1"></i>Dell WM126 Wireless Mouse (Resell)
                          </div>
                        </td>
                        <td class="text-center">100</td>
                        <td>K5944RUR</td>
                        <td class="text-center"><input type="text" class="stock_t" value="5" /></td>
                        <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>80.99</td>
                        <td class="text-right">12%</td>
                        <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>454.54</td>
                      </tr>
                      <tr>
                        <td colspan="6" class="text-right">Shipping Cost</td>
                        <td class="text-right w_200_f"><i class="fas fa-rupee-sign fs-12 me-1"></i>454.54</td>
                      </tr>
                      <tr>
                        <td colspan="6" class="text-right">GST</td>
                        <td class="text-right w_200_f"><i class="fas fa-rupee-sign fs-12 me-1"></i>454.54</td>
                      </tr>
                      <tr>
                        <td colspan="6" class="text-right">Other Charges
                          <div class="dropdown info_inline">
                            <i class="fas fa-info-circle opacity-50 pointer" data-bs-toggle="dropdown" aria-expanded="false"></i>
                            <div class="dropdown-menu fs-13 px-2 py-1 text-muted">
                              Package Cost, Labour Charges & Payment Processing Fee
                            </div>
                          </div>
                        </td>
                        <td class="text-right w_200_f"><i class="fas fa-rupee-sign fs-12 me-1"></i>454.54</td>
                      </tr>
                      <tr>
                        <td colspan="6" class="text-right bold">Total Order Cost</td>
                        <td class="text-right w_200_f bold"><i class="fas fa-rupee-sign fs-12 me-1"></i>454.54</td>
                      </tr>--}}
                    </tbody>
                  </table>
                </div>
                <div class="text-right d-flex justify-content-end mt30">
                  <button type="button" id="resell-order" class="btn btn-login btnekomn card_f_btn next_Tab"><i class="fas fa-rupee-sign me-1"></i>454.50 Pay</button>
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
<script>
  // Add/Remove Dropship SKU
  /*
  document.addEventListener("DOMContentLoaded", function() {
    const addSKUButton = document.querySelector("#addDropshipSKU");
    addSKUButton.addEventListener("click", function() {
      const dropshipInvoice = document.querySelector('#dropshipInvoice tbody');
      const dropshipInvoiceRow = document.createElement('tr');
      dropshipInvoiceRow.innerHTML = `
        <td>
          <div class="productTitle_t3 bold">
            <i class="fas fa-minus-circle removeDropshipSKU pointer text-danger me-1"></i>Dell WM126 Wireless Mouse
          </div>
        </td>
        <td class="text-center">100</td>
        <td>K5944RUR</td>
        <td class="text-center"><input type="text" class="stock_t" value="5" /></td>
        <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>80.99</td>
        <td class="text-right">12%</td>
        <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>454.54</td>`;
      dropshipInvoice.prepend(dropshipInvoiceRow);
    });
    const dropshipInvoiceBody = document.querySelector("#dropshipInvoice tbody");
    dropshipInvoiceBody.addEventListener("click", function(event) {
      if (event.target.closest(".removeDropshipSKU")) {
        const newSKUInput = event.target.closest("tr");
        dropshipInvoiceBody.removeChild(newSKUInput);
      }
    });
  });
  */
  // end


  // Add/Remove Bulk SKU
  document.addEventListener("DOMContentLoaded", function() {
    const addSKUButton = document.querySelector("#addBulkSKU");
    addSKUButton.addEventListener("click", function() {
      const dropshipInvoice = document.querySelector('#bulkInvoice tbody');
      const dropshipInvoiceRow = document.createElement('tr');
      dropshipInvoiceRow.innerHTML = `
        <td>
          <div class="productTitle_t3 bold">
            <i class="fas fa-minus-circle removeBulkSKU pointer text-danger me-1"></i>Dell WM126 Wireless Mouse (Bulk)
          </div>
        </td>
        <td class="text-center">100</td>
        <td>K5944RUR</td>
        <td class="text-center"><input type="text" class="stock_t" value="5" /></td>
        <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>80.99</td>
        <td class="text-right">12%</td>
        <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>454.54</td>`;
      dropshipInvoice.prepend(dropshipInvoiceRow);
    });
    const dropshipInvoiceBody = document.querySelector("#bulkInvoice tbody");
    dropshipInvoiceBody.addEventListener("click", function(event) {
      if (event.target.closest(".removeBulkSKU")) {
        const newSKUInput = event.target.closest("tr");
        dropshipInvoiceBody.removeChild(newSKUInput);
      }
    });
  });
  // end

  // Add/Remove Resell SKU
  document.addEventListener("DOMContentLoaded", function() {
    const addSKUButton = document.querySelector("#addResellSKU");
    addSKUButton.addEventListener("click", function() {
      const dropshipInvoice = document.querySelector('#resellInvoice tbody');
      const dropshipInvoiceRow = document.createElement('tr');
      dropshipInvoiceRow.innerHTML = `
        <td>
          <div class="productTitle_t3 bold">
            <i class="fas fa-minus-circle removeResellSKU pointer text-danger me-1"></i>Dell WM126 Wireless Mouse (Resell)
          </div>
        </td>
        <td class="text-center">100</td>
        <td>K5944RUR</td>
        <td class="text-center"><input type="text" class="stock_t" value="5" /></td>
        <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>80.99</td>
        <td class="text-right">12%</td>
        <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>454.54</td>`;
      dropshipInvoice.prepend(dropshipInvoiceRow);
    });
    const dropshipInvoiceBody = document.querySelector("#resellInvoice tbody");
    dropshipInvoiceBody.addEventListener("click", function(event) {
      if (event.target.closest(".removeResellSKU")) {
        const newSKUInput = event.target.closest("tr");
        dropshipInvoiceBody.removeChild(newSKUInput);
      }
    });
  });
  // end

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

    var isvalid = true;
    $('#dropship-order').click(function() {
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

      if (!$('#email').val()) {
        $('#email').addClass('is-invalid');
        $('#emailErr').text('Please enter email');
        isvalid = false;
      } else if (!emailRegex.test($('#email').val())) {
        $('#email').addClass('is-invalid');
        $('#emailErr').text('Please enter valid email');
        isvalid = false;
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
      } else if (!addressRegex.test($('#b_address').val())) {
        $('#b_address').addClass('is-invalid');
        $('#b_addressErr').text('Please enter valid address');
        isvalid = false;
      }

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
      let isValid = true;

      // Check if a file is selected
      if (!file) {
        $('#UploadInvoiceErr').text('Please upload an invoice file.');
        isValid = false;
      }else{
        $('#UploadInvoiceErr').text('');
      }
    });


    const fileInput = $('#UploadInvoice')[0];
    fileInput.addEventListener('change', function() {
      const file = fileInput.files[0];
      let isValid = true;
      // Check if a file is selected
      if (file) {
        $('#UploadInvoiceErr').text('');
        isValid = true;
      }
    });

  
    

    // Bulk Order 

    // const fileInputBulk = $('#UploadInvoiceBulk')[0];
    // fileInputBulk.addEventListener('change', function() {
    //   const file = fileInputBulk.files[0];
    //   let isValid = true;
    //   // Check if a file is selected
    //   if (file) {
    //     $('#UploadInvoiceBulkErr').text('');
    //     isValid = true;
    //   }
    // });

    // $('#bulk-order').click(function() {
    //   const fileInput = $('#UploadInvoiceBulk')[0];
    //   const file = fileInput.files[0];
    //   let isValid = true;
    //   if(!file){
    //     $('#UploadInvoiceBulkErr').text('Please upload an invoice file.');
    //     isValid = false;
    //   }else{
    //     $('#UploadInvoiceBulkErr').text('');
    //   }
    // });

      // Check if a file is selected

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
          console.log(cityList);
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


    $('#resell-order').click(function() {
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

      if (!$('#resell-email').val()) {
        $('#resell-email').addClass('is-invalid');
        $('#resell-emailErr').text('Please enter email address');
        isvalid = false;
      } else if (!emailRegex.test($('#resell-email').val())) {
        $('#resell-email').addClass('is-invalid');
        $('#resell-emailErr').text('Please enter valid email address');
        isvalid = false;
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
      } else if (!addressRegex.test($('#resell-d-address').val())) {
        $('#resell-d-address').addClass('is-invalid');
        $('#resell-d-addressErr').text('Please enter valid address');
        isvalid = false;
      }

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
      let isValid = true;

      if(!file){
        $('#UploadInvoiceResellErr').text('Please upload an invoice file.');
        isValid = false;
      }else{
        $('#UploadInvoiceResellErr').text('');
      }
    });

    const fileInputResell = $('#UploadInvoiceResell')[0];
    fileInputResell.addEventListener('change', function() {
      const file = fileInputResell.files[0];
      let isValid = true;
      // Check if a file is selected
      if (file) {
        $('#UploadInvoiceResellErr').text('');
        isValid = true;
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
              console.log(response);
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


    // jquery start
    $(document).ready(function() {
        fetchDropshipOrderSku();
    });
    // jquery end
    // functiomn for fetch sku data from add to cart api
    function fetchDropshipOrderSku() {
        var url = 'fetch-sku';
        var gstAmout = 0;
        var totalCost = 0;
        ApiRequest(url, 'GET').then(response => {
            // console.log(response);
            if (response.data.statusCode == 200) {
                // Handle the successful response here
                const $dropshipInvoice = $('#dropshipInvoice tbody');

                var products = response.data.data.data;
                // console.log(products);
                // Clear the existing rows if needed

                $dropshipInvoice.empty();

                // Check if response.data exists and is an array
                if (products) {
                    products.forEach(product => {
                        // console.log(product);
                        var amount = product.gstAmount.toFixed(2) || 0;
                        gstAmout += parseFloat(amount);
                        totalCost += parseFloat(product.totalCost) || 0;
                        // gstAmout += parseFloat(product.gstAmout) || 0;
                        const $dropshipInvoiceRow = $('<tr></tr>').html(`
                    <td>
                        <div class="productTitle_t3 bold">
                            <i class="fas fa-minus-circle pointer text-danger me-1" onClick="deleteSkuProduct(${product.product_id})"></i>${product.title}
                        </div>
                    </td>
                    <td class="text-center">${product.stock}</td>
                    <td>${product.sku}</td>
                    <td>${product.hsn}</td>
                    <td class="text-center"><input type="text" class="stock_t" value="1" /></td>
                    <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>${product.price_before_tax}</td>
                    <td class="text-right">${product.gst_percentage} %</td>
                    <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>${product.priceWithGst}</td>
                `);
                        $dropshipInvoice.prepend($dropshipInvoiceRow); // Add new row at the beginning
                    });

                    const additionalRows = `
                                        <tr>
                                            <td colspan="7" class="text-right">Shipping Cost</td>
                                            <td class="text-right w_200_f"><i class="fas fa-rupee-sign fs-12 me-1"></i>454.54</td>
                                        </tr>
                                        <tr>
                                            <td colspan="7" class="text-right">GST</td>
                                            <td class="text-right w_200_f"><i class="fas fa-rupee-sign fs-12 me-1"></i>${gstAmout}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="7" class="text-right">Other Charges
                                                <div class="dropdown info_inline">
                                                    <i class="fas fa-info-circle opacity-50 pointer" data-bs-toggle="dropdown" aria-expanded="false"></i>
                                                    <div class="dropdown-menu fs-13 px-2 py-1 text-muted">
                                                        Package Cost, Labour Charges & Payment Processing Fee
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-right w_200_f"><i class="fas fa-rupee-sign fs-12 me-1"></i>454.54</td>
                                        </tr>
                                        <tr>
                                            <td colspan="7" class="text-right bold">Total Order Cost</td>
                                            <td class="text-right w_200_f bold"><i class="fas fa-rupee-sign fs-12 me-1"></i>${totalCost}</td>
                                        </tr>`;

                    $dropshipInvoice.append(additionalRows); // Add additional rows at the end

                } else {
                    const $dropshipInvoice = $('#dropshipInvoice tbody');
                    $dropshipInvoice.empty();

                    const $dropshipInvoiceRow = $('<tr></tr>').html(
                        `<tr><td colspan="7" class="text-center">No Record Found</td></tr>`);
                    $dropshipInvoice.prepend(
                        $dropshipInvoiceRow); // Add new row at the beginning
                    const additionalRows = `
                                    <tr>
                                        <td colspan="7" class="text-right">Shipping Cost</td>
                                        <td class="text-right w_200_f"><i class="fas fa-rupee-sign fs-12 me-1"></i>454.54</td>
                                    </tr>
                                    <tr>
                                        <td colspan="7" class="text-right">GST</td>
                                        <td class="text-right w_200_f"><i class="fas fa-rupee-sign fs-12 me-1"></i>454.54</td>
                                    </tr>
                                    <tr>
                                        <td colspan="7" class="text-right">Other Charges
                                            <div class="dropdown info_inline">
                                                <i class="fas fa-info-circle opacity-50 pointer" data-bs-toggle="dropdown" aria-expanded="false"></i>
                                                <div class="dropdown-menu fs-13 px-2 py-1 text-muted">
                                                    Package Cost, Labour Charges & Payment Processing Fee
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-right w_200_f"><i class="fas fa-rupee-sign fs-12 me-1"></i>454.54</td>
                                    </tr>
                                    <tr>
                                        <td colspan="7" class="text-right bold">Total Order Cost</td>
                                        <td class="text-right w_200_f bold"><i class="fas fa-rupee-sign fs-12 me-1"></i>454.54</td>
                                    </tr>`;

                    $dropshipInvoice.append(additionalRows);
                }
            }
        }).catch(data => {
            const $dropshipInvoice = $('#dropshipInvoice tbody');
            $dropshipInvoice.empty();

            const $dropshipInvoiceRow = $('<tr></tr>').html(
                `<td colspan="8" class="text-center">No Record Found</td>`);
            $dropshipInvoice.prepend(
                $dropshipInvoiceRow);

        });

    }

    function deleteSkuProduct(id) {
        // var product_id = element;
        console.log(id);
        var csrfToken = $('input[name="_token"]').val();
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: !0,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel!",
            customClass: {
                confirmButton: "btn btn-primary",
                cancelButton: "btn btn-active-light",
            },
            buttonsStyling: !1,
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    type: "DELETE",
                    url: `{{ route('delete.sku', '') }}/${id}`,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken // Include the CSRF token in the headers
                    },

                    success: function(response) {
                        // console.log(data.data);
                        var data = response.data;
                        if (data.statusCode == '200') {
                            Swal.fire({
                                text: data.message,
                                icon: "success",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-light",
                                },
                            });
                            fetchDropshipOrderSku();

                        } else {
                            fetchDropshipOrderSku();
                            Swal.fire({
                                text: data.message,
                                icon: "error",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-light",
                                },
                            });
                        }

                    },
                    error: function(data) {
                        Swal.fire({
                            text: "Sorry, looks like there are some errors detected, please try again.",
                            icon: "error",
                            buttonsStyling: !1,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-light",
                            },
                        });
                    }
                });
            }

        });

    }
</script>
@endsection
