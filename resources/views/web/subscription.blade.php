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
});
    </script>
@section('scripts')
@endsection