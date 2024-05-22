@include('auth.layout.header')
<body>
@if(Request::path() == 'buyer/login')
@include('auth.buyer.login')

@elseif(Request::path() == 'supplier/login')
@include('auth.supplier.login')


@elseif(Request::path() == 'buyer/register')
@include('auth.buyer.register')


@elseif(Request::path() == 'supplier/register')
@include('auth.supplier.register')


@elseif(Request::path() == 'buyer/forget')
@include('auth.buyer.forget')


@elseif(Request::path() == 'supplier/forget')
@include('auth.supplier.forget')


@elseif(Request::path() == 'buyer/reset')
@include('auth.buyer.reset')


@elseif(Request::path() == 'supplier/reset')
@include('auth.supplier.reset')


@endif

<script type="text/javascript" src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
@yield('custom_script')
</body>
</html>