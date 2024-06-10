@extends('dashboard.layout.app')
@section('content')
<div class="ek_dashboard">
      <div class="ek_content">
        <div class="card ekcard pa shadow-sm">
          <div class="row">
            <div class="col-sm-12 col-md-7">
              <div class="pro_box_r">
                <div class="profilesection">
                  <h3 class="line_h">Business Details<span class="line"></span></h3>
                  <div class="ek_group">
                    <label class="eklabel req">Business name:</label>
                    <div class="ek_f_input">
                      <input type="text" class="form-control" placeholder="Your business name" />
                      <span class="text-danger hide">errr message</span>
                    </div>
                  </div>
                  <div class="ek_group">
                    <label class="eklabel">Business owner name:</label>
                    <div class="ek_f_input">
                      <div class="row">
                        <div class="col">
                          <input type="text" class="form-control" placeholder="First name" />
                        </div>
                        <div class="col">
                          <input type="text" class="form-control" placeholder="Last name" />
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="ek_group">
                    <label class="eklabel">Email address:</label>
                    <div class="ek_f_input">
                      <input type="text" class="form-control" placeholder="Email address" />
                      <span class="text-danger hide">errr message</span>
                    </div>
                  </div>
                  <div class="ek_group">
                    <label class="eklabel">Phone number:</label>
                    <div class="ek_f_input">
                      <input type="text" class="form-control" placeholder="Phone number" />
                      <span class="text-danger hide">errr message</span>
                    </div>
                  </div>
                  <div class="ek_group">
                    <label class="eklabel">PAN number:</label>
                    <div class="ek_f_input">
                      <div class="row">
                        <div class="col">
                          <input type="text" class="form-control" placeholder="PAN number" />
                          <span class="text-danger hide">errr message</span>
                        </div>
                        <div class="col">
                          <div class="d-flex align-items-center justify-content-between">
                            <label for="panupload" class="uploadlabel">
                              <i class="fas fa-cloud-upload-alt"></i>
                              <span id="panfilename" class="fileName">No file uploaded</span>
                            </label>
                            <input type="file" id="panupload" style="display: none;" />
                            <span class="btn-link text-success t_d_none px-0 text-nowrap"><i class="fas fa-certificate fs-11"></i> verified</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="ek_group">
                    <label class="eklabel">GST number:</label>
                    <div class="ek_f_input">
                      <div class="row">
                        <div class="col">
                          <input type="text" class="form-control" placeholder="GST number" />
                          <span class="text-danger hide">errr message</span>
                        </div>
                        <div class="col">
                          <div class="d-flex align-items-center justify-content-between">
                            <label for="gstupload" class="uploadlabel">
                              <i class="fas fa-cloud-upload-alt"></i>
                              <span id="gstfilename" class="fileName">No file uploaded</span>
                            </label>
                            <input type="file" id="gstupload" style="display: none;" />
                            <button class="btn btn-link px-0 a_color">verify it</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="profilesection">
                  <h3 class="line_h">Shipping Address<span class="line"></span></h3>
                  <div class="form-group">
                    <label>Street address<span class="r_color">*</span></label>
                    <input type="text" class="form-control" placeholder="Enter street address" />
                  </div>
                  <div class="row">
                    <div class="col-sm-12 col-md-4">
                      <div class="form-group">
                        <label>State<span class="r_color">*</span></label>
                        <select class="form-select">
                          <option value="0">Select State</option>
                          <option>Andhra Pradesh</option>
                          <option>Arunachal Pradesh</option>
                          <option>Assam</option>
                          <option>Bihar</option>
                          <option>Chhattisgarh</option>
                          <option>Delhi</option>
                          <option>Haryana</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                      <div class="form-group">
                        <label>City<span class="r_color">*</span></label>
                        <select class="form-select">
                          <option value="a">Delhi</option>
                          <option value="a">Grugram</option>
                          <option value="a">Noida</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                      <div class="form-group">
                        <label>Pin code<span class="r_color">*</span></label>
                        <input type="text" class="form-control" placeholder="Pin code">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Location link</label>
                    <input type="text" class="form-control" placeholder="Enter shippinig location link" />
                  </div>
                </div>
                <div class="profilesection">
                  <h3 class="line_h">Billing Address<span class="line"></span></h3>
                  <div class="form-group">
                    <label>Street address<span class="r_color">*</span></label>
                    <input type="text" class="form-control" placeholder="Enter street address" />
                  </div>
                  <div class="row">
                    <div class="col-sm-12 col-md-4">
                      <div class="form-group">
                        <label>State<span class="r_color">*</span></label>
                        <select class="form-select">
                          <option value="0">Select State</option>
                          <option>Andhra Pradesh</option>
                          <option>Arunachal Pradesh</option>
                          <option>Assam</option>
                          <option>Bihar</option>
                          <option>Chhattisgarh</option>
                          <option>Delhi</option>
                          <option>Haryana</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                      <div class="form-group">
                        <label>City<span class="r_color">*</span></label>
                        <select class="form-select">
                          <option value="a">Delhi</option>
                          <option value="a">Grugram</option>
                          <option value="a">Noida</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                      <div class="form-group">
                        <label>Pin code<span class="r_color">*</span></label>
                        <input type="text" class="form-control" placeholder="Pin code">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="profilesection">
                  <label class="bold">Business type</label>
                  <ul class="categoryList listnone">
                    <li>
                      <input class="form-check-input" type="checkbox" id="Manufacturer" />
                      <label for="Manufacturer">Manufacturer</label>
                    </li>
                    <li>
                      <input class="form-check-input" type="checkbox" id="Supplier" />
                      <label for="Supplier">Supplier</label>
                    </li>
                    <li>
                      <input class="form-check-input" type="checkbox" id="Distributor" />
                      <label for="Distributor">Distributor</label>
                    </li>
                    <li>
                      <input class="form-check-input" type="checkbox" id="Importer" />
                      <label for="Importer">Importer</label>
                    </li>
                    <li>
                      <input class="form-check-input" type="checkbox" id="Exporter" />
                      <label for="Exporter">Exporter</label>
                    </li>
                    <li>
                      <input class="form-check-input" type="checkbox" id="Wholesaler" />
                      <label for="Wholesaler">Wholesaler</label>
                    </li>
                  </ul>
                </div>
                <div class="profilesection">
                  <label class="bold">Product categories</label>
                  <ul class="categoryList listnone">
                    <li>
                      <input class="form-check-input" type="checkbox" id="category1" />
                      <label for="category1">Stationery</label>
                    </li>
                    <li>
                      <input class="form-check-input" type="checkbox" id="category2" />
                      <label for="category2">Furniture</label>
                    </li>
                    <li>
                      <input class="form-check-input" type="checkbox" id="category3" />
                      <label for="category3">Food and beverage</label>
                    </li>
                    <li>
                      <input class="form-check-input" type="checkbox" id="category4" />
                      <label for="category4">Electronics</label>
                    </li>
                    <li>
                      <input class="form-check-input" type="checkbox" id="category5" />
                      <label for="category5">Groceries</label>
                    </li>
                    <li>
                      <input class="form-check-input" type="checkbox" id="category6" />
                      <label for="category6">Baby products</label>
                    </li>
                    <li>
                      <input class="form-check-input" type="checkbox" id="category7" />
                      <label for="category7">Gift cards</label>
                    </li>
                    <li>
                      <input class="form-check-input" type="checkbox" id="category8" />
                      <label for="category8">Cleaning supplies</label>
                    </li>
                  </ul>
                </div>
                <div class="profilesection">
                  <label class="bold">Can handle</label>
                  <ul class="categoryList listnone">
                    <li>
                      <input class="form-check-input" type="checkbox" id="FBALabeling" />
                      <label for="FBALabeling">FBA Labeling</label>
                    </li>
                    <li>
                      <input class="form-check-input" type="checkbox" id="BulkOrders" />
                      <label for="BulkOrders">Bulk Orders</label>
                    </li>
                    <li>
                      <input class="form-check-input" type="checkbox" id="SampleOrders" />
                      <label for="SampleOrders">Sample Orders</label>
                    </li>
                    <li>
                      <input class="form-check-input" type="checkbox" id="Returns" />
                      <label for="Returns">Returns</label>
                    </li>
                    <li>
                      <input class="form-check-input" type="checkbox" id="ProductCustomization" />
                      <label for="ProductCustomization">Product Customization</label>
                    </li>
                  </ul>
                </div>
                <div class="profilesection mt-4">
                  <h3 class="line_h">Alternate Business Contact<span class="line"></span></h3>
                  <div class="form-group">
                    <label class="">Business Performance & Critical events:</label>
                    <div class="row">
                      <div class="col">
                        <input type="text" class="form-control" placeholder="Full name" />
                      </div>
                      <div class="col">
                        <input type="text" class="form-control" placeholder="Mobile number" />
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="">Business Performance & Critical events:</label>
                    <div class="row">
                      <div class="col">
                        <input type="text" class="form-control" placeholder="Full name" />
                      </div>
                      <div class="col">
                        <input type="text" class="form-control" placeholder="Mobile number" />
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="">Business Performance & Critical events:</label>
                    <div class="row">
                      <div class="col">
                        <input type="text" class="form-control" placeholder="Full name" />
                      </div>
                      <div class="col">
                        <input type="text" class="form-control" placeholder="Mobile number" />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-12 col-md-5">
              <h3 class="line_h">Bank Details<span class="line"></span></h3>
              <div class="bankcontainer">
                <div class="ek_group">
                  <label class="eklabel">Bank name:</label>
                  <div class="ek_f_input">
                    <input type="text" class="form-control" placeholder="Your bank name" />
                    <span class="text-danger hide">errr message</span>
                  </div>
                </div>
                <div class="ek_group">
                  <label class="eklabel">Account number:</label>
                  <div class="ek_f_input">
                    <input type="text" class="form-control" placeholder="Your account number" />
                    <span class="text-danger hide">errr message</span>
                  </div>
                </div>
                <div class="ek_group">
                  <label class="eklabel">Re-enter account number:</label>
                  <div class="ek_f_input">
                    <input type="text" class="form-control" placeholder="Re-enter your account number" />
                    <span class="text-danger hide">errr message</span>
                  </div>
                </div>
                <div class="ek_group">
                  <label class="eklabel">IFSC code:</label>
                  <div class="ek_f_input">
                    <input type="text" class="form-control" placeholder="eg: SBIN0050232" />
                    <span class="text-danger hide">errr message</span>
                  </div>
                </div>
                <div class="ek_group">
                  <label class="eklabel">SWIFT Code:</label>
                  <div class="ek_f_input">
                    <input type="text" class="form-control" placeholder="e.g. SBIN0050232" />
                    <span class="text-danger hide">errr message</span>
                  </div>
                </div>
              </div>
              <div class="profilesectionRight">
                <label>Upload cancelled cheque<span class="r_color">*</span></label>
                <label class="picture" for="picture__input_cheque" tabIndex="0">
                  <span class="picture__image_cheque"></span>
                </label>
                <input type="file" name="picture__input_cheque" id="picture__input_cheque" style="display: none;">
              </div>
              <div class="profilesectionRight">
                <label>Upload signature image<span class="r_color">*</span></label>
                <label class="picture" for="picture__input_signature" tabIndex="0">
                  <span class="picture__image_signature"></span>
                </label>
                <input type="file" name="picture__input_signature" id="picture__input_signature" style="display: none;">
              </div>
              <div class="profilesectionRight">
                <h3 class="line_h">Language Preferences<span class="line"></span></h3>
                <div class="form-group mt-3">
                  <label class="bold">I can read</label>
                  <ul class="categoryList listnone">
                    <li>
                      <input class="form-check-input" type="checkbox" id="English" />
                      <label for="English">English</label>
                    </li>
                    <li>
                      <input class="form-check-input" type="checkbox" id="Hindi" />
                      <label for="Hindi">Hindi</label>
                    </li>
                    <li>
                      <input class="form-check-input" type="checkbox" id="Bengali" />
                      <label for="Bengali">Bengali</label>
                    </li>
                    <li>
                      <input class="form-check-input" type="checkbox" id="Telugu" />
                      <label for="Telugu">Telugu</label>
                    </li>
                    <li>
                      <input class="form-check-input" type="checkbox" id="Marathi" />
                      <label for="Marathi">Marathi</label>
                    </li>
                    <li>
                      <input class="form-check-input" type="checkbox" id="Tamil" />
                      <label for="Tamil">Tamil</label>
                    </li>
                    <li>
                      <input class="form-check-input" type="checkbox" id="Gujarati" />
                      <label for="Gujarati">Gujarati</label>
                    </li>
                    <li>
                      <input class="form-check-input" type="checkbox" id="Malayalam" />
                      <label for="Malayalam">Malayalam</label>
                    </li>
                    <li>
                      <input class="form-check-input" type="checkbox" id="Kannada" />
                      <label for="Kannada">Kannada</label>
                    </li>
                  </ul>
                </div>
                <div class="form-group">
                  <label class="bold">I can understand</label>
                  <ul class="categoryList listnone">
                    <li>
                      <input class="form-check-input" type="checkbox" id="u_English" />
                      <label for="u_English">English</label>
                    </li>
                    <li>
                      <input class="form-check-input" type="checkbox" id="u_Hindi" />
                      <label for="u_Hindi">Hindi</label>
                    </li>
                    <li>
                      <input class="form-check-input" type="checkbox" id="u_Bengali" />
                      <label for="u_Bengali">Bengali</label>
                    </li>
                    <li>
                      <input class="form-check-input" type="checkbox" id="u_Telugu" />
                      <label for="u_Telugu">Telugu</label>
                    </li>
                    <li>
                      <input class="form-check-input" type="checkbox" id="u_Marathi" />
                      <label for="u_Marathi">Marathi</label>
                    </li>
                    <li>
                      <input class="form-check-input" type="checkbox" id="u_Tamil" />
                      <label for="u_Tamil">Tamil</label>
                    </li>
                    <li>
                      <input class="form-check-input" type="checkbox" id="u_Gujarati" />
                      <label for="u_Gujarati">Gujarati</label>
                    </li>
                    <li>
                      <input class="form-check-input" type="checkbox" id="u_Malayalam" />
                      <label for="u_Malayalam">Malayalam</label>
                    </li>
                    <li>
                      <input class="form-check-input" type="checkbox" id="u_Kannada" />
                      <label for="u_Kannada">Kannada</label>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="saveform_footer text-right">
            <button class="btn btn-login btnekomn card_f_btn px-4">Save Profile</button>
          </div>
        </div>
      </div>
      <div class="ek_db_footer">&copy; 2024 ekomn.com, All Rights Reserved</div>
    </div>
    @endsection