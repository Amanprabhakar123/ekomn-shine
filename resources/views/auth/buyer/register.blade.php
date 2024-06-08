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
                      <input type="text" class="form-control" id="first_name" name="first_name" placeholder="*First Name" />
                      <div id="last_nameErr" class="invalid-feedback"></div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                      <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" />
                      <div id="last_nameErr" class="invalid-feedback"></div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-6">
                    <div class="input-group form-group">
                      <span class="input-group-text text-muted">+91</span>
                      <input type="tel" class="form-control" id="mobile" name="mobile" placeholder="Mobile Number" />
                      <div id="mobileErr" class="invalid-feedback"></div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                      <input type="text" class="form-control" id="designation" name="designation" placeholder="Designation" />
                      <div id="designationErr" class="invalid-feedback"></div>
                    </div>
                  </div>
                </div>
                <strong class="pt-3 pb-1 block">Shipping Address</strong>
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <input type="text" class="form-control" id="address" name="address" placeholder="*Street Address" />
                      <div id="addressErr" class="invalid-feedback"></div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                      <input type="text" class="form-control" id="state" name="state" placeholder="*State" />
                      <div id="stateErr" class="invalid-feedback"></div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                      <input type="text" class="form-control" id="city" name="city" placeholder="*City" />
                      <div id="cityErr" class="invalid-feedback"></div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                      <input type="text" class="form-control" id="pin_code" name="pin_code" placeholder="*Pin Code" />
                      <div id="pin_codeErr" class="invalid-feedback"></div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                      <input type="text" class="form-control" id="business_name" name="business_name" placeholder="*Business name" />
                      <div id="business_nameErr" class="invalid-feedback"></div>
                    </div>
                  </div>
                </div>
                <div class="row chooseoneinput">
                  <span class="chooseone">or</span>
                  <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                      <input type="text" class="form-control" id="gst" name="gst" placeholder="GST ID" />
                      <div id="gstErr" class="invalid-feedback"></div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                      <input type="text" class="form-control" id="pan" name="pan" placeholder="PAN" />
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
                      <input type="email" class="form-control" id="email" name="email" placeholder="*Email Address" />
                      <div id="emailErr" class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control" id="password" name="password" placeholder="*Password" />
                      <div id="passwordErr" class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="*Confirm Password" />
                      <div id="confirm_passwordErr" class="invalid-feedback"></div>
                    </div>
                    <div class="mt40">
                      <ul class="ack_q_l listnone">
                        <li>
                          <label class="ack_q_w"><strong>How did you hear about eKomn?</strong></label>
                          <ul class="categoryList listnone">
                            <li>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="product_channel" value="Through sms" id="channel1" />
                                <label class="form-check-label" for="channel1">
                                  Through SMS
                                </label>
                              </div>
                            </li>
                            <li>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="product_channel" value="through email" id="channel2" />
                                <label class="form-check-label" for="channel2">
                                  Through eMail
                                </label>
                              </div>
                            </li>
                            <li>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="product_channel" value="google search" id="channel3" />
                                <label class="form-check-label" for="channel3">
                                  Google Search
                                </label>
                              </div>
                            </li>
                            <li>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="product_channel" value="social media" id="channel4" />
                                <label class="form-check-label" for="channel4">
                                  Social Media
                                </label>
                              </div>
                            </li>
                            <li>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="product_channel" value="referred" id="channel5" />
                                <label class="form-check-label" for="channel5">
                                  Referred
                                </label>
                              </div>
                            </li>
                            <li>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="product_channel" value="others" id="channel6" />
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
              <a href="{{route('buyer.login')}}" class="a_color">Click to Login</a>
            </div>
          </div>
        </div>
        
        @include('auth.layout.footer')
        
      </div>
    </div>
  </div>
  <!-- Pricing Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
      <div class="modal-content">
        <div class="modal-body fullbodyclose" style="background-color: #f4f5f6;">
          <button type="button" class="btn-close sup_formSubmit" data-bs-dismiss="modal" aria-label="Close"></button>
          <div class="container">
            <div class="row">
              <div class="col-sm-12">
                <div class="text-center sec__h">
                  <h1 class="h2 bold m-0">Unleash your business potential with the ideal plan</h1>
                  <ul class="promise_list listnone">
                    <li><i class="fas fa-check me-2 text-success"></i>Free 14-day trial</li>
                    <li><i class="fas fa-check me-2 text-success"></i>Unlimited Team Members</li>
                    <li><i class="fas fa-check me-2 text-success"></i>Cancel Anytime</li>
                  </ul>
                </div>
                <div class="pricing-container pt-0 mt-5">
                  <div class="features-list priceList">
                    <div class="feature-row">
                      <div class="feature">
                        <div class="SelectFeatures">
                          <div class="defaulPlan">
                            <span>Monthly</span>
                            <div class="form-check form-switch switch-lg m-0">
                              <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" />
                              <label class="form-check-label" for="flexSwitchCheckDefault"></label>
                            </div>
                            <span>Yearly</span>
                          </div>
                          <div class="SelectFeature">
                            <label for="">Select Features</label>
                            <select name="" id="" class="form-control form-control-sm">
                              <option value="">Standard</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="feature-value">
                        <input type="radio" class="btn-check selectplanbtn" name="options-base" id="free" autocomplete="off" />
                        <label class="plan_details" for="free">
                          <h2 style="font-size: 15px;">Free Trial - 14 days</h2>
                          <div class="price">INR 00.00</div>
                          <button class="btn subscribebtn btnekomn">Start Free Trial</button>
                        </label>
                      </div>
                      <div class="feature-value">
                        <input type="radio" class="btn-check selectplanbtn" name="options-base" id="Essential" autocomplete="off" />
                        <label class="plan_details" for="Essential">
                          <h2>Essential</h2>
                          <div class="price">INR 1999.00</div>
                          <button class="btn subscribebtn btnekomn">Subscribe</button>
                        </label>
                      </div>
                      <div class="feature-value">
                        <input type="radio" class="btn-check selectplanbtn" name="options-base" id="Booster" autocomplete="off" checked />
                        <label class="plan_details bestplan" for="Booster">
                          <span class="bestplanText">Most Popular</span>
                          <h2>Booster</h2>
                          <div class="price">INR 2999.00</div>
                          <button class="btn subscribebtn btnekomn">Subscribe</button>
                        </label>
                      </div>
                      <div class="feature-value">
                        <input type="radio" class="btn-check selectplanbtn" name="options-base" id="Trade" autocomplete="off" />
                        <label class="plan_details" for="Trade">
                          <h2>Trade Hub</h2>
                          <div class="price">INR 7999.00</div>
                          <button class="btn subscribebtn btnekomn">Subscribe</button>
                        </label>
                      </div>
                      <div class="feature-value">
                        <input type="radio" class="btn-check selectplanbtn" name="options-base" id="Enterprise" autocomplete="off" />
                        <label class="plan_details" for="Enterprise">
                          <h2>Enterprise</h2>
                          <div class="price">INR 11999.00</div>
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
                    <h3 class="AmazonSeller">Amazon Seller Central Services</h3>
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
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- end -->
  <script type="text/javascript" src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
  @section('custom_script')
  <script src="{{asset('assets/js/ek.common.js')}}"></script>
  @endsection