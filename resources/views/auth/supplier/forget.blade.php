    <div class="login-wrapper">
      <div class="loginimages">
      @include('auth.layout.sidebar_slider')
        <div class="login-container">
          <div class="loginForm">
          @include('auth.layout.logo')
            <h3 class="h3 m-0">Forgot your password</h3>
            <p class="opacity-75 my25">Please enter the email address you'd like your password reset information sent to.</p>
            <div class="form-group mb-0">
              <input type="text" class="form-control userico" placeholder="Email Address" />
            </div>
            <a href="" class="btn btn-login btnekomn block my-4">Request reset link</a>
            <div class="d-flex justify-content-center">
              <a href="{{ route('supplier.login') }}" class="btn btn-link a_color">Back To Login</a>
            </div>
          </div>
          @include('auth.layout.footer')
        </div>
      </div>
    </div>