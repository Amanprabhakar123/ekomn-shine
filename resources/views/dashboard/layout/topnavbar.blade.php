<header class="ekheader">
  <div class="menutoggle"><i class="fas fa-bars"></i></div>
  <div class="d-flex justify-content-between align-items-center">
    <div class=" Outo_brand">
      <a href="#" class="brand Outo_d"><img src="assets/images/ Outo.svg" alt=" Outo" height="40"></a>
    </div>
    <div class="dropdown">
      <div class="profile" data-bs-toggle="dropdown" aria-expanded="false">
        <div class="user">
          <h4>{{auth()->user()->name}}</h4>
          <p class="m-0">Retailer ID: 46568</p>
        </div>
        <div class="img-box">
          <img src="https://i.postimg.cc/BvNYhMHS/user-img.jpg" alt="some user image">
        </div>
      </div>
      <ul class="dropdown-menu dropdown-menu-end ekdropdown w_200">
        <li><a class="dropdown-item" href="#">Profile</a></li>
        <li><a class="dropdown-item" href="#">Wish List</a></li>
        <li><a class="dropdown-item" href="#">Settings</a></li>
        <li>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form><a href="#" class="dropdown-item"
            onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                Logout
            </a></li>
       
            
      </ul>
    </div>
  </div>
</header>