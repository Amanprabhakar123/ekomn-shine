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
                    <span>Product SKU:<span class="req_star">*</span></span>
                  </label>
                  <div class="ek_f_input sku_inline">
                    <div class="sku_list">
                      <input type="text" class="form-control" placeholder="Enter Product SKU" />
                    </div>
                    <button class="btn addSkuBtn mt-0 btn-sm px-3 bold" type="button" id="addDropshipSKU">Add</button>
                  </div>
                </div>
                <div class="d-flex justify-content-between">
                  <h4 class="subheading mb-2">Product Details</h4>
                  <div class="upload-original-invoice">
                    <input type="file" id="UploadInvoice" class="upload_invoice" accept=".csv, .xls, .xlsx, image/*, .pdf" style="display: none;">
                    
                    <div class="d-flex gap-2 align-items-center">
                      <div class="UploadInvoiceName fs-14 opacity-75"></div>
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
                    <div class="fw-normal">
                      <input class="form-check-input" type="checkbox" id="sameas_2" />
                      <label for="sameas_2" class="w-normal m-0">Same as aelivery address</label>
                    </div>
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
                      <span>Product SKU:<span class="req_star">*</span></span>
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
                      <input type="file" id="UploadInvoiceBulk" class="upload_invoice" accept=".csv, .xls, .xlsx, image/*, .pdf" style="display: none;">
                      <div class="d-flex gap-2 align-items-center">
                        <div class="UploadInvoiceName fs-14 opacity-75"></div>
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
                    <button type="button" class="btn btn-login btnekomn card_f_btn next_Tab"><i class="fas fa-rupee-sign me-1"></i>454.50 Pay</button>
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
                        <input type="text" class="form-control" placeholder="Enter Full Name" />
                        <span class="text-danger hide">errr message</span>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4">
                    <div class="ek_group">
                      <label class="eklabel req"><span>Email Address:</span></label>
                      <div class="ek_f_input">
                        <input type="text" class="form-control" placeholder="Email Address" />
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
                        <input type="text" class="form-control" placeholder="Phone Number" />
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
                        <input type="text" class="form-control" placeholder="Enter Stareet Address" />
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
                        <select class="form-select">
                          <option value="" selected>Select State</option>
                        </select>
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
                        <select class="form-select">
                          <option value="" selected>Select City</option>
                        </select>
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
                        <input type="text" class="form-control" placeholder="Enter Pin Code" />
                        <span class="text-danger hide">errr message</span>
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
                        <input type="text" class="form-control" placeholder="Enter Stareet Address" />
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
                        <select class="form-select">
                          <option value="" selected>Select State</option>
                        </select>
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
                        <select class="form-select">
                          <option value="" selected>Select City</option>
                        </select>
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
                        <input type="text" class="form-control" placeholder="Enter Pin Code" />
                        <span class="text-danger hide">errr message</span>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
              <section class="sectionspace">
                <div class="ek_group mb-1">
                  <label class="eklabel m-0">
                    <span>Product SKU:<span class="req_star">*</span></span>
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
                    <input type="file" id="UploadInvoiceBulk" class="upload_invoice" accept=".csv, .xls, .xlsx, image/*, .pdf" style="display: none;">
                    <div class="d-flex gap-2 align-items-center">
                      <div class="UploadInvoiceName fs-14 opacity-75"></div>
                      <label for="UploadInvoiceBulk" class="file-label invice m-0">
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
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="text-right d-flex justify-content-end mt30">
                  <button type="button" class="btn btn-login btnekomn card_f_btn next_Tab"><i class="fas fa-rupee-sign me-1"></i>454.50 Pay</button>
                </div>
              </section>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  @include('dashboard.layout.copyright')
</div>
@endsection
@section('scripts')
<script>
  // Add/Remove Dropship SKU
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
  
  $('#state').change(function(){
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

  $('#b_state').change(function(){
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


    const businessNameRegex = /^[a-zA-Z0-9 ,.\\-]+$/;
    const gstRegex = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/;
    const nameRegex = /^[a-zA-Z\s\-\.']+$/;
    const addressRegex = /^[a-zA-Z0-9\s,.'\-\/]+$/;
    const pinCodeRegex = /^[0-9]{6}$/;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const mobileRegex = /^[6-9]\d{9}$/;


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
    }else if(!nameRegex.test($('#full_name').val())){
      $('#full_name').addClass('is-invalid');
      $('#full_nameErr').text('Please enter valid full name');
      isvalid = false;
    }

    if (!$('#email').val()) {
      $('#email').addClass('is-invalid');
      $('#emailErr').text('Please enter email');
      isvalid = false;
    }else if(!emailRegex.test($('#email').val())){
      $('#email').addClass('is-invalid');
      $('#emailErr').text('Please enter valid email');
      isvalid = false;
    }

    if (!$('#mobile').val()) {
      $('#mobile').addClass('is-invalid');
      $('#mobileErr').text('Please enter phone');
      isvalid = false;
    }else if(!mobileRegex.test($('#mobile').val())){
      $('#mobile').addClass('is-invalid');
      $('#mobileErr').text('Please enter valid phone');
      isvalid = false;
    
  }

    if (!$('#address').val()) {
      $('#address').addClass('is-invalid');
      $('#addressErr').text('Please enter address');
      isvalid = false;
    }
    else if(!addressRegex.test($('#address').val())){
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
    }else if(!pinCodeRegex.test($('#pin_code').val())){
      $('#pin_code').addClass('is-invalid');
      $('#pin_codeErr').text('Please enter valid pin code');
      isvalid = false;
    }

    if (!$('#b_address').val()) {
      $('#b_address').addClass('is-invalid');
      $('#b_addressErr').text('Please enter address');
      isvalid = false
    }else if(!addressRegex.test($('#b_address').val())){
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
    }else if(!pinCodeRegex.test($('#b_pin_code').val())){
      $('#b_pin_code').addClass('is-invalid');
      $('#b_pin_codeErr').text('Please enter valid pin code');
      isvalid = false;
    }
   
  });



  // $('full_name').val();
  // if($('full_name').val() == ''){
  //   isvalid = false;
  //   $('full_name').next().removeClass('hide').text('Please enter full name'); 
  // }else{
  //   $('full_name').next().addClass('hide').text(''); 
  // };
</script>
@endsection