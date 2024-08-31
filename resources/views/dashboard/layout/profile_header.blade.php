<header class="ekheader dashboard-header">
    <div class="menutoggle"><i class="fas fa-bars"></i></div>
    <div class="d-flex justify-content-between align-items-center">
        <div class="logo_brand">
            <a href="{{route('dashboard')}}" class="brandLogo_d"><img src="{{asset('assets/images/Logo.svg')}}" alt="Logo" height="40" /></a>
        </div>
        <div class="dropdown">
            <div class="profile" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="user">
                    <h4>{{auth()->user()->name}}</h4>
                    @if(auth()->check())
                        @if(auth()->user()->hasRole(ROLE_ADMIN))
                            <p class="m-0">Admin</p>
                        @elseif(auth()->user()->hasRole(ROLE_SUB_ADMIN))
                            <p class="m-0">Sub Admin</p>
                        @elseif(auth()->user()->hasRole(ROLE_BUYER) || auth()->user()->hasRole(ROLE_SUPPLIER))
                            <p class="m-0">User ID: {{auth()->user()->companyDetails->company_serial_id}}</p>
                        @endif
                    @endif
                </div>
                <div class="img-box">
                    <img src="{{asset('assets/images/icon/user-2.png')}}" alt="some user image" />
                </div>
            </div>
            <ul class="dropdown-menu dropdown-menu-end ekdropdown w_200">
                @if(auth()->user()->hasRole(ROLE_BUYER) ||
                auth()->user()->hasRole(ROLE_SUPPLIER))
                <li><a class="dropdown-item" href="{{route('edit.profile')}}">Profile</a></li>
                @endif
                <li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                    <input type="hidden" name="token" id="token">
                </form>
                <a href="#" class="dropdown-item" onclick="event.preventDefault();
                        document.getElementById('token').value = sessionStorage.getItem('token');
                         sessionStorage.removeItem('token'); sessionStorage.removeItem('user_details');
                        document.getElementById('logout-form').submit();">
                    Logout
                </a>
                </li>
            </ul>
        </div>
    </div>
</header>