@extends('web.layout.app')
@section('content')
<div class="ekcontent">
  <section class="con_3_sec">
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
                  <input type="radio" class="btn-check selectplanbtn" name="options-base" id="free" autocomplete="off" value="{{salt_encrypt($plans[0]['id'])}}"
                  data-monthly-value="{{salt_encrypt('1')}}" data-yearly-value="{{salt_encrypt('1')}}" />
                  <label class="plan_details" for="{{$plans[0]['name']}}">
                    <h2 style="font-size: 15px;">{{$plans[0]['name']}}</h2>
                    <div class="price_p">
                      <div class="price" data-monthly="INR {{$plans[0]['price']}}" data-yearly="INR {{$plans[0]['price']}}">INR {{$plans[0]['price']}}</div>
                    </div>
                    <button class="btn subscribebtn btnekomn">Start Free Trial</button>
                  </label>
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
                  <div class="feature-value">30</div>
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
                  <div class="feature-value">30</div>
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
                <div class="feature-value"><i class="fas fa-check text-success"></i></div>
              </div>
            </div>
              <div class="tooltips">
                <span class="tooltiptext">Periodic communication on high profit products</span>
              <div class="feature-row">
                <div class="feature">Access to High profit, Low competetion, Unique products</div>
                <div class="feature-value"><i class="fas fa-times text-danger"></i></div>
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
                <div class="feature-value"><i class="fas fa-check text-success"></i></div>
              </div>
            </div>
              <div class="tooltips">
              <div class="feature-row">
                <span class="tooltiptext">Access to Pan India bulk reseller program</span>
                <div class="feature">ReSeller Program</div>
                <div class="feature-value"><i class="fas fa-times text-danger"></i></div>
                <div class="feature-value"><i class="fas fa-times text-danger"></i></div>
                <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                <div class="feature-value"><i class="fas fa-check text-success"></i></div>
              </div>
            </div>
              <div class="feature-row">
                <div class="feature">Shine Program</div>
                <div class="feature-value"><i class="fas fa-times text-danger"></i></div>
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
                <div class="feature-value"><i class="fas fa-check text-success"></i></div>
              </div>
            </div>
              <div class="tooltips">
                <span class="tooltiptext">Direct access to Expert/Engineer to address urgent issues</span>
              <div class="feature-row">
                <div class="feature">Phone Support</div>
                <div class="feature-value"><i class="fas fa-times text-danger"></i></div>
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
                <div class="feature-value"><i class="fas fa-times text-danger"></i></div>
                <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                <div class="feature-value"><i class="fas fa-check text-success"></i></div>
                <div class="feature-value"><i class="fas fa-check text-success"></i></div>
              </div>
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
              Registered Users - To avail similar services for other leading online Platforms, please reach out to our Support Desk <br>
              All prices are in INR and excluding of GST
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
<script>

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

  var subscript = document.querySelectorAll('.subscribebtn');
  subscript.forEach(function (btn) {
    btn.addEventListener('click', function () {
      window.location.href = "{{route('buyer.login')}}";
    });
  });
});


    </script>
@section('scripts')
@endsection