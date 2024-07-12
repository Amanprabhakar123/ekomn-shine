@extends('dashboard.layout.app')

@section('content')
<div class="ek_dashboard">
  <div class="ek_content">
    <div class="card ekcard pa shadow-sm">
      <div class="cardhead ">
        <h3 class="cardtitle">Add Inventory</h3>
        <a href="{{route('bulk-upload')}}" class="btn btnekomn btn-sm">Bulk Upload<i class="fas fa-cloud-upload-alt ms-2"></i></a>
      </div>
      <div>
        <ul class="nav nav-underline ekom_tab" role="tablist">
          <li class="nav-item" role="presentation">
            <a class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" role="tab" aria-controls="general" aria-selected="true">General</a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link" id="shipping-tab" data-bs-toggle="tab" data-bs-target="#shipping" role="tab" aria-controls="shipping" aria-selected="false">Pricing & Shipping</a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link" id="data-tab" data-bs-toggle="tab" data-bs-target="#data" role="tab" aria-controls="data" aria-selected="false">Data & dimensions</a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link" id="images-tab" data-bs-toggle="tab" data-bs-target="#images" role="tab" aria-controls="images" aria-selected="false">Product Images & Variants</a>
          </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
          <!-- <form id="addInventoryForm" enctype="multipart/form-data"> -->
          <input type="hidden" value="{{salt_encrypt($variations->id)}}" id="varition_id">
          <div class="tab-pane show active" id="general" role="tabpanel" aria-labelledby="general-tab" tabindex="0">
            <div class="addProductForm">
            @if(auth()->user()->hasRole(ROLE_ADMIN))
            <div class="ek_group">
                <label class="eklabel req"><span>Supplier Id:<span class="req_star">*</span></span></label>
                <div class="ek_f_input">
                    <input type="text" class="form-control" placeholder="Supplier Id." id="supplier_id" required  value="{{$variations->product->company->company_serial_id}}"/>
                    <div id="supplier_idErr" class="invalid-feedback"></div>
                </div>
            </div>
            @endif
              <div class="ek_group">
                <label class="eklabel req"><span>Product Name:<span class="req_star">*</span></span></label>
                <div class="ek_f_input">
                  <input type="text" class="form-control" placeholder="Product Name & Title" name="product_name" value="{{$variations->title}}" id="product_name" required />
                  <div id="product_nameErr" class="invalid-feedback"></div>
                </div>
              </div>
              <div class="ek_group">
                <label class="eklabel req"><span>Description:<span class="req_star">*</span></span></label>
                <div class="ek_f_input">
                  <textarea class="form-control" placeholder="Product Description" name="product_description" id="product_description" required>{{$variations->description}}</textarea>
                  <div id="product_descriptionErr" class="invalid-feedback"></div>
                </div>
              </div>
              <div class="ek_group">
                <label class="eklabel"><span>Product Keywords:<span class="req_star">*</span></span></label>
                <div class="ek_f_input">
                  <div class="tag-container">
                    <div class="tag-input">
                      <input type="text" id="tag-input" placeholder="Type and Press Enter or Comma" class="form-control" name="product_keywords" required />
                      <div id="tag-inputErr" class="invalid-feedback"></div>
                    </div>
                   
                  </div>
                </div>
              </div>
              <div class="ek_group">
                <label class="eklabel req"><span>Product Features:<span class="req_star">*</span></span></label>
                <div class="ek_f_input">
                  <textarea id="product-description" class="form-control" placeholder="Enter Product Features & Press Add Button"></textarea>
                 
                  <span id="features-error" class="text-danger hide">At least one product feature is required.</span>
                  <div class="clearfix">
                    <span class="fs-14 opacity-25">You can only add up to 7 features</span>
                    
                    <button id="add-feature" type="button" class="btn addNewRow px-4">Add</button>
                    
                  </div>
                  <ol id="features-list" class="featureslisting"></ol>
                </div>
              </div>
              <div class="ek_group">
                <label class="eklabel mt20"><span>Product Category:<span class="req_star">*</span></span></label>
                <div class="ek_f_input">
                  <div class="row">
                    <div class="mb10 col-sm-12 col-md-3">
                      <label style="font-size: 13px;opacity: 0.6;">Main Category</label>
                      <input type="text" name="product_category" id="product_category" class="form-control" value="{{$variations->product->category->name}}" placeholder="Product Category" disabled />
                      <input type="hidden" name="product_category_id" id="product_category_id" value="{{salt_encrypt($variations->product->category->id)}}"/>
                      <div id="product_categoryErr" class="invalid-feedback"></div>
                    </div>
                    <div class="form-group col-sm-12 col-md-3">
                      <label style="font-size: 13px;opacity: 0.6;">Sub Category</label>
                    
                      <input type="text" name="product_sub_category" id="product_sub_category" value="{{$variations->product->category->slug}}" class="form-control" placeholder="Product Sub Category" disabled />
                      <input type="hidden" value="{{salt_encrypt($variations->product->category->id)}}" name="product_sub_category_id" id="product_sub_category_id" />
                      <div id="product_sub_categoryErr" class="invalid-feedback"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="saveform_footer text-right single-button">
              <button type="button" class="btn btn-login btnekomn card_f_btn" id="generaltab">Save & Next</button>
            </div>
          </div>
          <div class="tab-pane fade" id="shipping" role="tabpanel" aria-labelledby="shipping-tab" tabindex="0">
            <div class="addProductForm">
              <div class="row">
                <div class="col-sm-12 col-md-4">
                  <div class="ek_group">
                    <label class="eklabel req"><span>Single Piece / Dropship Rate:<span class="req_star">*</span></span></label>
                    <div class="ek_f_input">
                      <input type="text" class="form-control" placeholder="Enter Dropship Rate" value="{{(int)$variations->dropship_rate}}" name="dropship_rate" id="dropship_rate" required />
                      <div id="dropship_rateErr" class="invalid-feedback"></div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12 col-md-4">
                  <div class="ek_group">
                    <label class="eklabel req"><span>Potential MRP:<span class="req_star">*</span></span></label>
                    <div class="ek_f_input">
                      <input type="text" class="form-control" placeholder="Enter Potential MRP" value="{{(int)$variations->potential_mrp}}" name="potential_mrp" id="potential_mrp" required />
                      <div id="potential_mrpErr" class="invalid-feedback"></div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12 col-md-12">
                  <div class="ek_group">
                    <label class="eklabel req"><span>Bulk Rate:<span class="req_star">*</span></span></label>
                    <div class="ek_f_input">
                      <div class="ekdiv">
                        <table class="normalTable addrowTable" id="bulkRateTable">
                          <thead>
                            <tr>
                              <th>Quantity upto</th>
                              <th>Price / Per Piece</th>
                              <th style="width: 20px;"></th>
                            </tr>
                          </thead>
                          <tbody>
                            @php
                            @$bulkRates = json_decode($variations->tier_rate, true);
                            @$shippingRates = json_decode($variations->tier_shipping_rate, true);
                            @endphp
                          
                            @foreach($bulkRates as $key => $bulkRate)                           
                            <tr>
                              <td>
                                <input type="text" class="smallInput_n" placeholder="Qty. Upto" value="{{ $bulkRate['range']['max'] }}" name="bulk[0][quantity]" id="bulk[0][quantity]" required>
                                <div id="bulk_quantityErr0" class="invalid-feedback"></div>
                              </td>
                              <td>
                                <input type="text" class="smallInput_n" value="{{ $bulkRate['price'] }}" placeholder="Rs. 0.00" name="bulk[0][price]" id="bulk[0][price]" required>
                                <div id="bulk_priceErr0" class="invalid-feedback"></div>
                              </td>
                              <td>
                                @if($key != 0)
                              <button type="button" class="deleteRow deleteBulkRow"><i class="far fa-trash-alt"></i></button>
                              @endif
                              </td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                        <button class="addNewRow" id="addNewRowButton" type="button">Add More</button>
                      </div>
                      <div id="bulk_rateErr" class="invalid-feedback"></div>
                    </div>
                  </div>
                  <div class="ek_group">
                    <label class="eklabel req"><span>Shipping Rate:<span class="req_star">*</span></span></label>
                    <div class="ek_f_input">
                      <div class="">
                        <table class="normalTable addrowTable" id="shippingRateTable">
                          <thead>
                            <tr>
                              <th>Quantity upto</th>
                              <th>Local</th>
                              <th>Regional</th>
                              <th>National</th>
                              <th style="width: 20px;"></th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($shippingRates as $key => $shippingRate)
                            <tr>
                              <td>
                                <input type="text" class="smallInput_n" placeholder="Qty. Upto" name="shipping[0][quantity]"  value="{{ $shippingRate['range']['max'] }}"  id="shipping[0][quantity]" required>
                                <div id="shipping_quantityErr0" class="invalid-feedback"></div>
                              </td>
                              <td>
                                <input type="text" class="smallInput_n" placeholder="Rs. 0.00" value="{{ $shippingRate['local'] }}" name="shipping[0][local]" id="shipping[0][local]" required>
                                <div id="shipping_localErr0" class="invalid-feedback"></div>
                              </td>
                              <td>
                                <input type="text" class="smallInput_n" placeholder="Rs. 0.00" name="shipping[0][regional]"  value="{{ $shippingRate['regional'] }}" id="shipping[0][regional]" required>
                                <div id="shipping_regionalErr0" class="invalid-feedback"></div>
                              </td>
                              <td>
                                <input type="text" class="smallInput_n" placeholder="Rs. 0.00" name="shipping[0][national]"  value="{{ $shippingRate['national'] }}" id="shipping[0][national]" required>
                                <div id="shipping_nationalErr0" class="invalid-feedback"></div>
                              </td>
                              <td>
                                @if($key != 0)
                                <button type="button" class="deleteRow deleteShippingRow"><i class="far fa-trash-alt"></i></button>
                                @endif
                            </td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                        <button class="addNewRow" id="addShippingRow" type="button">Add More</button>
                      </div>
                      <div id="shipping_rateErr" class="invalid-feedback"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="saveform_footer">
              <button type="button" class="btn btn-login btnekomn card_f_btn previous_Tab"><i class="fas fa-arrow-left me-3 fs-13"></i>Back</button>
              <button type="button" class="btn btn-login btnekomn card_f_btn" id="shippingTab">Save & Next</button>
            </div>
          </div>
          <div class="tab-pane fade" id="data" role="tabpanel" aria-labelledby="data-tab" tabindex="0">
            <div class="addProductForm">
              <h4 class="subheading">Product Details</h4>
              <div class="row">
                <div class="col-sm-12 col-md-3">
                  <div class="ek_group">
                    <label class="eklabel req"><span>Model:<span class="req_star">*</span></span></label>
                    <div class="ek_f_input">
                    @if(auth()->user()->hasRole(ROLE_ADMIN))
                      <input type="text" class="form-control" placeholder="Enter Modal Number" value="{{$variations->product->model}}" name="model" id="model" required />
                      @else
                      <input type="text" class="form-control" placeholder="Enter Modal Number" value="{{$variations->product->model}}" name="model" id="model" required disabled />
                      @endif
                      <div id="modelErr" class="invalid-feedback"></div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12 col-md-3">
                  <div class="ek_group">
                    <label class="eklabel req"><span>Product HSN:<span class="req_star">*</span></span></label>
                    <div class="ek_f_input">
                      <input type="text" class="form-control" placeholder="Enter HSN Code"  value="{{$variations->product->hsn}}"  name="product_hsn" id="product_hsn" required />
                      
                      <div id="product_hsnErr" class="invalid-feedback"></div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12 col-md-3">
                  <div class="ek_group">
                    <label class="eklabel req"><span>GST Bracket:<span class="req_star">*</span></span></label>
                    <div class="ek_f_input">
                      <select class="form-select" name="gst_bracket" id="gst_bracket"  value="{{$variations->product->gst_percentage}}"  required>
                   
                      <option value="0" {{ $variations->product->gst_percentage == '0' ? 'selected' : '' }}>0%</option>
                      <option value="5" {{ $variations->product->gst_percentage == '5' ? 'selected' : '' }}>5%</option>
                      <option value="12" {{ $variations->product->gst_percentage == '12' ? 'selected' : '' }}>12%</option>
                      <option value="18" {{ $variations->product->gst_percentage == '18' ? 'selected' : '' }}>18%</option>
                      <option value="28" {{ $variations->product->gst_percentage == '28' ? 'selected' : '' }}>28%</option>
                      </select>
                      <div id="gst_bracketErr" class="invalid-feedback"></div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12 col-md-3">
                  <div class="ek_group">
                    <label class="eklabel req"><span>Availability:<span class="req_star">*</span></span></label>
                    <div class="ek_f_input">
                    @if(auth()->user()->hasRole(ROLE_ADMIN))
                      <select class="form-select" name="availability" value="{{$variations->product->availability_status}}" id="availability" required>
                      @else
                      <select class="form-select" name="availability" value="{{$variations->product->availability_status}}" id="availability" disabled>
                      @endif
                        <option value="1">Till Stock Lasts</option>
                        <option value="2" selected>Regular Available</option>
                      </select>
                      <div id="availabilityErr" class="invalid-feedback"></div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12 col-md-3">
                  <div class="ek_group">
                    <label class="eklabel req">UPC:</label>
                    <div class="ek_f_input">
                    @if(auth()->user()->hasRole(ROLE_ADMIN))
                      <input type="text" class="form-control" placeholder="Universal Product Code" value="{{$variations->product->upc}}" name="upc" id="upc" />
                      @else
                      <input type="text" class="form-control" placeholder="Universal Product Code" value="{{$variations->product->upc}}" name="upc" id="upc" disabled/>
                      @endif
                      <div id="upcErr" class="invalid-feedback"></div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12 col-md-3">
                  <div class="ek_group">
                    <label class="eklabel req">ISBN:</label>
                    <div class="ek_f_input">
                    @if(auth()->user()->hasRole(ROLE_ADMIN))
                      <input type="text" class="form-control" placeholder="International Standard Book Number" value="{{$variations->product->isbn}}" name="isbn" id="isbn" />
                      @else
                      <input type="text" class="form-control" placeholder="International Standard Book Number" value="{{$variations->product->isbn}}" name="isbn" id="isbn" disabled />
                      @endif
                      <div id="isbnErr" class="invalid-feedback"></div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12 col-md-3">
                  <div class="ek_group">
                    <label class="eklabel req">MPN:</label>
                    <div class="ek_f_input">
                    @if(auth()->user()->hasRole(ROLE_ADMIN))
                      <input type="text" class="form-control" placeholder="Manufacturer Port Number" value="{{$variations->product->mpin}}" name="mpn" id="mpn" />
                      @else
                      <input type="text" class="form-control" placeholder="Manufacturer Port Number" value="{{$variations->product->mpin}}" name="mpn" id="mpn" disabled />
                      @endif
                      <div id="mpnErr" class="invalid-feedback"></div>
                    </div>
                  </div>
                </div>
              </div>
              <h4 class="subheading">Product Dimensions</h4>
              <div class="row">
                <div class="col-sm-12 col-md-3">
                  <div class="ek_group">
                    <label class="eklabel req"><span>Length:<span class="req_star">*</span></span></label>
                    <div class="ek_f_input">
                      <input type="text" class="form-control" placeholder="100" value="{{$variations->length}}" name="length" id="length" required />
                      <div id="lengthErr" class="invalid-feedback"></div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12 col-md-3">
                  <div class="ek_group">
                    <label class="eklabel req"><span>Width:<span class="req_star">*</span></span></label>
                    <div class="ek_f_input">
                      <input type="text" class="form-control" placeholder="100" value="{{$variations->width}}" name="width" id="width" required />
                      <div id="widthErr" class="invalid-feedback"></div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12 col-md-3">
                  <div class="ek_group">
                    <label class="eklabel req"><span>Height:<span class="req_star">*</span></span></label>
                    <div class="ek_f_input">
                      <input type="text" class="form-control" placeholder="100" name="height" value="{{$variations->height}}" id="height" required />
                      <div id="heightErr" class="invalid-feedback"></div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12 col-md-3">
                  <div class="ek_group">
                    <label class="eklabel req"><span>Dimension Unit:<span class="req_star">*</span></span></label>
                    <div class="ek_f_input">
                      <select class="form-select" name="dimension_class" id="dimension_class" required>
                      <option value="mm" {{ $variations->package_dimension_class == 'mm' ? 'selected' : '' }}>mm</option>
                       <option value="cm" {{ $variations->package_dimension_class == 'cm' ? 'selected' : '' }}>cm</option>
                        <option value="inch" {{ $variations->package_dimension_class == 'inch' ? 'selected' : '' }}>inch</option>

                      </select>
                      <div id="dimension_classErr" class="invalid-feedback"></div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12 col-md-3">
                  <div class="ek_group">
                    <label class="eklabel req"><span>Weight:<span class="req_star">*</span></span></label>
                    <div class="ek_f_input">
                      <input type="text" class="form-control" placeholder="100" value="{{$variations->weight}}" name="weight" id="weight" required />
                      <div id="weightErr" class="invalid-feedback"></div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12 col-md-3">
                  <div class="ek_group">
                    <label class="eklabel req"><span>Weight Unit:<span class="req_star">*</span></span></label>
                    <div class="ek_f_input">
                      <select class="form-select" name="weight_class" id="weight_class" required>
                      <option value="mg" {{ $variations->weight_class == 'mg' ? 'selected' : '' }}>mg</option>
                      <option value="gm" {{ $variations->weight_class == 'gm' ? 'selected' : '' }}>gm</option>
                      <option value="kg" {{ $variations->weight_class == 'kg' ? 'selected' : '' }}>kg</option>
                      <option value="ml" {{ $variations->weight_class == 'ml' ? 'selected' : '' }}>ml</option>
                      <option value="ltr" {{ $variations->weight_class == 'ltr' ? 'selected' : '' }}>ltr</option>

                      </select>
                      <div id="weight_classErr" class="invalid-feedback"></div>
                    </div>
                  </div>
                </div>
              </div>
              <h4 class="subheading">Package Dimensions Per Piece</h4>
              <div class="row">
                <div class="col-sm-12 col-md-3">
                  <div class="ek_group">
                    <label class="eklabel req"><span>Length:<span class="req_star">*</span></span></label>
                    <div class="ek_f_input">
                      <input type="text" class="form-control" placeholder="100" value="{{$variations->package_length}}" name="package_length" id="package_length" required />
                      <div id="package_lengthErr" class="invalid-feedback"></div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12 col-md-3">
                  <div class="ek_group">
                    <label class="eklabel req"><span>Width:<span class="req_star">*</span></span></label>
                    <div class="ek_f_input">
                      <input type="text" class="form-control" placeholder="100" value="{{$variations->package_width}}" name="package_width" id="package_width" required />
                      <div id="package_widthErr" class="invalid-feedback"></div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12 col-md-3">
                  <div class="ek_group">
                    <label class="eklabel req"><span>Height:<span class="req_star">*</span></span></label>
                    <div class="ek_f_input">
                      <input type="text" class="form-control" placeholder="100" value="{{$variations->package_height}}" name="package_height" id="package_height" required />
                      <div id="package_heightErr" class="invalid-feedback"></div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12 col-md-3">
                  <div class="ek_group">
                    <label class="eklabel req"><span>Dimension Unit:<span class="req_star">*</span></span></label>
                    <div class="ek_f_input">
                      <select class="form-select" name="package_dimension_class" id="package_dimension_class" required>
                      <option value="mm" {{ $variations->package_dimension_class == 'mm' ? 'selected' : '' }}>mm</option>
                      <option value="cm" {{ $variations->package_dimension_class == 'cm' ? 'selected' : '' }}>cm</option>
                      <option value="inch" {{ $variations->package_dimension_class == 'inch' ? 'selected' : '' }}>inch</option>

                      </select>
                      <div id="package_dimension_classErr" class="invalid-feedback"></div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12 col-md-3">
                  <div class="ek_group">
                    <label class="eklabel req"><span>Weight:<span class="req_star">*</span></span></label>
                    <div class="ek_f_input">
                      <input type="text" class="form-control" placeholder="100" value="{{$variations->package_weight}}" name="package_weight" id="package_weight" required />
                      <div id="package_weightErr" class="invalid-feedback"></div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12 col-md-3">
                  <div class="ek_group">
                    <label class="eklabel req"><span>Weight Unit:<span class="req_star">*</span></span></label>
                    <div class="ek_f_input">
                      <select class="form-select" name="package_weight_class" id="package_weight_class" required>
                      <option value="mg" {{ $variations->package_weight_class == 'mg' ? 'selected' : '' }}>mg</option>
                      <option value="gm" {{ $variations->package_weight_class == 'gm' ? 'selected' : '' }}>gm</option>
                      <option value="kg" {{ $variations->package_weight_class == 'kg' ? 'selected' : '' }}>kg</option>
                      <option value="ml" {{ $variations->package_weight_class == 'ml' ? 'selected' : '' }}>ml</option>
                      <option value="ltr" {{ $variations->package_weight_class == 'ltr' ? 'selected' : '' }}>lt</option>

                      </select>
                      <div id="package_weight_classErr" class="invalid-feedback"></div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12 col-md-3">
                  <div class="ek_group">
                    <label class="eklabel req"><span>Volumetric Weight in kg:<span class="req_star">*</span></span></label>
                    <div class="ek_f_input">
                      <input type="text" class="form-control" placeholder="L*W*H/5000" value="{{$variations->package_volumetric_weight}}" readonly name="package_volumetric_weight" id="package_volumetric_weight" required />
                      <div id="package_volumetric_weightErr" class="invalid-feedback"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="saveform_footer">
              <button type="button" class="btn btn-login btnekomn card_f_btn previous_Tab"><i class="fas fa-arrow-left me-3 fs-13"></i>Back</button>
              <button type="button" class="btn btn-login btnekomn card_f_btn" id="dataAndDimesionTab">Save & Next</button>
            </div>
          </div>
          <div class="tab-pane fade" id="images" role="tabpanel" aria-labelledby="images-tab" tabindex="0">
            <div class="addProductForm eklabel_wm">
              @if($variations->allow_editable)
              <h6>Do you have variants of this product?</h6>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="variant" id="yes" />
                <label class="form-check-label" for="yes">Yes</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="variant" id="no" checked />
                <label class="form-check-label" for="no">No</label>
              </div>
              @else
              <input class="form-check-input" type="radio" name="variant" id="no" checked style="display:none;"/>
              <input class="form-check-input" type="radio" name="variant" id="yes" style="display:none;"/>
              @endif
              
              <div class="noblock mt15 no_variant">
                <div class="single-row">
                  <div class="singlebox" id="variationColor">
                    <div class="mb10">
                      <label for="">Color<span class="req_star">*</span></label>
                      <select class="form-select" name="color" id="color" required>
                        <option value="default" {{ $variations->color == 'default' ? 'selected' : '' }}>Default</option>
                        <option value="beige" {{ $variations->color == 'beige' ? 'selected' : '' }}>Beige</option>
                        <option value="black" {{ $variations->color == 'black' ? 'selected' : '' }}>Black</option>
                        <option value="blue" {{ $variations->color == 'blue' ? 'selected' : '' }}>Blue</option>
                        <option value="brown" {{ $variations->color == 'brown' ? 'selected' : '' }}>Brown</option>
                        <option value="gold" {{ $variations->color == 'gold' ? 'selected' : '' }}>Gold</option>
                        <option value="green" {{ $variations->color == 'green' ? 'selected' : '' }}>Green</option>
                        <option value="grey" {{ $variations->color == 'grey' ? 'selected' : '' }}>Grey</option>
                        <option value="maroon" {{ $variations->color == 'maroon' ? 'selected' : '' }}>Maroon</option>
                        <option value="multicolor" {{ $variations->color == 'multicolor' ? 'selected' : '' }}>Multicolor</option>
                        <option value="orange" {{ $variations->color == 'orange' ? 'selected' : '' }}>Orange</option>
                        <option value="pink" {{ $variations->color == 'pink' ? 'selected' : '' }}>Pink</option>
                        <option value="purple" {{ $variations->color == 'purple' ? 'selected' : '' }}>Purple</option>
                        <option value="red" {{ $variations->color == 'red' ? 'selected' : '' }}>Red</option>
                        <option value="silver" {{ $variations->color == 'silver' ? 'selected' : '' }}>Silver</option>
                        <option value="white" {{ $variations->color == 'white' ? 'selected' : '' }}>White</option>
                        <option value="yellow" {{ $variations->color == 'yellow' ? 'selected' : '' }}>Yellow</option>
                      </select>

                    </div>
                    <div class="image-upload-box" id="box-1" onclick="triggerUpload('box-1')">
                      <input type="file" accept="image/*" onchange="previewImage(event, 'box-1')" d/>
                   
                     
                      <img id="img-box-1" src="{{$variations->media[0]->file_path}}" alt="Image" />
                 
      
                      <div class="delete-icon" id="delete-box-1" onclick="deleteImage(event, 'box-1')" style="display: block;">&#10006;</div>
                      <div class="placeholdertext" style="display: none;">
                        <img src="{{asset('assets/images/icon/placeholder-img-1.png')}}" />
                        <h6>Upload Main Image</h6>
                      </div>
                      <div id="boxError1" class="invalid-feedback"></div>
                    </div>
                  </div>
                  <div class="colorStock">
                    <table class="v_t_c_s" id="variantSize">
                      <thead>
                        <tr>
                          <th>Size</th>
                          <th>Stock</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>
                            <input type="text" class="smallInput_n" placeholder="Size" value="{{$variations->size}}" id="size" name="size">
                            <div id="sizeErr" class="invalid-feedback"></div>
                          </td>
                          <td>
                            <input type="text" class="smallInput_n" placeholder="0" value="{{$variations->stock}}" id="stock" name="stock">
                            <div id="stockErr" class="invalid-feedback"></div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="multi-row">
                  @for($i = 1; $i < 9; $i++)
                    @if(isset($image[$i]))
                    <div class="image-upload-box" id="box-{{$i+1}}" onclick="triggerUpload('box-{{$i+1}}')">
                    <input type="file" accept="image/*" onchange="previewImage(event, 'box-{{$i+1}}')" />
                    <img id="img-box-{{$i+1}}" src="{{asset($image[$i]->file_path)}}" alt="Image" />
                    <div class="delete-icon" id="delete-box-{{$i+1}}" onclick="deleteImage(event, 'box-{{$i+1}}')" style="display: block;">&#10006;</div>
                    <div class="placeholdertext" style="display: none;">
                      <img src="{{asset('assets/images/icon/placeholder-img-1.png')}}" />
                      <h6>Upload Image</h6>
                    </div>
                    
                  </div>
                    @else
                    <div class="image-upload-box" id="box-{{$i+1}}" onclick="triggerUpload('box-{{$i+1}}')">
                    <input type="file" accept="image/*" onchange="previewImage(event, 'box-{{$i+1}}')" />
                    <img id="img-box-{{$i+1}}" alt="Image" style="display: none;" />
                    <div class="delete-icon" id="delete-box-{{$i+1}}" onclick="deleteImage(event, 'box-{{$i+1}}')">&#10006;</div>
                    <div class="placeholdertext">
                    <img src="{{asset('assets/images/icon/placeholder-img-1.png')}}" />
                      <h6>Upload Image</h6>
                    </div>
                  </div>
                    @endif
                  
                  @endfor 
                  @isset($video->file_path)                 
                  <div class="video-container">
                    <div class="video-placeholder" style="display: none;">
                      <div style="margin: 4px 0px 2px 0px;">
                        <svg viewBox="0 0 64 64" width="38" height="38" fill="#FAFAFA">
                          <circle cx="32" cy="32" r="32" fill="rgba(0,0,0,0.15)" />
                          <polygon points="25,16 25,48 48,32" />
                        </svg>
                      </div>
                      <h6>Upload Video</h6>
                    </div>
                    <video class="video-element" style="display:block;">
                      <source src="{{asset('storage/'.$video->file_path) ?? ''}}" class="video-source">
                    </video>
                    <div class="play-icon" style="display:block;">
                      <svg viewBox="0 0 64 64" width="44" height="44" fill="white">
                        <circle cx="32" cy="32" r="32" fill="rgba(0,0,0,0.5)" />
                        <polygon points="25,16 25,48 48,32" />
                      </svg>
                    </div>
                    <div class="delete-icon" style="display:block;">&#10006;</div>
                    <input type="file" class="file-input" accept="video/*" >
                  </div>
                  @else
                  <div class="video-container">
                        <div class="video-placeholder">
                          <div style="margin: 4px 0px 2px 0px;">
                            <svg viewBox="0 0 64 64" width="38" height="38" fill="#FAFAFA">
                              <circle cx="32" cy="32" r="32" fill="rgba(0,0,0,0.15)" />
                              <polygon points="25,16 25,48 48,32" />
                            </svg>
                          </div>
                          <h6>Upload Video</h6>
                        </div>
                        <video class="video-element">
                          <source src="" class="video-source">
                        </video>
                        <div class="play-icon">
                          <svg viewBox="0 0 64 64" width="44" height="44" fill="white">
                            <circle cx="32" cy="32" r="32" fill="rgba(0,0,0,0.5)" />
                            <polygon points="25,16 25,48 48,32" />
                          </svg>
                        </div>
                        <div class="delete-icon">&#10006;</div>
                        <input type="file" class="file-input" accept="video/*" required>
                      </div>
                  @endif
                </div>
              </div>
              
              <div class="yesblock yes_variant">
                <div class="main-container" id="main-container">
                  <div class="imagecontainer" id="imagecontainerVariation-1">
                    <div class="single-row">
                      <div class="singlebox" id="variationColor-1">
                        <div class="mb10">
                          <label for="">Color<span class="req_star">*</span></label>
                          <select class="form-select" required>
                            <option value="beige">Beige</option>
                            <option value="black">Black</option>
                            <option value="blue">Blue</option>
                            <option value="brown">Brown</option>
                            <option value="gold">Gold</option>
                            <option value="green">Green</option>
                            <option value="grey">Grey</option>
                            <option value="maroon">Maroon</option>
                            <option value="multicolor">Multicolor</option>
                            <option value="orange">Orange</option>
                            <option value="pink">Pink</option>
                            <option value="purple">Purple</option>
                            <option value="red">Red</option>
                            <option value="silver">Silver</option>
                            <option value="white">White</option>
                            <option value="yellow">Yellow</option>
                          </select>
                        </div>
                        <div class="image-upload-box" id="box1-1" onclick="triggerUpload('box1-1')">
                          <input type="file" accept="image/*" onchange="previewImage(event, 'box1-1')" required />
                          <img id="img-box1-1" src="" alt="Image 1" style="display: none;" />
                          <div class="delete-icon" id="delete-box1-1" onclick="deleteImage(event, 'box1-1')">&#10006;</div>
                          <div class="placeholdertext">
                            <img src="{{asset('assets/images/icon/placeholder-img-1.png')}}" />
                            <h6>Upload Main Image</h6>
                          </div>
                        </div>
                      </div>
                      <div class="colorStock">
                        <table class="v_t_c_s" id="variantSize-1">
                          <thead>
                            <tr>
                              <th>Size</th>
                              <th>Stock</th>
                              <th></th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>
                                <input type="text" class="smallInput_n" placeholder="Size" id="size-0" name="size">
                                <div id="sizeErr-0" class="invalid-feedback"></div>
                              </td>
                              <td>
                                <input type="text" class="smallInput_n" placeholder="0" id="stock-0" name="stock">
                                <div id="stockErr-0" class="invalid-feedback"></div>
                              </td>
                              <td>
                                <button class="deleteRow lookdisable" type="button"><i class="far fa-trash-alt"></i></button>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        <button class="btn btn-sm addNewRow mt8 addSize" id="addSize" type="button">Add More Size</button>
                      </div>
                    </div>
                    <div class="multi-row">
                      <div class="image-upload-box" id="box1-2" onclick="triggerUpload('box1-2')">
                        <input type="file" accept="image/*" onchange="previewImage(event, 'box1-2')" required />
                        <img id="img-box1-2" src="#" alt="Image 2" style="display: none;" />
                        <div class="delete-icon" id="delete-box1-2" onclick="deleteImage(event, 'box1-2')">&#10006;</div>
                        <div class="placeholdertext">
                          <img src="{{asset('assets/images/icon/placeholder-img-1.png')}}" />
                          <h6>Upload Image</h6>
                        </div>
                      </div>
                      <div class="image-upload-box" id="box1-3" onclick="triggerUpload('box1-3')">
                        <input type="file" accept="image/*" onchange="previewImage(event, 'box1-3')" required />
                        <img id="img-box1-3" src="#" alt="Image 3" style="display: none;" />
                        <div class="delete-icon" id="delete-box1-3" onclick="deleteImage(event, 'box1-3')">&#10006;</div>
                        <div class="placeholdertext">
                          <img src="{{asset('assets/images/icon/placeholder-img-1.png')}}" />
                          <h6>Upload Image</h6>
                        </div>
                      </div>
                      <div class="image-upload-box" id="box1-4" onclick="triggerUpload('box1-4')">
                        <input type="file" accept="image/*" onchange="previewImage(event, 'box1-4')" required />
                        <img id="img-box1-4" src="#" alt="Image 4" style="display: none;" />
                        <div class="delete-icon" id="delete-box1-4" onclick="deleteImage(event, 'box1-4')">&#10006;</div>
                        <div class="placeholdertext">
                          <img src="{{asset('assets/images/icon/placeholder-img-1.png')}}" />
                          <h6>Upload Image</h6>
                        </div>
                      </div>
                      <div class="image-upload-box" id="box1-5" onclick="triggerUpload('box1-5')">
                        <input type="file" accept="image/*" onchange="previewImage(event, 'box1-5')" required />
                        <img id="img-box1-5" src="#" alt="Image 5" style="display: none;" />
                        <div class="delete-icon" id="delete-box1-5" onclick="deleteImage(event, 'box1-5')">&#10006;</div>
                        <div class="placeholdertext">
                          <img src="{{asset('assets/images/icon/placeholder-img-1.png')}}" />
                          <h6>Upload Image</h6>
                        </div>
                      </div>
                      <div class="image-upload-box" id="box1-6" onclick="triggerUpload('box1-6')">
                        <input type="file" accept="image/*" onchange="previewImage(event, 'box1-6')" required />
                        <img id="img-box1-6" src="#" alt="Image 6" style="display: none;" />
                        <div class="delete-icon" id="delete-box1-6" onclick="deleteImage(event, 'box1-6')">&#10006;</div>
                        <div class="placeholdertext">
                          <img src="{{asset('assets/images/icon/placeholder-img-1.png')}}" />
                          <h6>Upload Image</h6>
                        </div>
                      </div>
                      <div class="image-upload-box" id="box1-7" onclick="triggerUpload('box1-7')">
                        <input type="file" accept="image/*" onchange="previewImage(event, 'box1-7')" required />
                        <img id="img-box1-7" src="#" alt="Image" style="display: none;" />
                        <div class="delete-icon" id="delete-box1-7" onclick="deleteImage(event, 'box1-7')">&#10006;</div>
                        <div class="placeholdertext">
                          <img src="{{asset('assets/images/icon/placeholder-img-1.png')}}" />
                          <h6>Upload Image</h6>
                        </div>
                      </div>
                      <div class="image-upload-box" id="box1-8" onclick="triggerUpload('box1-8')">
                        <input type="file" accept="image/*" onchange="previewImage(event, 'box1-8')" required />
                        <img id="img-box1-8" src="#" alt="Image" style="display: none;" />
                        <div class="delete-icon" id="delete-box1-8" onclick="deleteImage(event, 'box1-8')">&#10006;</div>
                        <div class="placeholdertext">
                          <img src="{{asset('assets/images/icon/placeholder-img-1.png')}}" />
                          <h6>Upload Image</h6>
                        </div>
                      </div>
                      <div class="image-upload-box" id="box1-9" onclick="triggerUpload('box1-9')">
                        <input type="file" accept="image/*" onchange="previewImage(event, 'box1-9')" required />
                        <img id="img-box1-9" src="#" alt="Image" style="display: none;" />
                        <div class="delete-icon" id="delete-box1-9" onclick="deleteImage(event, 'box1-9')">&#10006;</div>
                        <div class="placeholdertext">
                          <img src="{{asset('assets/images/icon/placeholder-img-1.png')}}" />
                          <h6>Upload Image</h6>
                        </div>
                      </div>
                      <div class="video-container">
                        <div class="video-placeholder">
                          <div style="margin: 4px 0px 2px 0px;">
                            <svg viewBox="0 0 64 64" width="38" height="38" fill="#FAFAFA">
                              <circle cx="32" cy="32" r="32" fill="rgba(0,0,0,0.15)" />
                              <polygon points="25,16 25,48 48,32" />
                            </svg>
                          </div>
                          <h6>Upload Video</h6>
                        </div>
                        <video class="video-element">
                          <source src="" class="video-source">
                        </video>
                        <div class="play-icon">
                          <svg viewBox="0 0 64 64" width="44" height="44" fill="white">
                            <circle cx="32" cy="32" r="32" fill="rgba(0,0,0,0.5)" />
                            <polygon points="25,16 25,48 48,32" />
                          </svg>
                        </div>
                        <div class="delete-icon">&#10006;</div>
                        <input type="file" class="file-input" accept="video/*" required>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="clearfix mb25">
                  <button class="btn btn-sm addNewRow mt10" type="button" onclick="addNewContainer()">Add More Variant</button>
                </div>
              </div>
              
            </div>
            <div class="form-group mt15">
              <label>Product Listing Status</label>
              @if(isset($variations->product->category->name) && $variations->product->category->name == 'Unknown')
                <select id="product_listing_status" class="form-select w_200_f" required disabled>
                  @else
                  <select id="product_listing_status" class="form-select w_200_f" required >
                    @endif
                    @if($variations->allow_editable)
                      <option value="1" @if($variations->availability_status == 1) selected @endif>Active</option>
                      <option value="2" @if($variations->availability_status == 2) selected @endif>Inactive</option>
                      <option value="3" @if($variations->availability_status == 3) selected @endif>Out of Stock</option>
                      <option value="4" @if($variations->availability_status == 4) selected @endif>Draft</option>
                    @else
                      <option value="1" @if($variations->availability_status == 1) selected @endif>Active</option>
                      <option value="2" @if($variations->availability_status == 2) selected @endif>Inactive</option>
                      <option value="3" @if($variations->availability_status == 3) selected @endif>Out of Stock</option>
                      
                    @endif
               
                </select>
              </select>
            </div>
            <div class="saveform_footer">
              <button type="button" class="btn btn-login btnekomn card_f_btn previous_Tab"><i class="fas fa-arrow-left me-3 fs-13"></i>Back</button>
              <button type="button" class="btn btn-login btnekomn card_f_btn" id="submitInventoryForm">Submit</button>
            </div>
          </div>
          <!-- </form> -->
        </div>
      </div>
    </div>
  </div>
  @include('dashboard.layout.copyright')
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Append Keyword data
 
  const tagContainer = document.querySelector(".tag-container");
  function createTag(label) {
    const div = document.createElement("div");
    div.setAttribute("class", "tag");
    const span = document.createElement("span");
    span.innerHTML = label.trim();
    div.appendChild(span);
    const closeIcon = document.createElement("span");
    closeIcon.innerHTML = "";
    @if(auth()->user()->hasRole(ROLE_ADMIN))
    closeIcon.setAttribute("class", "remove-tag");
    @endif
    closeIcon.onclick = function () {
      tagContainer.removeChild(div);
    };
    div.appendChild(closeIcon);
    return div;
  }
    $(document).ready(function() {
      $('#no').click(function(){
      $('#product_listing_status').append('<option value="4">Draft</option>');
    });
    $('#yes').click(function(){
      $('#product_listing_status option[value="4"]').remove();
    });
  @foreach($variations->product->keywords as  $key => $keyword)
      let a{{$key}} = "{{$keyword->keyword}}";
      let input{{$key}} = document.querySelector("#tag-input");
    const inputValue{{$key}} = a{{$key}}.trim().replace(/,$/, '');
    if(inputValue{{$key}} !== "") {
      let tag = createTag(inputValue{{$key}});
      tagContainer.insertBefore(tag, input{{$key}}.parentElement);
      input{{$key}}.value = "";
    }
    @endforeach
  });

    // populate features list
    var featureList = $('#features-list');
  $(document).ready(function(){
    $('#product_listing_status').on('change', function() {
        if(this.value == 3){
          Swal.fire({
            title: 'If your selected Out of Stock then your stock will be 0.',
            didOpen: () => {
        // Apply inline CSS to the title
        const title = Swal.getTitle();
        title.style.color = 'red';
        title.style.fontSize = '20px';

        // Apply inline CSS to the content
        const content = Swal.getHtmlContainer();
        content.style.color = 'blue';

        // Apply inline CSS to the confirm button
        const confirmButton = Swal.getConfirmButton();
        confirmButton.style.backgroundColor = '#feca40';
        confirmButton.style.color = 'white';
    }
          });
          
        }
      });
  var newFeature = '';
  @foreach($variations->product->features as $key => $feature)
  let featureName{{$key}} = "{{$feature->feature_name}}";
  newFeature = $('<li>');
      newFeature.html(`
            <div class="featurescontent">
              ${featureName{{$key}}.replace(/\n/g, '<br>')}
              @if(auth()->user()->hasRole(ROLE_ADMIN))
              <div class="f_btn f_btn_rightSide">
                <button class="btn btn-link btn-sm me-1 p-1 edit-feature" type="button"><i class="fas fa-pencil-alt"></i></button>
                <button class="btn btn-link btn-sm text-danger p-1 delete-feature" type="button"><i class="fas fa-trash"></i></button>
              </div>
                 @endif
            </div>
          `);
      featureList.append(newFeature);
    // Bind the event handlers for delete and edit buttons
    @if(auth()->user()->hasRole(ROLE_ADMIN))
    bindFeatureEvents(newFeature);
    @endif
  @endforeach
  });

  function bindFeatureEvents(feature) {
    feature.find('.delete-feature').on('click', function() {
      feature.remove();
      if (featureList.children().length < 7) {
        $('#add-feature').prop('disabled', false);
      }
    });

    feature.find('.edit-feature').on('click', function() {
      const content = feature.find('.featurescontent').html().split('<div')[0].trim().replace(/<br>/g, '\n');
      $('#product-description').val(content);
      feature.remove();
      if (featureList.children().length < 7) {
        $('#add-feature').prop('disabled', false);
      }
    });
  }

  const formData = new FormData();

  const searchCategory = document.getElementById("tag-input");
  // Event listener for clicking outside the tag input field
  searchCategory.addEventListener("blur", (e) => {
    let keyWordInput = '';
    $('.tag-container .tag').each(function(index) {
      if (index !== $('.tag-container .tag').length - 1) {
        keyWordInput += $(this).text() + ',';
      } else {
        keyWordInput += $(this).text();
      }
    });
    ApiRequest('product/find-category?tags=' + keyWordInput, 'GET')
      .then(response => {
        if (response.data.status) {
          $('#product_category').empty();
          $('#product_sub_category').empty();
          $('#product_category').append().val(response.data.result.main_category);
          $('#product_sub_category').append().val(response.data.result.sub_category);

          $('#product_category_id').empty();
          $('#product_sub_category_id').empty();
          $('#product_category_id').append().val(response.data.result.main_category_id);
          $('#product_sub_category_id').append().val(response.data.result.sub_category_id);
          const mainCategory = $('#product_category').val();
          if( mainCategory == 'Unknown' ) {
            $('#product_listing_status').val('2');
            $('#product_listing_status').attr('disabled', true);
          }else{
            $('#product_listing_status').attr('disabled', false);
          }
        }
      })
      .catch(error => {
        console.error('Error222:', error);
      });
  });

  $('#add-feature').on('click', function() {
      const textarea = $('#product-description');;
      if (textarea.val().trim() === '') {
        return;
      }
      newFeature = $('<li>');
      newFeature.html(`
            <div class="featurescontent">
              ${textarea.val().replace(/\n/g, '<br>')}
              <div class="f_btn f_btn_rightSide">
                <button class="btn btn-link btn-sm me-1 p-1 edit-feature" type="button"><i class="fas fa-pencil-alt"></i></button>
                <button class="btn btn-link btn-sm text-danger p-1 delete-feature" type="button"><i class="fas fa-trash"></i></button>
              </div>
            </div>
          `);
      featureList.append(newFeature);
      // Bind the event handlers for delete and edit buttons
      bindFeatureEvents(newFeature);
      textarea.val('');
      if (featureList.children().length >= 7) {
        $('#add-feature').prop('disabled', true);
      }
    });
  // Start code General Tab Step 1
  $('#generaltab').click(function() {

    let isValid = true;

    const productName = $('#product_name').val();
    const productDescription = $('#product_description').val();
    const mainCategory = $('#product_category').val();
    const subCategory = $('#product_sub_category').val();
    const mainCategoryId = $('#product_category_id').val();
    const subCategoryId = $('#product_sub_category_id').val();
    const features = $('#features-list').children().length;

    // Validate Product Keywords
    const tagInputValue = $('#tag-input').val().trim();
    const tagCount = $('.tag-container .tag').length;

    $('.error').text('');

    if (!productName) {
      $('#product_name').addClass('is-invalid');
      $('#product_nameErr').text('Product Name is required.');
      isValid = false;
    } else {
      $('#product_name').removeClass('is-invalid');
      $('#product_nameErr').text('');
    }
    if (!productDescription) {
      $('#product_description').addClass('is-invalid');
      $('#product_descriptionErr').text('Product Description is required.');
      isValid = false;
    } else {
      $('#product_description').removeClass('is-invalid');
      $('#product_descriptionErr').text('');
    }
    if (tagCount === 0) {
      $('#tag-input').addClass('is-invalid');
      $('#tag-inputErr').text('Product Keywords are required.');
      isValid = false;
    } else {
      $('#tag-input').removeClass('is-invalid');
      $('#tag-inputErr').text('');
    }
    if (features === 0) {
      $('#features-error').removeClass('hide');
      isValid = false;
    } else {
      $('#features-error').addClass('hide');
    }
    if (!mainCategory) {
      $('#product_category').addClass('is-invalid');
      $('#product_categoryErr').text('Main Category is required.');
      isValid = false;
    } else {
      $('#product_category').removeClass('is-invalid');
      $('#product_categoryErr').text('');
    }
    if (!subCategory) {
      $('#product_sub_category').addClass('is-invalid');
      $('#product_sub_categoryErr').text('Sub Category is required.');
      isValid = false;
    } else {
      $('#product_sub_category').removeClass('is-invalid');
      $('#product_sub_categoryErr').text('');
    }

    @if(auth()->user()->hasRole(ROLE_ADMIN))
    const supplierId = $('#supplier_id').val();
    if (!supplierId) {
      $('#supplier_id').addClass('is-invalid');
      $('#supplier_idErr').text('Supplier Id is required.');
      isValid = false;
    } else {
      $('#supplier_id').removeClass('is-invalid');
      $('#supplier_idErr').text('');
    }
    formData.append('supplier_id', supplierId);
    @endif

    if (isValid) {
      $('#features-list').children().each(function(index) {
        const feature = $(this).find('.featurescontent').html().split('<div')[0].trim().replace(/<br>/g, '\n');
        formData.append(`feature[${index}]`, feature);
      });

      // Add Product Keywords to FormData

      $('.tag-container .tag').each(function(index) {
        formData.append(`product_keywords[${index}]`, $(this).text());

      });

      formData.append('product_name', productName);
      formData.append('product_description', productDescription);
      formData.append('product_category', mainCategory);
      formData.append('product_sub_category', subCategory);
      formData.append('product_category_id', mainCategoryId);
      formData.append('product_sub_category_id', subCategoryId);
      formData.append('varition_id', $('#varition_id').val());

      // Proceed to next step
      document.querySelector('a[data-bs-target="#shipping"]').click();
    }

  });
  // End code General Tab Step 1

  // -----------------------------------------------------------------------------------

  // Start code Shipping Tab Step 2
  $('#shippingTab').click(function() {
    let isValid = true;

    // Clear previous errors
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').text('');

    // Validate Single Piece / Dropship Rate
    const dropshipRate = $('#dropship_rate').val();
    if (!dropshipRate) {
      $('#dropship_rate').addClass('is-invalid');
      $('#dropship_rateErr').text('Dropship Rate is required.');
      isValid = false;

      
    } else if (!/^\d+$/.test(dropshipRate)) {
        $('#dropship_rate').addClass('is-invalid');
        $('#dropship_rateErr').text('Dropship Rate should be a number.');
        isValid = false;
      }

    // Validate Potential MRP
    const potentialMrp = $('#potential_mrp').val();
    if (!potentialMrp) {
      $('#potential_mrp').addClass('is-invalid');
      $('#potential_mrpErr').text('Potential MRP is required.');
      isValid = false;
    }else if (!/^\d+$/.test(potentialMrp)) {
        $('#potential_mrp').addClass('is-invalid');
        $('#potential_mrpErr').text('Potential MRP should be a number.');
        isValid = false;
      }


    const check_bulk_quantity = [];
    const check_bulk_price = [];
    // Validate Bulk Rate table rows
    $('#bulkRateTable tbody tr').each(function(index) {
      const quantityInput = $(this).find('input[name^="bulk"][name$="[quantity]"]');
      const priceInput = $(this).find('input[name^="bulk"][name$="[price]"]');
      const quantity = quantityInput.val();
      const price = priceInput.val();
      if (!quantity) {
        quantityInput.addClass('is-invalid form-control');
        $('#bulk_quantityErr'+index).text('Quantity is required.');
        isValid = false;
      } else if(!/^\d+$/.test(quantity)){ 
        quantityInput.addClass('is-invalid form-control');
        $('#bulk_quantityErr'+index).text('Quantity should be a number.');
        isValid = false;
      }else {
        quantityInput.removeClass('is-invalid form-control');
        $('#bulk_quantityErr'+index).text('');
      }

      if (!price) {
        priceInput.addClass('is-invalid form-control');
        $('#bulk_priceErr'+index).text('Price is required.');
        isValid = false;
      } else if(!/^\d+$/.test(price)){
        priceInput.addClass('is-invalid'); 
        $('#bulk_priceErr'+index).text('Price should be a number.');
        isValid = false; 
      }else {
        priceInput.removeClass('is-invalid form-control');
        $('#bulk_priceErr'+index).text('');
      }
      check_bulk_quantity.push(quantity);
      check_bulk_price.push(price);
    });

    const shipping_quantity = [];
    // Validate Shipping Rate table rows
    $('#shippingRateTable tbody tr').each(function(index) {
      const quantityInput = $(this).find('input[name^="shipping"][name$="[quantity]"]');
      const localInput = $(this).find('input[name^="shipping"][name$="[local]"]');
      const regionalInput = $(this).find('input[name^="shipping"][name$="[regional]"]');
      const nationalInput = $(this).find('input[name^="shipping"][name$="[national]"]');
      const quantity = quantityInput.val();
      const local = localInput.val();
      const regional = regionalInput.val();
      const national = nationalInput.val();

      if (!quantity) {
        quantityInput.addClass('is-invalid form-control');
        $('#shipping_quantityErr'+index).text('Quantity is required.');
        isValid = false;
      } else if(!/^\d+$/.test(quantity)){
        quantityInput.addClass('is-invalid');
        $('#shipping_quantityErr'+index).text('Quantity should be a number.');
        isValid = false;
      }else {
        quantityInput.removeClass('is-invalid form-control');
        $('#shipping_quantityErr'+index).text('');
      }

      if (!local) {
        localInput.addClass('is-invalid form-control');
        $('#shipping_localErr'+index).text('Local Shipping Rate is required.');
        isValid = false;
      } else if(!/^\d+$/.test(local)){
        localInput.addClass('is-invalid');
        $('#shipping_localErr'+index).text('Local Shipping Rate should be a number.');
        isValid = false;
      }else {
        localInput.removeClass('is-invalid form-control');
        $('#shipping_localErr'+index).text('');
      }

      if (!regional) {
        regionalInput.addClass('is-invalid form-control');
        $('#shipping_regionalErr'+index).text('Regional Shipping Rate is required.');
        isValid = false;
      } else if(!/^\d+$/.test(regional)){
        regionalInput.addClass('is-invalid');
        $('#shipping_regionalErr'+index).text('Regional Shipping Rate should be a number.');
        isValid = false;
      }else {
        regionalInput.removeClass('is-invalid form-control');
        $('#shipping_regionalErr'+index).text('');
      }

      if (!national) {
        nationalInput.addClass('is-invalid form-control');
        $('#shipping_nationalErr'+index).text('National Shipping Rate is required.');
        isValid = false;
      } else if(!/^\d+$/.test(national)){
        nationalInput.addClass('is-invalid');
        $('#shipping_nationalErr'+index).text('National Shipping Rate should be a number.');
        isValid = false;
      }else {
        nationalInput.removeClass('is-invalid form-control');
        $('#shipping_nationalErr'+index).text('');
      }
      shipping_quantity.push(quantity);
    });

    if (isValid) {
      // Check if the quantity is in ascending order
      let isQuantityAscending = true;
      for (let i = 1; i < check_bulk_quantity.length; i++) {
        if (parseInt(check_bulk_quantity[i]) <= parseInt(check_bulk_quantity[i - 1])) {
          isQuantityAscending = false;
          break;
        }
      }
      // check if the price is in ascending order
      let isPriceDescending = true;
      for (let i = 1; i < check_bulk_price.length; i++) {
        if (parseInt(check_bulk_price[i]) >= parseInt(check_bulk_price[i - 1])) {
          isPriceDescending = false;
          break;
        }
      }
     
      // check dropshipping price is greater then bulk order pricing
      isDropshippingGrater = true;
      if (isPriceDescending) {
        for (let i = 0; i < check_bulk_price.length; i++) {
            if (parseInt(dropshipRate) < parseInt(check_bulk_price[i])) {
              isDropshippingGrater = false;
            }
          }
      }

      // check shipping quantity is in ascending order
      let isShippingQuantityAscending = true;
      for (let i = 1; i < shipping_quantity.length; i++) {
        if (parseInt(shipping_quantity[i]) <= parseInt(shipping_quantity[i - 1])) {
          isShippingQuantityAscending = false;
          break;
        }
      }

      if(parseInt(potentialMrp) < parseInt(dropshipRate)){
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "Dropship Rate should be less than or Equal Potential MRP."
        });
      }else if(!isDropshippingGrater){
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "Dropship Rate should be greater than the Bulk Rate table."
        });
      }else if (!isQuantityAscending) {
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "Quantity should be in ascending order. Please correct the quantity in the Bulk Rate table."
        });
      }else if(!isPriceDescending){
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "Price should be in descending order. Please correct the price in the Bulk Rate table."
        });
      }else if(!isShippingQuantityAscending){
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "Shipping quantity should be in ascending order. Please correct the quantity in the Shipping Rate table."
        });
      }else{
        // Add Single Piece / Dropship Rate to FormData
        formData.append('dropship_rate', dropshipRate);
        formData.append('potential_mrp', potentialMrp);
        // Add Bulk Rate table rows to FormData
        for (let i = 0; i < check_bulk_quantity.length; i++) {
          formData.append(`bulk[${i}][quantity]`, check_bulk_quantity[i]);
          formData.append(`bulk[${i}][price]`, check_bulk_price[i]);
        }
          // Add Shipping Rate table rows to FormData
        $('#shippingRateTable tbody tr').each(function(index) {
          const quantity = $(this).find('input[name^="shipping"][name$="[quantity]"]').val();
          const local = $(this).find('input[name^="shipping"][name$="[local]"]').val();
          const regional = $(this).find('input[name^="shipping"][name$="[regional]"]').val();
          const national = $(this).find('input[name^="shipping"][name$="[national]"]').val();
          formData.append(`shipping[${index}][quantity]`, quantity);
          formData.append(`shipping[${index}][local]`, local);
          formData.append(`shipping[${index}][regional]`, regional);
          formData.append(`shipping[${index}][national]`, national);
        });
        // Proceed to next tab
        document.querySelector('a[data-bs-target="#data"]').click();
      }
    }
  });
  $('#addNewRowButton').click(function() {
    let index = $('#bulkRateTable tbody tr').length;

    const newRow = `
        <tr>
            <td>
                <input type="text" class="smallInput_n" placeholder="Qty. Upto" name="bulk[${index}][quantity]" required>
                <div id="bulk_quantityErr${index}" class="invalid-feedback"></div>
            </td>
            <td>
                <input type="text" class="smallInput_n " placeholder="Rs. 0.00" name="bulk[${index}][price]" required>
            <div id="bulk_priceErr${index}" class="invalid-feedback"></div>
                </td>
            <td>
                 <button type="button" class="deleteRow deleteBulkRow"><i class="far fa-trash-alt"></i></button>
                 
            </td>
        </tr>`;
    $('#bulkRateTable tbody').append(newRow);
  });

  // Event delegation for dynamically created delete buttons
  $('#bulkRateTable').on('click', '.deleteRow', function() {
    $(this).closest('tr').remove();
  });

  // Add Row Functionality for Shipping Rate Table
  $('#addShippingRow').click(function() {
    let index = $('#shippingRateTable tbody tr').length;

    const newRow = `
        <tr>
            <td>
                <input type="text" class="smallInput_n form-control" placeholder="Qty. Upto" name="shipping[${index}][quantity]" required>
                <div id="shipping_quantityErr${index}" class="invalid-feedback"></div>
                </td>
            <td>
                <input type="text" class="smallInput_n form-control" placeholder="Rs. 0.00" name="shipping[${index}][local]" required>
              <div id="shipping_localErr${index}" class="invalid-feedback"></div>
                </td>
            <td>
                <input type="text" class="smallInput_n form-control" placeholder="Rs. 0.00" name="shipping[${index}][regional]" required>
              <div id="shipping_regionalErr${index}" class="invalid-feedback"></div>
                </td>
            <td>
                <input type="text" class="smallInput_n form-control" placeholder="Rs. 0.00" name="shipping[${index}][national]" required>
            <div id="shipping_nationalErr${index}" class="invalid-feedback"></div>
                </td>
            <td>
                <button type="button" class="deleteRow deleteShippingRow"><i class="far fa-trash-alt"></i></button>
            </td>
        </tr>`;
    $('#shippingRateTable tbody').append(newRow);
  });
  $('#shippingRateTable').on('click', '.deleteShippingRow', function() {
    $(this).closest('tr').remove();
  });
  // End code Shipping Tab Step 2

  // -----------------------------------------------------------------------------------

  let packageLength = $('#package_length').val();
  let packageWidth = $('#package_width').val();
  let packageHeight = $('#package_height').val();
  let dimensionClass = $('#package_dimension_class').val();
  let packageVolumetricWeight = 0;

  // Add onchange function for each id
  $('#package_length').on('change', function() {
    packageLength = parseFloat($(this).val());
    packageVolumetricWeight = calculateVolumetricWeight(packageLength, packageWidth, packageHeight, dimensionClass);
    formData.append('package_volumetric_weight', packageVolumetricWeight.toFixed(3));
    parseFloat($('#package_volumetric_weight').val(packageVolumetricWeight.toFixed(3)));
  });

  $('#package_width').on('change', function() {
    packageWidth = parseFloat($(this).val());
    packageVolumetricWeight = calculateVolumetricWeight(packageLength, packageWidth, packageHeight, dimensionClass);
    formData.append('package_volumetric_weight', packageVolumetricWeight.toFixed(3));
    parseFloat($('#package_volumetric_weight').val(packageVolumetricWeight.toFixed(3)));
  });

  $('#package_height').on('change', function() {
    packageHeight = parseFloat($(this).val());
    packageVolumetricWeight = calculateVolumetricWeight(packageLength, packageWidth, packageHeight, dimensionClass);
    formData.append('package_volumetric_weight', packageVolumetricWeight.toFixed(3));
    parseFloat($('#package_volumetric_weight').val(packageVolumetricWeight.toFixed(3)));
  });

  $('#package_dimension_class').on('change', function() {
    dimensionClass = $(this).val();
    packageVolumetricWeight = calculateVolumetricWeight(packageLength, packageWidth, packageHeight, dimensionClass);
    formData.append('package_volumetric_weight', packageVolumetricWeight.toFixed(3));
    parseFloat($('#package_volumetric_weight').val(packageVolumetricWeight.toFixed(3)));
  });
  
  // Start code Data and Dimension Tab Step 3
  $('#dataAndDimesionTab').click(function() {
    let isValid = true;

    // Clear previous errors
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').text('');

    // Validate each field
    const fieldsToValidate = [{
        id: '#model',
        errorId: '#modelErr',
        errorMessage: 'Model is required.'
      },
      {
        id: '#product_hsn',
        errorId: '#product_hsnErr',
        errorMessage: 'Product HSN is required.'
      },
      {
        id: '#gst_bracket',
        errorId: '#gst_bracketErr',
        errorMessage: 'GST Bracket is required.'
      },
      {
        id: '#availability',
        errorId: '#availabilityErr',
        errorMessage: 'Availability is required.'
      },
      {
        id: '#length',
        errorId: '#lengthErr',
        errorMessage: 'Length is required.'
      },
      {
        id: '#width',
        errorId: '#widthErr',
        errorMessage: 'Width is required.'
      },
      {
        id: '#height',
        errorId: '#heightErr',
        errorMessage: 'Height is required.'
      },
      {
        id: '#dimension_class',
        errorId: '#dimension_classErr',
        errorMessage: 'Dimension Class is required.'
      },


      {
        id: '#weight',
        errorId: '#weightErr',
        errorMessage: 'Weight is required.'
      },
      {
        id: '#weight_class',
        errorId: '#weight_classErr',
        errorMessage: 'Weight Class is required.'
      },
      {
        id: '#package_length',
        errorId: '#package_lengthErr',
        errorMessage: 'Package Length is required.'
      },
      {
        id: '#package_width',
        errorId: '#package_widthErr',
        errorMessage: 'Package Width is required.'
      },
      {
        id: '#package_height',
        errorId: '#package_heightErr',
        errorMessage: 'Package Height is required.'
      },

      {
        id: '#package_dimension_class',
        errorId: '#package_dimension_classErr',
        errorMessage: 'Package Dimension Class is required.'
      },
      {
        id: '#package_weight',
        errorId: '#package_weightErr',
        errorMessage: 'Package Weight is required.'
      },
      {
        id: '#package_weight_class',
        errorId: '#package_weight_classErr',
        errorMessage: 'Package Weight Class is required.'
      },
      // {
      //   id: '#package_volumetric_weight',
      //   // errorId: '#package_volumetric_weightErr',
      //   // errorMessage: 'Package Volumetric Weight is required.'
      // },
      // {
      //   id: '#volumetric_weight',
      //   // errorId: '#volumetric_weightErr',
      //   // errorMessage: 'Volumetric Weight is required.'
      // }
    ];

    const fieldsToUnrequire = [{
        id: '#upc',
      },
      {
        id: '#isbn',
      },
      {
        id: '#mpn',
      },

      {
        id: '#package_volumetric_weight',
      },
     
    ];

    // Validate each field
    fieldsToValidate.forEach(field => {
      const value = $(field.id).val();
      if (!value) {
        $(field.id).addClass('is-invalid');
        $(field.errorId).text(field.errorMessage);
        isValid = false;
      } else if (field.id === '#length' || field.id === '#width' || field.id === '#height' || field.id === '#weight' || field.id === '#package_length' || field.id === '#package_width' || field.id === '#package_height' || field.id === '#package_weight') {
        if (!/^\d+(\.\d+)?$/.test(value)) {
          $(field.id).addClass('is-invalid');
          $(field.errorId).text('Value should be a number.');
          isValid = false;
        } 
      } else {
        $(field.id).removeClass('is-invalid');
        $(field.errorId).text('');
      }

      // if (field.id === '#length' || field.id === '#width' || field.id === '#height' || field.id === '#weight' || field.id === '#package_length' || field.id === '#package_width' || field.id === '#package_height' || field.id === '#package_weight') {
      //     if (!/^\d+$/.test(value)) {
      //       $(field.id).addClass('is-invalid');
      //       $(field.errorId).text('Value should be a number.');
      //       isValid = false;
      //     }
      //   }

      // Add event listener to handle input change
      $(field.id).on('input', function() {
        if ($(this).val().trim() !== '') {
          $(this).removeClass('is-invalid');
          $(field.errorId).text('');
        }
      });
    });

    if (isValid) {
      formData.append('package_volumetric_weight', packageVolumetricWeight.toFixed(3));
      // Add each field to FormData

      const allFields = [...fieldsToUnrequire, ...fieldsToValidate];

      allFields.forEach(field => {
        formData.append(field.id.replace('#', ''), $(field.id).val());
      });

      // Proceed to next step
      document.querySelector('a[data-bs-target="#images"]').click();
    }


  });

/**
 * Calculate the volumetric weight in kilograms based on the dimensions and unit.
 *
 * @param {number} length The length of the object.
 * @param {number} breadth The breadth of the object.
 * @param {number} height The height of the object.
 * @param {string} unit The unit of dimensions. Supported units are 'mm', 'cm', and 'inch'.
 * @return {number} The volumetric weight in kilograms.
 * @throws {Error} If an unsupported unit is provided.
 */
function calculateVolumetricWeight(length, breadth, height, unit = 'cm') {
    // Convert dimensions to centimeters
    switch (unit) {
        case 'mm':
            length /= 10;
            breadth /= 10;
            height /= 10;
            break;
        case 'in':
        case 'inch':
            length *= 2.54;
            breadth *= 2.54;
            height *= 2.54;
            break;
        case 'cm':
            // No conversion needed
            break;
        default:
            throw new Error("Unsupported unit. Please use 'mm', 'cm', or 'inch'.");
    }

    // Dimensional Weight Factor for cm to kg
    const dimensionalWeightFactor = 5000;

    // Calculate the volumetric weight in kilograms
    const volumetricWeight = (length * breadth * height) / dimensionalWeightFactor;
    return volumetricWeight;
}
  // End code Data and Dimension Tab Step 3

  // -----------------------------------------------------------------------------------

  // Start code Image Upload and video upload Step 4
  document.addEventListener("DOMContentLoaded", function() {
    // Function to initialize video upload functionality
    function initializeVideoUpload(container) {
      const fileInput = container.querySelector(".file-input");
      const video = container.querySelector("video");
      const source = container.querySelector(".video-source");
      const placeholder = container.querySelector(".video-placeholder");
      const deleteButton = container.querySelector(".delete-icon");
      const playIcon = container.querySelector(".play-icon");

      function togglePlayPause() {
        if (video.paused) {
          video.play();
        } else {
          video.pause();
        }
      }

      function handleFileChange(event) {
        const file = event.target.files[0];
        if (file) {
          source.src = URL.createObjectURL(file);
          video.style.display = "block";
          placeholder.style.display = "none";
          playIcon.style.display = "block";
          deleteButton.style.display = "block";
          video.load();
        }
      }

      function handleDeleteClick(event) {
        event.stopPropagation();
        if (!video.paused) {
          video.pause();
        } else {
          resetVideo();
        }
      }

      function resetVideo() {
        source.src = "";
        video.style.display = "none";
        placeholder.style.display = "flex";
        deleteButton.style.display = "none";
        playIcon.style.display = "none";
        fileInput.value = null;
      }
      container.addEventListener("click", (event) => {
        if (event.target === video || event.target === playIcon) {
          togglePlayPause();
        } else if (event.target === deleteButton) {
          handleDeleteClick(event);
        } else {
          fileInput.click();
        }
      });
      fileInput.addEventListener("change", handleFileChange);
      video.addEventListener("pause", () => {
        playIcon.style.display = "block";
        deleteButton.style.display = "block";
      });
      video.addEventListener("play", () => {
        playIcon.style.display = "none";
        deleteButton.style.display = "none";
      });
    }
    // Add event listener to dynamically added containers
    document.getElementById("main-container").addEventListener("DOMNodeInserted", function(event) {
      const newContainer = event.target;
      if (newContainer.classList.contains("imagecontainer")) {
        const videoContainer = newContainer.querySelector(".video-container");
        if (videoContainer) {
          initializeVideoUpload(videoContainer);
        }
      }
    });
    // Initial setup for existing containers
    const videoContainers = document.querySelectorAll(".video-container");
    videoContainers.forEach((container) => {
      initializeVideoUpload(container);
    });
  });
let stockAndSizeCounter = 1;
  document.getElementById("main-container").addEventListener("click", function(event) {
    if (event.target.classList.contains("addSize")) {
      const variantSizetbody = event.target.closest(".colorStock").querySelector("tbody");
      const newSize = document.createElement("tr");
      const sizeCell = document.createElement("td");
      const sizeInput = document.createElement("input");
      const ErrorDiv = document.createElement("div");
      sizeInput.type = "text";
      sizeInput.className = "smallInput_n";
      sizeInput.placeholder = "Size";
      sizeInput.name = "size";
      sizeInput.id = "size-"+stockAndSizeCounter;
      sizeCell.appendChild(sizeInput);
      ErrorDiv.id = "sizeErr-"+stockAndSizeCounter;
      ErrorDiv.className = "invalid-feedback";
      sizeCell.appendChild(ErrorDiv);
      const stockCell = document.createElement("td");
      const stockInput = document.createElement("input");
      stockInput.type = "text";
      stockInput.className = "smallInput_n";
      stockInput.placeholder = "0";
      stockInput.name = "stock";
      stockInput.id = "stock-"+stockAndSizeCounter;
      stockCell.appendChild(stockInput);
      const ErrorDivTwo = document.createElement("div");
      ErrorDivTwo.id = "stockErr-"+stockAndSizeCounter;
      ErrorDivTwo.className = "invalid-feedback";
      stockCell.appendChild(ErrorDivTwo);
      stockAndSizeCounter++;
      const actionCell = document.createElement("td");
      const removeButton = document.createElement("button");
      removeButton.className = "deleteRow";
      removeButton.innerHTML = '<i class="far fa-trash-alt"></i>';
      removeButton.type = "button";
      removeButton.onclick = function() {
        removeRow(this);
      };
      actionCell.appendChild(removeButton);
      newSize.appendChild(sizeCell);
      newSize.appendChild(stockCell);
      newSize.appendChild(actionCell);
      variantSizetbody.appendChild(newSize);
    }
  });

  function removeRow(button) {
    const row = button.parentNode.parentNode;
    row.parentNode.removeChild(row);
  }
  let containerCount = 1;
  let boxCount = 9;

  function triggerUpload(boxId) {
    document.querySelector(`#${boxId} input[type="file"]`).click();
  }

  function previewImage(event, boxId) {
    event.stopPropagation();
    const reader = new FileReader();
    reader.onload = function() {
      const img = document.getElementById(`img-${boxId}`);
      img.src = reader.result;
      img.style.display = "block";
      document.getElementById(`delete-${boxId}`).style.display = "block";
      document.querySelector(`#${boxId} .placeholdertext`).style.display = "none";
    };
    reader.readAsDataURL(event.target.files[0]);
  }

  function deleteImage(event, boxId) {
    event.stopPropagation();
    const img = document.getElementById(`img-${boxId}`);
    img.removeAttribute("src");
    img.style.display = "none";
    document.getElementById(`delete-${boxId}`).style.display = "none";
    document.querySelector(`#${boxId} input[type="file"]`).value = "";
    document.querySelector(`#${boxId} .placeholdertext`).style.display = "flex";
  }

  function addNewContainer() {
    containerCount++;
    const containers = document.getElementById("main-container");
    const newContainer = document.createElement("div");
    newContainer.className = "imagecontainer";
    newContainer.id = `imagecontainerVariation-${containerCount}`;

    // Add the first image upload box
    const firstBoxContainer = document.createElement("div");
    firstBoxContainer.className = "single-row";

    const singlebox = document.createElement("div");
    singlebox.className = "singlebox";

    singlebox.id = `variationColor-${containerCount}`;
    const singleboxColor = document.createElement("div");
    singleboxColor.className = "mb10";
    singleboxColor.innerHTML = `<label for="">Color<span class="req_star">*</span></label>
                              <select class="form-select">
                                <option value="beige">Beige</option>
                                <option value="black">Black</option>
                                <option value="blue">Blue</option>
                                <option value="brown">Brown</option>
                                <option value="gold">Gold</option>
                                <option value="green">Green</option>
                                <option value="grey">Grey</option>
                                <option value="maroon">Maroon</option>
                                <option value="multicolor">Multicolor</option>
                                <option value="orange">Orange</option>
                                <option value="pink">Pink</option>
                                <option value="purple">Purple</option>
                                <option value="red">Red</option>
                                <option value="silver">Silver</option>
                                <option value="white">White</option>
                                <option value="yellow">Yellow</option>
                              </select>`;
    singlebox.appendChild(singleboxColor);

    const firstboxsize = document.createElement("div");
    firstboxsize.className = "colorStock";
    firstboxsize.innerHTML = `<table class="v_t_c_s" id="variantSize-${containerCount}">
                              <thead>
                                <tr>
                                  <th>Size</th>
                                  <th>Stock</th>
                                  <th></th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>
                                    <input type="text" class="smallInput_n" placeholder="Size" name="size" id="size-${stockAndSizeCounter}">
                                    <div id="sizeErr-${stockAndSizeCounter}" class="invalid-feedback"></div>
                                  </td>
                                  <td>
                                    <input type="text" class="smallInput_n" placeholder="0" name="stock" id="stock-${stockAndSizeCounter}">
                                  <div id="stockErr-${stockAndSizeCounter}" class="invalid-feedback"></div>
                                    </td>
                                  <td>
                                    <button class="deleteRow lookdisable" type="button"><i class="far fa-trash-alt"></i></button>
                                    </td>
                                </tr>
                              </tbody>
                            </table>
                            <button class="btn btn-sm addNewRow mt8 addSize" id="addSize"  type="button">Add More Size</button>`;

    const firstBox = document.createElement("div");
    firstBox.className = "image-upload-box";
    firstBox.id = `box${containerCount}-1`;
    firstBox.setAttribute("onclick", `triggerUpload('box${containerCount}-1')`);

    const firstInput = document.createElement("input");
    firstInput.type = "file";
    firstInput.accept = "image/*";
    firstInput.setAttribute("onchange", `previewImage(event, 'box${containerCount}-1')`);

    const firstImg = document.createElement("img");
    firstImg.id = `img-box${containerCount}-1`;
    firstImg.src = "#";
    firstImg.alt = `Image ${boxCount + 1}`;
    firstImg.style.display = "none";

    const firstDeleteIcon = document.createElement("div");
    firstDeleteIcon.className = "delete-icon";
    firstDeleteIcon.id = `delete-box${containerCount}-1`;
    firstDeleteIcon.setAttribute("onclick", `deleteImage(event, 'box${containerCount}-1')`);
    firstDeleteIcon.innerHTML = "&#10006;";

    const firstPlaceholder = document.createElement("div");
    firstPlaceholder.className = "placeholdertext";
    firstPlaceholder.innerHTML = `<img src="{{asset('assets/images/icon/placeholder-img-1.png')}}"><h6>Upload Main Image</h6>`;

    firstBox.appendChild(firstInput);
    firstBox.appendChild(firstImg);
    firstBox.appendChild(firstDeleteIcon);
    firstBox.appendChild(firstPlaceholder);
    singlebox.appendChild(firstBox);

    firstBoxContainer.appendChild(singlebox);
    firstBoxContainer.appendChild(firstboxsize);
    newContainer.appendChild(firstBoxContainer);
    stockAndSizeCounter++;

    // Create additional boxes in a multi-row
    const multiRowContainer = document.createElement("div");
    multiRowContainer.className = "multi-row";

    for (let i = 2; i <= 9; i++) {
      boxCount++;
      const newBox = document.createElement("div");
      newBox.className = "image-upload-box";
      newBox.id = `box${containerCount}-${i}`;
      newBox.setAttribute("onclick", `triggerUpload('box${containerCount}-${i}')`);

      const newInput = document.createElement("input");
      newInput.type = "file";
      newInput.accept = "image/*";
      newInput.setAttribute("onchange", `previewImage(event, 'box${containerCount}-${i}')`);

      const newImg = document.createElement("img");
      newImg.id = `img-box${containerCount}-${i}`;
      newImg.src = "#";
      newImg.alt = `Image ${boxCount}`;
      newImg.style.display = "none";

      const newDeleteIcon = document.createElement("div");
      newDeleteIcon.className = "delete-icon";
      newDeleteIcon.id = `delete-box${containerCount}-${i}`;
      newDeleteIcon.setAttribute("onclick", `deleteImage(event, 'box${containerCount}-${i}')`);
      newDeleteIcon.innerHTML = "&#10006;";

      const newPlaceholder = document.createElement("div");
      newPlaceholder.className = "placeholdertext";
      newPlaceholder.innerHTML = `<img src="assets/images/icon/placeholder-img-1.png"><h6>Upload Image</h6>`;

      newBox.appendChild(newInput);
      newBox.appendChild(newImg);
      newBox.appendChild(newDeleteIcon);
      newBox.appendChild(newPlaceholder);
      multiRowContainer.appendChild(newBox);
    }
    const addVideo = document.createElement("div");
    addVideo.className = "video-container";
    addVideo.innerHTML = `<div class="video-placeholder">
        <div style="margin: 4px 0px 2px 0px;">
          <svg viewBox="0 0 64 64" width="38" height="38" fill="#FAFAFA">
            <circle cx="32" cy="32" r="32" fill="rgba(0,0,0,0.15)" />
            <polygon points="25,16 25,48 48,32" />
          </svg>
        </div>
        <h6>Upload Video</h6>
      </div>
      <video class="video-element">
        <source src="" class="video-source">
      </video>
      <div class="play-icon">
        <svg viewBox="0 0 64 64" width="44" height="44" fill="white">
          <circle cx="32" cy="32" r="32" fill="rgba(0,0,0,0.5)" />
          <polygon points="25,16 25,48 48,32" />
        </svg>
      </div>
      <div class="delete-icon">&#10006;</div>
      <input type="file" class="file-input" accept="video/*">`;

    multiRowContainer.appendChild(addVideo);
    newContainer.appendChild(multiRowContainer);
    containers.appendChild(newContainer);

  }
  // End code Image Upload and video upload Step 4

  // -----------------------------------------------------------------------------------

  // Start code Submit Inventory Form
  $('#submitInventoryForm').on('click', function() {
    let isValid = true;
    // Check if variant radio button is checked
    const variantChecked = $('input[name="variant"]:checked');

    if (variantChecked.length > 0) {
      const variantId = variantChecked.attr('id');

      if (variantId === 'no') {
        // Assuming you want to remove all files previously appended for the 'yes_variant' case.
        const keysToDelete = [];
        for (const key of formData.keys()) {
          if (key.startsWith('yes_variant')) {
            keysToDelete.push(key);
          }
          if (key.startsWith('yes_variant')) {
            keysToDelete.push(key);
          }
        }
        // Delete the collected keys
        keysToDelete.forEach(key => formData.delete(key));


        const stockIn = $("#stock");
        const sizeIn = $("#size");
        let = stock_value = stockIn.val();
        let = size_value = sizeIn.val();
        if (stock_value == '') {
          stockIn.addClass('is-invalid');
          $("#stockErr").text('Stock is required.');
        } 
        else if (!/^\d+$/.test(stock_value) && stock_value != '') {
          $("#stockErr").text('Stock shuld be a number.');
        } 
        else {
          stockIn.removeClass('is-invalid');
          $("#stockErr").text('');
        }
        if (size_value == '') {
            sizeIn.addClass('is-invalid');
            $("#sizeErr").text('Size is required.');
        } else {
          sizeIn.removeClass('is-invalid');
          $("#sizeErr").text('');
        }

        const imagecontainerImage = document.querySelectorAll("[id^='img-box-']");

        let totalFilesCount = 0;
        imagecontainerImage.forEach(input => {
          if(input.src != ''){
            totalFilesCount++;
          }
        });
        if (totalFilesCount < 5) {
            isValid = false;
            // Prevent form submission if less than 5 files
            event.preventDefault();
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: "You must upload at least 5 images. including 1 main image and 4 additional images."
            });
            return;
        }

        // Append files for the 'no_variant' case
        // let totalFilesCount = 0;
        const fileInputs = document.querySelectorAll('.no_variant input[type="file"]');
        // fileInputs.forEach(input => {
        //     totalFilesCount += input.files.length; // Count total number of files
        // });
        // if (totalFilesCount < 5) {
        //     isValid = false;
        //     // Prevent form submission if less than 5 files
        //     event.preventDefault();
        //     Swal.fire({
        //       icon: "error",
        //       title: "Oops...",
        //       text: "You must upload at least 5 images. including 1 main image and 4 additional images."
        //     });
        //     return;
        // }
        fileInputs.forEach((input, index) => {
          const files = input.files;
          if (files.length > 0) { // Ensure that there are files to append
            for (let i = 0; i < files.length; i++) {
              formData.append(`no_variant[0][media][${index}]`, files[i]);
              const reader = new FileReader();
              reader.onload = function(e) {
                const imgSrc = e.target.result;
                const imgBox = document.getElementById('img-box');
                const img = document.createElement('img');
                img.src = imgSrc;
                imgBox.appendChild(img);
              }
              reader.readAsDataURL(files[i]);
            }
          }
        });

        // Append size and stock data for the 'no_variant' case
        const size = document.querySelectorAll("#variantSize input[type='text'][name='size']");
        const stock = document.querySelectorAll("#variantSize input[type='text'][name='stock']");
        size.forEach((size, index) => {
          formData.append(`no_variant[${index}][size][0]`, size.value);
        });
        stock.forEach((stock, index) => {
          formData.append(`no_variant[${index}][stock][0]`, stock.value);
        });
        // Append color data for the 'no_variant' case
        const variationColor = document.querySelectorAll("#variationColor select");
        variationColor.forEach((color, index) => {
          formData.append(`no_variant[${index}][color]`, color.value);
        });


      } else if (variantId === 'yes') {
        // Assuming you want to remove all files previously appended for the 'no_variant' case.
        const keysToDelete = [];
        for (const key of formData.keys()) {
          if (key.startsWith('no_variant')) {
            keysToDelete.push(key);
          }
          if (key.startsWith('yes_variant')) {
            keysToDelete.push(key);
          }
        }
        // Delete the collected keys
        keysToDelete.forEach(key => formData.delete(key));


        // add validation stock and size
        const stockAndSizeElement = document.querySelectorAll("[id^='stock-']");
        stockAndSizeElement.forEach((variantElement, i) => {
          const stockIn = $("#stock-"+i);
          const sizeIn = $("#size-"+i);
          let = stock_value = stockIn.val();
          let = size_value = sizeIn.val();
          if (stock_value == '') {
            stockIn.addClass('is-invalid');
            $("#stockErr-"+i).text('Stock is required.');
          } 
          else if (!/^\d+$/.test(stock_value) && stock_value != '') {
            $("#stockErr-"+i).text('Stock shuld be a number.');
          } 
          else {
            stockIn.removeClass('is-invalid');
            $("#stockErr-"+i).text('');
          }
          if (size_value == '') {
            sizeIn.addClass('is-invalid');
            $("#sizeErr-"+i).text('Size is required.');
          } else {
            sizeIn.removeClass('is-invalid');
            $("#sizeErr-"+i).text('');
          }
        });

        // // Append files for the 'yes_variant' case
        const imagecontainerVariationElements = document.querySelectorAll("[id^='imagecontainerVariation-']");
        // Iterate over each variant element to collect data
        imagecontainerVariationElements.forEach((variantElement, i) => {
          const fileInputs = variantElement.querySelectorAll('input[type="file"]');
          let totalFilesCount = 0;
          fileInputs.forEach(input => {
              totalFilesCount += input.files.length; // Count total number of files
          });
          if (totalFilesCount < 5) {
              isValid = false;
              // Prevent form submission if less than 5 files
              event.preventDefault();
              Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "You must upload at least 5 images. including 1 main image and 4 additional images per variant."
              });
              return;
          }
          fileInputs.forEach((input, index) => {
            const files = input.files;
            if (files.length > 0) { // Ensure that there are files to append
              for (let a = 0; a < files.length; a++) {
                formData.append(`yes_variant[${i}][media][${index}]`, files[a]);
              }
            }
          });
        });


        // Initialize arrays to store size and stock data
        const sizes = [];
        const stocks = [];

        // Get all elements whose IDs start with 'variantSize-'
        const variantElements = document.querySelectorAll("[id^='variantSize-']");

        // Iterate over each variant element to collect data
        variantElements.forEach((variantElement, i) => {
          // Collect all 'size' and 'stock' inputs within each variant element
          const sizeInputs = variantElement.querySelectorAll("input[type='text'][name='size']");
          const stockInputs = variantElement.querySelectorAll("input[type='text'][name='stock']");

          // Initialize arrays at specific indices if they don't exist
          if (!sizes[i]) sizes[i] = [];
          if (!stocks[i]) stocks[i] = [];

          // Collect multiple sizes
          sizeInputs.forEach((sizeInput, index) => {
            if (sizeInput.value) {
              formData.append(`yes_variant[${i}][size][${index}]`, sizeInput.value);
            }
          });

          // Collect multiple stocks
          stockInputs.forEach((stockInput, index) => {
            if (stockInput.value) {
              formData.append(`yes_variant[${i}][stock][${index}]`, stockInput.value);
            }
          });
        });

        const uniquieColor = [];
        // Append color data for the 'yes_variant' case
        const variationColor = document.querySelectorAll("[id^='variationColor-']");
        variationColor.forEach((colorField, i) => {
          const colorSelect = colorField.querySelector("select");
          const selectedColor = colorSelect.value; // Get the selected option's value
          if (selectedColor) {
            uniquieColor.push(selectedColor);
            formData.append(`yes_variant[${i}][color]`, selectedColor);
          }
        });

        // Check if there are duplicate colors
        const duplicateColors = uniquieColor.filter((color, index) => uniquieColor.indexOf(color) !== index);
        if (duplicateColors.length > 0) {
          isValid = false;
          event.preventDefault();
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Duplicate variant colors are not allowed."
          });
        }
      }
    }

    // Add Product Listing Status to FormData
    let productListingStatus = $('#product_listing_status').val();

    
    formData.append('product_listing_status', productListingStatus);
    if(isValid){
        $.ajax({
        url: '{{route("inventory.update")}}',
        type: 'POST',
        data: formData,
        dataType: 'json',
        processData: false,
        contentType: false,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        async: false,
        success: function(response) {
          if (response.data.statusCode == 200) {
            // Redirect to the inventory index page
            Swal.fire({
              position: "center",
              icon: "success",
              title: "Invetory Updated Successfully.",
              showConfirmButton: false,
              timer: 1500
            });
            window.location.href = '{{route("my.inventory")}}';
          }
          if (response.data.statusCode == 422) {
            const field_list = response.data.message;
            // Iterate over the entries in the field_list object
            for (const [field, messages] of Object.entries(field_list)) {
              if (field == 'product_keywords') {
                $('#tag-input').addClass('is-invalid');
                $('#tag-inputErr').text(messages[0]);
              } else if (field == 'feature') {
                $('#features-error').removeClass('hide');
              } else if (field == 'bulk') {
                // Validate Bulk Rate table rows
                $('#bulkRateTable tbody tr').each(function() {
                  const quantityInput = $(this).find('input[name^="bulk"][name$="[quantity]"]');
                  const priceInput = $(this).find('input[name^="bulk"][name$="[price]"]');
                  const quantity = quantityInput.val();
                  const price = priceInput.val();

                  if (!quantity) {
                    quantityInput.addClass('is-invalid form-control');
                  } else {
                    quantityInput.removeClass('is-invalid form-control');
                  }
                  if (!price) {
                    priceInput.addClass('is-invalid form-control');
                  } else {
                    priceInput.removeClass('is-invalid form-control');
                  }
                });
              } else if (field == 'shipping') {
                // Validate Shipping Rate table rows
                $('#shippingRateTable tbody tr').each(function() {
                  const quantityInput = $(this).find('input[name^="shipping"][name$="[quantity]"]');
                  const localInput = $(this).find('input[name^="shipping"][name$="[local]"]');
                  const regionalInput = $(this).find('input[name^="shipping"][name$="[regional]"]');
                  const nationalInput = $(this).find('input[name^="shipping"][name$="[national]"]');
                  const quantity = quantityInput.val();
                  const local = localInput.val();
                  const regional = regionalInput.val();
                  const national = nationalInput.val();

                  if (!quantity) {
                    quantityInput.addClass('is-invalid form-control');
                    isValid = false;
                  } else {
                    quantityInput.removeClass('is-invalid form-control');
                  }

                  if (!local) {
                    localInput.addClass('is-invalid form-control');
                    isValid = false;
                  } else {
                    localInput.removeClass('is-invalid form-control');
                  }

                  if (!regional) {
                    regionalInput.addClass('is-invalid form-control');
                    isValid = false;
                  } else {
                    regionalInput.removeClass('is-invalid form-control');
                  }

                  if (!national) {
                    nationalInput.addClass('is-invalid form-control');
                    isValid = false;
                  } else {
                    nationalInput.removeClass('is-invalid form-control');
                  }
                });
              } else {
                // Add 'is-invalid' class to the corresponding element
                $(`#${field}`).addClass('is-invalid');

                // Set the error message in the corresponding error field
                $(`#${field}Err`).text(messages[0]);
              }
            }
            if(response.data.step == 1){
              document.querySelector('a[data-bs-target="#general"]').click();
            }else if(response.data.step == 2){
              document.querySelector('a[data-bs-target="#shipping"]').click();
            }else if(response.data.step == 3){
              document.querySelector('a[data-bs-target="#data"]').click();
            }else if(response.data.step == 4){
              document.querySelector('a[data-bs-target="#images"]').click();
            }
          }
        },
        error: function(error) {
          console.error('Error:', error);
        }
      });
    }
  });
</script>
@endsection