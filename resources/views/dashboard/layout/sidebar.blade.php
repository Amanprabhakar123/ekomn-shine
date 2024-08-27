<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="ek_nav">
    <div class="sidebar-header">
        <a href="{{ route('home') }}"><img src="{{ asset('assets/images/Logo.svg') }}" alt="logo" height="40px" /></a>
        <div class="collapseIcon"><i class="fas fa-angle-double-left"></i></div>
    </div>
    <div class="sidebar-menu">
        <ul class="navbar-nav" id="dashboard_ekomn">
                @if (auth()->user()->hasPermissionTo(PERMISSION_ADD_PRODUCT) || auth()->user()->hasPermissionTo(PERMISSION_LIST_PRODUCT))
 
                <li class="nav-item">
                    <a class="nav-link collapsed nav-link-arrow" data-bs-toggle="collapse" href="#Inventory"
                        data-bs-parent="#dashboard_ekomn" id="components">
                        <i class="fas fa-warehouse menuIcon"></i>
                        <span class="nav-link-text">Inventory</span>
                        <span class="menu_arrowIcon"><i class="fas fa-angle-right"></i></span>
                    </a>
                    <ul class="sidenav-second-level collapse" id="Inventory" data-bs-parent="#dashboard_ekomn">
                        @if (auth()->user()->hasPermissionTo(PERMISSION_ADD_PRODUCT))
                            <li>
                                <a class="nav-link" href="{{ route('add.inventory') }}">Add New Inventory</a>
                            </li>
                        @endif
                        @if (auth()->user()->hasPermissionTo(PERMISSION_LIST_PRODUCT))
                            <li>
                                <a class="nav-link" href="{{ route('my.inventory') }}">My Inventory</a>
                            </li>
                        @endif
                        @if (auth()->user()->hasPermissionTo(PERMISSION_ADD_PRODUCT))
                            <li>
                                <a class="nav-link" href="{{ route('bulk-upload') }}">Bulk Upload Inventory</a>
                            </li>
                            <li>
                                <a class="nav-link" href="{{ route('bulk-upload.list') }}">Bulk Upload List</a>
                            </li>
                        @endif
                        <li>
                    </ul>
                </li>
            @endif
            @if (auth()->user()->hasPermissionTo(PERMISSION_ADD_NEW_ORDER) || auth()->user()->hasPermissionTo(PERMISSION_LIST_ORDER) || auth()->user()->hasPermissionTo(PERMISSION_ORDER_TRACKING))
            <li class="nav-item">
                <a class="nav-link collapsed nav-link-arrow" data-bs-toggle="collapse" href="#Orders"
                    data-bs-parent="#dashboard_ekomn" id="components">
                    <i class="fas fa-shopping-cart menuIcon"></i>
                    <span class="nav-link-text">Orders</span>
                    <span class="menu_arrowIcon"><i class="fas fa-angle-right"></i></span>
                </a>
                <ul class="sidenav-second-level collapse" id="Orders" data-bs-parent="#dashboard_ekomn">
                    @if (auth()->user()->hasRole(ROLE_BUYER) && auth()->user()->hasPermissionTo(PERMISSION_ADD_NEW_ORDER))
                        <li>
                            <a class="nav-link" href="{{ route('create.order') }}">Add New Orders</a>
                        </li>
                    @endif
                    @if (auth()->user()->hasPermissionTo(PERMISSION_LIST_ORDER))
                    <li>
                        <a class="nav-link" href="{{ route('my.orders') }}">My Oders</a>
                    </li>
                    @endif
                    @if (auth()->user()->hasPermissionTo(PERMISSION_ORDER_TRACKING))
                        <li>
                            <a class="nav-link" href="{{ route('order.tracking') }}">Order Tracking</a>
                        </li>
                    @endif
                </ul>
            </li>
            @endif
            @if (auth()->user()->hasPermissionTo(PERMISSION_LIST_RETURN_ORDER) || auth()->user()->hasPermissionTo(PERMISSION_CREATE_RETURN_ORDER) || auth()->user()->hasPermissionTo(PERMISSION_ORDER_TRACKING))
            <li class="nav-item">
                <a class="nav-link collapsed nav-link-arrow" data-bs-toggle="collapse" href="#Return"
                    data-bs-parent="#dashboard_ekomn" id="components">
                    <i class="fas fa-undo menuIcon"></i>
                    <span class="nav-link-text">Returns</span>
                    <span class="menu_arrowIcon"><i class="fas fa-angle-right"></i></span>
                </a>
                <ul class="sidenav-second-level collapse" id="Return" data-bs-parent="#dashboard_ekomn">

                    @if (auth()->user()->hasPermissionTo(PERMISSION_LIST_RETURN_ORDER))
                    <li>
                        <a class="nav-link" href="{{route('list.return.order')}}">My Returns</a>
                    </li>
                    @endif
                    @if (auth()->user()->hasPermissionTo(PERMISSION_CREATE_RETURN_ORDER))
                    <li>
                        <a class="nav-link" href="{{route('create.return.order')}}">Add New Return</a>
                    </li>
                    @endif
                    @if (auth()->user()->hasPermissionTo(PERMISSION_ORDER_TRACKING))
                    <li>
                        <a class="nav-link" href="{{route('return.order.tracking')}}">Return Order Tracking</a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif
            @if (auth()->user()->hasPermissionTo(PERMISSION_PAYMENT_LIST))
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
                        @if (auth()->user()->hasPermissionTo(PERMISSION_PAYMENT_EDIT))
                            <li>
                                <a class="nav-link" href="{{ route('payment.update') }}">Update Bulk Payment</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            {{-- <li class="nav-item">
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
                <a class="nav-link" href="{{route('edit.profile')}}">
                    <i class="fas fa-user menuIcon"></i>
                    <span class="nav-link-text">Profile</span>
                </a>
            </li> --}}
            @if (auth()->user()->hasPermissionTo(PERMISSION_MIS_SETTING_INVENTORY))
                <li class="nav-item">
                    <a class="nav-link collapsed nav-link-arrow" data-bs-toggle="collapse" href="#misSetting"
                        data-bs-parent="#dashboard_ekomn" id="components">
                        <i class="fas fa-cogs menuIcon"></i>
                        <span class="nav-link-text">MIS Setting</span>
                        <span class="menu_arrowIcon"><i class="fas fa-angle-right"></i></span>
                    </a>
                    <ul class="sidenav-second-level collapse" id="misSetting" data-bs-parent="#dashboard_ekomn">

                        <li>
                            <a class="nav-link" href="{{ route('mis.setting.inventory') }}">Inventory</a>
                        </li>
                        <li>
                            <a class="nav-link" href="{{ route('mis.setting.supplier') }}">Supplier</a>
                        </li>
                        <li>
                            <a class="nav-link" href="{{ route('mis.setting.order') }}">Order</a>
                        </li>
                    </ul>
                </li>
            @endif

            @if (auth()->user()->hasPermissionTo(PERMISSION_BANNER) || auth()->user()->hasPermissionTo(PERMISSION_TOP_CATEGORY) || auth()->user()->hasPermissionTo(PERMISSION_TOP_PRODUCT) || auth()->user()->hasPermissionTo(PERMISSION_USER_LIST) || auth()->user()->hasPermissionTo(PERMISSION_CATEGORY_MANAGEMENT) ||
            auth()->user()->hasPermissionTo(PERMISSION_USER_LIST) || auth()->user()->hasPermissionTo(PERMISSION_ADMIN_LIST))
            <li class="nav-item">
                <a class="nav-link collapsed nav-link-arrow" data-bs-toggle="collapse" href="#AdminControl"
                    data-bs-parent="#dashboard_ekomn" id="components">
                    <i class="fas fa-wrench menuIcon"></i>
                    <span class="nav-link-text">Admin Control Panel</span>
                    <span class="menu_arrowIcon"><i class="fas fa-angle-right"></i></span>
                </a>
                <ul class="sidenav-second-level collapse" id="AdminControl" data-bs-parent="#dashboard_ekomn">
                    @if (auth()->user()->hasPermissionTo(PERMISSION_CATEGORY_MANAGEMENT))
                    <li>
                        <a class="nav-link" href="{{ route('add.category') }}">Add new category</a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{ route('category.management') }}">Category Management</a>
                    </li>
                    @endif
                    @if (auth()->user()->hasPermissionTo(PERMISSION_BANNER))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('banner') }}">
                                <span class="nav-link-text">Banner</span>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->hasPermissionTo(PERMISSION_TOP_CATEGORY))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('category.list') }}">
                                <span class="nav-link-text">Featured Categories</span>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->hasPermissionTo(PERMISSION_TOP_PRODUCT))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('top.product') }}">
                                <span class="nav-link-text">Top Products</span>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->hasPermissionTo(PERMISSION_USER_LIST))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.list') }}">
                                <span class="nav-link-text">User List</span>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->hasPermissionTo(PERMISSION_ADMIN_LIST))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.list') }}">
                                <span class="nav-link-text">Admin List</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
            @endif

            @if (auth()->user()->hasRole(ROLE_ADMIN))
                <li class="nav-item">
                    <a class="nav-link collapsed nav-link-arrow" data-bs-toggle="collapse" href="#SettingControl"
                        data-bs-parent="#dashboard_ekomn" id="components">
                        <i class="fas fa-cog menuIcon"></i>
                        <span class="nav-link-text">Setting</span>
                        <span class="menu_arrowIcon"><i class="fas fa-angle-right"></i></span>
                    </a>
                    @if (auth()->user()->hasPermissionTo(PERMISSION_ADD_COURIER) ||
                            auth()->user()->hasPermissionTo(PERMISSION_LIST_COURIER))
                        <ul class="sidenav-second-level collapse" id="SettingControl"
                            data-bs-parent="#dashboard_ekomn">
                            <li>
                                <a class="nav-link" href="{{ route('courier-details') }}">Add Courier Details</a>
                            </li>
                            </li>
                            <li>
                                <a class="nav-link" href="{{ route('courier.list') }}">Courier List</a>
                            </li>

                            </li>
                    </ul>
                    @endif
                </li>
            @endif
            {{--
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-headset menuIcon"></i>
                        <span class="nav-link-text">Support</span>
                    </a>
                </li>
            --}}
        </ul>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function exportMisReport(type) {
        // Make an API request to export the MIS report in CSV format based on the provided type
        ApiRequest(`mis-export-csv/${type}`, 'GET')
            .then(response => {
                // Check if the response status code indicates success
                if (response.data.statusCode == 200) {
                    // Display a success message using SweetAlert2
                    Swal.fire({
                        title: "Good job!", // Title of the alert
                        text: response.data.message, // Message text from the response
                        icon: "success", // Icon indicating success
                        didOpen: () => {
                            // Apply custom styles to the SweetAlert2 elements when it opens
                            const title = Swal.getTitle(); // Get the title element of the alert
                            title.style.color = 'red'; // Set the title color to red
                            title.style.fontSize = '20px'; // Set the title font size to 20px

                            const content = Swal
                                .getHtmlContainer(); // Get the HTML container of the alert content
                            // Optionally, you could style the content here

                            const confirmButton = Swal
                                .getConfirmButton(); // Get the confirm button of the alert
                            confirmButton.style.backgroundColor =
                                '#feca40'; // Set the button background color
                            confirmButton.style.color = 'white'; // Set the button text color to white
                        }
                    }).then(() => {
                        // Redirect to the inventory page after the alert is closed
                        window.location.href = "{{ route('mis.setting.inventory') }}";
                    });
                }
            })
            .catch(error => {
                // Log any errors encountered during the API request
                console.error('Error updating stock:', error);
            });
    }
</script>
