<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login | Ekomn</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" as="style" onload="this.rel='stylesheet'">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}" as="style" onload="this.rel='stylesheet'" />
    <link rel="stylesheet" href="{{asset('assets/css/all.min.css')}}" as="style" onload="this.rel='stylesheet'" >


    <script type="text/javascript" src="{{asset('assets/js/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/request.js')}}"></script>

  </head>
  <body>
    <div class="wrapper d-flex justify-content-center">
      <div class="loginform ekcard">
        <div class="brand-logo d-flex justify-content-center">
          <div class="text-center">
          @include('auth.layout.logo')
          </div>
        </div>
        <form id="loginForm" action="{{ route('login') }}" method="POST">
        <div class="form-group">
          <input type="text" class="form-control userico @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email Address" value="{{ old('email') }}" autofocus />
          <div id="emailError" class="invalid-feedback"> 
             @error('email')
             {{ $message }}
            @enderror
          </div> 
        </div>
        <div class="form-group mb-0">
          <input type="text" class="form-control pwdico  @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password" />
          <div id="passwordError" class="invalid-feedback">
          @error('password')
             {{ $message }}
            @enderror
          </div> 
        </div>
       
        <button class="btn btn-login btnekomn block mt-4" type="submit">Login</button>
        </form>
        <div class="dividerline"></div>
        <div class="opacity-75 mb-1">Don't have an account?</div>
        <button class="btn btn-login btnekomn-border block">Become a eKomn Supplier</button>
      </div>
      <div id="emailError" class="invalid-feedback"></div> 
    </div>
    <footer class="loginfooter">
      &copy; 2024 ekomn.com, All Rights Reserved
    </footer>
  
    
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

  </body>
</html>
