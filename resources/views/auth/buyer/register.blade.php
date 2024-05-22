
    <div class="login-wrapper">
      <div class="loginimages">
      @include('auth.layout.sidebar_slider')
        <div class="login-container">
          <div class="loginForm register">
          @include('auth.layout.logo')
            <h1 class="h4 bold ExcellenText">Excellent Choice!!</h1>
            <p class="mb25">Now, please fill the required details so that we can get you onboarded earliest.</p>
            <section class="section_1">
              <form action="" class="m-0">
                <div class="emptybox">
                  <div class="row">
                    <div class="col-sm-12 col-md-6">
                      <div class="form-group">
                        <input type="text" class="form-control" placeholder="*Business name" required aria-label="Business name"/>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                      <div class="form-group">
                        <input type="text" class="form-control" placeholder="*GST ID" required aria-label="GST ID"/>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <input type="url" class="form-control" placeholder="Website URL" aria-label="Website URL"/>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                      <div class="form-group">
                        <input type="text" class="form-control" placeholder="*First Name" required aria-label="First Name"/>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                      <div class="form-group">
                        <input type="text" class="form-control" placeholder="Last Name" aria-label="Last Name"/>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                      <div class="input-group form-group">
                        <span class="input-group-text text-muted">+91</span>
                        <input type="tel" class="form-control" placeholder="Mobile Number" aria-label="Mobile Number"/>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                      <div class="form-group">
                        <input type="text" class="form-control" placeholder="Designation" aria-label="Designation"/>
                      </div>
                    </div>
                  </div>
                  <strong class="pt-3 pb-1 block">Shipping Address</strong>
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <input type="text" class="form-control" placeholder="*Street Address" required aria-label="Street Address"/>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <input type="text" class="form-control" placeholder="*State" required aria-label="State"/>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <input type="text" class="form-control" placeholder="*City" required aria-label="City"/>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <input type="text" class="form-control" placeholder="*Pin Code" required aria-label="Pin Code"/>
                      </div>
                    </div>
                  </div>
                </div>
                <button class="btn btn-login btnekomn block section_1_next" type="submit">Next</button>
              </form>
            </section>
            <section class="section_2" style="display: none;">
              <form action="" class="m-0">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="emptybox">
                      <h4 class="ek_s_h">Acknowledgement</h4>
                      <ul class="ack_q_l listnone">
                        <li>
                          <div class="d-flex justify-content-between required">
                            <label class="ack_q_w" for="dispatch_timelines">Bulk Order Dispatch timelines<strong class="ms-1">3-5 calendar days</strong></label>
                            <input class="form-check-input" type="checkbox" id="dispatch_timelines" required/>
                          </div>
                        </li>
                        <li>
                          <div class="d-flex justify-content-between required">
                            <label class="ack_q_w" for="dropship_orders">Dropship/Sample Orders<strong class="ms-1">Same Day</strong></label>
                            <input class="form-check-input" type="checkbox" id="dropship_orders" required/>
                          </div>
                        </li>
                        <li>
                          <div class="d-flex justify-content-between required">
                            <label class="ack_q_w" for="defect_free">I/We confirm to dispatch brand new and defect free products confirming to product details mentioned in our product listings</label>
                            <input class="form-check-input" type="checkbox" id="defect_free" required/>
                          </div>
                        </li>
                        <li>
                          <div class="d-flex justify-content-between required">
                            <label class="ack_q_w" for="business_compliances">I/We confirm to applicable business compliances in India such as GST and Product quality norms as applicable respectively</label>
                            <input class="form-check-input" type="checkbox" id="business_compliances" required/>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <button class="btn btn-login btnekomn block section_2_next" type="submit">Next</button>
              </form>
            </section>
            <section class="section_3" style="display: none;">
              <form action="" class="m-0">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="emptybox">
                      <h4 class="ek_s_h">Key Information</h4>
                      <ul class="ack_q_l listnone">
                        <li>
                          <div class="d-flex justify-content-between required">
                            <label class="ack_q_w" for="product_qty">How many products you have in your catalog that you wish to sell?</label>
                            <input class="qt_inp form-control" type="number" id="product_qty" placeholder="Qty." aria-label="Product Quantity" required/>
                          </div>
                        </li>
                        <li>
                          <label class="ack_q_w required">Select your product categories</label>
                          <ul class="categoryList listnone">
                            <li>
                              <input class="form-check-input" type="checkbox" id="category1" />
                              <label for="category1">Stationery</label>
                            </li>
                            <li>
                              <input class="form-check-input" type="checkbox" id="category2" />
                              <label for="category2">Furniture</label>
                            </li>
                            <li>
                              <input class="form-check-input" type="checkbox" id="category3" />
                              <label for="category3">Food and beverage</label>
                            </li>
                            <li>
                              <input class="form-check-input" type="checkbox" id="category4" />
                              <label for="category4">Electronics</label>
                            </li>
                            <li>
                              <input class="form-check-input" type="checkbox" id="category5" />
                              <label for="category5">Groceries</label>
                            </li>
                            <li>
                              <input class="form-check-input" type="checkbox" id="category6" />
                              <label for="category6">Baby products</label>
                            </li>
                            <li>
                              <input class="form-check-input" type="checkbox" id="category7" />
                              <label for="category7">Gift cards</label>
                            </li>
                            <li>
                              <input class="form-check-input" type="checkbox" id="category8" />
                              <label for="category8">Cleaning supplies</label>
                            </li>
                          </ul>
                        </li>
                      </ul>
                      <div class="mt30">
                        <ul class="ack_q_l listnone">
                          <li>
                            <label class="ack_q_w"><strong>How did you hear about eKomn?</strong></label>
                            <ul class="categoryList listnone">
                              <li>
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" name="channel" id="channel1" />
                                  <label class="form-check-label" for="channel1">
                                    Through SMS
                                  </label>
                                </div>
                              </li>
                              <li>
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" name="channel" id="channel2" />
                                  <label class="form-check-label" for="channel2">
                                    Through eMail
                                  </label>
                                </div>
                              </li>
                              <li>
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" name="channel" id="channel3" />
                                  <label class="form-check-label" for="channel3">
                                    Google Search
                                  </label>
                                </div>
                              </li>
                              <li>
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" name="channel" id="channel4" />
                                  <label class="form-check-label" for="channel4">
                                    Social Media
                                  </label>
                                </div>
                              </li>
                              <li>
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" name="channel" id="channel5" />
                                  <label class="form-check-label" for="channel5">
                                    Referred
                                  </label>
                                </div>
                              </li>
                              <li>
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" name="channel" id="channel6" />
                                  <label class="form-check-label" for="channel6">
                                    Others
                                  </label>
                                </div>
                              </li>
                            </ul>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
                <button class="btn btn-login btnekomn block section_3_next" type="submit">Next</button>
              </form>
            </section>
            <section class="section_4" style="display: none;">
              <form action="" class="m-0">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="emptybox">
                      <h4 class="ek_s_h">Create Login Details</h4>
                      <div class="form-group">
                        <input type="email" class="form-control" placeholder="*Email Address" required aria-label="Email Address">
                      </div>
                      <div class="form-group">
                        <input type="password" class="form-control" placeholder="*Password" required aria-label="Password">
                      </div>
                      <div class="form-group">
                        <input type="password" class="form-control" placeholder="*Confirm Password" required aria-label="Confirm Password">
                      </div>
                    </div>
                  </div>
                </div>
                <button class="btn btn-login btnekomn block formSubmit" type="submit">Submit</button>
              </form>
            </section>
          </div>
          <div class="loginForm t_u_s" style="display: none;">
            <div class="brand-logo d-flex justify-content-center">
              <a href="#"><img src="/assets/images/Logo.svg" alt="Logo" /></a>
            </div>
            <div class="thankYou">
              <div class="thankYoubox">
                <svg xmlns="http://www.w3.org/2000/svg" class="svg-success" viewBox="0 0 24 24">
                  <g stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10">
                    <circle class="success-circle-outline" cx="12" cy="12" r="11.5" />
                    <circle class="success-circle-fill" cx="12" cy="12" r="11.5" />
                    <polyline class="success-tick" points="17,8.5 9.5,15.5 7,13" />
                  </g>
                </svg>
                <h1 class="thank_h1">Thank you!!</h1>
                <p>Your responses have earned you an immediate Onboarding Approval on eKomn.</p>
                <a href="{{ route('buyer.login') }}" class="a_color">Click to Login</a>
              </div>
            </div>
          </div>
          @include('auth.layout.footer')
        </div>
      </div>
    </div>
    
    @section('custom_script')
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        const section_1_next = document.querySelector(".section_1_next");
        const section_2_next = document.querySelector(".section_2_next");
        const section_3_next = document.querySelector(".section_3_next");
        const section_1 = document.querySelector(".section_1");
        const section_2 = document.querySelector(".section_2");
        const section_3 = document.querySelector(".section_3");
        const section_4 = document.querySelector(".section_4");
        const formSubmit = document.querySelector(".formSubmit");
        const t_u_s = document.querySelector(".t_u_s");
        const register = document.querySelector(".register");
        section_1_next.addEventListener("click", function () {
          event.preventDefault();
          section_1.style.display = "none";
          section_2.style.display = "block";
          setTimeout(() => {
            section_2.classList.add("show_section_2");
          }, 10);
        });
        section_2_next.addEventListener("click", function () {
          event.preventDefault();
          section_1.style.display = "none";
          section_2.style.display = "none";
          section_3.style.display = "block";
          setTimeout(() => {
            section_3.classList.add("show_section_3");
          }, 10);
        });
        section_3_next.addEventListener("click", function () {
          event.preventDefault();
          section_1.style.display = "none";
          section_2.style.display = "none";
          section_3.style.display = "none";
          section_4.style.display = "block";
          setTimeout(() => {
            section_4.classList.add("show_section_4");
          }, 10);
        });
        formSubmit.addEventListener("click", function () {
          event.preventDefault();
          section_1.style.display = "none";
          section_2.style.display = "none";
          section_3.style.display = "none";
          section_4.style.display = "none";
          register.style.display = "none";
          t_u_s.style.display = "block";
        });
      });
    </script>
    @endsection
  