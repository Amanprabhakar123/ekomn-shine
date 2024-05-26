<div class="brand-logo d-flex justify-content-center">
    <a href="#"><img src="{{asset('assets/images/Logo.svg')}}" alt="Logo" /></a>
    @if(Request::path() == 'supplier/login' || Request::path() == 'supplier/register')
    <span class="sub-title">Seller Center</span>
    @endif
</div>
