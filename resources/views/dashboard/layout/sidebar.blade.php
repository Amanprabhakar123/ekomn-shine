<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="ek_nav">
    <div class="sidebar-header">
        <img src="{{ asset('assets/images/Logo.svg') }}" alt="logo" height="40px" />
    </div>
    <div class="sidebar-menu">
        <ul class="navbar-nav" id="dashboard_ekomn">
            @if (auth()->user()->hasRole(ROLE_ADMIN) ||
                    auth()->user()->hasRole(ROLE_SUPPLIER) ||
                    auth()->user()->hasRole(ROLE_BUYER))
                <li class="nav-item">
                    <a class="nav-link collapsed nav-link-arrow" data-bs-toggle="collapse" href="#Inventory"
                        data-bs-parent="#dashboard_ekomn" id="components">
                        <i class="fas fa-warehouse menuIcon"></i>
                        <span class="nav-link-text">Inventory</span>
                        <span class="menu_arrowIcon"><i class="fas fa-angle-right"></i></span>
                    </a>
                    <ul class="sidenav-second-level collapse" id="Inventory" data-bs-parent="#dashboard_ekomn">
                        @if (auth()->user()->hasPermissionTo(PERMISSION_LIST_PRODUCT))
                            <li>
                                <a class="nav-link" href="{{ route('add.inventory') }}">Add New Inventory</a>
                            </li>
                            <li>
                                <a class="nav-link" href="{{ route('my.inventory') }}">My Inventory</a>
                            </li>
                            <li>
                                <a class="nav-link" href="{{ route('bulk-upload') }}">Bulk Upload Inventory</a>
                            </li>
                            <li>
                                <a class="nav-link" href="{{ route('bulk-upload.list') }}">Bulk Upload List</a>
                            </li>
                        @endif
                        @if (auth()->user()->hasRole(ROLE_BUYER))
                            <li>
                                <a class="nav-link" href="{{ route('my.inventory') }}">My Inventory</a>
                            </li>
                        @endif
                        <li>
                        <li>
                            <a class="nav-link" href="www.google.com">Integration Amazon</a>
                        </li>
                    </ul>
                </li>
            @endif
            <li class="nav-item">
                <a class="nav-link collapsed nav-link-arrow" data-bs-toggle="collapse" href="#Orders"
                    data-bs-parent="#dashboard_ekomn" id="components">
                    <i class="fas fa-shopping-cart menuIcon"></i>
                    <span class="nav-link-text">Orders</span>
                    <span class="menu_arrowIcon"><i class="fas fa-angle-right"></i></span>
                </a>
                <ul class="sidenav-second-level collapse" id="Orders" data-bs-parent="#dashboard_ekomn">
                    @if (auth()->user()->hasRole(ROLE_BUYER))
                        <li>
                            <a class="nav-link" href="{{ route('create.order') }}">Create Orders</a>
                        </li>
                    @endif
                    <li>
                        <a class="nav-link" href="{{ route('my.orders') }}">My Oders</a>
                    </li>
                    @if(auth()->user()->hasPermissionTo(PERMISSION_ORDER_TRACKING) )
                    <li>
                        <a class="nav-link" href="{{ route('order.tracking') }}">Order Tracking</a>
                    </li>
                    @endif
                    <li>
                        <a class="nav-link" href="#">Platform/Website Orders</a>
                    </li>
                    <li>
                        <a class="nav-link" href="#">Wallet/Invoices</a>
                    </li>
                    <li>
                        <a class="nav-link" href="#">Payments/Invoices</a>
                    </li>
                    <li>
                        <a class="nav-link" href="#">Returns</a>
                    </li>
                </ul>
            </li>
            @if(auth()->user()->hasPermissionTo(PERMISSION_PAYMENT_LIST) )
            <li class="nav-item">
                <a class="nav-link collapsed nav-link-arrow" data-bs-toggle="collapse" href="#payment"
                    data-bs-parent="#dashboard_ekomn" id="components">
                    <i class="fas fa-rupee-sign menuIcon"></i>
                    <span class="nav-link-text">Payments</span>
                    <span class="menu_arrowIcon"><i class="fas fa-angle-right"></i></span>
                </a>
                <ul class="sidenav-second-level collapse" id="payment" data-bs-parent="#dashboard_ekomn">
                    <li>
                        <a class="nav-link" href="{{ route('order.payment') }}">Payment</a>
                    </li>
                    <li>
                        <a class="nav-link" href="#">Payment Failed</a>
                    </li>
                </ul>
            </li>
            @endif
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-envelope menuIcon"></i>
                    <span class="nav-link-text">Messages/Notifications</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-tags menuIcon"></i>
                    <span class="nav-link-text">My Subscriptions</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed nav-link-arrow" data-bs-toggle="collapse" href="#Reports"
                    data-bs-parent="#dashboard_ekomn" id="components">
                    <i class="fas fa-file-pdf menuIcon"></i>
                    <span class="nav-link-text">Reports</span>
                    <span class="menu_arrowIcon"><i class="fas fa-angle-right"></i></span>
                </a>
                <ul class="sidenav-second-level collapse" id="Reports" data-bs-parent="#dashboard_ekomn">
                    <li>
                        <a class="nav-link" href="#">My Reports</a>
                    </li>
                    <li>
                        <a class="nav-link" href="#">Prebuilt Reports</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-user menuIcon"></i>
                    <span class="nav-link-text">Profile</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed nav-link-arrow" data-bs-toggle="collapse" href="#AdminControl"
                    data-bs-parent="#dashboard_ekomn" id="components">
                    <i class="fas fa-boxes menuIcon"></i>
                    <span class="nav-link-text">Admin Control Panel</span>
                    <span class="menu_arrowIcon"><i class="fas fa-angle-right"></i></span>
                </a>
                <ul class="sidenav-second-level collapse" id="AdminControl" data-bs-parent="#dashboard_ekomn">
                    <li>
                        <a class="nav-link" href="#">Banners</a>
                    </li>
                    <li>
                        <a class="nav-link" href="#">Content Update</a>
                    </li>
                    <li>
                        <a class="nav-link" href="#">MIS for Admin</a>
                    </li>
                    <li>
                        <a class="nav-link" href="#">Edit Log</a>
                    </li>
                    <li>
                        <a class="nav-link" href="#">Category Management</a>
                    </li>
                </ul>
            </li>

            @if (auth()->user()->hasRole(ROLE_ADMIN) )
            <li class="nav-item">
                <a class="nav-link collapsed nav-link-arrow" data-bs-toggle="collapse" href="#SettingControl"
                    data-bs-parent="#dashboard_ekomn" id="components">
                    <i class="fas fa-cog menuIcon"></i>
                    <span class="nav-link-text">Setting</span>
                    <span class="menu_arrowIcon"><i class="fas fa-angle-right"></i></span>
                </a>
                @if(auth()->user()->hasPermissionTo(PERMISSION_ADD_COURIER) || auth()->user()->hasPermissionTo(PERMISSION_LIST_COURIER))
                <ul class="sidenav-second-level collapse" id="SettingControl" data-bs-parent="#dashboard_ekomn">
                    <li>
                        <a class="nav-link" href="{{ route('courier-details') }}">Add Courier Details</a>
                    </li>
                    </li>
                    <li>
                        <a class="nav-link" href="{{ route('courier.list')}}">Courier List</a>
                    </li>
                  
                    </li>
                </ul>
                @endif
            </li>
            @endif
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-headset menuIcon"></i>
                    <span class="nav-link-text">Support</span>
                </a>
            </li>
        </ul>
    </div>
</div>
