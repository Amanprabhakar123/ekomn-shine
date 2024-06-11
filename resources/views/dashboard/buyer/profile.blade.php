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
                                    <input type="text" class="form-control" placeholder="Your business name" name="business_name" value="{{ auth()->user()->companyDetails->business_name }}" />
                                    <span class="text-danger hide">errr message</span>
                                </div>
                            </div>
                            <div class="ek_group">
                                <label class="eklabel">Business owner name:</label>
                                <div class="ek_f_input">
                                    <div class="row">
                                        <div class="col">
                                            <input type="text" class="form-control" placeholder="First name" name="first_name" value="{{ auth()->user()->companyDetails->first_name }}" />
                                        </div>
                                        <div class="col">
                                            <input type="text" class="form-control" placeholder="Last name" value="{{ auth()->user()->companyDetails->last_name }}" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ek_group">
                                <label class="eklabel">Email address:</label>
                                <div class="ek_f_input">
                                    <input type="text" class="form-control" placeholder="Email address" name="last_name" value="{{ auth()->user()->companyDetails->email}}" />
                                    <span class="text-danger hide">errr message</span>
                                </div>
                            </div>
                            <div class="ek_group">
                                <label class="eklabel">Phone number:</label>
                                <div class="ek_f_input">
                                    <input type="text" class="form-control" placeholder="Phone number" name="mobile_no" value="{{auth()->user()->companyDetails->mobile_no}}" />
                                    <span class="text-danger hide">errr message</span>
                                </div>
                            </div>
                            <div class="ek_group">
                                <label class="eklabel">PAN number:</label>
                                <div class="ek_f_input">
                                    <div class="row">
                                        <div class="col">
                                            <input type="text" class="form-control" placeholder="PAN number" name="pan_no" value="{{auth()->user()->companyDetails->pan_no}}"/>
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
                                            <input type="text" class="form-control" placeholder="GST number" name="gst_no" value="{{auth()->user()->companyDetails->gst_no}}" />
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
                            <h3 class="line_h">Delivery Address<span class="line"></span></h3>
                            <div class="form-group">
                                <label>Street address<span class="r_color">*</span></label>
                                <input type="text" class="form-control" placeholder="Enter street address" name="delivery_address" value="{{ isset($delivery_address) ? $delivery_address->address_line1 : '' }}" />
                            </div>
                            {{--
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
                            --}}

                            <div class="row">
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <label class="line_h">State</label>
                                        <input type="text" class="form-control" placeholder="Enter state" name="state" value="{{ isset($delivery_address) ? $delivery_address->state : '' }}" />
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <label class="line_h">city</label>
                                        <input type="text" class="form-control" placeholder="Enter city" name="city" value="{{ isset($delivery_address) ? $delivery_address->city : '' }}" />
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <label>Pin code<span class="r_color">*</span></label>
                                        <input type="text" class="form-control" placeholder="Pin code" name="pincode" value="{{ isset($delivery_address) ? $delivery_address->pincode : '' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Location link</label>
                                <input type="text" class="form-control" placeholder="Enter shippinig location link" name="location_link" value="{{ isset($delivery_address) ? $delivery_address->location_link : '' }}" />
                            </div>
                        </div>
                        <div class="profilesection">
                            <h3 class="line_h">Billing Address<span class="line"></span></h3>
                            <div class="form-group">
                                <label>Street address<span class="r_color">*</span></label>
                                <input type="text" class="form-control" placeholder="Enter street address" name="address_line1" value="{{ isset($billing_address) ? $billing_address->address_line1 : '' }}" />
                            </div>
                            {{--<div class="row">
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
                            </div>--}}

                            <div class="row">
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <label class="line_h">State</label>
                                        <input type="text" class="form-control" placeholder="Enter state" name="state" value="{{ isset($billing_address) ? $billing_address->state : '' }}" />
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <label class="line_h">city</label>
                                        <input type="text" class="form-control" placeholder="Enter city" name="city" value="{{ isset($billing_address) ? $billing_address->city : '' }}" />
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <label>Pin code<span class="r_color">*</span></label>
                                        <input type="text" class="form-control" placeholder="Pin code" name="pincode" value="{{ isset($billing_address) ? $billing_address->pincode : '' }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="profilesection">
                            <label class="bold">Business type</label>
                            <ul class="categoryList listnone">
                                @foreach ($business_type as $business_type)
                                <li>
                                    <input class="form-check-input" type="checkbox" id="bt_{{$business_type->id}}" name="product_category[]" {{(in_array($business_type->id, $selected_business_type) ? 'checked' : '')}} />
                                    <label for="bt_{{$business_type->id}}">{{$business_type->name}}</label>
                                </li>
                                @endforeach
                            </ul>
                            {{--<ul class="categoryList listnone">
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
                            </ul>--}}
                        </div>
                        <div class="profilesection">
                            <label class="bold">Product categories</label>
                            <ul class="categoryList listnone">
                                @foreach ($product_category as $product_category)
                                <li>

                                    <input class="form-check-input" type="checkbox" name="product_category[]" value="{{$product_category->id}}" id="pc_{{$product_category->id}}" {{(in_array($product_category->id, $selected_product_category) ? 'checked' : '')}} />
                                    <label for="pc_{{$product_category->id}}">{{ $product_category->name }}</label>


                                </li>
                                @endforeach
                            </ul>
                            {{--<ul class="categoryList listnone">
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
                            </ul>--}}
                        </div>
                        <div class="profilesection">
                            <label class="bold">Sales Channel</label>
                            <ul class="categoryList listnone">
                           
                                @foreach($sales as $sales)
                                <li>
                                    <input class="form-check-input" type="checkbox" id="ch_{{$sales->id}}"   {{(in_array($product_category->id, $selected_sales) ? 'checked' : '')}}/>
                                    <label for="ch_{{$sales->id}}">{{$sales->name}}</label>
                                </li>
                                @endforeach
                            </ul>
                            {{--<ul class="categoryList listnone">
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
                            </ul>--}}
                        </div>
                        <div class="profilesection mt-4">
                            <h3 class="line_h">Alternate Business Contact<span class="line"></span></h3>
                            <div class="form-group">
                                <label class="">Business Performance & Critical events:</label>
                                <div class="row">
                                    <div class="col">
                                        <input type="text" class="form-control" name="name" placeholder="Full name" value="{{ !empty($alternate_business_contact) ?$alternate_business_contact->alternate_business_contact->ProductListings->name : ''}}" />
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" name="mobile_no" placeholder="Mobile number" value="{{!empty($alternate_business_contact) ? $alternate_business_contact->alternate_business_contact->ProductListings->mobile_no : ''}}" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="">Product Listings:</label>
                                <div class="row">
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="Full name" value="{{!empty($alternate_business_contact) ?$alternate_business_contact->alternate_business_contact->BusinessPerformanceAndCriticalEvents->name : ''}}"/>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="Mobile number" value="{{!empty($alternate_business_contact) ? $alternate_business_contact->alternate_business_contact->BusinessPerformanceAndCriticalEvents->mobile_no : ''}}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="">Order Delivery Enquiry:</label>
                                <div class="row">
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="Full name" value="{{!empty($alternate_business_contact) ? $alternate_business_contact->alternate_business_contact->OrderDeliveryEnquiry->name : ''}}"/>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="Mobile number" value="{{!empty($alternate_business_contact) ? $alternate_business_contact->alternate_business_contact->OrderDeliveryEnquiry->mobile_no : ''}}"/>
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
                                <input type="text" class="form-control" placeholder="Your bank name" name="bank_name" value="{{ auth()->user()->companyDetails->bank_name }}"/>
                                <span class="text-danger hide">errr message</span>
                            </div>
                        </div>
                        <div class="ek_group">
                            <label class="eklabel">Account number:</label>
                            <div class="ek_f_input">
                                <input type="text" class="form-control" placeholder="Your account number" name="bank_account_no" value="{{ auth()->user()->companyDetails->bank_account_no }}"/>
                                <span class="text-danger hide">errr message</span>
                            </div>
                        </div>
                        <div class="ek_group">
                            <label class="eklabel">Re-enter account number:</label>
                            <div class="ek_f_input">
                                <input type="text" class="form-control" placeholder="Re-enter your account number" name="bank_account_no" value="{{ auth()->user()->companyDetails->bank_account_no }}"/>
                                <span class="text-danger hide">errr message</span>
                            </div>
                        </div>
                        <div class="ek_group">
                            <label class="eklabel">IFSC code:</label>
                            <div class="ek_f_input">
                                <input type="text" class="form-control" placeholder="eg: SBIN0050232" name="ifsc_code" value="{{ auth()->user()->companyDetails->ifsc_code }}"/>
                                <span class="text-danger hide">errr message</span>
                            </div>
                        </div>
                        <div class="ek_group">
                            <label class="eklabel">SWIFT Code:</label>
                            <div class="ek_f_input">
                                <input type="text" class="form-control" placeholder="e.g. SBIN0050232" name="swift_code" value="{{ auth()->user()->companyDetails->swift_code }}" />
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
                            @foreach($languages as $language)
                                <li>
                                    <input class="form-check-input" type="checkbox" name="language" id="l_{{$language}}" />
                                    <label for="English">{{$language}}</label>
                                </li>
                                @endforeach
                                
                            </ul>
                        </div>
                        <div class="form-group">
                            <label class="bold">I can understand</label>
                            <ul class="categoryList listnone">
                            @foreach($languages as $language)
                                <li>
                                    <input class="form-check-input" type="checkbox" name="language" id="l_{{$language}}" />
                                    <label for="English">{{$language}}</label>
                                </li>
                                @endforeach
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