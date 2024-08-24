<body>
  <div class="login-wrapper">
    <div class="loginimages">
      @include('auth.layout.sidebar_slider')

      <div class="login-container">
       
        <div class="loginForm register">
        <input type="hidden" id="hiddenField">
          @include('auth.layout.logo')
          <h1 class="h4 bold ExcellenText">Sign Up</h1>
          <p class="mb25">A step closer to set your online business on high growth track!!</p>
          <section class="sup_section section_1">
            <form id="formStep_1" action="#" method="POST">
              <div class="emptybox">
                <div class="row">
                  <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                      <input type="hidden" class="form-control" id="step_1" name="step_1" value="step_1" />
                      <input type="text" class="form-control" id="first_name" name="first_name" placeholder="*First Name"  value=""/>
                      <div id="first_nameErr" class="invalid-feedback"></div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                      <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" value="" />
                      <div id="last_nameErr" class="invalid-feedback"></div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-6">
                    <div class="input-group form-group">
                      <span class="input-group-text text-muted">+91</span>
                      <input type="tel" class="form-control" id="mobile" name="mobile" placeholder="Mobile Number" value="" />
                      <div id="mobileErr" class="invalid-feedback"></div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                      <input type="text" class="form-control" id="designation" name="designation" placeholder="Designation" value="" />
                      <div id="designationErr" class="invalid-feedback"></div>
                    </div>
                  </div>
                </div>
                <strong class="pt-3 pb-1 block">Shipping Address</strong>
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <input type="text" class="form-control" id="address" name="address" placeholder="*Street Address" value="" />
                      <div id="addressErr" class="invalid-feedback"></div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                      <input type="text" class="form-control" id="state" name="state" placeholder="*State"  value=""/>
                      <div id="stateErr" class="invalid-feedback"></div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                      <input type="text" class="form-control" id="city" name="city" placeholder="*City" value="" />
                      <div id="cityErr" class="invalid-feedback"></div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                      <input type="text" class="form-control" id="pin_code" name="pin_code" placeholder="*Pin Code" value="" />
                      <div id="pin_codeErr" class="invalid-feedback"></div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                      <input type="text" class="form-control" id="business_name" name="business_name" placeholder="Business name as per GST"  value=""/>
                      <div id="business_nameErr" class="invalid-feedback"></div>
                    </div>
                  </div>
                </div>
                <div class="row chooseoneinput">
                  <span class="chooseone">or</span>
                  <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                      <input type="text" class="form-control" id="gst" name="gst" placeholder="GST ID" value=""/>
                      <div id="gstErr" class="invalid-feedback"></div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                      <input type="text" class="form-control" id="pan" name="pan" placeholder="PAN" value=""/>
                      <div id="panErr" class="invalid-feedback"></div>
                    </div>
                  </div>
                </div>
              </div>
              <button class="btn btn-login btnekomn block sup_next" type="submit">Next</button>
            </form>
          </section>
          <section class="sup_section sup_section_2 section_2" style="display: none;">
            <form id="formStep_2" action="#" method="POST">
              <div class="row">
                <div class="col-sm-12">
                  <div class="emptybox">
                    <label class="ack_q_w mt10"><strong>Create Login Details</strong></label>
                    <div class="form-group mt-1">
                      <input type="hidden" class="form-control" id="step_2" name="step_2" value="step_2" />
                      <input type="email" class="form-control" id="email" name="email" placeholder="*Email Address" value=""/>
                      <div id="emailErr" class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control" id="password" name="password" placeholder="*Password" value=""/>
                      <div id="passwordErr" class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="*Confirm Password" value=""/>
                      <div id="confirm_passwordErr" class="invalid-feedback"></div>
                    </div>
                    <div class="mt40">
                      <ul class="ack_q_l listnone">
                        <li>
                          <label class="ack_q_w"><strong>How did you hear about eKomn?</strong></label>
                          <ul class="categoryList listnone">
                            <li>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="product_channel" value="1" id="channel1" />
                                <label class="form-check-label" for="channel1">
                                  Through SMS
                                </label>
                              </div>
                            </li>
                            <li>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="product_channel" value="2" id="channel2" />
                                <label class="form-check-label" for="channel2">
                                  Through eMail
                                </label>
                              </div>
                            </li>
                            <li>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="product_channel" value="3" id="channel3" />
                                <label class="form-check-label" for="channel3">
                                  Google Search
                                </label>
                              </div>
                            </li>
                            <li>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="product_channel" value="4" id="channel4" />
                                <label class="form-check-label" for="channel4">
                                  Social Media
                                </label>
                              </div>
                            </li>
                            <li>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="product_channel" value="5" id="channel5" />
                                <label class="form-check-label" for="channel5">
                                  Referred
                                </label>
                              </div>
                            </li>
                            <li>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="product_channel" value="6" id="channel6" />
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
              <button class="btn btn-login btnekomn block" type="submit">Next</button>
            </form>
          </section>
        </div>
        <div class="loginForm t_u_s">
          <div class="brand-logo d-flex justify-content-center">
            <a href="#"><img src="{{asset('assets/images/Logo.svg')}}" alt="Logo" /></a>
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
              <a href="{{route('buyer.login')}}" class="a_color">Click to Login</a>
            </div>
          </div>
        </div>
        
        @include('auth.layout.footer')
        
      </div>
    </div>
  </div>
  <!-- Pricing Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
      <div class="modal-content">
        <div class="modal-body fullbodyclose">
        <div class="container">
          <div class="row">
            <div class="col-sm-12">
              <div class="text-center sec__h">
                <h1 class="h2 bold m-0">Unleash your business potential with the ideal plan</h1>
                <ul class="promise_list listnone">
                  <li><i class="fas fa-check me-2 text-success"></i>Free 14-day trial</li>
                  <li><i class="fas fa-check me-2 text-success"></i>Cancel Anytime</li>
                </ul>
              </div>
              <div class="pricing-container pt-0 mt-5">
                <div class="features-list priceList">
                  <div class="feature-row">
                    <div class="feature">
                      <div class="SelectFeatures">
                        <h4 class="fs-20 bold mb10">Select Plan</h4>
                        <div class="defaulPlan">
                          <span class="monthly-label">Monthly</span>
                          <div class="form-check form-switch switch-lg m-0">
                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" />
                            <label class="form-check-label" for="flexSwitchCheckDefault"></label>
                          </div>
                          <span class="yearly-label">Yearly</span>
                        </div>
                      </div>
                    </div>
                    <div class="feature-value">
                      <input type="radio" class="btn-check selectplanbtn" name="options-base" id="free" autocomplete="off" value="{{salt_encrypt('1')}}"
                      data-monthly-value="{{salt_encrypt('1')}}" data-yearly-value="{{salt_encrypt('1')}}" />
                      <label class="plan_details" for="free">
                        <h2 style="font-size: 15px;">Free Trial-14 days</h2>
                        <div class="price_p">
                          <div class="price" data-monthly="INR 00.00" data-yearly="INR 00.00">INR 00.00</div>
                        </div>
                        <button class="btn subscribebtn btnekomn">Start Free Trial</button>
                      </label>
                    </div>
                    <div class="feature-value">
                      <input type="radio" class="btn-check selectplanbtn" name="options-base" id="Essential" autocomplete="off" value="{{salt_encrypt('2')}}"
                      data-monthly-value="{{salt_encrypt('2')}}" data-yearly-value="{{salt_encrypt('3')}}"/>
                      <label class="plan_details " for="Essential">
                        <h2>Essential</h2>
                        <div class="price_p">
                          <div class="price" data-monthly="INR 1999.00" data-yearly="INR 22309.00">INR 1999.00</div>
                          <div class="offeramount">
                            <del class="ms-1"><i class="fas fa-rupee-sign fs-13 me-1"></i>23988.00</del>
                            <small class="ms-1 bold text-success">7% Off</small>
                          </div>
                        </div>
                        <button class="btn subscribebtn btnekomn">Subscribe</button>
                      </label>
                    </div>
                    <div class="feature-value">
                      <input type="radio" class="btn-check selectplanbtn" name="options-base" id="Booster" autocomplete="off"  value="{{salt_encrypt('4')}}"
                      data-monthly-value="{{salt_encrypt('4')}}" data-yearly-value="{{salt_encrypt('5')}}"/>
                      <label class="plan_details bestplan active" for="Booster">
                        <span class="bestplanText">Most Popular</span>
                        <h2>Booster</h2>
                        <div class="price_p">
                          <div class="price" data-monthly="INR 2999.00" data-yearly="INR 33469.00">INR 2999.00</div>
                          <div class="offeramount">
                            <del class="ms-1"><i class="fas fa-rupee-sign fs-13 me-1"></i>35988.00</del>
                            <small class="ms-1 bold text-success">7% Off</small>
                          </div>
                        </div>
                        <button class="btn subscribebtn btnekomn">Subscribe</button>
                      </label>
                    </div>
                    <div class="feature-value">
                      <input type="radio" class="btn-check selectplanbtn" name="options-base" id="Trade" autocomplete="off" value="{{salt_encrypt('6')}}"
                      data-monthly-value="{{salt_encrypt('6')}}" data-yearly-value="{{salt_encrypt('7')}}"/>
                      <label class="plan_details" for="Trade">
                        <h2>Trade Hub</h2>
                        <div class="price_p">
                          <div class="price" data-monthly="INR 7999.00" data-yearly="INR 89269.00">INR 7999.00</div>
                          <div class="offeramount">
                            <del class="ms-1"><i class="fas fa-rupee-sign fs-13 me-1"></i>95988.00</del>
                            <small class="ms-1 bold text-success">7% Off</small>
                          </div>
                        </div>
                        <button class="btn subscribebtn btnekomn">Subscribe</button>
                      </label>
                    </div>
                    <div class="feature-value">
                      <input type="radio" class="btn-check selectplanbtn" name="options-base" id="Enterprise" autocomplete="off" value="{{salt_encrypt('8')}}"
                      data-monthly-value="{{salt_encrypt('8')}}" data-yearly-value="{{salt_encrypt('9')}}"/>
                      <label class="plan_details" for="Enterprise">
                        <h2>Enterprise</h2>
                        <div class="price_p">
                          <div class="price" data-monthly="INR 11999.00" data-yearly="INR 133909.00">INR 11999.00</div>
                          <div class="offeramount">
                            <del class="ms-1"><i class="fas fa-rupee-sign fs-13 me-1"></i>143988.00</del>
                            <small class="ms-1 bold text-success">7% Off</small>
                          </div>
                        </div>
                        <button class="btn subscribebtn btnekomn">Subscribe</button>
                      </label>
                    </div>
                  </div>
                </div>
                <div class="features-list">
                  <div class="feature-row">
                    <div class="feature">My Inventory List Limit</div>
                    <div class="feature-value">30</div>
                    <div class="feature-value">100</div>
                    <div class="feature-value">500</div>
                    <div class="feature-value">1000</div>
                    <div class="feature-value">2000</div>
                  </div>
                  <div class="feature-row">
                    <div class="feature">Monthly Products Download Count</div>
                    <div class="feature-value">30</div>
                    <div class="feature-value">100</div>
                    <div class="feature-value">500</div>
                    <div class="feature-value">1000</div>
                    <div class="feature-value">2000</div>
                  </div>
                  <div class="feature-row">
                    <div class="feature">New Products Alerts</div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                  </div>
                  <div class="feature-row">
                    <div class="feature">Product Notifications</div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                  </div>
                  <div class="feature-row">
                    <div class="feature">Curated Product List</div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                  </div>
                  <div class="feature-row">
                    <div class="feature">Access to High profit, Low competetion, Unique products</div>
                    <div class="feature-value"><i class="fas fa-times text-danger"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                  </div>
                  <div class="feature-row">
                    <div class="feature">Order Manager</div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                  </div>
                  <div class="feature-row">
                    <div class="feature">Returns</div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                  </div>
                  <div class="feature-row">
                    <div class="feature">ReSeller Program</div>
                    <div class="feature-value"><i class="fas fa-times text-danger"></i></div>
                    <div class="feature-value"><i class="fas fa-times text-danger"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                  </div>
                  <div class="feature-row">
                    <div class="feature">Shine Program</div>
                    <div class="feature-value"><i class="fas fa-times text-danger"></i></div>
                    <div class="feature-value"><i class="fas fa-times text-danger"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                  </div>
                  <div class="feature-row">
                    <div class="feature">Amazon Integration</div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                  </div>
                  <div class="feature-row">
                    <div class="feature">My Connections</div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                  </div>
                  <div class="feature-row">
                    <div class="feature">Chat & Email Support</div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                  </div>
                  <div class="feature-row">
                    <div class="feature">Phone Support</div>
                    <div class="feature-value"><i class="fas fa-times text-danger"></i></div>
                    <div class="feature-value"><i class="fas fa-times text-danger"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                  </div>
                  <div class="feature-row">
                    <div class="feature">Dedicated Account Manager</div>
                    <div class="feature-value"><i class="fas fa-times text-danger"></i></div>
                    <div class="feature-value"><i class="fas fa-times text-danger"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                  </div>
                  <div class="feature-row">
                    <div class="feature">Download Center</div>
                    <div class="feature-value"><i class="fas fa-times text-danger"></i></div>
                    <div class="feature-value"><i class="fas fa-times text-danger"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                  </div>
                  <div class="feature-row">
                    <div class="feature">My Reports</div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                  </div>
                </div>
                <div class="amazonbox">
                  <h3 class="AmazonSeller" data-bs-toggle="collapse" data-bs-target="#AmazonSeller" aria-expanded="false" aria-controls="AmazonSeller">Amazon Seller Central Services <span class="viewmore">View in Detail</span></h3>
                  <div class="collapse" id="AmazonSeller">
                    <div class="features-list">
                      <div class="feature-row">
                        <div class="feature">Product Listing Support</div>
                        <div class="feature-value"><i class="fas fa-times text-danger"></i></div>
                        <div class="feature-value">20</div>
                        <div class="feature-value">50</div>
                        <div class="feature-value">200</div>
                        <div class="feature-value">Unlimited</div>
                      </div>
                      <div class="feature-row">
                        <div class="feature">Listing Enhancements in a month</div>
                        <div class="feature-value"><i class="fas fa-times text-danger"></i></div>
                        <div class="feature-value">2</div>
                        <div class="feature-value">5</div>
                        <div class="feature-value">20</div>
                        <div class="feature-value">25</div>
                      </div>
                      <div class="feature-row">
                        <div class="feature">A+ Listings in a month</div>
                        <div class="feature-value"><i class="fas fa-times text-danger"></i></div>
                        <div class="feature-value"><i class="fas fa-times text-danger"></i></div>
                        <div class="feature-value"><i class="fas fa-times text-danger"></i></div>
                        <div class="feature-value">2</div>
                        <div class="feature-value">5</div>
                      </div>
                      <div class="feature-row">
                        <div class="feature">Premiuim Store Development</div>
                        <div class="feature-value"><i class="fas fa-times text-danger"></i></div>
                        <div class="feature-value"><i class="fas fa-times text-danger"></i></div>
                        <div class="feature-value"><i class="fas fa-times text-danger"></i></div>
                        <div class="feature-value">1</div>
                        <div class="feature-value">1</div>
                      </div>
                      <div class="feature-row">
                        <div class="feature">Customer Review Management</div>
                        <div class="feature-value"><i class="fas fa-times text-danger"></i></div>
                        <div class="feature-value"><i class="fas fa-times text-danger"></i></div>
                        <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                        <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                        <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                      </div>
                      <div class="feature-row">
                        <div class="feature">Product Return Management</div>
                        <div class="feature-value"><i class="fas fa-times text-danger"></i></div>
                        <div class="feature-value"><i class="fas fa-times text-danger"></i></div>
                        <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                        <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                        <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                      </div>
                      <div class="feature-row">
                        <div class="feature">FBA Shipments</div>
                        <div class="feature-value"><i class="fas fa-times text-danger"></i></div>
                        <div class="feature-value"><i class="fas fa-times text-danger"></i></div>
                        <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                        <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                        <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                      </div>
                      <div class="feature-row">
                        <div class="feature">Brand Registerations & Approvals</div>
                        <div class="feature-value"><i class="fas fa-times text-danger"></i></div>
                        <div class="feature-value"><i class="fas fa-times text-danger"></i></div>
                        <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                        <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                        <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                      </div>
                      <div class="feature-row">
                        <div class="feature">Expert Consulting</div>
                        <div class="feature-value"><i class="fas fa-times text-danger"></i></div>
                        <div class="feature-value"><i class="fas fa-times text-danger"></i></div>
                        <div class="feature-value">1 Session</div>
                        <div class="feature-value">3 Session</div>
                        <div class="feature-value">3 Session</div>
                      </div>
                      <div class="feature-row">
                        <div class="feature">Complete Account Management</div>
                        <div class="feature-value"><i class="fas fa-times text-danger"></i></div>
                        <div class="feature-value"><i class="fas fa-times text-danger"></i></div>
                        <div class="feature-value"><i class="fas fa-times text-danger"></i></div>
                        <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                        <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                      </div>
                    </div>
                  </div>
                </div>
                <p class="subcribeNote">
                  Registered Users - To avail similar services for other leading online Platforms, please reach out to our Support Desk
                </p>
              </div>
            </div>
          </div>
        </div>
        </div>
      </div>
    </div>
  </div>
  <!-- end -->
  @section('custom_script')
  <!-- <script src="{{asset('assets/js/buyer.register.js')}}"></script> -->
  <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
    // Prevent modal from closing when the Escape key is pressed
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            event.preventDefault(); // Prevent the default action (closing the modal)
        }
    });
});

  document.querySelectorAll('.status-dropdown').forEach(function(selectElement) {
    const label = selectElement.getAttribute('data-label');
    selectElement.addEventListener('change', function() {
      const selectedText = this.options[this.selectedIndex].text;
      this.options[0].text = `${label} ${selectedText}`;
    });
  });
document.addEventListener('DOMContentLoaded', function () {
  const switchInput = document.getElementById('flexSwitchCheckDefault');
  const monthlyLabel = document.querySelector('.monthly-label');
  const yearlyLabel = document.querySelector('.yearly-label');
  const prices = document.querySelectorAll('.price');
  const planInputs = document.querySelectorAll('.selectplanbtn');
  const offeramounts = document.querySelectorAll('.offeramount');
  const toggleSwitch = (isYearly) => {
    switchInput.checked = isYearly;
    updatePrices(isYearly);
    updateValues(isYearly);
  };
  const updatePrices = (isYearly) => {
    prices.forEach((price, index) => {
      const monthlyPrice = price.getAttribute('data-monthly');
      const yearlyPrice = price.getAttribute('data-yearly');
      const selectedPrice = isYearly ? yearlyPrice : monthlyPrice;
      price.innerHTML = `<i class="fas fa-rupee-sign fs-14 posup"></i> ${selectedPrice.replace('INR', '').trim()}`;
      const offeramount = offeramounts[index];
      if (offeramount) {
        offeramount.style.display = isYearly ? 'block' : 'none';
      }
    });
  };
  const updateValues = (isYearly) => {
    planInputs.forEach(plan => {
      const monthlyValue = plan.getAttribute('data-monthly-value');
      const yearlyValue = plan.getAttribute('data-yearly-value');
      plan.value = isYearly ? yearlyValue : monthlyValue;
    });
  };
  monthlyLabel.addEventListener('click', () => toggleSwitch(false));
  yearlyLabel.addEventListener('click', () => toggleSwitch(true));
  switchInput.addEventListener('change', () => {
    const isYearly = switchInput.checked;
    updatePrices(isYearly);
    updateValues(isYearly);
  });
  updatePrices(switchInput.checked);
  updateValues(switchInput.checked);
});

$(document).ready(function () {
  // Function to clear error messages for all fields
  function clearErrorMessages() {
    const fields = [
      'first_name', 'mobile', 'address', 'state', 'city', 'pin_code',
      'business_name', 'gst', 'pan', 'designation', 'email', 'password', 'confirm_password'
    ];
    fields.forEach(field => {
      $(`#${field}`).removeClass('is-invalid');
      $(`#${field}Err`).text('');
    });
  }

  // Call clearErrorMessages function when any input field is focused
  $('input').focus(function () {
    clearErrorMessages();
  });

  // Form submission handler for Step 1
  $('#formStep_1').submit(function (event) {
    event.preventDefault();

    // Clear previous error messages
    // clearErrorMessages();
    var gst = $('#gst').val();
    var pan = $('#pan').val();
    // Retrieve form values
    const formData_1 = {
      step_1: $('#step_1').val(),
      first_name: $('#first_name').val(),
      last_name: $('#last_name').val(), // This will be included but not validated
      mobile: $('#mobile').val(),
      designation: $('#designation').val(), // This will be included but not validated
      address: $('#address').val(),
      state: $('#state').val(),
      city: $('#city').val(),
      pin_code: $('#pin_code').val(),
      business_name: $('#business_name').val(),
      gst: $('#gst').val(),
      pan: $('#pan').val(),
    };

    // Validate form fields and show error messages
    // let isValid = true;
    // const requiredFields = ['first_name', 'mobile', 'address', 'state', 'city', 'pin_code', 'business_name',];
    // requiredFields.forEach(field => {
    //   if (!formData_1[field]) {
    //     $(`#${field}`).addClass('is-invalid');
    //     $(`#${field}Err`).text(`Please enter your ${field.replace('_', ' ')}.`);
    //     isValid = false;
    //   }
    // });

    const businessNameRegex = /^[a-zA-Z0-9 ,.\\-]+$/;
      const gstRegex = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/;
      const nameRegex = /^[a-zA-Z\s\-\.']+$/;
      const addressRegex = /^[a-zA-Z0-9\s,.'\-\/]+$/;
      const pinCodeRegex = /^[0-9]{6}$/;
      const mobileRegex = /^[6-9]\d{9}$/;
      let isValid = true;

    // first nmae validation
    if (!formData_1.first_name) {
      $('#first_name').addClass('is-invalid');
      $('#first_nameErr').text('Please enter your first name.');
      isValid = false;
    }else if (formData_1.first_name.length < 3) {
      $('#first_name').addClass('is-invalid');
      $('#first_nameErr').text('First name must be at least 3 characters long.');
      isValid = false;
    }else if (!nameRegex.test(formData_1.first_name)) {
      $('#first_name').addClass('is-invalid');
      $('#first_nameErr').text('First name must contain only letters.');
      isValid = false;
    };

    if (formData_1.last_name) {
      if (formData_1.last_name.length < 2) {
        $('#last_name').addClass('is-invalid');
        $('#last_nameErr').text('Last name must be at least 2 characters long.');
        isValid = false;
      }
      else if (!nameRegex.test(formData_1.last_name)) {
        $('#last_name').addClass('is-invalid');
        $('#last_nameErr').text('Last name must contain only letters.');
        isValid = false;
      }
    }

    // mobile validation
    if (!formData_1.mobile) {
      $('#mobile').addClass('is-invalid');
      $('#mobileErr').text('Please enter your mobile number.');
      isValid = false;
    }else if (formData_1.mobile.length !== 10) {
      $('#mobile').addClass('is-invalid');
      $('#mobileErr').text('Mobile number must be 10 digits long.');
      isValid = false;
    }else if (!mobileRegex.test(formData_1.mobile)) {
      $('#mobile').addClass('is-invalid');
      $('#mobileErr').text('Invalid mobile number.');
      isValid = false;
    };

    if (formData_1.designation) {
      if (formData_1.designation.length < 2) {
      $('#designation').addClass('is-invalid');
      $('#designationErr').text('Designation must be at least 2  characters long.');  
      isValid = false;
    }else if (!nameRegex.test(formData_1.designation)) {
      $('#designation').addClass('is-invalid');
      $('#designationErr').text('Designation must contain only letters.');
      isValid = false;
    } 
  }
  
  

    // address validation
    if (!formData_1.address) {
      $('#address').addClass('is-invalid');
      $('#addressErr').text('Please enter your address.');
      isValid = false;
    }
   else if (formData_1.address.length < 10) {
      $('#address').addClass('is-invalid');
      $('#addressErr').text('Address must be at least 10 characters long.');
      isValid = false;
    }

    // state validation
    if (!formData_1.state) {
      $('#state').addClass('is-invalid');
      $('#stateErr').text('Please enter your state.');
      isValid = false;
    }
    else if (formData_1.state.length < 2) {
      $('#state').addClass('is-invalid');
      $('#stateErr').text('State must be at least 2 characters long.');
      isValid = false;
    }
    else if (!nameRegex.test(formData_1.state)) {
      $('#state').addClass('is-invalid');
      $('#stateErr').text('State must contain only letters.');
      isValid = false;
    }

    // city validation
    if (!formData_1.city) {
      $('#city').addClass('is-invalid');
      $('#cityErr').text('Please enter your city.');
      isValid = false;
    }
   else if (formData_1.city.length < 2) {
      $('#city').addClass('is-invalid');
      $('#cityErr').text('City must be at least 2 characters long.');
      isValid = false;
    }
   else if (!nameRegex.test(formData_1.city)) {
      $('#city').addClass('is-invalid');
      $('#cityErr').text('City must contain only letters.');
      isValid = false;
    }

    // pin code validation
    if (!formData_1.pin_code) {
      $('#pin_code').addClass('is-invalid');
      $('#pin_codeErr').text('Please enter your pin code.');
      isValid = false;
    }
    else if (formData_1.pin_code.length !== 6) {
      $('#pin_code').addClass('is-invalid');
      $('#pin_codeErr').text('Pin code must be 6 digits long.');
      isValid = false;
    }
    else if (!pinCodeRegex.test(formData_1.pin_code)) {
      $('#pin_code').addClass('is-invalid');
      $('#pin_codeErr').text('Pin code must contain only numbers.');
      isValid = false;
    }

    // business name validation
    if (formData_1.business_name) {
    if (formData_1.business_name.length < 3) {
      $('#business_name').addClass('is-invalid');
      $('#business_nameErr').text('Business name must be at least 3 characters long.');
      isValid = false;
    }
    else if (!businessNameRegex.test(formData_1.business_name)) {
      $('#business_name').addClass('is-invalid');
      $('#business_nameErr').text('Business name must be only characters. ');
      isValid = false;
    }
  }
    // GST and Pan validation
    if(formData_1.gst || formData_1.pan){
      if(formData_1.gst){
        if(formData_1.gst.length !== 15){
        $('#gst').addClass('is-invalid');
        $('#gstErr').text('GST number must be 15 characters long.');
        isValid = false;
      }
      else if (!gstRegex.test(formData_1.gst)) {
        $('#gst').addClass('is-invalid');
        $('#gstErr').text('Please enter a valid GST number.');
        isValid = false;
      }
    }
      if(formData_1.pan){
        const panRegex = /^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/;
        if(formData_1.pan.length !== 10){
          $('#pan').addClass('is-invalid');
          $('#panErr').text('PAN number must be 10 characters long.');
          isValid = false;
        }
        else if (!panRegex.test(formData_1.pan)) {
          $('#pan').addClass('is-invalid');
          $('#panErr').text('Please enter a valid PAN number.');
          isValid = false;
        } 
      }
     
    }else{
      $('#gst').addClass('is-invalid');
      $('#gstErr').text('Please enter your GST number Or PAN number.');
      isValid = false;
    }
   

    // If form is not valid, exit function
  if (!isValid) return;

    // Submit form data via API
    ApiRequest('buyer/register', 'POST', formData_1)
      .then(response => {
        if (response.data.statusCode == 200) {
          // alert('Step 1 form submitted successfully.');
          $('#hiddenField').val(response.data.id);
          $('.section_1').hide();
          $('.section_2').css('display', 'block');
          setTimeout(function () {
            $('.section_2').show().addClass('show_section_2');
          }, 10);

        }
        if (response.data.statusCode == 422) {
          const field = response.data.key;
          $(`#${field}`).addClass('is-invalid');
          $(`#${field}Err`).text(response.data.message);
        }
      })
      .catch(error => {
        console.error('Error222:', error);
      });
  });

  $('#formStep_2').submit(function (event) {
    event.preventDefault();

    var hiddenField = $('#hiddenField').val();
    var email = $("#email").val();
    var password = $("#password").val();
    var confirm_password = $("#confirm_password").val();
    const regex = /^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%@_.]).*$/;

    let isValid = true;
    // Clear previous errors
    $('#email').removeClass('is-invalid');
    $('#emailErr').text('');
    $('#password').removeClass('is-invalid');
    $('#passwordErr').text('');
    $('#confirm_password').removeClass('is-invalid');
    $('#confirm_passwordErr').text('');

    if (!email) {
      $('#email').addClass('is-invalid');
      $('#emailErr').text('Please enter your email.');
      isValid = false;
    }
    if (!password) {
      $('#password').addClass('is-invalid');
      $('#passwordErr').text('Please enter your password.');
      isValid = false;
    }
   else if (!regex.test(password)) {
      $('#password').addClass('is-invalid');
      $('#passwordErr').text('Password must be at least 8 characters long, include letters, numbers, and special characters.');
      isValid = false;
    }
    if (!confirm_password) {
      $('#confirm_password').addClass('is-invalid');
      $('#confirm_passwordErr').text('Please enter your confirm password.');
      isValid = false;
    }
    else if(password !== confirm_password) {
      $('#confirm_password').addClass('is-invalid');
      $('#confirm_passwordErr').text('Passwords do not match.');
      isValid = false;
    }

    if (isValid) {
      const formData_2 = {
        step_2: $('#step_2').val(),
        hiddenField: hiddenField,
        email: email,
        password: password,
        password_confirmation: confirm_password,
        product_channel: $('input[type="radio"][name="product_channel"]:checked').val()
      };
      ApiRequest('buyer/register', 'POST', formData_2)
        .then(response => {
          
          if (response.data.statusCode == 200) {
            $('#exampleModal').modal({backdrop: 'static', keyboard: false}, 'show');
            $('#exampleModal').modal('show');
            $(document).on('change', 'input[name="options-base"]', function() {
              if(this.checked) {
                $('.plan_details').removeClass('active');
                $(this).closest('.feature-value').find('.plan_details').addClass('active');
              }
            });
          // Handle button click event inside the label
          $(document).on('click', '.subscribebtn', function(e) {
            e.preventDefault();
            var radioInput = $(this).closest('.plan_details').prev('input[name="options-base"]');
            if(!radioInput.prop('checked')) {
              radioInput.prop('checked', true).trigger('change');
            }
            const planValue = radioInput.val();
            handlePayment(planValue);
          });
        function handlePayment(planValue) {
          const subscriptionPlan = {
            plan: planValue,
            hiddenField: $('#hiddenField').val(),
          };
        ApiRequest('create-payment', 'POST', subscriptionPlan)
        .then(response => {
            // console.log("API Response:", response);
            if (response.data.statusCode == 200) {
                if (response.data.is_trial_plan) {
                    window.location.href = "{{route('thankyou')}}";
                } else {
                    var options = {
                        "key": "{{env('RAZORPAY_KEY')}}",
                        "amount": response.data.order.amount,
                        "currency": response.data.order.currency,
                        "name": "{{env('APP_NAME')}}",
                        "description": "Ecomn Buyer Subscription Transaction",
                        "image": "{{asset('assets/images/Logo.svg')}}",
                        "order_id": response.data.order.id,
                        "callback_url": "{{route('payment.success')}}",
                        "prefill": {
                            "name": $('#first_name').val() + ' ' + $('#last_name').val(),
                            "email": $("#email").val(),
                            "contact": $('#mobile').val()
                        },
                        "notes": {
                            "address": "Gurugram, Haryana India"
                        },
                        "theme": {
                            "color": "#FECA40"
                        }
                    };

                    var rzp1 = new Razorpay(options);

                    rzp1.on('payment.failed', function (response) {
                        console.error("Payment Failed:", response.error);
                    });

                    rzp1.open();
                }
            } else {
                console.error("API Response Error:", response.data);
            }
        })
        .catch(error => {
            console.error("API Request Error:", error);
        });
    }


            // $('input[name="options-base"]').change(function() {
            //       if (this.checked) {
            //         console.log(this.value);
            //           const subscriptionPlan = {
            //             plan: this.value,
            //             hiddenField: $('#hiddenField').val(),
            //           };

            //           ApiRequest('create-payment', 'POST', subscriptionPlan)
            //           .then(response => {
            //             if (response.data.statusCode == 200) {
            //               if(response.data.is_trial_plan){
            //                 window.location.href = "{{route('thankyou')}}";
            //               }
            //             else{
            //                   var options = {
            //                     "key": "{{env('RAZORPAY_KEY')}}", // Enter the Key ID generated from the Dashboard
            //                     "amount": response.data.order.amount, // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
            //                     "currency": response.data.order.currency,
            //                     "name": "{{env('APP_NAME')}}", //your business name
            //                     "description": "Ecomn Buyer Subscription Transaction",
            //                     "image": "{{asset('assets/images/Logo.svg')}}",
            //                     "order_id": response.data.order.id, //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
            //                     "callback_url": "{{route('payment.success')}}",
            //                     "prefill": { //We recommend using the prefill parameter to auto-fill customer's contact information especially their phone number
            //                         "name": $('#first_name').val()+' '+$('#last_name').val(), //your customer's name
            //                         "email": $("#email").val(),
            //                         "contact":  $('#mobile').val() //Provide the customer's phone number for better conversion rates 
            //                     },
            //                     "notes": {
            //                         "address": "Gurugram, Haryana India"
            //                     },
            //                     "theme": {
            //                         "color": "#FECA40"
            //                     }
            //                 };
            //                 var rzp1 = new Razorpay(options);
            //                 rzp1.open();
            //                 }
            //               }
            //           })
            //           .catch(error => {
            //             console.error('Error:', error);
            //           });
            //       }
            //   });

            
            
            
              $(document).ready(function() {
              if ($('.sup_formSubmit').length) {
                $('.sup_formSubmit').on('click', function(event) {
                  event.preventDefault();
                  
                  // Hide the register element
                  $('.register').hide();
                  
                  // Show the t_u_s element
                  setTimeout(function () {
                    $('.t_u_s').show();
                  }, 10);
                 
                });
              }
            });
            
          } 
         else if (response.data.statusCode == 422) {
            const field = response.data.key;
            $(`#${field}`).addClass('is-invalid');
            $(`#${field}Err`).text(response.data.message);
          }
        })
        .catch(error => {
          console.error('Error:', error);
        });
    }

  });


});
  </script>

  @endsection