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
                        <input class="qt_inp form-control" type="number" id="product_qty" placeholder="Qty." aria-label="Product Quantity" />
                      </div>
                    </li>
                    <li>
                      <label class="ack_q_w required">Select your product categories</label>
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
  /*
  $(document).ready(function() {


    // Function to clear error messages for email and password fields
    function clearErrorMessages() {
        $('#business_name').removeClass('is-invalid');
        $('#business_nameErr').text('');

        $('#gst').removeClass('is-invalid');
        $('#gstErr').text('');

        $('#first_name').removeClass('is-invalid');
        $('#first_nameErr').text('');

        $('#mobile').removeClass('is-invalid');
        $('#mobileErr').text('');

        // $('#designation').removeClass('is-invalid');
        // $('#designationErr').text('');

        $('#address').removeClass('is-invalid');
        $('#addressErr').text('');

        $('#state').removeClass('is-invalid');
        $('#stateErr').text('');

        $('#city').removeClass('is-invalid');
        $('#cityErr').text('');

        $('#pin_code').removeClass('is-invalid');
        $('#pin_codeErr').text('');

        $('#email').removeClass('is-invalid');
        $('#emailErr').text('');

        $('#password').removeClass('is-invalid');
        $('#passwordErr').text('');

        $('#confirm_password').removeClass('is-invalid');
        $('#confirm_passwordErr').text('');
    }

    // Call clearErrorMessages function when the email input is focused
    $('#business_name').focus(function() {
        clearErrorMessages();
    });

    $('#gst').focus(function() {
        clearErrorMessages();
    });

    $('#first_name').focus(function() {
        clearErrorMessages();
    });

    $('#mobile').focus(function() {
        clearErrorMessages();
    });

    // $('#designation').focus(function() {
    //     clearErrorMessages();
    // });

    $('#address').focus(function() {
        clearErrorMessages();
    });

    $('#state').focus(function() {
        clearErrorMessages();
    });

    $('#city').focus(function() {
        clearErrorMessages();
    });

    $('#pin_code').focus(function() {
        clearErrorMessages();
    });

    $('#email').focus(function() {
        clearErrorMessages();
    });

    $('#password').focus(function() {
        clearErrorMessages();
    });

    $('#confirm_password').focus(function() {
        clearErrorMessages();
    });
    $('#formStep_1').submit(function(event) {
      event.preventDefault();
      // Retrieve form values
      var step_1 = $('#step_1').val(); // this is hidden field
      var businessName = $('#business_name').val();
      var gst = $('#gst').val();
      var website = $('#website_url').val();
      var firstName = $('#first_name').val();
      var lastName = $('#last_name').val();
      var mobile = $('#mobile').val();
      var designation = $('#designation').val();
      var address = $('#address').val();
      var state = $('#state').val();
      var city = $('#city').val();
      var pinCode = $('#pin_code').val();

      

          // Show error message for empty fields
          if (!businessName) {
              $('#business_name').addClass('is-invalid'); // Add red border to email field
              $('#business_nameErr').text('Please enter your email.'); // Display error message for email
          } 

          if (!gst) {
              $('#gst').addClass('is-invalid'); // Add red border to email field
              $('#gstErr').text('Please enter your email.'); // Display error message for email
          } 
          if (!firstName) {
              $('#first_name').addClass('is-invalid'); // Add red border to password field
              $('#first_nameErr').text('Please enter your password.'); // Display error message for password
              
          }
          if (!mobile) {
              $('#mobile').addClass('is-invalid'); // Add red border to password field
              $('#mobileErr').text('Please enter your password.'); // Display error message for password
          } 
          // if (!designation) {
          //     $('#designation').addClass('is-invalid'); // Add red border to password field
          //     $('#designationErr').text('Please enter your password.'); // Display error message for password
          // } 
          if (!address) {
              $('#address').addClass('is-invalid'); // Add red border to password field
              $('#addressErr').text('Please enter your password.'); // Display error message for password
          } 
          if (!state) {
              $('#state').addClass('is-invalid'); // Add red border to password field
              $('#stateErr').text('Please enter your password.'); // Display error message for password
          } 
          if (!city) {
              $('#city').addClass('is-invalid'); // Add red border to password field
              $('#cityErr').text('Please enter your password.'); // Display error message for password
          } 
          if (!pinCode) {
              $('#pin_code').addClass('is-invalid'); // Add red border to password field
              $('#pin_codeErr').text('Please enter your password.'); // Display error message for password
              return; // Exit the function if any field is empty
          } 
           
          
          
      

      // If all fields are filled, proceed with form submission
      const formData_1 = {
        business_name: businessName,
        step_1: step_1,
        gst: gst,
        website: website,
        first_name: firstName,
        last_name: lastName,
        mobile: mobile,
        designation: designation,
        address: address,
        state: state,
        city: city,
        pin_code: pinCode
      };

      // Call APIRequest function with login endpoint and form data
      ApiRequest('registration', 'POST', formData_1)
        .then(response => {
          // If login successful, store token in sessionStorage

          if (response.data.statusCode = 200) {

            alert('registered successful!');
            $('#hiddenField').val(response.data.id);
            $('.section_1').css('display', 'none')
            $('.section_2').css('display', 'block')

            setTimeout(function() {
              $(".section_2").show().addClass("show_section_2");
            }, 10);


            // Redirect to dashboard or perform other actions
          } else {
            alert('register failed!');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Login failed!');
        });
    });

    $('#formStep_2').submit(function(event) {
      event.preventDefault();
      // Retrieve form values

      var step_2 = $('#step_2').val();
      var hiddenField = $('#hiddenField').val();
      var bulk_dispatch_time_isChecked = $("#bulk_dispatch_time").prop("checked") ? 1 : 0;
      var dropship_dispatch_time_isChecked = $("#dropship_dispatch_time").prop("checked") ? 1 : 0;
      var product_quality_confirm_isChecked = $("#product_quality_confirm").prop("checked") ? 1 : 0;
      var business_compliance_confirm_isChecked = $("#business_compliance_confirm").prop("checked") ? 1 : 0;


      const formData_2 = {
        step_2: step_2,
        hiddenField: hiddenField,
        bulk_dispatch_time: bulk_dispatch_time_isChecked,
        dropship_dispatch_time: dropship_dispatch_time_isChecked,
        product_quality_confirm: product_quality_confirm_isChecked,
        business_compliance_confirm: business_compliance_confirm_isChecked,
      };


      ApiRequest('registration', 'POST', formData_2)
        .then(response => {
          if (response.data.statusCode = 200) {
            alert('registered successful!');
            $('.section_1').css('display', 'none')
            $('.section_2').css('display', 'none')
            $('.section_3').css('display', 'block')

            setTimeout(function() {
              $(".section_3").show().addClass("show_section_3");
            }, 10);


            // Redirect to dashboard or perform other actions
          } else {
            alert('register failed!');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Login failed!');
        });
    });

    // form step 3 start here
    $('#formData_3').submit(function(event) {
      event.preventDefault();

      var step_3 = $('#step_3').val();
      var hiddenField = $('#hiddenField').val();
      var category1 = $("#category1").prop("checked") ? 1 : 0;
      var category2 = $("#category2").prop("checked") ? 1 : 0;
      var category3 = $("#category3").prop("checked") ? 1 : 0;
      var category4 = $("#category4").prop("checked") ? 1 : 0;
      var category5 = $("#category5").prop("checked") ? 1 : 0;
      var category6 = $("#category6").prop("checked") ? 1 : 0;
      var category7 = $("#category7").prop("checked") ? 1 : 0;
      var category8 = $("#category8").prop("checked") ? 1 : 0;
      var channel1 = $("#channel1").prop("checked") ? 1 : 0;
      var channel2 = $("#channel2").prop("checked") ? 1 : 0;
      var channel3 = $("#channel3").prop("checked") ? 1 : 0;
      var channel4 = $("#channel4").prop("checked") ? 1 : 0;
      var channel5 = $("#channel5").prop("checked") ? 1 : 0;
      var channel6 = $("#channel6").prop("checked") ? 1 : 0;



      const formData_3 = {
        step_3: step_3,
        hiddenField: hiddenField,
        category1: category1,
        category2: category2,
        category3: category3,
        category4: category4,
        category5: category5,
        category6: category6,
        category7: category7,
        category8: category8,
        channel1: channel1,
        channel2: channel2,
        channel3: channel3,
        channel4: channel4,
        channel5: channel5,
        channel6: channel6
      };

      ApiRequest('registration', 'POST', formData_3)
        .then(response => {
          // If login successful, store token in sessionStorage
          // console.log(formData_2)
          if (response.data.statusCode = 200) {
            alert('registered successful!');

            // $('.section_1').css('display', 'none')
            $('.section_1').css('display', 'none')
            $('.section_2').css('display', 'none')
            $('.section_3').css('display', 'none')
            $('.section_4').css('display', 'block')

            setTimeout(function() {
              $(".section_4").show().addClass("show_section_4");
            }, 10);


            // Redirect to dashboard or perform other actions
          } else {
            alert('register failed!');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Login failed!');
        });

    });
    $('#formData_4').submit(function(event) {
      event.preventDefault();

      var step_4 = $('#step_4').val();
      var hiddenField = $('#hiddenField').val();
      var email = $("#email").val()
      var password = $("#password").val();
      var confirm_password = $("#confirm_password").val();

      if (!email) {
              $('#email').addClass('is-invalid'); // Add red border to password field
              $('#emailErr').text('Please enter your email.'); // Display error message for password
          } 
          if (!password) {
              $('#password').addClass('is-invalid'); // Add red border to password field
              $('#passwordErr').text('Please enter your password.'); // Display error message for password
          } 
          if (!confirm_password) {
              $('#confirm_password').addClass('is-invalid'); // Add red border to password field
              $('#confirm_passwordErr').text('Please enter your confirm password.'); // Display error message for password
              return;
          } 
          if (password !== confirm_password) {
              $('#confirm_password').addClass('is-invalid'); // Add red border to password field
              $('#confirm_passwordErr').text('Password does not match.'); // Display error message for password
              return;
          } 


      const formData_4= {
        step_4: step_4,
        hiddenField: hiddenField,
        email: email,
        password: password,
        confirm_password: confirm_password,
      };

      ApiRequest('registration', 'POST', formData_4)
        .then(response => {
         
          if (response.data.statusCode = 200) {
            alert('registered successful!');
            $('.register').css('display', 'none')
            
            setTimeout(function() {
              $('.t_u_s').css('display', 'block')
            }, 10);
          } else {
            alert('register failed!');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Login failed!');
        });

    });
  });
  */

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
      ApiRequest('registration', 'POST', formData_1)
        .then(response => {
          if (response.data.statusCode == 200) {
            $('#hiddenField').val(response.data.id);
            $('.section_1').hide();
            $('.section_2').show().addClass('show_section_2');
          }
        })
        .catch(error => {
          console.error('Error222:', error);
        });
    });

    // Form submission handler for Step 2
    $('#formStep_2').submit(function(event) {
      event.preventDefault();

      const formData_2 = {
        step_2: $('#step_2').val(),
        hiddenField: $('#hiddenField').val(),
        bulk_dispatch_time: $("#bulk_dispatch_time").is(":checked") ? 1 : 0,
        dropship_dispatch_time: $("#dropship_dispatch_time").is(":checked") ? 1 : 0,
        product_quality_confirm: $("#product_quality_confirm").is(":checked") ? 1 : 0,
        business_compliance_confirm: $("#business_compliance_confirm").is(":checked") ? 1 : 0,
      };

      ApiRequest('registration', 'POST', formData_2)
        .then(response => {
          if (response.data.statusCode == 200) {
            $('.section_2').hide();
            $('.section_3').show().addClass('show_section_3');
          } else {
            alert('Acknowledgement failed!');
          }
        })
        .catch(error => {
          console.error('Error:', error);
        });
    });

    // Form submission handler for Step 3
    $('#formData_3').submit(function(event) {
      event.preventDefault();

      const formData_3 = {
        step_3: $('#step_3').val(),
        hiddenField: $('#hiddenField').val(),
        category1: $("#category1").is(":checked") ? 1 : 0,
        category2: $("#category2").is(":checked") ? 1 : 0,
        category3: $("#category3").is(":checked") ? 1 : 0,
        category4: $("#category4").is(":checked") ? 1 : 0,
        category5: $("#category5").is(":checked") ? 1 : 0,
        category6: $("#category6").is(":checked") ? 1 : 0,
        category7: $("#category7").is(":checked") ? 1 : 0,
        category8: $("#category8").is(":checked") ? 1 : 0,
        channel1: $("#channel1").is(":checked") ? 1 : 0,
        channel2: $("#channel2").is(":checked") ? 1 : 0,
        channel3: $("#channel3").is(":checked") ? 1 : 0,
        channel4: $("#channel4").is(":checked") ? 1 : 0,
        channel5: $("#channel5").is(":checked") ? 1 : 0,
        channel6: $("#channel6").is(":checked") ? 1 : 0,
      };

      ApiRequest('registration', 'POST', formData_3)
        .then(response => {
          if (response.data.statusCode == 200) {
            $('.section_3').hide();
            $('.section_4').show().addClass('show_section_4');
          } else {
            alert('Submission failed!');
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

            ApiRequest('registration', 'POST', formData_4)
                .then(response => {
                    if (response.data.statusCode == 200) {
                        $('.register').css('display', 'none');
                        setTimeout(function() {
                            $('.t_u_s').css('display', 'block');
                        }, 10);
                    } else {
                        alert('Registration failed!');
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