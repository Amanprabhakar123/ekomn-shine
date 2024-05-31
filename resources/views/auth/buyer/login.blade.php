<div class="login-wrapper">
    <div class="loginimages">
        @include('auth.layout.sidebar_slider')
        <div class="login-container">
            <form id="loginForm" action="{{ route('login') }}" method="POST">
                @csrf <!-- Laravel CSRF protection token -->
                <div class="loginForm">
                    @include('auth.layout.logo')
                    <a class="btn btn-login ssologin block" href="{{ route('auth.google.redirect') }}">Login with Google</a>
                    <div class="orline">
                        <span>Or</span>
                    </div>
                    <div class="form-group">
                        <input type="text" id="email" name="email" class="form-control userico" placeholder="Email Address" />
                        <div id="emailError" class="invalid-feedback"></div> <!-- Error message for email -->
                    </div>
                    <div class="form-group mb-0">
                        <input type="password" id="password" name="password" class="form-control pwdico" placeholder="Password" />
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
        function clearErrorMessages() {
            $('#email').removeClass('is-invalid');
            $('#emailError').text('');
            $('#password').removeClass('is-invalid');
            $('#passwordError').text('');
        }

        $('#email').focus(function() {
            clearErrorMessages();
        });

        $('#password').focus(function() {
            clearErrorMessages();
        });

        $('#loginForm').submit(function(event) {
            // Retrieve form values
            const email = $('#email').val();
            const password = $('#password').val();

            // Check if email and password are not empty
            if (!email || !password) {
                // Show error message for empty fields
                if (!email) {
                    $('#email').addClass('is-invalid');
                    $('#emailError').text('Please enter your email.');
                } else {
                    $('#email').removeClass('is-invalid');
                    $('#emailError').text('');
                }
                if (!password) {
                    $('#password').addClass('is-invalid');
                    $('#passwordError').text('Please enter your password.');
                } else {
                    $('#password').removeClass('is-invalid');
                    $('#passwordError').text('');
                }
                return false; // Prevent form submission if any field is empty
            }

            // Allow the form to submit normally if validation passes
            return true;
        });
    });
</script>
@endsection
