
    @if(Request::path() == 'supplier/login' || Request::path() == 'supplier/register')
    <div class="brand-logo d-flex justify-content-center align-items-center">
              <a href="{{route('home')}}"><img src="{{asset('assets/images/Logo.svg')}}" alt="Logo" /></a>
               <div class="SellerText">Seller Center</div>
            </div>
    @else
    <div class="brand-logo d-flex justify-content-center">
    <a href="{{route('home')}}"><img src="{{asset('assets/images/Logo.svg')}}" alt="Logo" /></a>
    </div>
    @endif

