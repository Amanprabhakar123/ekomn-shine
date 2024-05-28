<div class="login-wrapper">
  <div class="loginimages">
    @include('auth.layout.sidebar_slider')
    <div class="login-container">
      <div id="sentEmialForm">
      <form id="loginForm" action="#" method="POST">
        <div class="loginForm">
          @include('auth.layout.logo')
          <h3 class="h3 m-0">Forgot your password</h3>
          <p class="opacity-75 my25">Please enter the email address you'd like your password reset information sent to.</p>
          <div class="form-group mb-0">
            <input type="email" id="email" name="email" class="form-control userico" placeholder="Email Address" />
            <div id="emailError" class="invalid-feedback"></div> <!-- Error message for email -->
          </div>
          <button class="btn btn-login btnekomn block my-4" type="submit">Request reset link</button>
      </form>
      <div class="d-flex justify-content-center">
        <a href="{{ route('supplier.login') }}" class="btn btn-link a_color">Back To Login</a>
      </div>
      </div>
    </div>

    <div class="loginForm t_u_s" style="display: none;" id="thankyou">
          @include('auth.layout.logo')

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
                <p id="r_m"></p>
                <a href="{{ route('supplier.login') }}" class="a_color">Click to Login</a>
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
    // Function to clear error messages for email and password fields
    function clearErrorMessages() {
      $('#email').removeClass('is-invalid');
      $('#emailError').text('');
    }

    // Call clearErrorMessages function when the email input is focused
    $('#email').focus(function() {
      clearErrorMessages();
    });

    $('#loginForm').submit(function(event) {
      event.preventDefault(); // Prevent form submission
      // Retrieve form values
      const email = $('#email').val();

      // Check if email and password are not empty
      if (!email) {
        // Show error message for empty fields
        if (!email) {
          $('#email').addClass('is-invalid'); // Add red border to email field
          $('#emailError').text('Please enter your email.'); // Display error message for email
        } else {
          $('#email').removeClass('is-invalid'); // Remove red border from email field
          $('#emailError').text(''); // Clear error message for email
        }

        return; // Exit the function if any field is empty
      }

      // If all fields are filled, proceed with form submission
      const formData = {
        email: email,
      };
      // var element = document.getElementById("myElement");

      // Call APIRequest function with login endpoint and form data
      ApiRequest('password/forget', 'POST', formData)
        .then(response => {
          // If login successful, store token in sessionStorage
          if (response.data.statusCode == 200) {

            $("#sentEmialForm").css({
              "display": "none"
            });
            $("#thankyou").css({
              "display": "block"
            });
            $('#r_m').append(response.data.message);
          } else {
            alert('Failed to send reset password email. Please try again.');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('><><><><><><> Failed to send reset password email. Please try again later.');
        });
    });
  });
</script>
@endsection
    