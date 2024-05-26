<div class="login-wrapper">
    <div class="loginimages">
        @include('auth.layout.sidebar_slider')
        <div class="login-container">
            <form  id="loginForm" action="#" method="POST">
            <div class="loginForm">
                @include('auth.layout.logo')
                <a class="btn btn-login ssologin block" href="{{ route('auth.google.redirect') }}">Login with Google</a>
                <div class="orline">
                    <span>Or</span>
                </div>
                <div class="form-group">
                    <input type="text" id="email" class="form-control userico" placeholder="Email Address" />
                    <div id="emailError" class="invalid-feedback"></div> <!-- Error message for email -->
                </div>
                <div class="form-group mb-0">
                    <input type="password" id="password" class="form-control pwdico" placeholder="Password" />
                    <div id="passwordError" class="invalid-feedback"></div> <!-- Error message for password -->
                </div>
                <div class="text-end mt-1">
                    <a href="{{ route('buyer.forget') }}" class="a_color text_u">Forgot Password?</a>
                </div>
                <button class="btn btn-login btnekomn block mt-4" type="submit">Login</button>
                <div class="dividerline"></div>
                <div class="opacity-75 mb-1">Don't have an account?</div>
                <a href="{{ route('buyer.register') }}" class="btn btn-login btnekomn-border block">Register Now</a>
            </div>
            </form>
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
            $('#password').removeClass('is-invalid');
            $('#passwordError').text('');
        }

        // Call clearErrorMessages function when the email input is focused
        $('#email').focus(function() {
            clearErrorMessages();
        });

        // Call clearErrorMessages function when the password input is focused
        $('#password').focus(function() {
            clearErrorMessages();
        });
        
        $('#loginForm').submit(function(event) {
            event.preventDefault(); // Prevent form submission

            // Retrieve form values
            const email = $('#email').val();
            const password = $('#password').val();

            // Check if email and password are not empty
            if (!email || !password) {
                // Show error message for empty fields
                if (!email) {
                    $('#email').addClass('is-invalid'); // Add red border to email field
                    $('#emailError').text('Please enter your email.'); // Display error message for email
                } else {
                    $('#email').removeClass('is-invalid'); // Remove red border from email field
                    $('#emailError').text(''); // Clear error message for email
                }
                if (!password) {
                    $('#password').addClass('is-invalid'); // Add red border to password field
                    $('#passwordError').text('Please enter your password.'); // Display error message for password
                } else {
                    $('#password').removeClass('is-invalid'); // Remove red border from password field
                    $('#passwordError').text(''); // Clear error message for password
                }
                return; // Exit the function if any field is empty
            }

             // If all fields are filled, proceed with form submission
             const formData = {
                email: email,
                password: password
            };

            // Call APIRequest function with login endpoint and form data
            ApiRequest('login', 'POST', formData)
                .then(response => {
                    // If login successful, store token in sessionStorage
                    if (response.data.auth.access_token) {
                        sessionStorage.setItem('token', response.data.auth.access_token);
                        alert('Login successful!');
                        // Redirect to dashboard or perform other actions
                        window.location.href = '/';
                    } else {
                        alert('Login failed!');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Login failed!');
                });
        });
    });
</script>
@endsection