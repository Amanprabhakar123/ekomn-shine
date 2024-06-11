@include('auth.layout.header')
<body>
  <div class="login-wrapper">
    <div class="loginimages">
      @include('auth.layout.sidebar_slider')
      <div class="login-container">
        <div id="sentEmialForm">
          <form id="loginForm" action="#" method="POST">
            <div class="loginForm">
              @include('auth.layout.logo')
              <h3 class="h3 m-0">Please Verify Your Email</h3>

              {{--<div class="form-group mb-0">
                <input type="hidden" id="id" name="id" value="{{ request()->get('id') }}" class="form-control userico" />
                <input type="hidden" id="hash" name="hash" value="{{ request()->get('hash') }}" class="form-control userico" />
              </div> --}}
              <input type="hidden" id="id" name="id" value="{{ salt_encrypt(auth()->user()->id) }}" class="form-control userico" />
              <button class="btn btn-login btnekomn block my-4" type="submit">Send Email Link</button>
          </form>
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
            <!-- <a href="" id="role_s_b" class="a_color">Click to Login</a> -->
          </div>
        </div>
      </div>
      @include('auth.layout.footer')
    </div>
  </div>
  </div>

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
        // // Retrieve form values
        const id = $('#id').val();
        // const hash = $('#hash').val();

        // // If all fields are filled, proceed with form submission
        const formData = {
          id: id,
        };
        // var element = document.getElementById("myElement");

        // Call APIRequest function with login endpoint and form data
        ApiRequest('send-email-link', 'POST', formData)
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
              $('#role_s_b').attr('href', response.data.redirect);
              // $('#role_s_b').text(response.data.text);
            } else {
              console.log(response.data);
              // alert('Failed to send reset password email. Please try again.');
            }
          })
          .catch(error => {
            console.error('Error:', error);
          });
      });
    });
  </script>
</body>

</html>