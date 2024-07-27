@extends('dashboard.layout.app')

@section('content')
    <div class="ek_dashboard">
        <div class="ek_content">
            @if (auth()->user()->hasRole(ROLE_BUYER))
                <div class="card ekcard pa shadow-sm">
                    <div class="cardhead">
                        <h3 class="cardtitle">View Order Details</h3>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <section class="">
                                <div class="row">
                                    <div class="col-sm-4 col-md-2">
                                        <div class="mt10">
                                            <label class="bold">eKomn Order No</label>
                                            <input type="text" class="form-control"
                                                value="{{ $orderTable->order_number }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-2">
                                        <div class="mt10">
                                            <label class="bold">Order Status</label>
                                            <input type="text" class="form-control" value="Dispatched" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-2">
                                        <div class="mt10">
                                            <label class="bold">Courier Name</label>
                                            <input type="text" class="form-control" value="DTDC" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-2">
                                        <div class="mt10">
                                            <label class="bold">Traking No</label>
                                            <input type="text" class="form-control" value="DTDC-33484181426" readonly>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section class="mt30">
                                <h4 class="subheading mb-1">Customer Details</h4>
                                <div class="orderStatus_d">
                                    <div><strong class="me-2">Full Name:</strong><span class="opacity-75">Mohd
                                            Imtyaj</span></div>
                                    <div><strong class="me-2">Email Address:</strong><span
                                            class="opacity-75">imtyaj92@outlook.com</span></div>
                                    <div><strong class="me-2">Phone No:</strong><span class="opacity-75">+91
                                            7827821676</span></div>
                                </div>
                            </section>
                            <section class="mt5">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6 mt15">
                                        <h4 class="subheading mb-1">Delivery Address</h4>
                                        <div class="addressbox">

                                            <h6 class="m-0 pb-1">Mohd Imtyaj</h6>
                                            <div>{{ $billing_address->street }}</div>
                                            <div>{{ $billing_address->city }}, {{ $billing_address->state }},
                                                {{ $billing_address->postal_code }}</div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 mt15">
                                        <h4 class="subheading mb-1">Billing Address</h4>
                                        <div class="addressbox">
                                            <h6 class="m-0 pb-1">Mohd Imtyaj</h6>
                                            <div>{{ $delivery_address->street }}</div>
                                            <div>{{ $delivery_address->city }}, {{ $delivery_address->state }},
                                                {{ $delivery_address->postal_code }}</div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section class="mt30">
                                <h4 class="subheading mb-1 d-flex-ek align-items-center">Order Summery
                                    <div class="detailSku">
                                        [<strong>SKU:</strong>
                                        <span>K5944RUR</span>
                                        <span>K5944RUR</span>
                                        <span>K5944RUR</span>]
                                    </div>
                                </h4>
                                <div class="table-responsive">
                                    <table class="payInvoiceTable">
                                        <thead>
                                            <tr>
                                                <th>Product Title</th>
                                                <th class="text-center">Stock</th>
                                                <th>SKU</th>
                                                <th class="text-center">Qty</th>
                                                <th class="text-right">Price/piece</th>
                                                <th class="text-right">GST%</th>
                                                <th class="text-right">Total Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="productTitle_t3 bold">
                                                        Dell WM126 Wireless Mouse
                                                    </div>
                                                </td>
                                                <td class="text-center">100</td>
                                                <td>K5944RUR</td>
                                                <td class="text-center">2</td>
                                                <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>80.99
                                                </td>
                                                <td class="text-right">12%</td>
                                                <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>454.54
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="productTitle_t3 bold">
                                                        Dell WM126 Wireless Mouse
                                                    </div>
                                                </td>
                                                <td class="text-center">100</td>
                                                <td>K5944RUR</td>
                                                <td class="text-center">6</td>
                                                <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>50.00
                                                </td>
                                                <td class="text-right">18%</td>
                                                <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>454.54
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="productTitle_t3 bold">
                                                        Dell WM126 Wireless Mouse
                                                    </div>
                                                </td>
                                                <td class="text-center">100</td>
                                                <td>K5944RUR</td>
                                                <td class="text-center">5</td>
                                                <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>50.00
                                                </td>
                                                <td class="text-right">12%</td>
                                                <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>454.54
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" class="text-right">Shipping Cost</td>
                                                <td class="text-right w_200_f"><i
                                                        class="fas fa-rupee-sign fs-12 me-1"></i>454.54</td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" class="text-right">GST</td>
                                                <td class="text-right w_200_f"><i
                                                        class="fas fa-rupee-sign fs-12 me-1"></i>454.54</td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" class="text-right">Other Charges
                                                    <div class="dropdown info_inline">
                                                        <i class="fas fa-info-circle opacity-50 pointer"
                                                            data-bs-toggle="dropdown" aria-expanded="false"></i>
                                                        <div class="dropdown-menu fs-13 px-2 py-1 text-muted">
                                                            Package Cost, Labour Charges & Payment Processing Fee
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-right w_200_f"><i
                                                        class="fas fa-rupee-sign fs-12 me-1"></i>454.54</td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" class="text-right bold">Total Order Cost</td>
                                                <td class="text-right w_200_f bold"><i
                                                        class="fas fa-rupee-sign fs-12 me-1"></i>454.54</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- <button class="btn CancelOrderbtn btn-sm px-2">Cancel Order</button> -->
                                <div class="text-right d-flex justify-content-end">
                                    <button class="btn CancelOrderbtn btn-sm px-3 mt10">Cancel Order</button>
                                </div>
                            </section>
                            <section class="mt20">
                                <form action="" class="eklabel_w">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <h4 class="subheading mb-2">Product feedback</h4>
                                            <div class="ek_group mb-1">
                                                <label class="eklabel align-items-center bold">Rate Us:</label>
                                                <div class="ek_f_input">
                                                    <div class="star-rating">
                                                        <span class="star active" data-value="1">&#9733;</span>
                                                        <span class="star active" data-value="2">&#9733;</span>
                                                        <span class="star active" data-value="3">&#9733;</span>
                                                        <span class="star" data-value="4">&#9733;</span>
                                                        <span class="star" data-value="5">&#9733;</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ek_group">
                                                <label class="eklabel align-items-start bold">Comment:</label>
                                                <div class="ek_f_input">
                                                    <textarea rows="3" class="form-control resizer_none" placeholder="Type here..."></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </section>
                        </div>
                    </div>
                </div>
            @endif
            <!-- view supplier ordqer -->
            @if (auth()->user()->hasRole(ROLE_SUPPLIER))
                <div class="card ekcard pa shadow-sm">
                    <div class="cardhead">
                        <h3 class="cardtitle">View Order Details</h3>
                    </div>
                    <div class="row">
                        <input type="hidden" id="orderID" value="{{ get_defined_vars()['id'] }}" name="orderID">
                        <div class="col-sm-12 col-md-12">
                            <section class="">
                                <div class="row">
                                    <div class="col-sm-4 col-md-2">
                                        <div class="mt10">
                                            <label class="bold">eKomn Order No</label>
                                            <input type="text" class="form-control" value="EK1050IND" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-2">
                                        <div class="mt10">
                                            <label class="bold">Order Status</label>
                                            <input type="text" class="form-control" value="In Progress" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-2">
                                        <div class="mt10">
                                            <label class="bold">Courier Name</label>
                                            <input type="text" class="form-control" placeholder="Enter Courier Name"
                                                value="" id="courierName" name="courierName">

                                        </div>
                                        <p id="error_courier"></p>

                                    </div>
                                    <div class="col-sm-4 col-md-2">
                                        <div class="mt10">
                                            <label class="bold">Traking No</label>
                                            <input type="text" class="form-control" placeholder="Enter Traking No"
                                                value="" id="trackingNo" name="trackingNo">
                                        </div>
                                        <p id="error_tracking"></p>

                                    </div>
                                    <div class="col-sm-4 col-md-2">
                                        <div class="mt10">
                                            <label class="bold">Order Category</label>
                                            <input type="text" class="form-control" value="Dropship" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-2">
                                        <div class="mt10">
                                            <label class="bold">Shipping Date</label>
                                            <input type="date" class="form-control" value="" id="shippingDate"
                                                name="shippingDate">

                                        </div>
                                        <p id="error_shipping_date"></p>

                                    </div>
                                    <div class="col-sm-4 col-md-2">
                                        <div class="mt10">
                                            <label class="bold">Delhivery Date</label>
                                            <input type="date" class="form-control" value="" id="delhiveryDate"
                                                name="delhiveryDate">
                                        </div>
                                        <p id="error_delhivery_date"></p>

                                    </div>
                                </div>
                            </section>
                            <section class="mt30">
                                <h4 class="subheading mb-1">Customer Details</h4>
                                <div class="orderStatus_d">
                                    <div><strong class="me-2">Full Name:</strong><span class="opacity-75">Mohd
                                            Imtyaj</span></div>
                                    <div><strong class="me-2">Email Address:</strong><span
                                            class="opacity-75">imtyaj92@outlook.com</span></div>
                                    <div><strong class="me-2">Phone No:</strong><span class="opacity-75">+91
                                            7827821676</span></div>
                                </div>
                            </section>
                            <section class="mt5">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6 mt15">
                                        <h4 class="subheading mb-1">Delivery Address</h4>
                                        <div class="addressbox">
                                            <h6 class="m-0 pb-1">Mohd Imtyaj</h6>
                                            <div>HN. 564, Second floor, Houshing board colony, Sector 17A</div>
                                            <div>Grugram, Haryana, 122001</div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 mt15">
                                        <h4 class="subheading mb-1">Billing Address</h4>
                                        <div class="addressbox">
                                            <h6 class="m-0 pb-1">Mohd Imtyaj</h6>
                                            <div>HN. 564, Second floor, Houshing board colony, Sector 17A</div>
                                            <div>Grugram, Haryana, 122001</div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section class="mt30">
                                <h4 class="subheading mb-1 d-flex-ek align-items-center">Order Summery
                                    <div class="detailSku">
                                        [
                                        <strong>SKU:</strong>
                                        <span>K5944RUR</span>
                                        <span>K5944RUR</span>
                                        <span>K5944RUR</span>
                                        ]
                                    </div>
                                </h4>
                                <div class="table-responsive">
                                    <table class="payInvoiceTable">
                                        <thead>
                                            <tr>
                                                <th>Product Title</th>
                                                <th class="text-center">Stock</th>
                                                <th>SKU</th>
                                                <th class="text-center">Qty</th>
                                                <th class="text-right">Price/piece</th>
                                                <th class="text-right">GST%</th>
                                                <th class="text-right">Total Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="productTitle_t3 bold">
                                                        Dell WM126 Wireless Mouse
                                                    </div>
                                                </td>
                                                <td class="text-center">100</td>
                                                <td>K5944RUR</td>
                                                <td class="text-center">2</td>
                                                <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>80.99
                                                </td>
                                                <td class="text-right">12%</td>
                                                <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>454.54
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="productTitle_t3 bold">
                                                        Dell WM126 Wireless Mouse
                                                    </div>
                                                </td>
                                                <td class="text-center">100</td>
                                                <td>K5944RUR</td>
                                                <td class="text-center">6</td>
                                                <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>50.00
                                                </td>
                                                <td class="text-right">18%</td>
                                                <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>454.54
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="productTitle_t3 bold">
                                                        Dell WM126 Wireless Mouse
                                                    </div>
                                                </td>
                                                <td class="text-center">100</td>
                                                <td>K5944RUR</td>
                                                <td class="text-center">5</td>
                                                <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>50.00
                                                </td>
                                                <td class="text-right">12%</td>
                                                <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>454.54
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" class="text-right">Shipping Cost</td>
                                                <td class="text-right w_200_f"><i
                                                        class="fas fa-rupee-sign fs-12 me-1"></i>454.54</td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" class="text-right">GST</td>
                                                <td class="text-right w_200_f"><i
                                                        class="fas fa-rupee-sign fs-12 me-1"></i>454.54</td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" class="text-right">Other Charges
                                                    <div class="dropdown info_inline">
                                                        <i class="fas fa-info-circle opacity-50 pointer"
                                                            data-bs-toggle="dropdown" aria-expanded="false"></i>
                                                        <div class="dropdown-menu fs-13 px-2 py-1 text-muted">
                                                            Package Cost, Labour Charges & Payment Processing Fee
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-right w_200_f"><i
                                                        class="fas fa-rupee-sign fs-12 me-1"></i>454.54</td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" class="text-right bold">Total Order Cost</td>
                                                <td class="text-right w_200_f bold"><i
                                                        class="fas fa-rupee-sign fs-12 me-1"></i>454.54</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-right d-flex justify-content-end mt10">
                                    <button type="button" class="btn  btn-primary btn-sm px-2 ml-5"
                                        id="updateOrder">Update Order</button>
                                    <button class="btn CancelOrderbtn btn-sm px-2">Cancel Order</button>
                                </div>
                            </section>
                            <section class="mt30">
                                <form action="" class="eklabel_w">
                                    <h4 class="subheading mb-2">Product feedback</h4>
                                    <div class="ek_group mb-1">
                                        <label class="eklabel align-items-center bold">Rate Us:</label>
                                        <div class="ek_f_input">
                                            <div class="star-rating">
                                                <span class="star active" data-value="1">&#9733;</span>
                                                <span class="star active" data-value="2">&#9733;</span>
                                                <span class="star active" data-value="3">&#9733;</span>
                                                <span class="star" data-value="4">&#9733;</span>
                                                <span class="star" data-value="5">&#9733;</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ek_group">
                                        <label class="eklabel align-items-start bold">Comment:</label>
                                        <div class="ek_f_input">
                                            <textarea rows="3" class="form-control w_400_f resizer_none" placeholder="Type here..."></textarea>
                                        </div>
                                    </div>
                                </form>
                            </section>
                        </div>
                    </div>
                </div>
            @endif
            <!-- view admin order -->
            @if (auth()->user()->hasRole(ROLE_ADMIN))
                <div class="card ekcard pa shadow-sm">
                    <div class="cardhead">
                        <h3 class="cardtitle">View Order Details</h3>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <section class="">
                                <div class="row">
                                    <div class="col-sm-4 col-md-2">
                                        <div class="mt10">
                                            <label class="bold">eKomn Order No</label>
                                            <input type="text" class="form-control" value="EK1050IND" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-2">
                                        <div class="mt10">
                                            <label class="bold">Order Status</label>
                                            <input type="text" class="form-control" value="Dispatched" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-2">
                                        <div class="mt10">
                                            <label class="bold">Courier Name</label>
                                            <input type="text" class="form-control" placeholder="Enter Courier Name">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-2">
                                        <div class="mt10">
                                            <label class="bold">Traking No</label>
                                            <input type="text" class="form-control" placeholder="Enter Traking No">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-2">
                                        <div class="mt10">
                                            <label class="bold">Order Category</label>
                                            <input type="text" class="form-control" value="Dropship" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-2">
                                        <div class="mt10">
                                            <label class="bold">Order Type</label>
                                            <input type="text" class="form-control" value="Manual Order" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-2">
                                        <div class="mt10">
                                            <label class="bold">Supplier ID</label>
                                            <input type="text" class="form-control" placeholder="Enter Supplier ID">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-2">
                                        <div class="mt10">
                                            <label class="bold">Business Buyer ID</label>
                                            <input type="text" class="form-control" placeholder="Business Buyer ID">
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section class="mt30">
                                <h4 class="subheading mb-1">Customer Details</h4>
                                <div class="orderStatus_d">
                                    <div><strong class="me-2">Full Name:</strong><span class="opacity-75">Mohd
                                            Imtyaj</span></div>
                                    <div><strong class="me-2">Email Address:</strong><span
                                            class="opacity-75">imtyaj92@outlook.com</span></div>
                                    <div><strong class="me-2">Phone No:</strong><span class="opacity-75">+91
                                            7827821676</span></div>
                                </div>
                            </section>
                            <section class="mt5">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6 mt15">
                                        <h4 class="subheading mb-1">Delivery Address</h4>
                                        <div class="addressbox">
                                            <h6 class="m-0 pb-1">Mohd Imtyaj</h6>
                                            <div>HN. 564, Second floor, Houshing board colony, Sector 17A</div>
                                            <div>Grugram, Haryana, 122001</div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 mt15">
                                        <h4 class="subheading mb-1">Billing Address</h4>
                                        <div class="addressbox">
                                            <h6 class="m-0 pb-1">Mohd Imtyaj</h6>
                                            <div>HN. 564, Second floor, Houshing board colony, Sector 17A</div>
                                            <div>Grugram, Haryana, 122001</div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section class="mt30">
                                <h4 class="subheading mb-1 d-flex-ek align-items-center">Order Summery
                                    <div class="detailSku">
                                        [
                                        <strong>SKU:</strong>
                                        <span>K5944RUR</span>
                                        <span>K5944RUR</span>
                                        <span>K5944RUR</span>
                                        ]
                                    </div>
                                </h4>
                                <div class="table-responsive">
                                    <table class="payInvoiceTable">
                                        <thead>
                                            <tr>
                                                <th>Product Title</th>
                                                <th class="text-center">Stock</th>
                                                <th>SKU</th>
                                                <th class="text-center">Qty</th>
                                                <th class="text-right">Price/piece</th>
                                                <th class="text-right">GST%</th>
                                                <th class="text-right">Total Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="productTitle_t3 bold">
                                                        Dell WM126 Wireless Mouse
                                                    </div>
                                                </td>
                                                <td class="text-center">100</td>
                                                <td>K5944RUR</td>
                                                <td class="text-center">2</td>
                                                <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>80.99
                                                </td>
                                                <td class="text-right">12%</td>
                                                <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>454.54
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="productTitle_t3 bold">
                                                        Dell WM126 Wireless Mouse
                                                    </div>
                                                </td>
                                                <td class="text-center">100</td>
                                                <td>K5944RUR</td>
                                                <td class="text-center">6</td>
                                                <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>50.00
                                                </td>
                                                <td class="text-right">18%</td>
                                                <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>454.54
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="productTitle_t3 bold">
                                                        Dell WM126 Wireless Mouse
                                                    </div>
                                                </td>
                                                <td class="text-center">100</td>
                                                <td>K5944RUR</td>
                                                <td class="text-center">5</td>
                                                <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>50.00
                                                </td>
                                                <td class="text-right">12%</td>
                                                <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>454.54
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" class="text-right">Shipping Cost</td>
                                                <td class="text-right w_200_f"><i
                                                        class="fas fa-rupee-sign fs-12 me-1"></i>454.54</td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" class="text-right">GST</td>
                                                <td class="text-right w_200_f"><i
                                                        class="fas fa-rupee-sign fs-12 me-1"></i>454.54</td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" class="text-right">Other Charges
                                                    <div class="dropdown info_inline">
                                                        <i class="fas fa-info-circle opacity-50 pointer"
                                                            data-bs-toggle="dropdown" aria-expanded="false"></i>
                                                        <div class="dropdown-menu fs-13 px-2 py-1 text-muted">
                                                            Package Cost, Labour Charges & Payment Processing Fee
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-right w_200_f"><i
                                                        class="fas fa-rupee-sign fs-12 me-1"></i>454.54</td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" class="text-right bold">Total Order Cost</td>
                                                <td class="text-right w_200_f bold"><i
                                                        class="fas fa-rupee-sign fs-12 me-1"></i>454.54</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-right d-flex justify-content-end mt10">
                                    <button class="btn CancelOrderbtn btn-sm px-2">Cancel Order</button>
                                </div>
                            </section>
                            <section class="mt30">
                                <form action="" class="eklabel_w">
                                    <h4 class="subheading mb-2">Product feedback</h4>
                                    <div class="ek_group mb-1">
                                        <label class="eklabel align-items-center bold">Rate Us:</label>
                                        <div class="ek_f_input">
                                            <div class="star-rating">
                                                <span class="star active" data-value="1">&#9733;</span>
                                                <span class="star active" data-value="2">&#9733;</span>
                                                <span class="star active" data-value="3">&#9733;</span>
                                                <span class="star" data-value="4">&#9733;</span>
                                                <span class="star" data-value="5">&#9733;</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ek_group">
                                        <label class="eklabel align-items-start bold">Comment:</label>
                                        <div class="ek_f_input">
                                            <textarea rows="3" class="form-control w_400_f resizer_none" placeholder="Type here..."></textarea>
                                        </div>
                                    </div>
                                </form>
                            </section>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        @include('dashboard.layout.copyright')
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const stars = document.querySelectorAll('.star');

            stars.forEach(star => {
                star.addEventListener('click', () => {
                    const rating = parseInt(star.getAttribute('data-value'));
                    stars.forEach((s, index) => {
                        if (index < rating) {
                            s.classList.add('active');
                        } else {
                            s.classList.remove('active');
                        }
                    });
                });

                star.addEventListener('mouseover', () => {
                    const rating = parseInt(star.getAttribute('data-value'));
                    stars.forEach((s, index) => {
                        if (index < rating) {
                            s.classList.add('hover');
                        } else {
                            s.classList.remove('hover');
                        }
                    });
                });

                star.addEventListener('mouseout', () => {
                    stars.forEach(s => {
                        s.classList.remove('hover');
                    });
                });
            });
        });
        $(document).ready(function() {
            $("#updateOrder").on('click', function() {
                var courierName = $("#courierName").val();
                var trackingNo = $("#trackingNo").val();
                var shippingDate = $("#shippingDate").val();
                var delhiveryDate = $("#delhiveryDate").val();
                var orderID = $('#orderID').val();

                if (courierName == '') {
                    $("#error_courier").html('This Field is Required');
                    $("#error_courier").css('color', 'red');
                }
                if (trackingNo == '') {
                    $("#error_tracking").html('This Field is Required');
                    $("#error_tracking").css('color', 'red');
                }
                if (shippingDate == '') {
                    $("#error_shipping_date").html('This Field is Required');
                    $("#error_shipping_date").css('color', 'red');
                }
                if (delhiveryDate == '') {
                    $("#error_delhivery_date").html('This Field is Required');
                    $("#error_delhivery_date").css('color', 'red');

                }
                const body = {
                    courierName: courierName,
                    trackingNo: trackingNo,
                    shippingDate: shippingDate,
                    delhiveryDate: delhiveryDate,
                    orderID: orderID,

                }
                if (courierName != '' && trackingNo != '' && shippingDate != '' && delhiveryDate != '' &&
                    orderID != '') {
                    ApiRequest("update-order", 'POST', body).then(response => {
                        console.log(response);
                        if (response.data.statusCode) {
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
                            });
                        }

                    }).catch(error => {
                        console.error(error);

                    });
                }
            });
        });
    </script>
@endsection
