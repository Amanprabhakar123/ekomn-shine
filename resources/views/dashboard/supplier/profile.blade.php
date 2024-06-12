@extends('dashboard.layout.app')
@section('content')
@section('title')
Supplier Profile
@endsection
<div class="ek_dashboard">
    <div class="ek_content">
        <div class="card ekcard pa shadow-sm">
            <form id="edit_profile" action="#" method="POST" enctype="multipart/form-data" >
                @csrf
                <div class="row">
                    <div class="col-sm-12 col-md-7">
                        <div class="pro_box_r">
                            <div class="profilesection">
                                <h3 class="line_h">Business Details<span class="line"></span></h3>
                                <div class="ek_group">
                                    <label class="eklabel req">Business name:</label>
                                    <div class="ek_f_input">
                                        <input type="text" class="form-control" placeholder="Your business name" id="business_name" name="business_name" value="{{ auth()->user()->companyDetails->business_name }}" />
                                        <div id="business_nameErr" class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="ek_group">
                                    <label class="eklabel">Business owner name:</label>
                                    <div class="ek_f_input">
                                        <div class="row">
                                            <div class="col">
                                                <input type="text" class="form-control" placeholder="First name" id="first_name" name="first_name" value="{{ auth()->user()->companyDetails->first_name }}" />
                                                <div id="first_nameErr" class="invalid-feedback"></div>
                                            </div>
                                            <div class="col">
                                                <input type="text" class="form-control" id="last_name" placeholder="Last name" value="{{ auth()->user()->companyDetails->last_name }}" />
                                                <div id="last_nameErr" class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ek_group">
                                    <label class="eklabel">Email address:</label>
                                    <div class="ek_f_input">
                                        <input type="text" class="form-control" placeholder="Email address" id="email" name="email" value="{{ auth()->user()->companyDetails->email}}" />
                                        <div id="emailErr" class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="ek_group">
                                    <label class="eklabel">Phone number:</label>
                                    <div class="ek_f_input">
                                        <input type="text" class="form-control" placeholder="Phone number" id="mobile_no" name="mobile_no" value="{{auth()->user()->companyDetails->mobile_no}}" />
                                        <div id="mobile_noErr" class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="ek_group">
                                    <label class="eklabel">PAN number:</label>
                                    <div class="ek_f_input">
                                        <div class="row">
                                            <div class="col">
                                                <input type="text" class="form-control" placeholder="PAN number" id="pan_no" name="pan_no" value="{{auth()->user()->companyDetails->pan_no}}" />
                                                <div id="pan_noErr" class="invalid-feedback"></div>
                                            </div>
                                            <div class="col">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <label for="pan_file" class="uploadlabel">
                                                        <i class="fas fa-cloud-upload-alt"></i>
                                                        <span id="panfilename" class="fileName {{ auth()->user()->companyDetails->pan_no_file_path ? 'text-success' : '' }}"> {{auth()->user()->companyDetails->pan_no_file_path ? 'Pan Uploaded ': 'No file uploaded' }}</span>
                                                    </label>
                                                    <input type="file" id="pan_file" name="pan_file" style="display: none;" />
                                                    <div id="pan_fileErr" class="invalid-feedback"></div>

                                                    @if(auth()->user()->companyDetails->pan_verified)
                                                    <span class="btn-link text-success t_d_none px-0 text-nowrap"><i class="fas fa-certificate fs-11"></i> verified</span>
                                                    @else
                                                    <button class="btn btn-link px-0 a_color" disabled>Not verified</button>
                                                    @endif
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
                                                <input type="text" class="form-control" placeholder="GST number" id="gst_no" name="gst_no" value="{{auth()->user()->companyDetails->gst_no}}" />
                                                <div id="gst_noErr" class="invalid-feedback"></div>
                                            </div>
                                            <div class="col">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <label for="gst_file" class="uploadlabel">
                                                        <i class="fas fa-cloud-upload-alt"></i>
                                                        <span id="gstfilename" class="fileName {{ auth()->user()->companyDetails->gst_no_file_path ? 'text-success' : 'text-danger' }}">{{auth()->user()->companyDetails->gst_no_file_path ? 'Gst Uploaded ': 'No file uploaded' }}</span>
                                                    </label>
                                                    <input type="file" id="gst_file" name="gst_no_file_path" style="display: none;" />
                                                    <div id="gst_fileErr" class="invalid-feedback"></div>
                                                    @if(auth()->user()->companyDetails->gst_verified)
                                                    <span class="btn-link text-success t_d_none px-0 text-nowrap"><i class="fas fa-certificate fs-11"></i> verified</span>
                                                    @else
                                                    <button class="btn btn-link px-0 a_color" disabled>Not verified</button>
                                                    @endif
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
                                    <input type ="hidden" id="s_id" name="s_id" value="{{isset($shipping_address) ? $shipping_address->id : '' }}">
                                    <input type="text" class="form-control" placeholder="Enter street address" id="s_address_line1" name="address_line1" value="{{ isset($shipping_address) ? $shipping_address->address_line1 : '' }}" />
                                    <div id="s_address_line1Err" class="invalid-feedback"></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <label class="line_h">State</label>
                                            <input type="text" class="form-control" placeholder="Enter state" id="s_state" name="s_state" value="{{ isset($shipping_address) ? $shipping_address->state : '' }}" />
                                            <div id="s_stateErr" class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <label class="line_h">city</label>
                                            <input type="text" class="form-control" placeholder="Enter city" id="s_city" name="scity" value="{{ isset($shipping_address) ? $shipping_address->city : '' }}" />
                                            <div id="s_cityErr" class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <label>Pin code<span class="r_color">*</span></label>
                                            <input type="text" class="form-control" placeholder="Pin code" id="s_pincode" name="pincode" value="{{ isset($shipping_address) ? $shipping_address->pincode : '' }}">
                                            <div id="s_pincodeErr" class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Location link</label>
                                    <input type="text" class="form-control" placeholder="Enter shippinig location link" id="location_link" name="location_link" value="{{ isset($shipping_address) ? $shipping_address->location_link : '' }}" />
                                    <div id="location_linkErr" class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="profilesection">
                                <h3 class="line_h">Billing Address<span class="line"></span></h3>
                                <div class="form-group">
                                    <label>Street address<span class="r_color">*</span></label>
                                    <input type="hidden" id="b_id" name="b_name" value="{{ isset($billing_address) ? $billing_address->id : '' }}">
                                    <input type="text" class="form-control" placeholder="Enter street address" id="b_address_line1" name="address_line1" value="{{ isset($billing_address) ? $billing_address->address_line1 : '' }}" />
                                    <div id="b_address_line1Err" class="invalid-feedback"></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <label class="line_h">State</label>
                                            <input type="text" class="form-control" placeholder="Enter state" id="b_state" name="b_state" value="{{ isset($billing_address) ? $billing_address->state : '' }}" />
                                            <div id="b_stateErr" class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <label class="line_h">city</label>
                                            <input type="text" class="form-control" placeholder="Enter city" id="b_city" name="b_city" value="{{ isset($billing_address) ? $billing_address->city : '' }}" />
                                            <div id="b_cityErr" class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <label>Pin code<span class="r_color">*</span></label>
                                            <input type="text" class="form-control" placeholder="Pin code" id="b_pincode" name="b_pincode" value="{{ isset($billing_address) ? $billing_address->pincode : '' }}">
                                            <div id="b_pincodeErr" class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="profilesection" id="businessTypeSection">
                                <label class="bold">Business type</label>
                                <ul class="categoryList listnone">
                                    @foreach ($business_type as $business_type)
                                    <li>
                                        <input class="form-check-input" type="checkbox" id="b_{{$business_type->id}}" name="business_type[]" value="{{$business_type->id}}" {{(in_array($business_type->id, $selected_business_type) ? 'checked' : '')}} />
                                        <label for="b_{{$business_type->id}}">{{$business_type->name}}</label>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="profilesection" id="productCategorySection">
                                <label class="bold">Product categories</label>
                                <ul class="categoryList listnone">
                                    @foreach ($product_category as $product_category)
                                    <li>
                                        <input class="form-check-input" type="checkbox" name="product_category[]" value="{{$product_category->id}}" id="pc_{{$product_category->id}}" {{(in_array($product_category->id, $selected_product_category) ? 'checked' : '')}} />
                                        <label for="pc_{{$product_category->id}}">{{ $product_category->name }}</label>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="profilesection" id="canHandleSection">
                                <label class="bold">Can handle</label>
                                <ul class="categoryList listnone">
                                    @foreach($can_handle as $can_handle)
                                    <li>
                                        <input class="form-check-input" type="checkbox" id="ch_{{$can_handle->id}}" value="{{$can_handle->id}}" name="can_handle[]"  {{(in_array($can_handle->id, $selected_can_handle) ? 'checked' : '')}} />
                                        <label for="ch_{{$can_handle->id}}">{{$can_handle->name}}</label>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="profilesection mt-4">
                                <h3 class="line_h">Alternate Business Contact<span class="line"></span></h3>
                                <div class="form-group">
                                    <label class="">Business Performance & Critical events:</label>
                                    <div class="row">
                                        <div class="col">
                                            <input type="text" class="form-control" id="business_performance_name" name="name" placeholder="Full name" value="{{ !empty($alternate_business_contact) ?$alternate_business_contact->alternate_business_contact->ProductListings->name : ''}}" />
                                            <div id="last_nameErr" class="invalid-feedback"></div>
                                        </div>
                                        <div class="col">
                                            <input type="text" class="form-control" id="business_performance_mobile" name="mobile_no" placeholder="Mobile number" value="{{!empty($alternate_business_contact) ? $alternate_business_contact->alternate_business_contact->ProductListings->mobile_no : ''}}" />
                                            <div id="last_nameErr" class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="">Product Listings:</label>
                                    <div class="row">
                                        <div class="col">
                                            <input type="text" class="form-control" id="product_listings_name" placeholder="Full name" value="{{!empty($alternate_business_contact) ?$alternate_business_contact->alternate_business_contact->BusinessPerformanceAndCriticalEvents->name : ''}}" />
                                        </div>
                                        <div class="col">
                                            <input type="text" class="form-control" id="product_listings_mobile" placeholder="Mobile number" value="{{!empty($alternate_business_contact) ? $alternate_business_contact->alternate_business_contact->BusinessPerformanceAndCriticalEvents->mobile_no : ''}}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="">Order Delivery Enquiry:</label>
                                    <div class="row">
                                        <div class="col">
                                            <input type="text" class="form-control" id="order_delivery_enquiry_name" placeholder="Full name" value="{{!empty($alternate_business_contact) ? $alternate_business_contact->alternate_business_contact->OrderDeliveryEnquiry->name : ''}}" />
                                        </div>
                                        <div class="col">
                                            <input type="text" class="form-control" id="order_delivery_enquiry_mobile" placeholder="Mobile number" value="{{!empty($alternate_business_contact) ? $alternate_business_contact->alternate_business_contact->OrderDeliveryEnquiry->mobile_no : ''}}" />
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
                                    <input type="text" class="form-control" placeholder="Your bank name" id="bank_name" name="bank_name" value="{{ auth()->user()->companyDetails->bank_name }}" />
                                    <div id="bank_nameErr" class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="ek_group">
                                <label class="eklabel">Account number:</label>
                                <div class="ek_f_input">
                                    <input type="text" class="form-control" placeholder="Your account number" id="bank_account_no" name="bank_account_no" value="{{ auth()->user()->companyDetails->bank_account_no }}" />
                                    <div id="bank_account_noErr" class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="ek_group">
                                <label class="eklabel">Re-enter account number:</label>
                                <div class="ek_f_input">
                                    <input type="text" class="form-control" placeholder="Re-enter your account number" id="re_bank_account_no" name="bank_account_no" value="{{ auth()->user()->companyDetails->bank_account_no }}" />
                                    <div id="re_bank_account_noErr" class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="ek_group">
                                <label class="eklabel">IFSC code:</label>
                                <div class="ek_f_input">
                                    <input type="text" class="form-control" placeholder="eg: SBIN0050232" id="ifsc_code" name="ifsc_code" value="{{ auth()->user()->companyDetails->ifsc_code }}" />
                                    <div id="ifsc_codeErr" class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="ek_group">
                                <label class="eklabel">SWIFT Code:</label>
                                <div class="ek_f_input">
                                    <input type="text" class="form-control" placeholder="e.g. SBIN0050232" id="swift_code" name="swift_code" value="{{ auth()->user()->companyDetails->swift_code }}" />
                                    <div id="swift_codeErr" class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="profilesectionRight">
                            <label>Upload cancelled cheque<span class="r_color">*</span></label>
                            <label class="picture" for="cancelled_cheque_image" tabIndex="0">
                                <span class="picture__image_cheque">
                                    @if(isset(auth()->user()->companyDetails->gst_no_file_path))
                                    <img src="{{asset(auth()->user()->companyDetails->gst_no_file_path)}}" class="picture__img">
                                    @else
                                    @endif
                                </span>
                            </label>
                            <input type="file" name="cancelled_cheque_image" id="cancelled_cheque_image" style="display: none;">
                            <div id="cancelled_cheque_imageErr" class="invalid-feedback"></div>
                        </div>
                        <div class="profilesectionRight">
                            <label>Upload signature image<span class="r_color">*</span></label>
                            <label class="picture" for="signature_image" tabIndex="0">
                                <span class="signature_image"></span>
                            </label>
                            <input type="file" name="signature_image" id="signature_image" style="display: none;">
                            <div id="signature_imageErr" class="invalid-feedback"></div>
                        </div>
                        <div class="profilesectionRight">
                            <h3 class="line_h">Language Preferences<span class="line"></span></h3>
                            <div class="form-group mt-3" id="readLanguage">
                                <label class="bold">I can read</label>
                                <ul class="categoryList listnone">
                                    @foreach($languages as $language)
                                    <li>
                                        <input class="form-check-input" type="checkbox" name="language_i_can_read[]" value="{{$loop->index}}" id="L_{{$loop->index}}" {{(in_array($loop->index, $read_selected_languages) ? 'checked' : '')}}/>
                                        <label for="English">{{$language}}</label>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="form-group" id="understandLanguage">
                                <label class="bold">I can understand</label>
                                <ul class="categoryList listnone">
                                    @foreach($languages as $language)
                                    <li>
                                        <input class="form-check-input" type="checkbox" name="language_i_can_understand[]"  value="{{$loop->index}}" id="I_{{$loop->index}}" {{(in_array($loop->index, $understand_selected_languages) ? 'checked' : '')}}/>
                                        <label for="English">{{$language}}</label>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="saveform_footer text-right">
                        <button class="btn btn-login btnekomn card_f_btn px-4" type="submit">Save Profile</button>
                    </div>
            </form>
        </div>
    </div>


</div>
<div class="ek_db_footer">&copy; 2024 ekomn.com, All Rights Reserved</div>
</div>
<script>
$(document).ready(function() {
    // Function to clear error messages for all fields
    function clearErrorMessages() {
        const fields = [
            'business_name', 'first_name', 'last_name', 'email', 'mobile_no', 'pan_no', 'gst_no', 's_address_line1',
            's_state', 's_city', 's_pincode', 'location_link', 'b_address_line1', 'b_state', 'b_city', 'b_pincode', 'bank_name',
            'bank_account_no', 're_bank_account_no', 'ifsc_code', 'swift_code', 'cancelled_cheque_image', 'signature_image','pan_file', 'gst_file'
        ];
        fields.forEach(field => {
            $(`#${field}`).removeClass('is-invalid');
            $(`#${field}Err`).text('');
        });
    }

    // Call clearErrorMessages function when any input field is focused
    $('input').focus(function() {
        clearErrorMessages();
    });

    // Function to get selected values from checkboxes
    function getSelectedValues(sectionId) {
        return $(`#${sectionId} input[type="checkbox"]:checked`).map(function() {
            return $(this).val();
        }).get();
    }

    // Form submission handler for Step 1
    $('#edit_profile').submit(function(event) {
        event.preventDefault();

       
        // Validate form fields and show error messages
        let isValid = true;
        const requiredFields = [
            'business_name', 'first_name', 'email', 'mobile_no', 'pan_no', 'gst_no', 's_address_line1',
            's_state', 's_city', 's_pincode', 'location_link', 'b_address_line1', 'b_state', 'b_city', 'b_pincode', 'bank_name',
            'bank_account_no', 're_bank_account_no', 'ifsc_code', 'swift_code',
        ];

        const editprofile = {
            business_name: $('#business_name').val(),
            first_name: $('#first_name').val(),
            last_name: $('#last_name').val(),
            email: $('#email').val(),
            mobile_no: $('#mobile_no').val(),
            s_address_line1: $('#s_address_line1').val(),
            s_state: $('#s_state').val(),
            s_city: $('#s_city').val(),
            s_pincode: $('#s_pincode').val(),
            b_state: $('#b_state').val(),
            b_city: $('#b_city').val(),
            b_pincode: $('#b_pincode').val(),
            b_address_line1: $('#b_address_line1').val(),
            bank_name: $('#bank_name').val(),
            bank_account_no: $('#bank_account_no').val(),
            re_bank_account_no: $('#re_bank_account_no').val(),
            ifsc_code: $('#ifsc_code').val(),
            swift_code: $('#swift_code').val(),
            location_link: $('#location_link').val(),
            gst_no: $('#gst_no').val(),
            pan_no: $('#pan_no').val()
        };

        const shipping_address = {
            id: $('#s_id').val(),
            address_line1: $('#s_address_line1').val(),
            state: $('#s_state').val(),
            pincode: $('#s_pincode').val(),
            city: $('#s_city').val(),
            address_type: 4,
            is_primary:1,
            location_link: $('#location_link').val(),
        };

        const billing_address = {
            id: $('#b_id').val(),
            address_line1: $('#b_address_line1').val(),
            state: $('#b_state').val(),
            pincode: $('#b_pincode').val(),
            city: $('#b_city').val(),
            address_type: 1,
            is_primary: 1,
            location_link: $('#location_link').val(),
        };

         // Alternate business contact data
         const alternate_business_contact = {
            BusinessPerformanceAndCriticalEvents: {
                name: $('#business_performance_name').val(),
                mobile_no: $('#business_performance_mobile').val()
            },
            OrderDeliveryEnquiry: {
                name: $('#order_delivery_enquiry_name').val(),
                mobile_no: $('#order_delivery_enquiry_mobile').val()
            },
            ProductListings: {
                name: $('#product_listings_name').val(),
                mobile_no: $('#product_listings_mobile').val()
            }
        };

        requiredFields.forEach(field => {
            if (!editprofile[field]) {
                $(`#${field}`).addClass('is-invalid');
                $(`#${field}Err`).text(`Please enter your ${field.replace(/_/g, ' ')}.`);
                isValid = false;
            }
        });

        // Validate file inputs
        const fileFields = ['cancelled_cheque_image', 'signature_image', 'pan_file', 'gst_file'];
        fileFields.forEach(field => {
            if (!$(`#${field}`)[0].files.length) {
                $(`#${field}`).addClass('is-invalid');
                $(`#${field}Err`).text(`Please upload your ${field.replace(/_/g, ' ')}.`);
                isValid = false;
            } else {
                $(`#${field}`).removeClass('is-invalid');
                $(`#${field}Err`).text('');
            }
        });

        // If form is not valid, exit function
        if (!isValid) return;

        // Prepare form data for submission
        const formData = new FormData();
        formData.append('business_name', $('#business_name').val());
        formData.append('first_name', $('#first_name').val());
        formData.append('last_name', $('#last_name').val());
        formData.append('email', $('#email').val());
        formData.append('mobile_no', $('#mobile_no').val());
        for (const key in shipping_address) {
            if (shipping_address.hasOwnProperty(key)) {
                formData.append(`shipping_address[${key}]`, shipping_address[key]);
            }
        }
        for (const key in billing_address) {
            if (billing_address.hasOwnProperty(key)) {
                formData.append(`billing_address[${key}]`, billing_address[key]);
            }
        }
        formData.append('bank_name', $('#bank_name').val());
        formData.append('bank_account_no', $('#bank_account_no').val());
        formData.append('bank_account_no_confirmation', $('#re_bank_account_no').val());
        formData.append('ifsc_code', $('#ifsc_code').val());
        formData.append('swift_code', $('#swift_code').val());

        for (const section in alternate_business_contact) {
            if (alternate_business_contact.hasOwnProperty(section)) {
                for (const key in alternate_business_contact[section]) {
                    if (alternate_business_contact[section].hasOwnProperty(key)) {
                        formData.append(`alternate_business_contact[${section}][${key}]`, alternate_business_contact[section][key]);
                    }
                }
            }
        }
        
        formData.append('gst_no', $('#gst_no').val());
        formData.append('pan_no', $('#pan_no').val());
        formData.append('business_type', JSON.stringify(getSelectedValues('businessTypeSection')));
        formData.append('product_categories', JSON.stringify(getSelectedValues('productCategorySection')));
        formData.append('can_handle', JSON.stringify(getSelectedValues('canHandleSection')));
        formData.append('language_i_can_read', JSON.stringify(getSelectedValues('readLanguage')));
        formData.append('language_i_can_understand', JSON.stringify(getSelectedValues('understandLanguage')));

        const chequeFile = $('#cancelled_cheque_image')[0].files[0];
        const signatureFile = $('#signature_image')[0].files[0];
        const panFile = $('#pan_file')[0].files[0];
        const gstFile = $('#gst_file')[0].files[0];
        

        if (chequeFile) formData.append('cancelled_cheque_image', chequeFile);
        if (signatureFile) formData.append('signature_image', signatureFile);
        if (panFile) formData.append('pan_file', panFile);
        if (gstFile) formData.append('gst_file', gstFile);

        $.ajax({
            url: '{{route("company-profile.update")}}',
            type: 'POST',
            data: formData,
            dataType: 'application/json',
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.data.statusCode == 200) {
                    alert('Profile updated successfully');
                }
                if (response.data.statusCode == 422) {
                    const field = response.data.key;
                    $(`#${field}`).addClass('is-invalid');
                    $(`#${field}Err`).text(response.data.message);
                }
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    });
});

</script>
    <script>
      document.getElementById("pan_file").addEventListener("change", function () {
        var fileName = this.files[0].name;
        document.getElementById("panfilename").innerHTML = fileName;
      });
      document.getElementById("gst_file").addEventListener("change", function () {
        var fileName = this.files[0].name;
        document.getElementById("gstfilename").innerHTML = fileName;
      });
    </script>
    <script>
      function handleFileSelect(inputElement, imageElement, defaultHtml) {
        const inputFile = document.querySelector(inputElement);
        const pictureImage = document.querySelector(imageElement);
        pictureImage.innerHTML = defaultHtml;
    
        inputFile.addEventListener("change", function (e) {
          const inputTarget = e.target;
          const file = inputTarget.files[0];
    
          if (file) {
            const reader = new FileReader();
    
            reader.addEventListener("load", function (e) {
              const readerTarget = e.target;
    
              const img = document.createElement("img");
              img.src = readerTarget.result;
              img.classList.add("picture__img");
    
              pictureImage.innerHTML = "";
              pictureImage.appendChild(img);
            });
    
            reader.readAsDataURL(file);
          } else {
            pictureImage.innerHTML = defaultHtml;
          }
        });
      }
    
    handleFileSelect("#cancelled_cheque_image", ".picture__image_cheque", ` <div class="uploadText">
                <i class="fas fa-cloud-upload-alt"></i>
                <h4>Upload Cheque</h4>
                <p class="m-0">Upload a copy of cancelled cheque for above bank account</p>
            </div>`);
    handleFileSelect("#signature_image", ".signature_image", `<div class="uploadText">
                <i class="fas fa-cloud-upload-alt"></i>
                <h4>Upload Signature</h4>
                <p class="m-0">Sign on a blank page, take a picture and upload a high resolution copy here</p>
            </div>`);
    </script>

@endsection