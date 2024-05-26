<div class="login-wrapper">
    <div class="loginimages">
        @include('auth.layout.sidebar_slider')
        <div class="login-container">
            <div class="loginForm">
                @include('auth.layout.logo')
                <h3 class="h3 m-0">Reset your password</h3>
                <p class="opacity-75 my25">Set a new password for your account. Enter your desired password and confirm it below.</p>
                <form id="resetForm" action="#" method="POST">
                    <div class="form-group">
                        <input type="hidden" id="email" name="email" value="{{ request()->get('email') }}" />
                        <input type="hidden" id="token" name="token" value="{{ request()->get('token') }}" />
                        <input type="hidden" id="role" name="role" value="{{ request()->get('role') }}" />
                        <input type="password" id="password" name="password" class="form-control pwdico" placeholder="Enter a new password" />
                        <div id="passwordError" class="invalid-feedback"></div> <!-- Error message for password -->
                    </div>
                    <div class="form-group mb-0">
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control pwdico" placeholder="Confirm a new password" />
                        <div id="confirmPasswordError" class="invalid-feedback"></div> <!-- Error message for password -->
                    </div>
                    <button type="submit" class="btn btn-login btnekomn block my-4">Submit</button>
                </form>
                <div class="d-flex justify-content-center">
                    @if(request()->get('role') == 'buyer')
                    <a href="{{ route('buyer.login') }}" class="btn btn-link a_color">Back To Login</a>
                    @elseif(request()->get('role') == 'supplier')
                    <a href="{{ route('supplier.login') }}" class="btn btn-link a_color">Back To Login</a>
                    @endif
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
            $('#password').removeClass('is-invalid');
            $('#passwordError').text('');
            $('#password_confirmation').removeClass('is-invalid');
            $('#confirmPasswordError').text('');
        }

        // Call clearErrorMessages function when the email input is focused
        $('#passowrd').focus(function() {
            clearErrorMessages();
        });

        // Call clearErrorMessages function when the password input is focused
        $('#password_confirmation').focus(function() {
            clearErrorMessages();
        });

        $('#resetForm').submit(function(event) {
            event.preventDefault(); // Prevent form submission

            // Show error message for empty fields
            var email = $('#email').val();
            var token = $('#token').val();
            var role = $('#role').val();
            var password = $('#password').val();
            var passwordConfirmation = $('#password_confirmation').val();
    

            // Password validation
            if (!password) {
                $('#password').addClass('is-invalid');
                $('#passwordError').text('Please enter your password.');
                
            }

            // Password confirmation validation
            if (!passwordConfirmation) {
                $('#password_confirmation').addClass('is-invalid');
                $('#confirmPasswordError').text('Please confirm your password.');
                return;
            }

            // Check if passwords match
            if (password !== passwordConfirmation) {
                $('#password_confirmation').addClass('is-invalid');
                $('#confirmPasswordError').text('Passwords do not match.');
                return;
            }
            // return; // Exit the function if any field is empty


            const formData = {
                email: email,
                token:token,
                role:role,
                password: password,
                password_confirmation: passwordConfirmation
            };

            // Call APIRequest function with login endpoint and form data
            ApiRequest('password/reset', 'POST', formData)
                .then(response => {
                    // If login successful, store token in sessionStorage
                    console.log(response);
                    if (response.data.statusCode == 200) {
                        
                        alert('password reset successful!');
                        // Redirect to dashboard or perform other actions
                        if(role == "buyer"){
                            window.location.href = 'buyer/login';
                        }else{
                            window.location.href = 'supplier/login';
                        }
                        
                    } else {
                        alert('password failed!');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('password failed!');
                });
        });
    });
</script>
@endsection