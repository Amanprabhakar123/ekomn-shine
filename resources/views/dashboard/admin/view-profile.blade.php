@extends('dashboard.layout.app')

@section('content')
<div class="ek_dashboard">
    <div class="ek_content">
        <div class="card ekcard pa shadow-sm">
            <form id="edit_profile" action="#" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-sm-12 col-md-7">
                        <div class="pro_box_r">
                            <div class="profilesection">
                                <h3 class="line_h">Business Details<span class="line"></span></h3>
                                <input type="hidden" id="company_id" name="company_id" value="{{salt_encrypt($companyDetails->id)}}">
                                <div class="ek_group">
                                    <label class="eklabel req">Business name:</label>
                                    <div class="ek_f_input">
                                        <input type="text" class="form-control" placeholder="Your business name as per GST" id="business_name" name="business_name" value="{{ $companyDetails->business_name }}" disabled/>
                                        <div id="business_nameErr" class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="ek_group">
                                    <label class="eklabel req">Display name:</label>
                                    <div class="ek_f_input">
                                        <div id="business_nameErr" class="invalid-feedback"></div>
                                        <input type="text" class="form-control py-1 mt-1 " placeholder="" id="display_name" name="" value="{{ $companyDetails->display_name }}" disabled />
                                    </div>
                                </div>
                                <div class="ek_group">
                                    <label class="eklabel">Business owner name:</label>
                                    <div class="ek_f_input">
                                        <div class="row">
                                            <div class="col">
                                                <input type="text" class="form-control" placeholder="First name" id="first_name" name="first_name" value="{{ $companyDetails->first_name }}" disabled/>
                                                <div id="first_nameErr" class="invalid-feedback"></div>
                                            </div>
                                            <div class="col">
                                                <input type="text" class="form-control" id="last_name" placeholder="Last name" value="{{ $companyDetails->last_name }}" disabled/>
                                                <div id="last_nameErr" class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ek_group">
                                    <label class="eklabel">Email address:</label>
                                    <div class="ek_f_input">
                                        <input type="text" class="form-control" placeholder="Email address" id="email" name="email" value="{{ $companyDetails->email}}"  disabled/>
                                        <div id="emailErr" class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="ek_group">
                                    <label class="eklabel">Phone number:</label>
                                    <div class="ek_f_input">
                                        <input type="text" class="form-control" placeholder="Phone number" id="mobile_no" name="mobile_no" value="{{$companyDetails->mobile_no}}" disabled/>
                                        <div id="mobile_noErr" class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="ek_group">
                                    <label class="eklabel">PAN number:</label>
                                    <div class="ek_f_input">
                                        <div class="row">
                                            <div class="col">
                                                <input type="text" class="form-control" placeholder="PAN number" id="pan_no" name="pan_no" value="{{$companyDetails->pan_no}}"  {{$companyDetails->pan_verified ? 'disabled' : ''}} disabled/>
                                                <div id="pan_noErr" class="invalid-feedback"></div>
                                            </div>
                                            <div class="col">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <label for="" class="uploadlabel">
                                                        @if($companyDetails->pan_no_file_path)
                                                        <span id="panfilename" class="text-success" onclick="dowloadFile(`{{$companyDetails->pan_no_file_path}}`)"><i class="fas fa-cloud-download-alt"></i> Download</span>
                                                        @else
                                                        <span id="" class="" disabled><i class="fas fa-cloud-download-alt"></i> Download</span>
                                                        @endif
                                                    </label>
                                                    <input type="file" id="pan_file" name="pan_file" style="display: none;" />
                                                    <div id="pan_fileErr" class="invalid-feedback"></div>
                                                    <input type="hidden" name="pan_verified" value="{{$companyDetails->pan_verified ?? 0}}" id="pan_verified">
                                                    @if($companyDetails->pan_verified == 0)
                                                        <input type="radio" name="pan_verified" value="0" id="decline" checked>
                                                        <label for="decline">Not Verify</label>
                                                        <input type="radio" name="pan_verified" value="1" id="approve">
                                                        <label for="approve">Verify</label>
                                                    @elseif($companyDetails->pan_verified == 1)
                                                        <input type="radio" name="pan_verified" value="0" id="decline">
                                                        <label for="decline">Not Verify</label>
                                                        <input type="radio" name="pan_verified" value="1" id="approve" checked>
                                                        <label for="approve">Verify</label>
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
                                                <input type="text" class="form-control" placeholder="GST number" id="gst_no" name="gst_no" value="{{$companyDetails->gst_no}} " {{$companyDetails->gst_verified ? 'disabled' : ''}} disabled/>
                                                <div id="gst_noErr" class="invalid-feedback"></div>
                                            </div>
                                            <div class="col">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <label for="" class="uploadlabel">
                                                        @if($companyDetails->gst_no_file_path)
                                                        <span id="gstfilename" class="text-success"  onclick="dowloadFile(`{{$companyDetails->gst_no_file_path}}`)"><i class="fas fa-cloud-download-alt"></i>Download</span>
                                                        @else
                                                        <span id="" class="" disabled><i class="fas fa-cloud-download-alt"></i> Download</span>
                                                        @endif
                                                    </label>
                                                    <input type="file" id="gst_file" name="gst_no_file_path" style="display: none;" />
                                                    <div id="gst_fileErr" class="invalid-feedback"></div>
                                                    <input type="hidden" name="gst_verified" value="{{$companyDetails->gst_verified ?? 0}}" id="gst_verified" disabled>
                                                    @if($companyDetails->gst_verified == 0)
                                                        <input type="radio" name="approval_status" value="0" id="" checked>
                                                        <label for="decline">Not Verify</label>
                                                        <input type="radio" name="approval_status" value="1" id="">
                                                        <label for="approve">Verify</label>
                                                    @elseif($companyDetails->gst_verified == 1)
                                                     <input type="radio" name="approval_status" value="0" id="">
                                                        <label for="approve">Not Verify</label>
                                                        <input type="radio" name="approval_status" value="1" id="" checked>
                                                        <label for="decline">Verify</label>
                                                       
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
                                    <input type="hidden" id="s_id" name="s_id" value="{{isset($shipping_address) ? $shipping_address->id : '' }}">
                                    <input type="text" class="form-control" placeholder="Enter street address" id="s_address_line1" name="address_line1" value="{{ isset($shipping_address) ? $shipping_address->address_line1 : '' }}" disabled/>
                                    <div id="s_address_line1Err" class="invalid-feedback"></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <label class="line_h">State</label>
                                            <input type="text" class="form-control" placeholder="Enter state" id="s_state" name="s_state" value="{{ isset($shipping_address) ? $shipping_address->state : '' }}" disabled/>
                                            <div id="s_stateErr" class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <label class="line_h">city</label>
                                            <input type="text" class="form-control" placeholder="Enter city" id="s_city" name="scity" value="{{ isset($shipping_address) ? $shipping_address->city : '' }}" disabled/>
                                            <div id="s_cityErr" class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <label>Pin code<span class="r_color">*</span></label>
                                            <input type="text" class="form-control" placeholder="Pin code" id="s_pincode" name="pincode" value="{{ isset($shipping_address) ? $shipping_address->pincode : '' }}" disabled/>
                                            <div id="s_pincodeErr" class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Location link</label>
                                    <input type="text" class="form-control" placeholder="Enter shippinig location link" id="location_link" name="location_link" value="{{ isset($shipping_address) ? $shipping_address->location_link : '' }}" disabled/>
                                    <div id="location_linkErr" class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="profilesection">
                                <h3 class="line_h">Billing Address<span class="line"></span></h3>
                                <div class="form-group">
                                    <label>Street address<span class="r_color">*</span></label>
                                    <input type="hidden" id="b_id" name="b_name" value="{{ isset($billing_address) ? $billing_address->id : '' }}">
                                    <input type="text" class="form-control" placeholder="Enter street address" id="b_address_line1" name="address_line1" value="{{ isset($billing_address) ? $billing_address->address_line1 : '' }}" disabled/>
                                    <div id="b_address_line1Err" class="invalid-feedback"></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <label class="line_h">State</label>
                                            <input type="text" class="form-control" placeholder="Enter state" id="b_state" name="b_state" value="{{ isset($billing_address) ? $billing_address->state : '' }}" disabled/>
                                            <div id="b_stateErr" class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <label class="line_h">city</label>
                                            <input type="text" class="form-control" placeholder="Enter city" id="b_city" name="b_city" value="{{ isset($billing_address) ? $billing_address->city : '' }}" disabled/>
                                            <div id="b_cityErr" class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <label>Pin code<span class="r_color">*</span></label>
                                            <input type="text" class="form-control" placeholder="Pin code" id="b_pincode" name="b_pincode" value="{{ isset($billing_address) ? $billing_address->pincode : '' }}" disabled/>
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
                                        <input class="form-check-input" type="checkbox" id="b_{{$business_type->id}}" name="business_type[]" value="{{$business_type->id}}" {{(in_array($business_type->id, $selected_business_type) ? 'checked' : '')}} disabled/>
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
                                        <input class="form-check-input" type="checkbox" name="product_category[]" value="{{$product_category->id}}" id="pc_{{$product_category->id}}" {{(in_array($product_category->id, $selected_product_category) ? 'checked' : '')}} disabled/>
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
                                        <input class="form-check-input" type="checkbox" id="ch_{{$can_handle->id}}" value="{{$can_handle->id}}" name="can_handle[]" {{(in_array($can_handle->id, $selected_can_handle) ? 'checked' : '')}} disabled/>
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
                                            <input type="text" class="form-control" id="business_performance_name" name="name" placeholder="Full name" value="{{ !empty($alternate_business_contact) ?$alternate_business_contact->alternate_business_contact->ProductListings->name : ''}}" disabled/>
                                            <div id="business_performance_nameErr" class="invalid-feedback"></div>
                                        </div>
                                        <div class="col">
                                            <input type="text" class="form-control" id="business_performance_mobile" name="mobile_no" placeholder="Mobile number" value="{{!empty($alternate_business_contact) ? $alternate_business_contact->alternate_business_contact->ProductListings->mobile_no : ''}}" disabled/>
                                            <div id="business_performance_mobileErr" class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="">Product Listings:</label>
                                    <div class="row">
                                        <div class="col">
                                            <input type="text" class="form-control" id="product_listings_name" placeholder="Full name" value="{{!empty($alternate_business_contact) ?$alternate_business_contact->alternate_business_contact->BusinessPerformanceAndCriticalEvents->name : ''}}" disabled/>
                                            <div id="product_listings_nameErr" class="invalid-feedback"></div>
                                        </div>
                                        <div class="col">
                                            <input type="text" class="form-control" id="product_listings_mobile" placeholder="Mobile number" value="{{!empty($alternate_business_contact) ? $alternate_business_contact->alternate_business_contact->BusinessPerformanceAndCriticalEvents->mobile_no : ''}}" disabled/>
                                            <div id="product_listings_mobileErr" class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="">Order Delivery Enquiry:</label>
                                    <div class="row">
                                        <div class="col">
                                            <input type="text" class="form-control" id="order_delivery_enquiry_name" placeholder="Full name" value="{{!empty($alternate_business_contact) ? $alternate_business_contact->alternate_business_contact->OrderDeliveryEnquiry->name : ''}}" disabled/>
                                            <div id="order_delivery_enquiry_nameErr" class="invalid-feedback"></div>
                                        </div>
                                        <div class="col">
                                            <input type="text" class="form-control" id="order_delivery_enquiry_mobile" placeholder="Mobile number" value="{{!empty($alternate_business_contact) ? $alternate_business_contact->alternate_business_contact->OrderDeliveryEnquiry->mobile_no : ''}}" disabled/>
                                            <div id="order_delivery_enquiry_mobileErr" class="invalid-feedback"></div>
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
                                    <input type="text" class="form-control" placeholder="Your bank name" id="bank_name" name="bank_name" value="{{ $companyDetails->bank_name }}" disabled/>
                                    <div id="bank_nameErr" class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="ek_group">
                                <label class="eklabel">Account number:</label>
                                <div class="ek_f_input">
                                    <input type="text" class="form-control" placeholder="Your account number" id="bank_account_no" name="bank_account_no" value="{{ $companyDetails->bank_account_no }}" disabled/>
                                    <div id="bank_account_noErr" class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="ek_group">
                                <label class="eklabel">Re-enter account number:</label>
                                <div class="ek_f_input">
                                    <input type="password" class="form-control" placeholder="Re-enter your account number" id="re_bank_account_no" name="bank_account_no" value="{{ $companyDetails->bank_account_no }}" disabled/>
                                    <div id="re_bank_account_noErr" class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="ek_group">
                                <label class="eklabel">IFSC code:</label>
                                <div class="ek_f_input">
                                    <input type="text" class="form-control" placeholder="eg: SBIN0050232" id="ifsc_code" name="ifsc_code" value="{{ $companyDetails->ifsc_code }}" disabled/>
                                    <div id="ifsc_codeErr" class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="ek_group">
                                <label class="eklabel">SWIFT Code:</label>
                                <div class="ek_f_input">
                                    <input type="text" class="form-control" placeholder="e.g. SBIN0050232" id="swift_code" name="swift_code" value="{{ $companyDetails->swift_code }}" disabled/>
                                    <div id="swift_codeErr" class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="profilesectionRight">
                            <label>Upload cancelled cheque<span class="r_color">*</span></label>
                            <label class="picture" for="cancelled_cheque_image" tabIndex="0">
                                <span class="picture__image_cheque"></span> 
                            </label>
                            <input type="file" name="cancelled_cheque_image" id="cancelled_cheque_image" style="display: none;" disabled>
                            <div id="cancelled_cheque_imageErr" class="invalid-feedback"></div>
                        </div>
                        <div class="profilesectionRight">
                            <label>Upload signature image<span class="r_color">*</span></label>
                            <label class="picture" for="signature_image" tabIndex="0">
                                <span class="signature_image"></span>
                            </label>
                            <input type="file" name="signature_image" id="signature_image" style="display: none;" disabled>
                            <div id="signature_imageErr" class="invalid-feedback"></div>
                        </div>
                        <div class="profilesectionRight">
                            <h3 class="line_h">Language Preferences<span class="line"></span></h3>
                            <div class="form-group mt-3" id="readLanguage">
                                <label class="bold">I can read</label>
                                <ul class="categoryList listnone">
                                    @foreach($languages as $language)
                                    <li>
                                        <input class="form-check-input" type="checkbox" name="language_i_can_read[]" value="{{$loop->index}}" id="L_{{$loop->index}}" {{(in_array($loop->index, $read_selected_languages) ? 'checked' : '')}} disabled/>
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
                                        <input class="form-check-input" type="checkbox" name="language_i_can_understand[]" value="{{$loop->index}}" id="I_{{$loop->index}}" {{(in_array($loop->index, $understand_selected_languages) ? 'checked' : '')}} disabled/>
                                        <label for="English">{{$language}}</label>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
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

    $(document).ready(function() {

         // Get all radio buttons with the name "gst_no"
         var gstRadioButtons = document.querySelectorAll('input[name="approval_status"]');
         var panRadioButtons = document.querySelectorAll('input[name="pan_verified"]');
        var formData = new FormData();
        formData.append('id', $('#company_id').val());
            // Add an event listener to each radio button
            gstRadioButtons.forEach(function(radio) {
                radio.addEventListener('change', function(e) {
                    formData.append('gst_verified', e.target.value);
                    Swal.fire({
                        title: "Do you want to update courier tracking status?",
                        showCancelButton: true,
                        confirmButtonText: "Save",
                        denyButtonText: `Don't save`,
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
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            ApiRequest('update-pan-gst-verified', 'POST', formData)
                            .then(response => {
                                if(response.data.statusCode == 200) {
                                    Swal.fire({
                                    title: "Good job!",
                                    text: response.data.message,
                                    icon: "success",
                                    didOpen: () => {
                                    // Apply inline CSS to the title
                                    const title = Swal.getTitle();
                                    title.style.color = 'red';
                                    title.style.fontSize = '20px';

                                    // Apply inline CSS to the content
                                    const content = Swal.getHtmlContainer();

                                    // Apply inline CSS to the confirm button
                                    const confirmButton = Swal.getConfirmButton();
                                    confirmButton.style.backgroundColor = '#feca40';
                                    confirmButton.style.color = 'white';
                                    }
                                })
                                .then(() => {
                                    location.reload();
                                });
                                
                                }
                            })
                           
                        }
                    });
                    })
                });
           

            // Similarly, for the PAN radio buttons
           

            panRadioButtons.forEach(function(radio) {
                radio.addEventListener('change', function(e) {
                    formData.append('pan_verified', e.target.value);
                    Swal.fire({
                        title: "Do you want to update courier tracking status?",
                        showCancelButton: true,
                        confirmButtonText: "Save",
                        denyButtonText: `Don't save`,
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
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            ApiRequest('update-pan-gst-verified', 'POST', formData)
                            .then(response => {
                                if(response.data.statusCode == 200) {
                                    Swal.fire({
                                    title: "Good job!",
                                    text: response.data.message,
                                    icon: "success",
                                    didOpen: () => {
                                    // Apply inline CSS to the title
                                    const title = Swal.getTitle();
                                    title.style.color = 'red';
                                    title.style.fontSize = '20px';

                                    // Apply inline CSS to the content
                                    const content = Swal.getHtmlContainer();

                                    // Apply inline CSS to the confirm button
                                    const confirmButton = Swal.getConfirmButton();
                                    confirmButton.style.backgroundColor = '#feca40';
                                    confirmButton.style.color = 'white';
                                    }
                                })
                                .then(() => {
                                    location.reload();
                                });
                                
                                }
                            })
                           
                        }
                    });
                });
            });
    
        });

function dowloadFile(url) {
    if (url) {
        var a = document.createElement('a');
        a.href = url;
        a.download = url.split('/').pop();
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    } else {
        console.error("Invalid file URL");
    }
    }

    
        // Get all radio buttons with the name "gst_no"
            // var gstRadioButtons = document.querySelectorAll('input[name="gst_no"]');

            // // Add an event listener to each radio button
            // gstRadioButtons.forEach(function(radio) {
            //     radio.addEventListener('change', function(e) {
            //         alert('GST selected: ' + e.target.value);
            //     });
            // });

// Similarly, for the PAN radio buttons
// var panRadioButtons = document.querySelectorAll('input[name="pan_no"]');

// panRadioButtons.forEach(function(radio) {
//     radio.addEventListener('change', function(e) {
//         alert('PAN selected: ' + e.target.value);
//     });
// });


       

    function handleFileSelect(inputElement, imageElement, defaultHtml) {
        const inputFile = document.querySelector(inputElement);
        const pictureImage = document.querySelector(imageElement);
        pictureImage.innerHTML = defaultHtml;

        inputFile.addEventListener("change", function(e) {
            const inputTarget = e.target;
            const file = inputTarget.files[0];

            if (file) {
                const reader = new FileReader();

                reader.addEventListener("load", function(e) {
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
    @if($companyDetails->cancelled_cheque_file_path)
    handleFileSelect("#cancelled_cheque_image", ".picture__image_cheque", 
    `<img src="{{asset($companyDetails->cancelled_cheque_file_path)}}" class="picture__img">`);
    @else
    handleFileSelect("#cancelled_cheque_image", ".picture__image_cheque",`<div class="uploadText">
                <i class="fas fa-cloud-upload-alt"></i>
                <h4>Upload Cheque</h4>
                <p class="m-0">Upload a copy of cancelled cheque for above bank account</p>
            </div>`);
    @endif
    @if($companyDetails->signature_image_file_path)
    handleFileSelect("#signature_image", ".signature_image", 
    `<img src="{{asset($companyDetails->signature_image_file_path)}}" class="picture__img">`);
    @else
    handleFileSelect("#signature_image", ".signature_image", `<div class="uploadText">
                <i class="fas fa-cloud-upload-alt"></i>
                <h4>Upload Signature</h4>
                <p class="m-0">Sign on a blank page, take a picture and upload a high resolution copy here</p>
            </div>`);
    @endif
</script>
@endsection