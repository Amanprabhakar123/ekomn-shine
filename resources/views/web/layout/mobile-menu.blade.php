<div class="mobileMenu">
    <div class="mob_head profile gap-2">
        <span class="closeDrawer"><i class="fas fa-angle-double-left"></i></span>
        @if (Auth::check())
        <div class="img-box">
            <img src="{{asset('assets/images/icon/user-2.png')}}" alt="some user image" width="44px" height="44px" />
        </div>
            <div class="user align-items-start">
                <h4 style="text-align: justify;">{{ auth()->user()->name }}</h4>
                @if (auth()->user()->hasRole(ROLE_BUYER) ||
                        auth()->user()->hasRole(ROLE_SUPPLIER))
                    <p class="m-0">User ID: {{ auth()->user()->companyDetails->company_serial_id }}</p>
                    @elseif (auth()->user()->hasRole(ROLE_ADMIN))
                        <p class="m-0">Admin</p>
                    @elseif(auth()->user()->hasRole(ROLE_SUB_ADMIN))
                    <p class="m-0">Sub Admin</p>
                @endif
            </div>
        @else
            <div class="userAction">
                <a href="{{ route('buyer.login') }}" class="text-white underline fs-6">Login</a>
                <a href="{{ route('buyer.register') }}" class="btn btn-sm w_100_f btnekomn btnround">Register</a>
            </div>
        @endif
    </div>
    <div class="mobileMenuInner">
        <div class="sidebar-menu">
            <ul class="navbar-nav mob_cat_list" id="mob_cat_list">

            </ul>
            <div class="mobOtherFilter">
                <label class="checkbox-item">
                    <input type="checkbox" name="newArrivals" id="newArrivals" value="1"
                        onclick="filterWithCheckbox('newArrivals',this.checked)">
                    <span class="checkbox-text">
                        <i class="fas fa-info-circle me-2"></i>New Arrivals
                    </span>
                </label>
                <label class="checkbox-item">
                    <input type="checkbox" id="productWithVideos" name="productWithVideos"
                        onclick="filterWithCheckbox('productWithVideos',this.checked)">
                    <span class="checkbox-text">
                        <i class="far fa-play-circle me-2"></i>Product with Videos
                    </span>
                </label>
                <div class="mt15">
                    <label>Product Near By</label>
                    <div class="inputwithOk">
                        <input type="text" class="form-control" placeholder="Enter Pin Code">
                        <button class="inputokbtn">Ok</button>
                    </div>
                </div>
                <div class="mt15">
                    <label>Minimum Stock</label>
                    <div class="inputwithOk">
                        <input type="text" class="form-control" placeholder="Eg. 100" id="mobileMinimumStk"
                            name="mobileMinimumStk" value="">
                        <button class="inputokbtn">Ok</button>
                    </div>
                </div>
                <div class="mt15">
                    <label>Price (<i class="fas fa-rupee-sign fs-13"></i>)</label>
                    <div class="inputwithOk minmax">
                        <span class="sepminmax">-</span>
                        <input type="text" class="form-control" placeholder="Min" name="mobileMin" id="mobileMin"
                            value="">
                        <input type="text" class="form-control" placeholder="Max" name="mobileMax" id="mobileMax"
                            value="">
                        <button type="button" class="inputokbtn" id="priceRange">Ok</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
