<header>
    <div class="top_header">
        <ul class="b_h_list">
            <li><a href="{{ route('supplier.login') }}" class="active">Become a Supplier</a></li>
            <li><a href="">Subscriptions</a></li>
            <li><a href="">Integrations</a></li>
            <li><a href="">eKomn Blog</a></li>
        </ul>
    </div>
    <div class="main_header" id="main_header">
        <div class="barIcon" id="barIcon"><i class="fas fa-bars"></i></div>
        <div class="brandLogo">
            <a href="{{route('home')}}"><img src="{{asset('assets/images/Logo.svg')}}" alt="Logo" height="40" /></a>
        </div>
        <div class="headersearch">
            
                <div class="productSearch">
                    <input class="form-control serchinput" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn" id="searchBtnInput" type="button"><i class="fas fa-search"></i></button>
                </div>
                <div class="header_search_card">
                    <ul class="searchList">
                    </ul>
                </div>
        </div>
        @if (Auth::check())
            <div class="userAction">
                <div class="dropdown notificationDropdown">
                    <a href="" class="eknotification">
                        <span class="counter">5</span>
                        <i class="far fa-bell"></i>
                    </a>
                </div>
                <div class="dropdown userDropdown">
                    <div class="profile" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user">
                            <h4>{{ auth()->user()->name }}</h4>
                            @if (auth()->check())
                                @if (auth()->user()->hasRole(ROLE_ADMIN))
                                    <p class="m-0">Admin</p>
                                @elseif(auth()->user()->hasRole(ROLE_BUYER) ||
                                        auth()->user()->hasRole(ROLE_SUPPLIER))
                                    <p class="m-0">User ID: {{ auth()->user()->companyDetails->company_serial_id }}
                                    </p>
                                @endif
                            @endif
                        </div>
                        <div class="img-box">
                            <img src="https://i.postimg.cc/BvNYhMHS/user-img.jpg" alt="some user image" width="32px"
                                height="32px" />
                        </div>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end ekdropdown w_200">
                        <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li><a class="dropdown-item" href="{{ route('edit.profile') }}">Profile</a></li>
                        <li><a class="dropdown-item" href="#">Wish List</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                                <input type="hidden" name="token" id="token">
                            </form>
                            <a href="#" class="dropdown-item"
                                onclick="event.preventDefault();
                      document.getElementById('token').value = sessionStorage.getItem('token');
                        sessionStorage.removeItem('token'); sessionStorage.removeItem('user_details');
                      document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="cartAction">
                    <a href="" class="cart">
                        <span class="counter">0</span>
                        <img src="https://static-assets-web.flixcart.com/batman-returns/batman-returns/p/images/header_cart-eed150.svg"
                            alt="Cart" class="_1XmrCc" width="30" height="30">
                    </a>
                </div>
            </div>
        @else
            <div class="userAction">
                <a href="{{ route('buyer.login') }}" class="text-white fs-6">Login</a>
                <a href="{{ route('buyer.register') }}" class="btn btnekomn btnround px-5">Register</a>
            </div>
            <!-- <a href="{{ route('buyer.login') }}" class="text-white" >Login</a>
        <a href="{{ route('buyer.register') }}" class="btn btnekomn btnround px-5" >Register</a> -->
        @endif
    </div>
    <div class="bottom_header">
        <ul class="b_h_list">
            <li><a href="{{route('product.type', 'regular-available')}}" class="active">Regular Available</a></li>
            <li><a href="{{route('product.type', 'in-demand')}}">In Demand</a></li>
            <li><a href="{{route('product.type', 'premium')}}">Premium Products</a></li>
            <li><a href="{{route('product.type', 'new-arrivals')}}">New Arrivals</a></li>
            @if(Request::path() == '/' || Request::path() == 'product/premium' || Request::path() == 'product/in-demand' || Request::path() == 'product/new-arrivals')
            <li><a href="{{route('product.category', 'all')}}">View All</a></li>
            @else
            <li><a href="javascript:void(0)" onclick="viewAll();">View All</a></li>
            @endif
        </ul>
    </div>
</header>
