<div class="login-wrapper">
    <div class="loginimages">
        @include('auth.layout.sidebar_slider')
        <div class="login-container">
        <div class="loginForm">

                <div class="loginForm t_u_s">
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
                        <h1 class="thank_h1">Payment Failed!</h1>
                        <p>Your payment was failed if you have amount please wait 48 working hours for refund.</p>
                        <a href="{{route('buyer.register')}}" class="a_color">Click to Register</a>
                        </div>
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
        $('.t_u_s').show();
    });
    </script>
@endsection