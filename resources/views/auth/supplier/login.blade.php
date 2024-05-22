<body>
    <div class="login-wrapper">
        <div class="loginimages">
            @include('auth.layout.sidebar_slider')
            <div class="login-container">
                <div class="loginForm">
                    @include('auth.layout.logo')
                    <button class="btn btn-login ssologin block">Login with Google</button>
                    <div class="orline">
                        <span>Or</span>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control userico" placeholder="Email Address" />
                    </div>
                    <div class="form-group mb-0">
                        <input type="text" class="form-control pwdico" placeholder="Password" />
                    </div>
                    <div class="text-end mt-1">
                        <a href="forgot-password.html" class="a_color text_u">Forgot Password?</a>
                    </div>
                    <button class="btn btn-login btnekomn block mt-4">Login</button>
                    <div class="dividerline"></div>
                    <div class="opacity-75 mb-1">Don't have an account?</div>
                    <a href="{{ route('supplier.login') }}" class="btn btn-login btnekomn-border block">Register Now</a>
                </div>
                @include('auth.layout.footer')
            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
</body>