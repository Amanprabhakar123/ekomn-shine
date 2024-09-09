@extends('dashboard.layout.app')

@section('content')
<div class="ek_dashboard">
    <div class="ek_content">
        <div class="card ekcard pa shadow-sm">
            <div class="cardhead">
                <h3 class="cardtitle">Subscription View</h3>
                <button class="btn btnekomn_dark stripbtn" onclick="downloadInvoice('{{salt_encrypt($companyDetail->id)}}')"><i class="fas fa-file-pdf me-2"></i>Download Invoice</button>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <table class="detail_s_t">
                        <thead>
                            <tr>
                                <th>Plan Name</th>
                                <th>Plan Status</th>
                                <th>Plan Price</th>
                                <th>Paid Amount</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$companyDetail->subscription[0]->plan->name}}</td>
                                <td>{{getCompanyPlanStatus($companyDetail->subscription[0]->status)}}</td>
                                <td>{{$companyDetail->subscription[0]->plan->price}}</td>
                                <td>{{$companyDetail->companyPlanPayment->amount_with_gst}}</td>
                                <td>{{$companyDetail->subscription[0]->subscription_start_date->toDateString()}}</td>
                                <td>{{$companyDetail->subscription[0]->subscription_end_date->toDateString()}}</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="">
                        <div class="bulkBuing">
                            <label class="fs-14 bold">Bulk Buying Rates:</label>
                            <table class="detail_s_t width-100">
                                
                                <tbody>
                                    <tr>
                                        <td >My Inventory List Limit - Used</td>
                                        <td>{{$companyDetail->planSubscription->inventory_count}}</td>
                                    </tr>
                                    <tr>
                                        <td>Monthly Products Download Count</td>
                                        <td>{{$companyDetail->planSubscription->download_count}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

              

            </div>
            @if(!is_null($companyDetail->razorpay_subscription_id))

            <div class="col-sm-12 col-md-4 mt-3">
                    <div class="ek_group">
                      <label class="eklabel req">
                        <span class="autodebitStatus fw-bold fs-6">Smart Pay:</span>
                      </label>
                      <div class="ek_f_input">
                      <div class="switch-container">
                            <label class="switch mt-2">
                                @if($companyDetail->isSubscriptionActive() )
                                <input type="checkbox" id="autodebitToggle" onclick="toggleAutodebit()" checked>
                                @elseif($companyDetail->isSubscriptionInActive())
                                <input type="checkbox" id="autodebitToggle" onclick="toggleAutodebit()">
                                @else
                                <input type="checkbox" id="autodebitToggle" disabled>
                                @endif
                                <span class="slider"></span>
                            </label>
                           <strong>AutoDebit: </strong> <span id="autodebitStatus"></span>
                        </div>
                      </div>
                    </div>
                  </div>
                  @else
                  <div class="col-sm-12 col-md-4 mt-3">
                    <div class="ek_group">
                      <label class="eklabel req">
                        <span class="autodebitStatus fw-bold fs-6">Smart Pay:</span>
                      </label>
                      <div class="ek_f_input">
                      <div class="switch-container">
                            <label class="switch mt-2">
                             
                                <input type="checkbox" id="autodebitToggle" disabled>
                                <span class="slider"></span>
                            </label>
                           <strong>AutoDebit: </strong> <span id="autodebitStatus"></span>
                        </div>
                      </div>
                    </div>
                  </div>
                  @endif

                  <div class="col-sm-12 col-md-4 mt-3">
                    <div class="ek_group">
                      <div class="ek_f_input">
                       <button id="btnRenewal" class="btn btn-login btnekomn card_f_btn payment_button">Renew/Upgrade</button>
                      
                       @if($companyDetail->isSubscriptionActive() || $companyDetail->isSubscriptionInActive() || $companyDetail->isSubscriptionAuth() || $companyDetail->isSubscriptionPending())
                       @if(!is_null($companyDetail->razorpay_subscription_id))
                       <button id="cancelSmartPay" class="btn btn-danger">Cancel Smart Pay</button>
                       @else
                       <button id="enableSmartPay" class="btn btn-success">Enable Smart Pay</button>
                       @endif

                       @else
                       @if($companyDetail->subscription[0]->isPlanActive())
                       <button id="enableSmartPay" class="btn btn-success" >Enable Smart Pay</button>
                       @else
                          <button id="enableSmartPay" class="btn btn-success" disabled>Enable Smart Pay</button>
                        @endif
                        @endif
                      </div>
                    </div>
                  </div>
        </div>
    </div>
    @include('dashboard.layout.copyright')
</div>
<!-- Pricing Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
      <div class="modal-content">
        <div class="modal-body fullbodyclose">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="container">
            <div class="row">
              <div class="col-sm-12">
                <div class="text-center sec__h">
                  <h1 class="h2 bold m-0">Unleash your business potential with the ideal plan</h1>
                  <ul class="promise_list listnone">
                    <!-- <li><i class="fas fa-check me-2 text-success"></i>Free 14-day trial</li> -->
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
                        <input type="radio" class="btn-check selectplanbtn" name="options-base" id="Essential" autocomplete="off" value="{{salt_encrypt($plans[1]['id'])}}"
                        data-monthly-value="{{salt_encrypt($plans[1]['id'])}}" data-yearly-value="{{salt_encrypt($plans[2]['id'])}}"/>
                        <label class="plan_details " for="Essential">
                          <h2>{{$plans[1]['name']}}</h2>
                          <div class="price_p">
                            <div class="price" data-monthly="INR {{$plans[1]['price']}}" data-yearly="INR {{$plans[2]['price']}}">INR {{$plans[1]['price']}}</div>
                            <div class="offeramount">
                              <del class="ms-1"><i class="fas fa-rupee-sign fs-13 me-1"></i>{{yearlyPrice($plans[1]['price'])}}</del>
                              <small class="ms-1 bold text-success">{{getYearlyDiscountPercent($plans[1]['price'], $plans[2]['price'])}}% Off</small>
                            </div>
                          </div>
                          <button class="btn subscribebtn btnekomn">Subscribe</button>
                        </label>
                      </div>
                      <div class="feature-value">
                        <input type="radio" class="btn-check selectplanbtn" name="options-base" id="Booster" autocomplete="off"  value="{{salt_encrypt($plans[3]['id'])}}"
                        data-monthly-value="{{salt_encrypt($plans[3]['id'])}}" data-yearly-value="{{salt_encrypt($plans[4]['id'])}}"/>
                        <label class="plan_details bestplan active" for="Booster">
                          <span class="bestplanText">Most Popular</span>
                          <h2>{{$plans[3]['name']}}</h2>
                          <div class="price_p">
                            <div class="price" data-monthly="INR {{$plans[3]['price']}}" data-yearly="{{$plans[4]['price']}}">{{$plans[3]['price']}}</div>
                            <div class="offeramount">
                              <del class="ms-1"><i class="fas fa-rupee-sign fs-13 me-1"></i>{{yearlyPrice($plans[3]['price'])}}</del>
                              <small class="ms-1 bold text-success">{{getYearlyDiscountPercent($plans[3]['price'], $plans[4]['price'])}}% Off</small>
                            </div>
                          </div>
                          <button class="btn subscribebtn btnekomn">Subscribe</button>
                        </label>
                      </div>
                      <div class="feature-value">
                        <input type="radio" class="btn-check selectplanbtn" name="options-base" id="Trade" autocomplete="off" value="{{salt_encrypt( $plans[5]['id'] )}}"
                        data-monthly-value="{{salt_encrypt($plans[5]['id'])}}" data-yearly-value="{{salt_encrypt($plans[6]['id'])}}"/>
                        <label class="plan_details" for="Trade">
                          <h2>{{$plans[5]['name']}}</h2>
                          <div class="price_p">
                            <div class="price" data-monthly="INR {{$plans[5]['price']}}" data-yearly="INR {{$plans[6]['price']}}">INR {{$plans[5]['price']}}</div>
                            <div class="offeramount">
                              <del class="ms-1"><i class="fas fa-rupee-sign fs-13 me-1"></i>{{yearlyPrice($plans[5]['price'])}}</del>
                              <small class="ms-1 bold text-success">{{getYearlyDiscountPercent($plans[5]['price'], $plans[6]['price'])}}% Off</small>
                            </div>
                          </div>
                          <button class="btn subscribebtn btnekomn">Subscribe</button>
                        </label>
                      </div>
                      <div class="feature-value">
                        <input type="radio" class="btn-check selectplanbtn" name="options-base" id="Enterprise" autocomplete="off" value="{{salt_encrypt( $plans[7]['id'])}}"
                        data-monthly-value="{{salt_encrypt( $plans[7]['id'])}}" data-yearly-value="{{salt_encrypt( $plans[8]['id'])}}"/>
                        <label class="plan_details" for="Enterprise">
                          <h2>{{$plans[7]['name']}}</h2>
                          <div class="price_p">
                            <div class="price" data-monthly="INR {{$plans[7]['price']}}" data-yearly="INR {{$plans[8]['price']}}">INR {{$plans[7]['price']}}</div>
                            <div class="offeramount">
                              <del class="ms-1"><i class="fas fa-rupee-sign fs-13 me-1"></i>{{yearlyPrice($plans[7]['price'])}}</del>
                              <small class="ms-1 bold text-success">{{getYearlyDiscountPercent($plans[7]['price'], $plans[8]['price'])}}% Off</small>
                            </div>
                          </div>
                          <button class="btn subscribebtn btnekomn">Subscribe</button>
                        </label>
                      </div>
                    </div>
                  </div>
                
                  <div class="features-list">
                    <div class="tooltips">
                      <div class="feature-row">
                        <span class="tooltiptext">Allowed limit of total selected products that can be added to Inventory</span>
                        <div class="feature">My Inventory List Limit</div>
                        <div class="feature-value">100</div>
                        <div class="feature-value">500</div>
                        <div class="feature-value">1000</div>
                        <div class="feature-value">2000</div>
                      </div>
                    </div>
                    <div class="tooltips">
                    <span class="tooltiptext">Allowed limit of product content download that you are allowed to do in a month</span>
                      <div class="feature-row">
                        <div class="feature">Monthly Products Download Count</div>
                        <div class="feature-value">100</div>
                        <div class="feature-value">500</div>
                        <div class="feature-value">1000</div>
                        <div class="feature-value">2000</div>
                      </div>
                    </div>
                    <div class="tooltips">
                    <div class="feature-row">
                    <span class="tooltiptext">Periodic New product alert sent to your email</span>
                      <div class="feature">New Products Alerts</div>
                      <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                      <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                      <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                      <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    </div>
                  </div>
                  <div class="tooltips">
                    <span class="tooltiptext">Important product related notifications</span>
                    <div class="feature-row">
                      <div class="feature">Product Notifications</div>
                      <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                      <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                      <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                      <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    </div>  
                  </div>
                    <div class="tooltips">
                    <div class="feature-row">
                      <span class="tooltiptext">Curated product list especially prepared for you as per your product category and usage</span>
                      <div class="feature">Curated Product List</div>
                      <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                      <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                      <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                      <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    </div>
                  </div>
                    <div class="tooltips">
                      <span class="tooltiptext">Periodic communication on high profit products</span>
                    <div class="feature-row">
                      <div class="feature">Access to High profit, Low competetion, Unique products</div>
                      <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                      <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                      <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                      <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    </div>
                  </div>
                    <div class="tooltips">
                      
                    <div class="feature-row">
                      <span class="tooltiptext">Manage your Store Orders, Dropship orders, Bulk Orders & Order product Samples</span>
                      <div class="feature">Order Manager</div>
                      <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                      <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                      <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                      <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    </div>
                  </div>
                    <div class="tooltips">
                      <span class="tooltiptext">File and review returns</span>
                    <div class="feature-row">
                      <div class="feature">Returns</div>
                      <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                      <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                      <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                      <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    </div>
                  </div>
                    <div class="tooltips">
                    <div class="feature-row">
                      <span class="tooltiptext">Access to Pan India bulk reseller program</span>
                      <div class="feature">ReSeller Program</div>
                      <div class="feature-value"><i class="fas fa-times text-danger"></i></div>
                      <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                      <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                      <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    </div>
                  </div>
                    <div class="feature-row">
                      <div class="feature">Shine Program</div>
                      <div class="feature-value"><i class="fas fa-times text-danger"></i></div>
                      <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                      <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                      <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    </div>
                    <div class="tooltips">
                    <div class="feature-row">
                      <span class="tooltiptext">Integrate your Amazon account and update product stock and Manager Orders automatically</span>
                      <div class="feature">Amazon Integration</div>
                      <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                      <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                      <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                      <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    </div>
                  </div>
                    <div class="tooltips">
                      <span class="tooltiptext">Panel access to manage your integration with leading platforms</span>
                    <div class="feature-row">
                      <div class="feature">My Connections</div>
                      <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                      <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                      <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                      <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    </div>
                  </div>
                    <div class="tooltips">
                    <div class="feature-row">
                      <span class="tooltiptext">Prompt business support to manage your daily operations smoothly</span>
                      <div class="feature">Chat & Email Support</div>
                      <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                      <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                      <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                      <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    </div>
                  </div>
                    <div class="tooltips">
                      <span class="tooltiptext">Direct access to Expert/Engineer to address urgent issues</span>
                    <div class="feature-row">
                      <div class="feature">Phone Support</div>
                      <div class="feature-value"><i class="fas fa-times text-danger"></i></div>
                      <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                      <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                      <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    </div>
                  </div>
                    <div class="tooltips">
                    <div class="feature-row">
                      <span class="tooltiptext">An eKomn expert just a call away to to collaborate with you on your business growth</span>
                      <div class="feature">Dedicated Account Manager</div>
                      <div class="feature-value"><i class="fas fa-times text-danger"></i></div>
                      <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                      <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                      <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                    </div>
                  </div>
                    <div class="feature-row">
                      <div class="feature">Download Center</div>
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
                    </div>
                  </div>
                  <div class="amazonbox">
                    <h3 class="AmazonSeller" data-bs-toggle="collapse" data-bs-target="#AmazonSeller" aria-expanded="false" aria-controls="AmazonSeller">Amazon Seller Central Services <span class="viewmore">View in Detail</span></h3>
                    <div class="collapse" id="AmazonSeller">
                      <div class="features-list">
                        <div class="feature-row">
                          <div class="feature">Product Listing Support</div>
                          <div class="feature-value">20</div>
                          <div class="feature-value">50</div>
                          <div class="feature-value">200</div>
                          <div class="feature-value">Unlimited</div>
                        </div>
                        <div class="feature-row">
                          <div class="feature">Listing Enhancements in a month</div>
                          <div class="feature-value">2</div>
                          <div class="feature-value">5</div>
                          <div class="feature-value">20</div>
                          <div class="feature-value">25</div>
                        </div>
                        <div class="feature-row">
                          <div class="feature">A+ Listings in a month</div>
                          <div class="feature-value"><i class="fas fa-times text-danger"></i></div>
                          <div class="feature-value"><i class="fas fa-times text-danger"></i></div>
                          <div class="feature-value">2</div>
                          <div class="feature-value">5</div>
                        </div>
                        <div class="feature-row">
                          <div class="feature">Premiuim Store Development</div>
                          <div class="feature-value"><i class="fas fa-times text-danger"></i></div>
                          <div class="feature-value"><i class="fas fa-times text-danger"></i></div>
                          <div class="feature-value">1</div>
                          <div class="feature-value">1</div>
                        </div>
                        <div class="feature-row">
                          <div class="feature">Customer Review Management</div>
                          <div class="feature-value"><i class="fas fa-times text-danger"></i></div>
                          <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                          <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                          <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                        </div>
                        <div class="feature-row">
                          <div class="feature">Product Return Management</div>
                          <div class="feature-value"><i class="fas fa-times text-danger"></i></div>
                          <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                          <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                          <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                        </div>
                        <div class="feature-row">
                          <div class="feature">FBA Shipments</div>
                          <div class="feature-value"><i class="fas fa-times text-danger"></i></div>
                          <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                          <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                          <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                        </div>
                        <div class="feature-row">
                          <div class="feature">Brand Registerations & Approvals</div>
                          <div class="feature-value"><i class="fas fa-times text-danger"></i></div>
                          <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                          <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                          <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                        </div>
                        <div class="feature-row">
                          <div class="feature">Expert Consulting</div>
                          <div class="feature-value"><i class="fas fa-times text-danger"></i></div>
                          <div class="feature-value">1 Session</div>
                          <div class="feature-value">3 Session</div>
                          <div class="feature-value">3 Session</div>
                        </div>
                        <div class="feature-row">
                          <div class="feature">Complete Account Management</div>
                          <div class="feature-value"><i class="fas fa-times text-danger"></i></div>
                          <div class="feature-value"><i class="fas fa-times text-danger"></i></div>
                          <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                          <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <p class="subcribeNote">
                    Registered Users - To avail similar services for other leading online Platforms, please reach out to our Support Desk <br>
                    All prices are in INR and excluding of GST
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
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    function toggleAutodebit() {
    var checkbox = document.getElementById("autodebitToggle");
    var statusText = document.getElementById("autodebitStatus");
    
    @if($companyDetail->isSubscriptionActive() || $companyDetail->isSubscriptionInActive())
    if (checkbox.checked) {
      @if(!is_null($companyDetail->razorpay_subscription_id))
      statusText.textContent = "{{$companyDetail->subscriptionStatus()}}";
      statusText.style.color = "green";
      @else
      statusText.textContent = "In Active";
      statusText.style.color = "red";
      @endif
      
    } else {
      @if(!is_null($companyDetail->razorpay_subscription_id))
      statusText.textContent = "{{$companyDetail->subscriptionStatus()}}";
      statusText.style.color = "red";
      @else
        statusText.textContent = "In Active";
        statusText.style.color = "red";
      @endif
    }
    @else
        checkbox.disabled = true;
        statusText.textContent = "{{$companyDetail->subscriptionStatus()}}";
        statusText.style.color = "#cccccc";
    @endif

}
toggleAutodebit()

$('#autodebitToggle').change(function() {
    let company_id = (`{{ salt_encrypt($companyDetail->id) }}`);
    ChangeStatus(company_id);
});

$('#cancelSmartPay').click(function() {
    let company_id = (`{{ salt_encrypt($companyDetail->id) }}`);
    // add sweet alert confirmation
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to cancel the Smart Pay!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Cancel it!',
        didOpen: () => {
            const title = Swal.getTitle();
            title.style.fontSize = '25px';
            // Apply inline CSS to the content
            const content = Swal.getHtmlContainer();
            // Apply inline CSS to the confirm button
            const confirmButton = Swal.getConfirmButton();
            confirmButton.style.backgroundColor = '#feca40';
            confirmButton.style.color = 'white';
        }
    }).then((result) => {
        if (result.isConfirmed) {
            ChangeStatus(company_id, true);
        }
    });
});

function ChangeStatus(company_id, is_cancel = false) {
    ApiRequest("change-subscription-status", 'POST', {
        company_id: company_id,
        is_cancel: is_cancel
    }).then(response => {
        if (response.data.statusCode == 200) {
            Swal.fire({
                title: 'Success',
                text: response.data.message,
                icon: 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK',
                didOpen: () => {
                    const title = Swal.getTitle();
                    title.style.fontSize = '25px';
                    // Apply inline CSS to the content
                    const content = Swal.getHtmlContainer();
                    // Apply inline CSS to the confirm button
                    const confirmButton = Swal.getConfirmButton();
                    confirmButton.style.backgroundColor = '#feca40';
                    confirmButton.style.color = 'white';
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.reload();
                }
            });
        }else{
            Swal.fire({
                title: 'Error',
                text: response.data.message,
                icon: 'error',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK',
                didOpen: () => {
                    const title = Swal.getTitle();
                    title.style.fontSize = '25px';
                    // Apply inline CSS to the content
                    const content = Swal.getHtmlContainer();
                    // Apply inline CSS to the confirm button
                    const confirmButton = Swal.getConfirmButton();
                    confirmButton.style.backgroundColor = '#feca40';
                    confirmButton.style.color = 'white';
                }
            });
        }
    });
}

$('#enableSmartPay').click(function() {
    let company_id = (`{{ salt_encrypt($companyDetail->id) }}`);
    ApiRequest("enable-subscription", 'POST', {
        company_id: company_id,
        plan_id: "{{salt_encrypt($companyDetail->subscription[0]->plan_id)}}",
        subscription_end_date: "{{$companyDetail->subscription[0]->subscription_end_date->toDateString()}}"
    }).then(response => {
        if (response.data.statusCode == 200) {
            window.open(response.data.payment_link, '_blank');
        }
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

$('#btnRenewal').click(function() {
    let company_id = (`{{ salt_encrypt($companyDetail->id) }}`);
    let last_plan = (`{{ salt_encrypt($companyDetail->subscription[0]->plan_id)}}`);
    let last_plan_status = (`{{ $companyDetail->subscription[0]->status }}`);
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
            // Check if the last plan is active or not
            if(last_plan_status == true){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to renew or upgrade your subscription because the current plan is active?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Renew/Upgrade/Downgrade it!',
                    didOpen: () => {
                        const title = Swal.getTitle();
                        title.style.fontSize = '25px';
                        // Apply inline CSS to the content
                        const content = Swal.getHtmlContainer();
                        // Apply inline CSS to the confirm button
                        const confirmButton = Swal.getConfirmButton();
                        confirmButton.style.backgroundColor = '#feca40';
                        confirmButton.style.color = 'white';
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        handlePayment(planValue, true);
                    }
                });
            }else{
                handlePayment(planValue, true);
            }
          });
        function handlePayment(planValue, is_downgrade = false) {
          const subscriptionPlan = {
            plan: planValue,
            company_id: company_id,
            last_plan: last_plan,
            is_downgrade: is_downgrade
          };
        ApiRequest('renew-payment', 'POST', subscriptionPlan)
        .then(response => {
            // console.log("API Response:", response);
            if (response.data.statusCode == 200) {
                    var options = {
                        "key": "{{env('RAZORPAY_KEY')}}",
                        'subscription_id': response.data.order.subscription_id,
                        "amount": response.data.order.amount,
                        "currency": response.data.order.currency,
                        "name": "{{env('APP_NAME')}}",
                        "description": "Ecomn Buyer Subscription Transaction",
                        "image": "{{asset('assets/images/logo.png')}}",
                        "order_id": response.data.order.id,
                        "callback_url": "{{route('renewal.payment.success')}}",
                        "prefill": {
                            "name": '{{$companyDetail->first_name}} {{$companyDetail->last_name}}',
                            "email": '{{$companyDetail->email}}',
                            "contact": '{{$companyDetail->mobile_no}}'
                        },
                        "notes": {
                            "address": "Gurugram, Haryana India"
                        },
                        "theme": {
                            "color": "#FECA40"
                        },
                    };

                    var rzp1 = new Razorpay(options);

                    rzp1.on('payment.failed', function (response) {
                        console.error("Payment Failed:", response.error);
                    });

                    rzp1.open();
            } else if(response.data.statusCode == 422) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: response.data.message,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Renew/Downgrade it!',
                    didOpen: () => {
                        const title = Swal.getTitle();
                        title.style.fontSize = '25px';
                        // Apply inline CSS to the content
                        const content = Swal.getHtmlContainer();
                        // Apply inline CSS to the confirm button
                        const confirmButton = Swal.getConfirmButton();
                        confirmButton.style.backgroundColor = '#feca40';
                        confirmButton.style.color = 'white';
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        handlePayment(planValue, false);
                    }
                });
            }else{
                console.error("API Response Error:", response.data);
            }
        })
        .catch(error => {
            console.error("API Request Error:", error);
        });
    }
  });
     // download the invoice pdf
     function downloadInvoice(subscription_id) {
            fetch('{{ route('subscription.invoice') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(subscription_id)
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.blob();
                })
                .then(blob => {
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.style.display = 'none';
                    a.href = url;
                    a.download = 'Invoice_' + Date.now() + '.pdf';
                    document.body.appendChild(a);
                    a.click();
                    window.URL.revokeObjectURL(url);
                })
                .catch(error => {
                    console.error('Error downloading products:', error);
                });


        }

</script>
@endsection