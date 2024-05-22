<body>
    <div class="login-wrapper">
      <div class="loginimages">
      @include('auth.layout.sidebar_slider')
        <div class="login-container">
          <div class="loginForm">
          @include('auth.layout.logo')
            <h3 class="h3 m-0">Reset your password</h3>
            <p class="opacity-75 my25">Set a new password for your account. Enter your desired password and confirm it below.</p>
            <div class="form-group">
              <input type="password" class="form-control pwdico" placeholder="Enter a new password" />
            </div>
            <div class="form-group mb-0">
              <input type="text" class="form-control pwdico" placeholder="Confirm a new password" />
            </div>
            <button type="submit" class="btn btn-login btnekomn block my-4">Submit</button>
            <div class="d-flex justify-content-center">
              <a href="{{ route('supplier.login') }}" class="btn btn-link a_color">Back To Login</a>
            </div>
          </div>
          @include('auth.layout.footer')
        </div>
      </div>
    </div>
    <script type="text/javascript" src="assets/js/bootstrap.bundle.min.js"></script>
  </body>