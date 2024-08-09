<div class="mobileMenu">
    <div class="mob_head profile gap-2">
      <span class="closeDrawer"><i class="fas fa-angle-double-left"></i></span>
      <div class="img-box">
        <img src="https://i.postimg.cc/BvNYhMHS/user-img.jpg" alt="some user image" width="44px" height="44px" />
      </div>
      @if(Auth::check())
      <div class="user align-items-start">
        <h4>Mohdammad Imtyaj</h4>
        <p class="m-0">User ID: 46568</p>
      </div>
        @else
        <div class="userAction">
          <a href="{{ route('supplier.login') }}" class="text-white fs-6" >Login</a>
          <a href="{{ route('supplier.register') }}" class="btn btnekomn btnround" >Register</a>   
        </div>
        @endif
    </div>
    <div class="mobileMenuInner">
      <div class="sidebar-menu">
        <ul class="navbar-nav mob_cat_list" id="mob_cat_list">
          <li class="nav-item">
            <a class="nav-link collapsed nav-link-arrow" data-bs-toggle="collapse" href="#HomeGarden" data-bs-parent="#mob_cat_list" id="components">
              <span class="nav-link-text">Home, Garden & Tools</span>
              <span class="menu_arrowIcon"><i class="fas fa-angle-right"></i></span>
            </a>
            <ul class="sidenav-second-level collapse" id="HomeGarden" data-bs-parent="#mob_cat_list">
              <li>
                <a class="nav-link" href="#">Sub Category</a>
              </li>
              <li>
                <a class="nav-link" href="#">Sub Category</a>
              </li>
              <li>
                <a class="nav-link" href="#">Sub Category</a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link collapsed nav-link-arrow" data-bs-toggle="collapse" href="#BeautyHealth" data-bs-parent="#mob_cat_list" id="components">
              <span class="nav-link-text">Beauty & Health</span>
              <span class="menu_arrowIcon"><i class="fas fa-angle-right"></i></span>
            </a>
            <ul class="sidenav-second-level collapse" id="BeautyHealth" data-bs-parent="#mob_cat_list">
              <li>
                <a class="nav-link" href="#">Sub Category</a>
              </li>
              <li>
                <a class="nav-link" href="#">Sub Category</a>
              </li>
              <li>
                <a class="nav-link" href="#">Sub Category</a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link collapsed nav-link-arrow" data-bs-toggle="collapse" href="#Outdoor" data-bs-parent="#mob_cat_list" id="components">
              <span class="nav-link-text">Outdoor</span>
              <span class="menu_arrowIcon"><i class="fas fa-angle-right"></i></span>
            </a>
            <ul class="sidenav-second-level collapse" id="Outdoor" data-bs-parent="#mob_cat_list">
              <li>
                <a class="nav-link" href="#">Sub Category</a>
              </li>
              <li>
                <a class="nav-link" href="#">Sub Category</a>
              </li>
              <li>
                <a class="nav-link" href="#">Sub Category</a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link collapsed nav-link-arrow" data-bs-toggle="collapse" href="#ClothingShoes" data-bs-parent="#mob_cat_list" id="components">
              <span class="nav-link-text">Clothing, Shoes & Jewelry</span>
              <span class="menu_arrowIcon"><i class="fas fa-angle-right"></i></span>
            </a>
            <ul class="sidenav-second-level collapse" id="ClothingShoes" data-bs-parent="#mob_cat_list">
              <li>
                <a class="nav-link" href="#">Sub Category</a>
              </li>
              <li>
                <a class="nav-link" href="#">Sub Category</a>
              </li>
              <li>
                <a class="nav-link" href="#">Sub Category</a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link collapsed nav-link-arrow" data-bs-toggle="collapse" href="#ToysBaby" data-bs-parent="#mob_cat_list" id="components">
              <span class="nav-link-text">Toys, Kids & Baby</span>
              <span class="menu_arrowIcon"><i class="fas fa-angle-right"></i></span>
            </a>
            <ul class="sidenav-second-level collapse" id="ToysBaby" data-bs-parent="#mob_cat_list">
              <li>
                <a class="nav-link" href="#">Sub Category</a>
              </li>
              <li>
                <a class="nav-link" href="#">Sub Category</a>
              </li>
              <li>
                <a class="nav-link" href="#">Sub Category</a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link collapsed nav-link-arrow" data-bs-toggle="collapse" href="#Sports" data-bs-parent="#mob_cat_list" id="components">
              <span class="nav-link-text">Sports</span>
              <span class="menu_arrowIcon"><i class="fas fa-angle-right"></i></span>
            </a>
            <ul class="sidenav-second-level collapse" id="Sports" data-bs-parent="#mob_cat_list">
              <li>
                <a class="nav-link" href="#">Sub Category</a>
              </li>
              <li>
                <a class="nav-link" href="#">Sub Category</a>
              </li>
              <li>
                <a class="nav-link" href="#">Sub Category</a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link collapsed nav-link-arrow" data-bs-toggle="collapse" href="#Pets" data-bs-parent="#mob_cat_list" id="components">
              <span class="nav-link-text">Pets</span>
              <span class="menu_arrowIcon"><i class="fas fa-angle-right"></i></span>
            </a>
            <ul class="sidenav-second-level collapse" id="Pets" data-bs-parent="#mob_cat_list">
              <li>
                <a class="nav-link" href="#">Sub Category</a>
              </li>
              <li>
                <a class="nav-link" href="#">Sub Category</a>
              </li>
              <li>
                <a class="nav-link" href="#">Sub Category</a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link collapsed nav-link-arrow" data-bs-toggle="collapse" href="#Electronocs" data-bs-parent="#mob_cat_list" id="components">
              <span class="nav-link-text">Electronocs</span>
              <span class="menu_arrowIcon"><i class="fas fa-angle-right"></i></span>
            </a>
            <ul class="sidenav-second-level collapse" id="Electronocs" data-bs-parent="#mob_cat_list">
              <li>
                <a class="nav-link" href="#">Sub Category</a>
              </li>
              <li>
                <a class="nav-link" href="#">Sub Category</a>
              </li>
              <li>
                <a class="nav-link" href="#">Sub Category</a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link collapsed nav-link-arrow" data-bs-toggle="collapse" href="#Computers" data-bs-parent="#mob_cat_list" id="components">
              <span class="nav-link-text">Computers, Office Supplies</span>
              <span class="menu_arrowIcon"><i class="fas fa-angle-right"></i></span>
            </a>
            <ul class="sidenav-second-level collapse" id="Computers" data-bs-parent="#mob_cat_list">
              <li>
                <a class="nav-link" href="#">Sub Category</a>
              </li>
              <li>
                <a class="nav-link" href="#">Sub Category</a>
              </li>
              <li>
                <a class="nav-link" href="#">Sub Category</a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link collapsed nav-link-arrow" data-bs-toggle="collapse" href="#Industrial" data-bs-parent="#mob_cat_list" id="components">
              <span class="nav-link-text">Industrial</span>
              <span class="menu_arrowIcon"><i class="fas fa-angle-right"></i></span>
            </a>
            <ul class="sidenav-second-level collapse" id="Industrial" data-bs-parent="#mob_cat_list">
              <li>
                <a class="nav-link" href="#">Sub Category</a>
              </li>
              <li>
                <a class="nav-link" href="#">Sub Category</a>
              </li>
              <li>
                <a class="nav-link" href="#">Sub Category</a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link collapsed nav-link-arrow" data-bs-toggle="collapse" href="#Arts" data-bs-parent="#mob_cat_list" id="components">
              <span class="nav-link-text">Arts & Crafts</span>
              <span class="menu_arrowIcon"><i class="fas fa-angle-right"></i></span>
            </a>
            <ul class="sidenav-second-level collapse" id="Arts" data-bs-parent="#mob_cat_list">
              <li>
                <a class="nav-link" href="#">Sub Category</a>
              </li>
              <li>
                <a class="nav-link" href="#">Sub Category</a>
              </li>
              <li>
                <a class="nav-link" href="#">Sub Category</a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link collapsed nav-link-arrow" data-bs-toggle="collapse" href="#Automotive" data-bs-parent="#mob_cat_list" id="components">
              <span class="nav-link-text">Automotive</span>
              <span class="menu_arrowIcon"><i class="fas fa-angle-right"></i></span>
            </a>
            <ul class="sidenav-second-level collapse" id="Automotive" data-bs-parent="#mob_cat_list">
              <li>
                <a class="nav-link" href="#">Sub Category</a>
              </li>
              <li>
                <a class="nav-link" href="#">Sub Category</a>
              </li>
              <li>
                <a class="nav-link" href="#">Sub Category</a>
              </li>
            </ul>
          </li>
        </ul>
        <div class="mobOtherFilter">
        <label class="checkbox-item">
          <input type="checkbox">
          <span class="checkbox-text">
            <i class="fas fa-info-circle me-2"></i>New Arrivals 
          </span>
        </label>
        <label class="checkbox-item">
          <input type="checkbox">
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
            <input type="text" class="form-control" placeholder="Eg. 100">
            <button class="inputokbtn">Ok</button>
          </div>
        </div>
        <div class="mt15">
          <label>Price (<i class="fas fa-rupee-sign fs-13"></i>)</label>
          <div class="inputwithOk minmax">
            <span class="sepminmax">-</span>
            <input type="text" class="form-control" placeholder="Min">
            <input type="text" class="form-control" placeholder="Max">
            <button class="inputokbtn">Ok</button>
          </div>
        </div>
        </div>
      </div>
    </div>
  </div>