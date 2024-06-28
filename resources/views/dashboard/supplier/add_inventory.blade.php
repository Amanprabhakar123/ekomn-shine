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
              <button class="nav-link" id="images-tab" data-bs-toggle="tab" data-bs-target="#images" type="button" role="tab" aria-controls="images" aria-selected="false">Product Images & Variants</button>
            </li>
          </ul>
          <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab" tabindex="0">
              <form action="">
                <div class="addProductForm">
                  <div class="ek_group">
                    <label class="eklabel req"><span>Product Name:<span class="req_star">*</span></span></label>
                    <div class="ek_f_input">
                      <input type="text" class="form-control" placeholder="Product Name & Title" />
                      <span class="text-danger hide">errr message</span>
                    </div>
                  </div>
                  <div class="ek_group">
                    <label class="eklabel req"><span>Description:<span class="req_star">*</span></span></label>
                    <div class="ek_f_input">
                      <textarea class="form-control" placeholder="Product Description"></textarea>
                      <span class="text-danger hide">errr message</span>
                    </div>
                  </div>
                  <div class="ek_group">
                    <label class="eklabel"><span>Product Keywords:<span class="req_star">*</span></span></label>
                    <div class="ek_f_input">
                      <div class="tag-container">
                        <div class="tag-input">
                            <input type="text" id="tag-input" placeholder="Type and Press Enter or Comma" class="form-control">
                        </div>
                      </div>
                      <span class="text-danger hide">errr message</span>
                    </div>
                  </div>
                  <div class="ek_group">
                    <label class="eklabel req"><span>Product Features:<span class="req_star">*</span></span></label>
                    <div class="ek_f_input">
                      <textarea id="product-description" class="form-control" placeholder="Enter Product Features & Press Add Button"></textarea>
                      <div class="clearfix">
                        <span class="fs-14 opacity-25">You can only add up to 7 features</span> 
                        <button id="add-feature" type="button" class="btn addNewRow px-4">Add</button>
                      </div>
                      <span id="error-message" class="text-danger hide">errr message</span>
                      <ol id="features-list" class="featureslisting"></ol>
                    </div>
                  </div>
                  <div class="ek_group">
                    <label class="eklabel mt20"><span>Product Category:<span class="req_star">*</span></span></label>
                    <div class="ek_f_input">
                      <div class="row">
                        <div class="mb10 col-sm-12 col-md-3">
                          <label style="font-size: 13px;opacity: 0.6;">Main Category</label>
                          <input type="text" class="form-control" placeholder="Product Category" readonly />
                          <span class="text-danger hide">errr message</span>
                        </div>
                        <div class="form-group col-sm-12 col-md-3">
                          <label style="font-size: 13px;opacity: 0.6;">Sub Category</label>
                          <input type="text" class="form-control" placeholder="Product Sub Category" readonly />
                          <span class="text-danger hide">errr message</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="saveform_footer text-right">
                  <button type="button" class="btn btn-login btnekomn card_f_btn next_Tab">Save & Next</button>
                </div>
              </form>
            </div>
            <div class="tab-pane fade" id="shipping" role="tabpanel" aria-labelledby="shipping-tab" tabindex="0">
              <form action="">
                <div class="addProductForm">
                  <div class="row">
                    <div class="col-sm-12 col-md-4">
                      <div class="ek_group">
                        <label class="eklabel req"><span>Single Piece / Dropship Rate:<span class="req_star">*</span></span></label>
                        <div class="ek_f_input">
                          <input type="text" class="form-control" placeholder="Enter Dropship Rate" />
                          <span class="text-danger hide">errr message</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                      <div class="ek_group">
                        <label class="eklabel req"><span>Potential MRP:<span class="req_star">*</span></span></label>
                        <div class="ek_f_input">
                          <input type="text" class="form-control" placeholder="Enter Potential MRP" />
                          <span class="text-danger hide">errr message</span>
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
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>
                                    <input type="text" class="smallInput_n" placeholder="Qty. Upto">
                                  </td>
                                  <td>
                                    <input type="text" class="smallInput_n" placeholder="Rs. 0.00">
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                            <button class="addNewRow" id="addNewRowButton" type="button">Add More</button>
                          </div>
                          <span class="text-danger hide">errr message</span>
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
                                <tr>
                                  <td>
                                    <input type="text" class="smallInput_n" placeholder="Qty. Upto">
                                  </td>
                                  <td>
                                    <input type="text" class="smallInput_n" placeholder="Rs. 0.00">
                                  </td>
                                  <td>
                                    <input type="text" class="smallInput_n" placeholder="Rs. 0.00">
                                  </td>
                                  <td>
                                    <input type="text" class="smallInput_n" placeholder="Rs. 0.00">
                                  </td>
                                  <td></td>
                                </tr>
                              </tbody>
                            </table>
                            <button class="addNewRow" id="addShippingRow" type="button">Add More</button>
                          </div>
                          <span class="text-danger hide">errr message</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="saveform_footer">
                  <button type="button" class="btn btn-login btnekomn card_f_btn previous_Tab"><i class="fas fa-arrow-left me-3 fs-13"></i>Back</button>
                  <button type="button" class="btn btn-login btnekomn card_f_btn next_Tab">Save & Next</button>
                </div>
              </form>
            </div>
            <div class="tab-pane fade" id="data" role="tabpanel" aria-labelledby="data-tab" tabindex="0">
              <form action="">
                <div class="addProductForm">
                  <h4 class="subheading">Product Details</h4>
                  <div class="row">
                    <div class="col-sm-12 col-md-3">
                      <div class="ek_group">
                        <label class="eklabel req"><span>Model:<span class="req_star">*</span></span></label>
                        <div class="ek_f_input">
                          <input type="text" class="form-control" placeholder="Enter Modal Number" />
                          <span class="text-danger hide">errr message</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                      <div class="ek_group">
                        <label class="eklabel req"><span>Product HSN:<span class="req_star">*</span></span></label>
                        <div class="ek_f_input">
                          <input type="text" class="form-control" placeholder="Enter HSN Code" />
                          <span class="text-danger hide">errr message</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                      <div class="ek_group">
                        <label class="eklabel req"><span>GST Bracket:<span class="req_star">*</span></span></label>
                        <div class="ek_f_input">
                          <select class="form-select">
                            <option value="0">0%</option>
                            <option value="5" selected>5%</option>
                            <option value="12">12%</option>
                            <option value="18">18%</option>
                            <option value="28">28%</option>
                          </select>
                          <span class="text-danger hide">errr message</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                      <div class="ek_group">
                        <label class="eklabel req"><span>Availability:<span class="req_star">*</span></span></label>
                        <div class="ek_f_input">
                          <select class="form-select">
                            <option value="till">Till Stock Lasts</option>
                            <option value="available" selected>Regular Available</option>
                          </select>
                          <span class="text-danger hide">errr message</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                      <div class="ek_group">
                        <label class="eklabel req">UPC:</label>
                        <div class="ek_f_input">
                          <input type="text" class="form-control" placeholder="Universal Product Code" />
                          <span class="text-danger hide">errr message</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                      <div class="ek_group">
                        <label class="eklabel req">ISBN:</label>
                        <div class="ek_f_input">
                          <input type="text" class="form-control" placeholder="International Standard Book Number" />
                          <span class="text-danger hide">errr message</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                      <div class="ek_group">
                        <label class="eklabel req">MPN:</label>
                        <div class="ek_f_input">
                          <input type="text" class="form-control" placeholder="Manufacturer Port Number" />
                          <span class="text-danger hide">errr message</span>
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
                          <input type="text" class="form-control" placeholder="100" />
                          <span class="text-danger hide">errr message</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                      <div class="ek_group">
                        <label class="eklabel req"><span>Width:<span class="req_star">*</span></span></label>
                        <div class="ek_f_input">
                          <input type="text" class="form-control" placeholder="100" />
                          <span class="text-danger hide">errr message</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                      <div class="ek_group">
                        <label class="eklabel req"><span>Height:<span class="req_star">*</span></span></label>
                        <div class="ek_f_input">
                          <input type="text" class="form-control" placeholder="100" />
                          <span class="text-danger hide">errr message</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                      <div class="ek_group">
                        <label class="eklabel req"><span>Dimension Class:<span class="req_star">*</span></span></label>
                        <div class="ek_f_input">
                          <select class="form-select">
                            <option value="mm">mm</option>
                            <option value="CM">cm</option>
                            <option value="inch">inch</option>
                          </select>
                          <span class="text-danger hide">errr message</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                      <div class="ek_group">
                        <label class="eklabel req"><span>Weight:<span class="req_star">*</span></span></label>
                        <div class="ek_f_input">
                          <input type="text" class="form-control" placeholder="100" />
                          <span class="text-danger hide">errr message</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                      <div class="ek_group">
                        <label class="eklabel req"><span>Weight Class:<span class="req_star">*</span></span></label>
                        <div class="ek_f_input">
                          <select class="form-select">
                            <option value="mg">mg</option>
                            <option value="gm">gm</option>
                            <option value="kg">kg</option>
                            <option value="ml">ml</option>
                            <option value="ltr">ltr</option>
                          </select>
                          <span class="text-danger hide">errr message</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                      <div class="ek_group">
                        <label class="eklabel req"><span>Volumetric Weight:<span class="req_star">*</span></span></label>
                        <div class="ek_f_input">
                          <input type="text" class="form-control" placeholder="L*W*H/5000" readonly/>
                          <span class="text-danger hide">errr message</span>
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
                          <input type="text" class="form-control" placeholder="100" />
                          <span class="text-danger hide">errr message</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                      <div class="ek_group">
                        <label class="eklabel req"><span>Width:<span class="req_star">*</span></span></label>
                        <div class="ek_f_input">
                          <input type="text" class="form-control" placeholder="100" />
                          <span class="text-danger hide">errr message</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                      <div class="ek_group">
                        <label class="eklabel req"><span>Height:<span class="req_star">*</span></span></label>
                        <div class="ek_f_input">
                          <input type="text" class="form-control" placeholder="100" />
                          <span class="text-danger hide">errr message</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                      <div class="ek_group">
                        <label class="eklabel req"><span>Dimension Class:<span class="req_star">*</span></span></label>
                        <div class="ek_f_input">
                          <select class="form-select">
                            <option value="mm">mm</option>
                            <option value="CM">cm</option>
                            <option value="inch">inch</option>
                          </select>
                          <span class="text-danger hide">errr message</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                      <div class="ek_group">
                        <label class="eklabel req"><span>Weight:<span class="req_star">*</span></span></label>
                        <div class="ek_f_input">
                          <input type="text" class="form-control" placeholder="100" />
                          <span class="text-danger hide">errr message</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                      <div class="ek_group">
                        <label class="eklabel req"><span>Weight Class:<span class="req_star">*</span></span></label>
                        <div class="ek_f_input">
                          <select class="form-select">
                            <option value="mg">mg</option>
                            <option value="gm">gm</option>
                            <option value="kg">kg</option>
                            <option value="ml">ml</option>
                            <option value="ltr">lt</option>
                          </select>
                          <span class="text-danger hide">errr message</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                      <div class="ek_group">
                        <label class="eklabel req"><span>Volumetric Weight:<span class="req_star">*</span></span></label>
                        <div class="ek_f_input">
                          <input type="text" class="form-control" placeholder="L*W*H/5000" readonly />
                          <span class="text-danger hide">errr message</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="saveform_footer">
                  <button type="button" class="btn btn-login btnekomn card_f_btn previous_Tab"><i class="fas fa-arrow-left me-3 fs-13"></i>Back</button>
                  <button type="button" class="btn btn-login btnekomn card_f_btn next_Tab">Save & Next</button>
                </div>
              </form>
            </div>
            <div class="tab-pane fade" id="images" role="tabpanel" aria-labelledby="images-tab" tabindex="0">
              <form action="">
                <div class="addProductForm eklabel_wm">
                  <h6>Do you have variants of this product?</h6>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="variant" id="yes" />
                    <label class="form-check-label" for="yes">Yes</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="variant" id="no" checked />
                    <label class="form-check-label" for="no">No</label>
                  </div>
                  <div class="noblock mt15">
                    <div class="single-row">
                      <div class="singlebox">
                        <div class="mb10">
                          <label for="">Color<span class="req_star">*</span></label>
                          <select class="form-select">
                            <option value="black">Black</option>
                            <option value="red">Red</option>
                            <option value="blue">Blue</option>
                          </select>
                        </div>
                        <div class="image-upload-box" id="box-1" onclick="triggerUpload('box-1')">
                          <input type="file" accept="image/*" onchange="previewImage(event, 'box-1')" />
                          <img id="img-box-1" src="" alt="Image" style="display: none;" />
                          <div class="delete-icon" id="delete-box-1" onclick="deleteImage(event, 'box-1')">&#10006;</div>
                          <div class="placeholdertext">
                            <img src="assets/images/icon/placeholder-img-1.png" />
                            <h6>Upload Main Image</h6>
                          </div>
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
                                <input type="text" class="smallInput_n" placeholder="Size">
                              </td>
                              <td>
                                <input type="text" class="smallInput_n" placeholder="0">
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="multi-row">
                      <div class="image-upload-box" id="box-2" onclick="triggerUpload('box-2')">
                        <input type="file" accept="image/*" onchange="previewImage(event, 'box-2')" />
                        <img id="img-box-2" src="#" alt="Image 2" style="display: none;" />
                        <div class="delete-icon" id="delete-box-2" onclick="deleteImage(event, 'box-2')">&#10006;</div>
                        <div class="placeholdertext">
                          <img src="assets/images/icon/placeholder-img-1.png" />
                          <h6>Upload Image</h6>
                        </div>
                      </div>
                      <div class="image-upload-box" id="box-3" onclick="triggerUpload('box-3')">
                        <input type="file" accept="image/*" onchange="previewImage(event, 'box-3')" />
                        <img id="img-box-3" src="#" alt="Image 3" style="display: none;" />
                        <div class="delete-icon" id="delete-box-3" onclick="deleteImage(event, 'box-3')">&#10006;</div>
                        <div class="placeholdertext">
                          <img src="assets/images/icon/placeholder-img-1.png" />
                          <h6>Upload Image</h6>
                        </div>
                      </div>
                      <div class="image-upload-box" id="box-4" onclick="triggerUpload('box-4')">
                        <input type="file" accept="image/*" onchange="previewImage(event, 'box-4')" />
                        <img id="img-box-4" src="#" alt="Image" style="display: none;" />
                        <div class="delete-icon" id="delete-box-4" onclick="deleteImage(event, 'box-4')">&#10006;</div>
                        <div class="placeholdertext">
                          <img src="assets/images/icon/placeholder-img-1.png" />
                          <h6>Upload Image</h6>
                        </div>
                      </div>
                      <div class="image-upload-box" id="box-5" onclick="triggerUpload('box-5')">
                        <input type="file" accept="image/*" onchange="previewImage(event, 'box-5')" />
                        <img id="img-box-5" src="#" alt="Image" style="display: none;" />
                        <div class="delete-icon" id="delete-box-5" onclick="deleteImage(event, 'box-5')">&#10006;</div>
                        <div class="placeholdertext">
                          <img src="assets/images/icon/placeholder-img-1.png" />
                          <h6>Upload Image</h6>
                        </div>
                      </div>
                      <div class="image-upload-box" id="box-6" onclick="triggerUpload('box-6')">
                        <input type="file" accept="image/*" onchange="previewImage(event, 'box-6')" />
                        <img id="img-box-6" src="#" alt="Image 6" style="display: none;" />
                        <div class="delete-icon" id="delete-box-6" onclick="deleteImage(event, 'box-6')">&#10006;</div>
                        <div class="placeholdertext">
                          <img src="assets/images/icon/placeholder-img-1.png" />
                          <h6>Upload Image</h6>
                        </div>
                      </div>
                      <div class="image-upload-box" id="box-7" onclick="triggerUpload('box-7')">
                        <input type="file" accept="image/*" onchange="previewImage(event, 'box-7')" />
                        <img id="img-box-7" src="#" alt="Image" style="display: none;" />
                        <div class="delete-icon" id="delete-box-7" onclick="deleteImage(event, 'box-7')">&#10006;</div>
                        <div class="placeholdertext">
                          <img src="assets/images/icon/placeholder-img-1.png" />
                          <h6>Upload Image</h6>
                        </div>
                      </div>
                      <div class="image-upload-box" id="box-8" onclick="triggerUpload('box-8')">
                        <input type="file" accept="image/*" onchange="previewImage(event, 'box-8')" />
                        <img id="img-box-8" src="#" alt="Image" style="display: none;" />
                        <div class="delete-icon" id="delete-box-8" onclick="deleteImage(event, 'box-8')">&#10006;</div>
                        <div class="placeholdertext">
                          <img src="assets/images/icon/placeholder-img-1.png" />
                          <h6>Upload Image</h6>
                        </div>
                      </div>
                      <div class="image-upload-box" id="box-9" onclick="triggerUpload('box-9')">
                        <input type="file" accept="image/*" onchange="previewImage(event, 'box-9')" />
                        <img id="img-box-9" src="#" alt="Image" style="display: none;" />
                        <div class="delete-icon" id="delete-box-9" onclick="deleteImage(event, 'box-9')">&#10006;</div>
                        <div class="placeholdertext">
                          <img src="assets/images/icon/placeholder-img-1.png" />
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
                        <input type="file" class="file-input" accept="video/*">
                      </div>
                    </div>
                  </div>
                  <div class="yesblock">
                    <div class="main-container" id="main-container">
                      <div class="imagecontainer">
                        <div class="single-row">
                          <div class="singlebox">
                            <div class="mb10">
                              <label for="">Color<span class="req_star">*</span></label>
                              <select class="form-select">
                                <option value="black">Black</option>
                                <option value="red">Red</option>
                                <option value="blue">Blue</option>
                              </select>
                            </div>
                            <div class="image-upload-box" id="box1-1" onclick="triggerUpload('box1-1')">
                              <input type="file" accept="image/*" onchange="previewImage(event, 'box1-1')" />
                              <img id="img-box1-1" src="" alt="Image 1" style="display: none;" />
                              <div class="delete-icon" id="delete-box1-1" onclick="deleteImage(event, 'box1-1')">&#10006;</div>
                              <div class="placeholdertext">
                                <img src="assets/images/icon/placeholder-img-1.png" />
                                <h6>Upload Main Image</h6>
                              </div>
                            </div>
                          </div>
                          <div class="colorStock">
                            <table class="v_t_c_s" id="variantSize">
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
                                    <input type="text" class="smallInput_n" placeholder="Size">
                                  </td>
                                  <td>
                                    <input type="text" class="smallInput_n" placeholder="0">
                                  </td>
                                  <td>
                                    <button class="deleteRow lookdisable" type="button"><i class="far fa-trash-alt"></i></button>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                            <button class="btn btn-sm addNewRow mt8 addSize" id="addSize"  type="button">Add More Size</button>
                          </div>
                        </div>
                        <div class="multi-row">
                          <div class="image-upload-box" id="box1-2" onclick="triggerUpload('box1-2')">
                            <input type="file" accept="image/*" onchange="previewImage(event, 'box1-2')" />
                            <img id="img-box1-2" src="#" alt="Image 2" style="display: none;" />
                            <div class="delete-icon" id="delete-box1-2" onclick="deleteImage(event, 'box1-2')">&#10006;</div>
                            <div class="placeholdertext">
                              <img src="assets/images/icon/placeholder-img-1.png" />
                              <h6>Upload Image</h6>
                            </div>
                          </div>
                          <div class="image-upload-box" id="box1-3" onclick="triggerUpload('box1-3')">
                            <input type="file" accept="image/*" onchange="previewImage(event, 'box1-3')" />
                            <img id="img-box1-3" src="#" alt="Image 3" style="display: none;" />
                            <div class="delete-icon" id="delete-box1-3" onclick="deleteImage(event, 'box1-3')">&#10006;</div>
                            <div class="placeholdertext">
                              <img src="assets/images/icon/placeholder-img-1.png" />
                              <h6>Upload Image</h6>
                            </div>
                          </div>
                          <div class="image-upload-box" id="box1-4" onclick="triggerUpload('box1-4')">
                            <input type="file" accept="image/*" onchange="previewImage(event, 'box1-4')" />
                            <img id="img-box1-4" src="#" alt="Image 4" style="display: none;" />
                            <div class="delete-icon" id="delete-box1-4" onclick="deleteImage(event, 'box1-4')">&#10006;</div>
                            <div class="placeholdertext">
                              <img src="assets/images/icon/placeholder-img-1.png" />
                              <h6>Upload Image</h6>
                            </div>
                          </div>
                          <div class="image-upload-box" id="box1-5" onclick="triggerUpload('box1-5')">
                            <input type="file" accept="image/*" onchange="previewImage(event, 'box1-5')" />
                            <img id="img-box1-5" src="#" alt="Image 5" style="display: none;" />
                            <div class="delete-icon" id="delete-box1-5" onclick="deleteImage(event, 'box1-5')">&#10006;</div>
                            <div class="placeholdertext">
                              <img src="assets/images/icon/placeholder-img-1.png" />
                              <h6>Upload Image</h6>
                            </div>
                          </div>
                          <div class="image-upload-box" id="box1-6" onclick="triggerUpload('box1-6')">
                            <input type="file" accept="image/*" onchange="previewImage(event, 'box1-6')" />
                            <img id="img-box1-6" src="#" alt="Image 6" style="display: none;" />
                            <div class="delete-icon" id="delete-box1-6" onclick="deleteImage(event, 'box1-6')">&#10006;</div>
                            <div class="placeholdertext">
                              <img src="assets/images/icon/placeholder-img-1.png" />
                              <h6>Upload Image</h6>
                            </div>
                          </div>
                          <div class="image-upload-box" id="box1-7" onclick="triggerUpload('box1-7')">
                            <input type="file" accept="image/*" onchange="previewImage(event, 'box1-7')" />
                            <img id="img-box1-7" src="#" alt="Image" style="display: none;" />
                            <div class="delete-icon" id="delete-box1-7" onclick="deleteImage(event, 'box1-7')">&#10006;</div>
                            <div class="placeholdertext">
                              <img src="assets/images/icon/placeholder-img-1.png" />
                              <h6>Upload Image</h6>
                            </div>
                          </div>
                          <div class="image-upload-box" id="box1-8" onclick="triggerUpload('box1-8')">
                            <input type="file" accept="image/*" onchange="previewImage(event, 'box1-8')" />
                            <img id="img-box1-8" src="#" alt="Image" style="display: none;" />
                            <div class="delete-icon" id="delete-box1-8" onclick="deleteImage(event, 'box1-8')">&#10006;</div>
                            <div class="placeholdertext">
                              <img src="assets/images/icon/placeholder-img-1.png" />
                              <h6>Upload Image</h6>
                            </div>
                          </div>
                          <div class="image-upload-box" id="box1-9" onclick="triggerUpload('box1-9')">
                            <input type="file" accept="image/*" onchange="previewImage(event, 'box1-9')" />
                            <img id="img-box1-9" src="#" alt="Image" style="display: none;" />
                            <div class="delete-icon" id="delete-box1-9" onclick="deleteImage(event, 'box1-9')">&#10006;</div>
                            <div class="placeholdertext">
                              <img src="assets/images/icon/placeholder-img-1.png" />
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
                            <input type="file" class="file-input" accept="video/*">
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
                  <select name="" id="" class="form-select w_200_f">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                    <option value="Draft">Draft</option>
                  </select>
                </div>
                <div class="saveform_footer">
                  <button type="button" class="btn btn-login btnekomn card_f_btn previous_Tab"><i class="fas fa-arrow-left me-3 fs-13"></i>Back</button>
                  <button type="button" class="btn btn-login btnekomn card_f_btn">Submit</button>
                </div>
              </form>
            </div>
          </div>
        </div> 
      </div>
    </div>
    @include('dashboard.layout.copyright')
</div>
@endsection

@section('scripts')
<script>
 document.addEventListener("DOMContentLoaded", function () {
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
    document.getElementById("main-container").addEventListener("DOMNodeInserted", function (event) {
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

  document.getElementById("main-container").addEventListener("click", function (event) {
    if (event.target.classList.contains("addSize")) {
      const variantSizetbody = event.target.closest(".colorStock").querySelector("tbody");
      const newSize = document.createElement("tr");
      const sizeCell = document.createElement("td");
      const sizeInput = document.createElement("input");
      sizeInput.type = "text";
      sizeInput.className = "smallInput_n";
      sizeInput.placeholder = "Size";
      sizeCell.appendChild(sizeInput);
      const stockCell = document.createElement("td");
      const stockInput = document.createElement("input");
      stockInput.type = "text";
      stockInput.className = "smallInput_n";
      stockInput.placeholder = "0";
      stockCell.appendChild(stockInput);
      const actionCell = document.createElement("td");
      const removeButton = document.createElement("button");
      removeButton.className = "deleteRow";
      removeButton.innerHTML = '<i class="far fa-trash-alt"></i>';
      removeButton.type = "button";
      removeButton.onclick = function () {
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
    reader.onload = function () {
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
    img.src = "";
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

    // Add the first image upload box
    const firstBoxContainer = document.createElement("div");
    firstBoxContainer.className = "single-row";

    const singlebox = document.createElement("div");
    singlebox.className = "singlebox";

    const singleboxColor = document.createElement("div");
    singleboxColor.className = "mb10";
    singleboxColor.innerHTML = `<label for="">Color<span class="req_star">*</span></label>
                              <select class="form-select">
                                <option value="black">Black</option>
                                <option value="red">Red</option>
                                <option value="blue">Blue</option>
                              </select>`;
    singlebox.appendChild(singleboxColor);

    const firstboxsize = document.createElement("div");
    firstboxsize.className = "colorStock";
    firstboxsize.innerHTML = `<table class="v_t_c_s" id="variantSize">
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
                                    <input type="text" class="smallInput_n" placeholder="Size">
                                  </td>
                                  <td>
                                    <input type="text" class="smallInput_n" placeholder="0">
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
    firstPlaceholder.innerHTML = `<img src="assets/images/icon/placeholder-img-1.png"><h6>Upload Main Image</h6>`;

    firstBox.appendChild(firstInput);
    firstBox.appendChild(firstImg);
    firstBox.appendChild(firstDeleteIcon);
    firstBox.appendChild(firstPlaceholder);
    singlebox.appendChild(firstBox);

    firstBoxContainer.appendChild(singlebox);
    firstBoxContainer.appendChild(firstboxsize);
    newContainer.appendChild(firstBoxContainer);

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
</script>
@endsection