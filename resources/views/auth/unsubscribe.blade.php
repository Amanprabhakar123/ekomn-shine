@include('auth.layout.header')

<body>
    <div class="login-wrapper">
        <div class="loginimages">
            @include('auth.layout.sidebar_slider')
            <div class="login-container">
            <div class="loginForm">
                <div class="loginForm">
                    <div class="brand-logo d-flex justify-content-center">
                        <a href="#"><img src="{{asset('assets/images/Logo.svg')}}" alt="Logo" /></a>
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
                        <h1 class="thank_h1">Thank you!</h1>
                        <p>You have successfully unsubscribed.</p>
                        <a href="{{route('home')}}" class="a_color">Go to Website</a>
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>
    </div>

</body>

</html>