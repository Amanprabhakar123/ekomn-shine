<div class="login-wrapper">
  <div class="loginimages">
    @include('auth.layout.sidebar_slider')
    <div class="login-container">
      <div class="loginForm register">
        @include('auth.layout.logo')
        <h1 class="h4 bold ExcellenText">Excellent Choice!!</h1>
        <p class="mb25">Now, please fill the required details so that we can get you onboarded earliest.</p>
        <section class="section_1">
          <form id="formStep_1" action="#" method="POST">
            <div class="emptybox">
              <div class="row">
                <div class="col-sm-12 col-md-6">
                  <div class="form-group">
                    <!-- this is hidden field step 1 -->
                    <input type="hidden" class="form-control" id="step_1" name="step_1" value="step_1" />
                    <input type="text" class="form-control" id="business_name" name="business_name" placeholder="*Business name" aria-label="Business name" />
                    <div id="business_nameErr" class="invalid-feedback"></div>
                  </div>
                </div>
                <div class="col-sm-12 col-md-6">
                  <div class="form-group">
                    <input type="text" class="form-control" id="gst" name="gst" placeholder="*GST ID" aria-label="GST ID" />
                    <div id="gstErr" class="invalid-feedback"></div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <input type="url" class="form-control" id="website_url" name="website_url" placeholder="Website URL" aria-label="Website URL" />
                    <div id="websiteErr" class="invalid-feedback"></div>
                  </div>
                </div>
                <div class="col-sm-12 col-md-6">
                  <div class="form-group">
                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="*First Name" aria-label="First Name" />
                    <div id="first_nameErr" class="invalid-feedback"></div>
                  </div>
                </div>
                <div class="col-sm-12 col-md-6">
                  <div class="form-group">
                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" aria-label="Last Name" />
                    <div id="last_nameErr" class="invalid-feedback"></div>
                  </div>
                </div>
                <div class="col-sm-12 col-md-6">
                  <div class="input-group form-group">
                    <span class="input-group-text text-muted">+91</span>
                    <input type="tel" class="form-control" id="mobile" name="mobile" placeholder="Mobile Number" aria-label="Mobile Number" />
                    <div id="mobileErr" class="invalid-feedback"></div>
                  </div>
                </div>
                <div class="col-sm-12 col-md-6">
                  <div class="form-group">
                    <input type="text" class="form-control" id="designation" name="designation" placeholder="Designation" aria-label="Designation" />
                    <div id="designationErr" class="invalid-feedback"></div>
                  </div>
                </div>
              </div>
              <strong class="pt-3 pb-1 block">Shipping Address</strong>
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <input type="text" class="form-control" id="address" name="address" placeholder="*Street Address" aria-label="Street Address" />
                    <div id="addressErr" class="invalid-feedback"></div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <input type="text" class="form-control" id="state" name="state" placeholder="*State" aria-label="State" />
                    <div id="stateErr" class="invalid-feedback"></div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <input type="text" class="form-control" id="city" name="city" placeholder="*City" aria-label="City" />
                    <div id="cityErr" class="invalid-feedback"></div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <input type="text" class="form-control" id="pin_code" name="pin_code" placeholder="*Pin Code" aria-label="Pin Code" />
                    <div id="pin_codeErr" class="invalid-feedback"></div>
                  </div>
                </div>
              </div>
            </div>
            <button class="btn btn-login btnekomn block section_1_next" type="submit">Next</button>
          </form>
        </section>
        <section class="section_2" style="display: none;">
          <form id="formStep_2" action="#" method="POST">
            <div class="row">
              <div class="col-sm-12">
                <div class="emptybox">
                  <h4 class="ek_s_h">Acknowledgement</h4>
                  <ul class="ack_q_l listnone">
                    <li>
                      <div class="d-flex justify-content-between required">
                        <input type="hidden" class="form-control" id="step_2" name="step_2" value="step_2" />
                        <label class="ack_q_w" for="dispatch_timelines">Bulk Order Dispatch timelines<strong class="ms-1">3-5 calendar days</strong></label>
                        <input class="form-check-input" type="checkbox" id="bulk_dispatch_time" />
                      </div>
                    </li>
                    <li>
                      <div class="d-flex justify-content-between required">
                        <label class="ack_q_w" for="dropship_orders">Dropship/Sample Orders<strong class="ms-1">Same Day</strong></label>
                        <input class="form-check-input" type="checkbox" id="dropship_dispatch_time" />
                      </div>
                    </li>
                    <li>
                      <div class="d-flex justify-content-between required">
                        <label class="ack_q_w" for="defect_free">I/We confirm to dispatch brand new and defect free products confirming to product details mentioned in our product listings</label>
                        <input class="form-check-input" type="checkbox" id="product_quality_confirm" />
                      </div>
                    </li>
                    <li>
                      <div class="d-flex justify-content-between required">
                        <label class="ack_q_w" for="business_compliances">I/We confirm to applicable business compliances in India such as GST and Product quality norms as applicable respectively</label>
                        <input class="form-check-input" type="checkbox" id="business_compliance_confirm" />
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <button class="btn btn-login btnekomn block section_2_next" type="submit">Next</button>
          </form>
        </section>
        <section class="section_3" style="display: none;">
          <form id="formData_3" action="#" method="POST">
            <div class="row">
              <div class="col-sm-12">
                <div class="emptybox">
                  <h4 class="ek_s_h">Key Information</h4>
                  <ul class="ack_q_l listnone">
                    <li>
                      <div class="d-flex justify-content-between ">
                        <label class="ack_q_w" for="product_qty">How many products you have in your catalog that you wish to sell?</label>
                        <!-- this is hidden field step 1 -->
                        <input type="hidden" class="form-control" id="step_3" name="step_3" value="step_3" />
                        <input class="qt_inp form-control" type="number" name="product_qty" id="product_qty" placeholder="Qty." aria-label="Product Quantity" />
                      </div>
                    </li>
                    <li>
                      <label class="ack_q_w required">Select your product categories</label>
                      <ul class="categoryList listnone">
                        @foreach ($product as $product)

                        <li>
                          <input class="form-check-input" type="checkbox" name="product_category[]" id="{{$product->id}}" />
                          <label for="{{$product->id}}">{{ $product->name }}</label>
                        </li>
                        @endforeach


                    </li>
                  </ul>
                  <div class="mt30">
                    <ul class="ack_q_l listnone">
                      <li>
                        <label class="ack_q_w"><strong>How did you hear about eKomn?</strong></label>
                        <ul class="categoryList listnone">
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="channel" id="channel1" />
                              <label class="form-check-label" for="channel1">
                                Through SMS
                              </label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="channel" id="channel2" />
                              <label class="form-check-label" for="channel2">
                                Through eMail
                              </label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="channel" id="channel3" />
                              <label class="form-check-label" for="channel3">
                                Google Search
                              </label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="channel" id="channel4" />
                              <label class="form-check-label" for="channel4">
                                Social Media
                              </label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="channel" id="channel5" />
                              <label class="form-check-label" for="channel5">
                                Referred
                              </label>
                            </div>
                          </li>
                          <li>
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="channel" id="channel6" />
                              <label class="form-check-label" for="channel6">
                                Others
                              </label>
                            </div>
                          </li>
                        </ul>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <button class="btn btn-login btnekomn block section_3_next" type="submit">Next</button>
          </form>
        </section>
        <section class="section_4" style="display: none;">
          <form id="formData_4" action="#" method="POST">
            <div class="row">
              <div class="col-sm-12">
                <div class="emptybox">
                  <h4 class="ek_s_h">Create Login Details</h4>
                  <div class="form-group">
                    <input type="hidden" class="form-control" id="step_4" name="step_2" value="step_4" />
                    <input type="email" class="form-control" placeholder="*Email Address" id="email" aria-label="Email Address">
                    <div id="emailErr" class="invalid-feedback"></div>
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control" placeholder="*Password" id="password" aria-label="Password">
                    <div id="passwordErr" class="invalid-feedback"></div>
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control" placeholder="*Confirm Password" id="confirm_password" confirm_password aria-label="Confirm Password">
                    <div id="confirm_passwordErr" class="invalid-feedback"></div>
                  </div>
                </div>
              </div>
            </div>
            <button class="btn btn-login btnekomn block formSubmit" type="submit">Submit</button>
          </form>
        </section>
        <!-- hidden input feleid -->
        <input type="hidden" id="hiddenField">
        <div id="error-message" style="color:red; display:none;"></div> <!-- rror messag show and hide -->
      </div>
      <div class="loginForm t_u_s" style="display: none;">
        <div class="brand-logo d-flex justify-content-center">
          <a href="#"><img src="/assets/images/Logo.svg" alt="Logo" /></a>
        </div>
        <div class="thankYou">
          <div class="thankYoubox">
            <svg xmlns="http://www.w3.org/2000/svg" class="svg-success" viewBox="0 0 24 24">
              <g stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10">
                <circle class="success-circle-outline" cx="12" cy="12" r="11.5" />
                <circle class="success-circle-fill" cx="12" cy="12" r="11.5" />
                <polyline class="success-tick" points="17,8.5 9.5,15.5 7,13" />
              </g>
            </svg>
            <h1 class="thank_h1">Thank you!!</h1>
            <p>Your responses have earned you an immediate Onboarding Approval on eKomn.</p>
            <a href="{{ route('buyer.login') }}" class="a_color">Click to Login</a>
          </div>
        </div>
      </div>
      @include('auth.layout.footer')
    </div>
  </div>
</div>

@section('custom_script')
<script>
  $(document).ready(function() {

    // Function to clear error messages for all fields
    function clearErrorMessages() {
      const fields = [
        'business_name', 'gst', 'first_name', 'mobile', 'address',
        'state', 'city', 'pin_code', 'email', 'password', 'confirm_password'
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

    // Form submission handler for Step 1
    $('#formStep_1').submit(function(event) {
      event.preventDefault();

      // Clear previous error messages
      clearErrorMessages();

      // Retrieve form values
      const formData_1 = {
        step_1: $('#step_1').val(),
        business_name: $('#business_name').val(),
        gst: $('#gst').val(),
        website_url: $('#website_url').val(),
        first_name: $('#first_name').val(),
        last_name: $('#last_name').val(), // This will be included but not validated
        mobile: $('#mobile').val(),
        designation: $('#designation').val(), // This will be included but not validated
        address: $('#address').val(),
        state: $('#state').val(),
        city: $('#city').val(),
        pin_code: $('#pin_code').val()
      };

      // Validate form fields and show error messages
      let isValid = true;
      const requiredFields = ['business_name', 'gst', 'first_name', 'mobile', 'address', 'state', 'city', 'pin_code'];
      requiredFields.forEach(field => {
        if (!formData_1[field]) {
          $(`#${field}`).addClass('is-invalid');
          $(`#${field}Err`).text(`Please enter your ${field.replace('_', ' ')}.`);
          isValid = false;
        }
      });

      // If form is not valid, exit function
      if (!isValid) return;

      // Submit form data via API
      ApiRequest('supplier/register', 'POST', formData_1)
        .then(response => {
          if (response.data.statusCode == 200) {
            $('#hiddenField').val(response.data.id);
            $('.section_1').hide();
            $('.section_2').show().addClass('show_section_2');
          }
          if (response.data.statusCode == 422) {
            const field = response.data.key;
            $(`#${field}`).addClass('is-invalid');
            $(`#${field}Err`).text(response.data.message);
          }
        })
        .catch(error => {
          console.error('Error222:', error);
        });
    });

    // Form submission handler for Step 2
    $('#formStep_2').submit(function(event) {
      event.preventDefault();

      // Clear previous error messages
      $('#error-message').hide().text('');

      // Perform validation
      let isValid = true;
      let errorMessage = '';

      if (!$('#bulk_dispatch_time').is(':checked') &&
        !$('#dropship_dispatch_time').is(':checked') &&
        !$('#product_quality_confirm').is(':checked') &&
        !$('#business_compliance_confirm').is(':checked')) {
        isValid = false;
        errorMessage += 'All checkbox must be selected. ';
      }
      // Example validation: Ensure step_2 is not empty
      else if (!$('#bulk_dispatch_time').is(":checked")) {
        isValid = false;
        errorMessage += 'bulk dispatch time is required. ';

      } else if (!$('#dropship_dispatch_time').is(":checked")) {
        isValid = false;
        errorMessage += 'dropship dispatch time is required. ';
      } else if (!$('#product_quality_confirm').is(":checked")) {
        isValid = false;
        errorMessage += 'product quality confirm is required. ';
      } else if (!$('#business_compliance_confirm').is(":checked")) {
        isValid = false;
        errorMessage += 'business compliance confirm is required. ';
      }

      if (!isValid) {
        $('#error-message').text(errorMessage).show();
        return;
      }

      // If validation fails, show error message and prevent form submission

      const formData_2 = {
        step_2: $('#step_2').val(),
        hiddenField: $('#hiddenField').val(),
        bulk_dispatch_time: $("#bulk_dispatch_time").is(":checked") ? 1 : 0,
        dropship_dispatch_time: $("#dropship_dispatch_time").is(":checked") ? 1 : 0,
        product_quality_confirm: $("#product_quality_confirm").is(":checked") ? 1 : 0,
        business_compliance_confirm: $("#business_compliance_confirm").is(":checked") ? 1 : 0,
      };

      ApiRequest('supplier/register', 'POST', formData_2)
        .then(response => {
          if (response.data.statusCode == 200) {
            $('.section_2').hide();
            $('.section_3').show().addClass('show_section_3');
          } else {
            // alert('Acknowledgement failed!');
          }
        })
        .catch(error => {
          console.error('Error:', error);
        });
    });

    // Form submission handler for Step 3
    $('#formData_3').submit(function(event) {
      event.preventDefault();
      // Clear previous error messages
      // Hide and clear any previous error message
      $('#error-message').hide().text('');

      var quantity = $('#product_qty').val();
      if (isNaN(quantity)) {
        $('#error-message').text('Quantity must be a number.').show();
      } else if (quantity < 1) {
        $('#error-message').text('At least Quantity must be 1').show();
        return;
      }

      // Initialize variables
      var isAnyCheckboxChecked = false;
      var checkboxData = {};

      // Loop through all checkboxes
      $('#formData_3 input[type="checkbox"]').each(function() {
        // Store the state of each checkbox (1 if checked, 0 if not)
        checkboxData[$(this).attr('id')] = $(this).is(':checked') ? 1 : 0;
        // Check if at least one checkbox is checked
        if ($(this).is(':checked')) {
          isAnyCheckboxChecked = true;
        }
      });

      // If no checkboxes are checked, show the error message
      if (!isAnyCheckboxChecked) {
        $('#error-message').text('At least one checkbox must be checked.').show();
        return;
      }

      let checkedChannel = $('input[type="radio"]:checked').attr('id');
      // Continue with the rest of your code here if needed

      const formData_3 = {
        step_3: $('#step_3').val(),
        hiddenField: $('#hiddenField').val(),
        product_qty: $('#product_qty').val(),
        product_category: checkboxData,
        product_channel: checkedChannel
      };

      ApiRequest('supplier/register', 'POST', formData_3)
        .then(response => {
          if (response.data.statusCode == 200) {
            $('.section_3').hide();
            $('.section_4').show().addClass('show_section_4');
          } else {
            // alert('Submission failed!');
          }
        })
        .catch(error => {
          console.error('Error:', error);
        });
    });

    $('#formData_4').submit(function(event) {
      event.preventDefault();

      var hiddenField = $('#hiddenField').val();
      var email = $("#email").val();
      var password = $("#password").val();
      var confirm_password = $("#confirm_password").val();
      const regex = /^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%@_.]).*$/;

      var isValid = true;

      // Clear previous errors
      $('#email').removeClass('is-invalid');
      $('#emailErr').text('');
      $('#password').removeClass('is-invalid');
      $('#passwordErr').text('');
      $('#confirm_password').removeClass('is-invalid');
      $('#confirm_passwordErr').text('');

      if (!email) {
        $('#email').addClass('is-invalid');
        $('#emailErr').text('Please enter your email.');
        isValid = false;
      }
      if (!password) {
        $('#password').addClass('is-invalid');
        $('#passwordErr').text('Please enter your password.');
        isValid = false;
      }
      if (!regex.test(password)) {
        $('#password').addClass('is-invalid');
        $('#passwordErr').text('Password must be at least 8 characters long, include letters, numbers, and special characters.');
        isValid = false;
      }
      if (!confirm_password) {
        $('#confirm_password').addClass('is-invalid');
        $('#confirm_passwordErr').text('Please enter your confirm password.');
        isValid = false;
      }
      if (password !== confirm_password) {
        $('#confirm_password').addClass('is-invalid');
        $('#confirm_passwordErr').text('Passwords do not match.');
        isValid = false;
      }

      if (isValid) {
        const formData_4 = {
          step_4: $('#step_4').val(),
          hiddenField: hiddenField,
          email: email,
          password: password,
          password_confirmation: confirm_password
        };

        ApiRequest('supplier/register', 'POST', formData_4)
          .then(response => {
            if (response.data.statusCode == 200) {
              $('.register').css('display', 'none');
              setTimeout(function() {
                $('.t_u_s').css('display', 'block');
              }, 10);
            } 
           else if (response.data.statusCode == 422) {
            const field = response.data.key;
            $(`#${field}`).addClass('is-invalid');
            $(`#${field}Err`).text(response.data.message);
          }
          })
          .catch(error => {
            console.error('Error:', error);
          });
      }
    });
  });
</script>
@endsection