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
        <a href="index.html"><img src="../assets/images/Logo.svg" alt="Logo" height="40" /></a>
      </div>
      <div class="headersearch">
        <form role="search">
          <div class="productSearch">
            <input class="form-control serchinput" type="search" placeholder="Search" aria-label="Search">
            <button class="btn" type="submit"><i class="fas fa-search"></i></button>
          </div>
          <div class="header_search_card">
            <ul class="searchList">
              <li><a href="">Searchlist</a></li>
              <li><a href="">searchlist</a></li>
              <li><a href="">searchlist</a></li>
            </ul>
          </div>
        </form>
      </div>
      @if(Auth::check())
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
              <h4>Mohdammad Imtyaj</h4>
              <p class="m-0">User ID: 46568</p>
            </div>
            <div class="img-box">
              <img src="https://i.postimg.cc/BvNYhMHS/user-img.jpg" alt="some user image" width="32px" height="32px" />
            </div>
          </div>
          <ul class="dropdown-menu dropdown-menu-end ekdropdown w_200">
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <li><a class="dropdown-item" href="#">Wish List</a></li>
            <li><a class="dropdown-item" href="#">Settings</a></li>
          </ul>
        </div>
        <div class="cartAction">
          <a href="" class="cart">
            <span class="counter">0</span>
            <img src="https://static-assets-web.flixcart.com/batman-returns/batman-returns/p/images/header_cart-eed150.svg" alt="Cart" class="_1XmrCc" width="30" height="30">
          </a>
        </div>
      </div>
        @else
        <div class="userAction">
          <a href="{{ route('buyer.login') }}" class="text-white fs-6" >Login</a>
          <a href="{{ route('buyer.register') }}" class="btn btnekomn btnround px-5" >Register</a>   
        </div>
        <!-- <a href="{{ route('buyer.login') }}" class="text-white" >Login</a>
        <a href="{{ route('buyer.register') }}" class="btn btnekomn btnround px-5" >Register</a> -->
      @endif
    </div>
    <div class="bottom_header">
      <ul class="b_h_list">
        <li><a href="../amazon-orders.html" class="active">Regular Available</a></li>
        <li><a href="../create-order.html">In Demand</a></li>
        <li><a href="">Premium Products</a></li>
        <li><a href="">New Arrivals</a></li>
        <li><a href="">View All</a></li>
      </ul>
    </div>
  </header>