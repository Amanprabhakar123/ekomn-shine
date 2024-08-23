@extends('web.layout.app')
@section('content')
<div class="ekcontent">
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
                                <input type="radio" class="btn-check selectplanbtn" name="options-base" id="free" autocomplete="off" value="{{salt_encrypt('1')}}" />
                                <label class="plan_details" for="free">
                                    <h2 style="font-size: 15px;">Free Trial - 14 days</h2>
                                    <div class="price">INR 00.00</div>
                                    <button class="btn subscribebtn btnekomn">Start Free Trial</button>
                                </label>
                            </div>
                            <div class="feature-value">
                                <input type="radio" class="btn-check selectplanbtn" name="options-base" id="Essential" autocomplete="off" value="{{salt_encrypt('2')}}" />
                                <label class="plan_details " for="Essential">
                                    <h2>Essential</h2>
                                    <div class="price">INR 1999.00</div>
                                    <button class="btn subscribebtn btnekomn">Subscribe</button>
                                </label>
                            </div>
                            <div class="feature-value">
                                <input type="radio" class="btn-check selectplanbtn" name="options-base" id="Booster" autocomplete="off" value="{{salt_encrypt('4')}}" />
                                <label class="plan_details bestplan" for="Booster">
                                    <span class="bestplanText">Most Popular</span>
                                    <h2>Booster</h2>
                                    <div class="price">INR 2999.00</div>
                                    <button class="btn subscribebtn btnekomn">Subscribe</button>
                                </label>
                            </div>
                            <div class="feature-value">
                                <input type="radio" class="btn-check selectplanbtn" name="options-base" id="Trade" autocomplete="off" value="{{salt_encrypt('6')}}" />
                                <label class="plan_details" for="Trade">
                                    <h2>Trade Hub</h2>
                                    <div class="price">INR 7999.00</div>
                                    <button class="btn subscribebtn btnekomn">Subscribe</button>
                                </label>
                            </div>
                            <div class="feature-value">
                                <input type="radio" class="btn-check selectplanbtn" name="options-base" id="Enterprise" autocomplete="off" value="{{salt_encrypt('8')}}" />
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
@endsection
@section('scripts')
@endsection