@extends('dashboard.layout.app')
@section('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection
@section('content')
    <div class="ek_dashboard">
        <div class="ek_content">
        <input type="hidden" id="orderID" value="{{ salt_encrypt($myOrderId) }}" name="orderID">
        @if (auth()->user()->hasRole(ROLE_BUYER))
                <div class="card ekcard pa shadow-sm">
                    <div class="cardhead d-flex justify-content-between align-items-center">
                        <h3 class="cardtitle">View Order Details</h3>
                        <div class="text-end">
                            <h4 class="subheading">Last Update - Activity/Order Tracking</h4>
                            <span class="fs-15">{{$orderUpdate->updated_at->toDateString()}} - ({{$orderUpdate->updated_at->diffForHumans()}})</span>
                        </div>
                     </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <section class="">
                                <div class="row">
                                    <div class="col-sm-4 col-md-2">
                                        <div class="mt10">
                                            <label class="bold">eKomn Order No</label>
                                            <input type="text" class="form-control" value="{{$orderUpdate->order_number}}" disabled>
                                        </div>
                                    </div>

                                    <div class="col-sm-4 col-md-2">
                                        <div class="mt10">
                                            <label class="bold">Store Order</label>
                                            <input type="text" class="form-control" value="{{$orderUpdate->store_order}}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-2">
                                        <div class="mt10">
                                            <label class="bold">Order Date</label>
                                            <input type="text" class="form-control" value="{{$orderUpdate->order_date->format('d-m-Y')}}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-2">
                                        <div class="mt10">
                                            <label class="bold">Order Status</label>
                                            <input type="text" class="form-control" value="{{$orderUpdate->getStatus()}}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-2">
                                        <div class="mt10">
                                            <label class="bold">Courier Name</label>
                                            @isset($shipment)
                                            <select class="form-select" id="courier_id" name="courier_id" disabled>
                                                <option value="">Select Courier</option>
                                                @if($courierList->isNotEmpty())
                                                @foreach($courierList as $courier)
                                                @if($courier->id == $shipment->courier_id)
                                                <option selected value="{{$courier->id}}">{{$courier->courier_name}}</option>
                                                @else
                                                <option value="{{$courier->id}}">{{$courier->courier_name}}</option>
                                                @endif
                                                @endforeach
                                                @endif
                                            </select>
                                            @else
                                            <select class="form-select" id="courier_id" name="courier_id" disabled>
                                                <option value="">Select Courier</option>
                                                @if($courierList->isNotEmpty())
                                                @foreach($courierList as $courier)
                                                <option value="{{$courier->id}}">{{$courier->courier_name}}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                            @endif
                                        </div>
                                        <p id="error_courier"></p>

                                    </div>

                                    @isset($courier_detatils)
                                    <div class="col-sm-4 col-md-2" id="show_courier">
                                        <div class="mt10">
                                            <label class="bold">Other Courier Name</label>
                                            <input type="text" class="form-control" placeholder="Enter Courier Name"
                                            id="courierName" name="courierName" value="{{$courier_detatils->courier_provider_name}}" disabled>
                                        </div>
                                        <p id="error_courier_text"></p>
                                    </div>
                                    @else
                                    <div class="col-sm-4 col-md-2" id="show_courier">
                                        <div class="mt10">
                                            <label class="bold">Other Courier Name</label>
                                            <input type="text" class="form-control" placeholder="Enter Courier Name"
                                            id="courierName" name="courierName">
                                        </div>
                                        <p id="error_courier_text"></p>
                                    </div>
                                    @endif
                                    <div class="col-sm-4 col-md-2">
                                        <div class="mt10">
                                            <label class="bold">Traking No</label>
                                            @isset($courier_detatils)
                                            <input type="text" class="form-control" placeholder="Enter Traking No"
                                            value="{{$courier_detatils->awb_number}}" id="trackingNo" name="trackingNo" disabled>
                                            @else
                                            <input type="text" class="form-control" placeholder="Enter Traking No"
                                                value="" id="trackingNo" name="trackingNo" disabled>
                                            @endif
                                        </div>
                                        <p id="error_tracking"></p>

                                    </div>
                                </div>
                            </section>
                            @if(!empty($orderUpdate->orderCancellations->reason))
                            <section class="mt20">
                                <div class="alert alert-warning p-2" role="alert">
                                <h5 class="subheading m-0 text-danger mb-1">Cancellation Reson</h5> {{$orderUpdate->orderCancellations->reason}}
                            </div>
                            </section>
                            @endif
                            <section class="mt30">
                                <h4 class="subheading mb-1">Customer Details</h4>
                                <div class="orderStatus_d">
                                    <div><strong class="me-2">Full Name:</strong><span class="opacity-75">{{$orderUpdate->full_name}}</span></div>
                                    <div><strong class="me-2">Email Address:</strong><span
                                            class="opacity-75">{{$orderUpdate->email}}</span></div>
                                    <div><strong class="me-2">Phone No:</strong><span class="opacity-75">{{$orderUpdate->mobile_number}}</span></div>
                                </div>
                            </section>
                            <section class="mt5">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6 mt15">
                                        <h4 class="subheading mb-1">Delivery Address</h4>
                                        <div class="addressbox">

                                            <h6 class="m-0 pb-1">{{$orderUpdate->full_name}}</h6>
                                            <div>{{ $billing_address->street }}</div>
                                            <div>{{ $billing_address->city }}, {{ $billing_address->state }},
                                                {{ $billing_address->postal_code }}</div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 mt15">
                                        <h4 class="subheading mb-1">Billing Address</h4>
                                        <div class="addressbox">
                                            <h6 class="m-0 pb-1">{{$orderUpdate->full_name}}</h6>
                                            <div>{{ $delivery_address->street }}</div>
                                            <div>{{ $delivery_address->city }}, {{ $delivery_address->state }},
                                                {{ $delivery_address->postal_code }}</div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section class="mt30">
                                <h4 class="subheading mb-1 d-flex-ek align-items-center justify-content-between">
                                    <div class="d-flex-ek align-items-center gap-2">Order Summery
                                    <div class="detailSku">
                                        [
                                        <strong>SKU:</strong>
                                        @if($orderUpdate->orderItemsCharges->isNotEmpty())
                                        @foreach($orderUpdate->orderItemsCharges as $orderItem)
                                        <span>{{$orderItem->product->sku}},</span>
                                        @endforeach
                                        @endif
                                        ]
                                    </div>
                                    </div>
                                    @if($orderUpdate->isDropship() || $orderUpdate->isResell())
                                    <button class="btn CancelOrderbtn btn-sm px-2" onclick="downloadInvoice('{{salt_encrypt($orderUpdate->id)}}')">Download Invoice</button> 
                                    @endif
                                </h4>
                                <div class="table-responsive">
                                    <table class="payInvoiceTable">
                                        <thead>
                                            <tr>
                                                <th>Product Title</th>
                                                <th>SKU</th>
                                                <th class="text-center">HSN</th>
                                                <th class="text-center">Qty</th>
                                                <th class="text-right">Price/piece</th>
                                                <th class="text-right">GST%</th>
                                                <th class="text-right">GST Amount</th>
                                                <th class="text-right">Total Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $shipping_charges = 0;
                                            $shipping_gst_percent = 0;
                                            $gst = 0;
                                            $other_charges = 0;
                                            $total_order_cost = 0;
                                            $shipping_cost = 0;
                                            $shiping_gst_amount = 0;
                                            $other_charges_gst = 0;
                                            $other_charges_gst_amount = 0;
                                            ?>
                                            @if($orderUpdate->orderItemsCharges->isNotEmpty())
                                            @foreach($orderUpdate->orderItemsCharges as $orderItem)
                                            @php
                                            $shipping_charges += $orderItem->shipping_charges;
                                            $shipping_gst_percent = $orderItem->shipping_gst_percent;
                                            
                                            $shiping_gst_amount = ($shipping_charges * $shipping_gst_percent / 100);
                                            $shipping_cost = $shipping_charges + $shiping_gst_amount;
                                            $gst += $orderItem->total_price_inc_gst - $orderItem->total_price_exc_gst;
                                            $other_charges += $orderItem->packing_charges + $orderItem->labour_charges + $orderItem->processing_charges + $orderItem->payment_gateway_charges;
                                            $other_charges_gst = ($orderItem->packaging_gst_percent + $orderItem->labour_gst_percent + $orderItem->processing_gst_percent + $orderItem->payment_gateway_gst_percent)/4;
                                            $other_charges_gst_amount = $other_charges / (1+($other_charges_gst/100));
                                            @endphp
                                            <tr>
                                                <td>
                                                    <div class="productTitle_t3 bold">
                                                        {{$orderItem->product->title}}
                                                    </div>
                                                </td>
                                                <td>{{$orderItem->product->sku}}</td>
                                                <td class="text-center">{{$orderItem->product->product->hsn}}</td>
                                                <td class="text-center">{{$orderItem->quantity}}</td>
                                                <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>{{$orderItem->total_price_exc_gst}}
                                                </td>
                                                <td class="text-right">{{$orderItem->gst_percentage}} %</td>
                                                <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>{{$orderItem->total_price_inc_gst - $orderItem->total_price_exc_gst}}</td>
                                                <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>{{$orderItem->total_price_inc_gst}}
                                                </td>

                                            </tr>
                                            @endforeach
                                            @endif
                                            <tr>
                                                <td colspan="9" style="padding:10px 0px!important"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-left">Shipping Cost</td>
                                                <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>{{$shipping_charges}}</td>
                                                <td class="text-right">{{$shipping_gst_percent}} %</td>
                                                <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>{{number_format($shiping_gst_amount, 2)}}</td>
                                                <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>{{$shipping_cost}}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-left">Other Charges
                                                    <div class="dropdown info_inline">
                                                        <i class="fas fa-info-circle opacity-50 pointer" data-bs-toggle="dropdown" aria-expanded="false"></i>
                                                        <div class="dropdown-menu fs-13 px-2 py-1 text-muted">
                                                            Package Cost, Labour Charges, Platform Fee & Payment Processing Fee
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>{{number_format($other_charges_gst_amount, 2)}}</td>
                                                <td class="text-right">{{number_format($other_charges_gst, 2)}}%</td>
                                                <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>{{number_format(($other_charges - $other_charges_gst_amount) ,2)}}</td>
                                                <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>{{$other_charges}}</td>
                                            </tr> 
                                      
                                            <tr>
                                                <td colspan="7" class="text-left bold">Total Order Cost</td>
                                                <td class="text-right bold"><i class="fas fa-rupee-sign fs-12 me-1"></i>{{$orderUpdate->total_amount}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-right d-flex justify-content-end mt10">
                                   
                                    @if($orderUpdate->isInProgress() || $orderUpdate->isDispatched() || $orderUpdate->isDelivered() || $orderUpdate->isInTransit() || $orderUpdate->isRTO() || $orderUpdate->isReturnFilled() || $orderUpdate->isCancelled())
                                    @else
                                    <button class="btn CancelOrderbtn btn-sm px-2" onclick="cancelOrder('{{salt_encrypt($orderUpdate->id)}}')">Cancel Order</button>
                                    @endif

                                    @if($orderUpdate->isDraft())
                                    <button class="btn btnekomn btn-sm px-2" id="payBtn"><i
                                    class="fas fa-rupee-sign fs-12 me-1"></i>{{$orderUpdate->total_amount}} Pay</button>
                                    @endif
                                </div>
                            </section>
                            @if($orderUpdate->isDelivered())    
                            @if(empty($orderUpdate->feedBack))
                            <section class="mt20">
                                <form action="#" id="ratingForm" class="eklabel_w">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <h4 class="subheading mb-2">Product feedback</h4>
                                            <div class="ek_group mb-1">
                                                <label class="eklabel align-items-center bold">Rate Us:</label>
                                                <div class="ek_f_input">
                                                    <div class="star-rating">
                                                        <span class="star" data-value="1">&#9733;</span>
                                                        <span class="star" data-value="2">&#9733;</span>
                                                        <span class="star" data-value="3">&#9733;</span>
                                                        <span class="star" data-value="4">&#9733;</span>
                                                        <span class="star" data-value="5">&#9733;</span>
                                                    </div>
                                                    <input type="hidden" name="rating" id="ratingInput">
                                                </div>
                                            </div>
                                            <div class="ek_group">
                                                <label class="eklabel align-items-start bold">Comment:</label>
                                                <div class="ek_f_input">
                                                    <textarea rows="3" name="comment" id="comment" class="form-control resizer_none" placeholder="Type here..."></textarea>
                                                </div>
                                            </div>
                                        
                                        <button type="submit" class="btn btnekomn btn-sm ml-10" id="submitRating">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </section>
                            @endif
                            @endif
                        </div>
                    </div>
                </div>
            @endif
            <!-- view supplier ordqer -->
            @if (auth()->user()->hasRole(ROLE_SUPPLIER))
                <div class="card ekcard pa shadow-sm">
                <div class="cardhead d-flex justify-content-between align-items-center">
                        <h3 class="cardtitle">View Order Details</h3>
                        <div class="text-end">
                            <h4 class="subheading">Last Update - Activity/Order Tracking</h4>
                            <span class="fs-15">{{$orderUpdate->updated_at->toDateString()}} - ({{$orderUpdate->updated_at->diffForHumans()}})</span>
                        </div>
                     </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <section class="">
                                <div class="row">
                                    <div class="col-sm-4 col-md-2">
                                        <div class="mt10">
                                            <label class="bold">eKomn Order No</label>
                                            <input type="text" class="form-control" value="{{$orderUpdate->order_number}}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-2">
                                        <div class="mt10">
                                            <label class="bold">Store Order</label>
                                            <input type="text" class="form-control" value="{{$orderUpdate->store_order}}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-2">
                                        <div class="mt10">
                                            <label class="bold">Order Date</label>
                                            <input type="text" class="form-control" value="{{$orderUpdate->order_date->format('d-m-Y')}}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-2">
                                        <div class="mt10">
                                            <label class="bold">Order Category</label>
                                            <input type="text" class="form-control" value="{{$orderUpdate->getOrderType()}}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-2">
                                        <div class="mt10">
                                            <label class="bold">Order Status</label>
                                            <input type="text" class="form-control" value="{{$orderUpdate->getStatus()}}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-2">
                                        <div class="mt10">
                                            <label class="bold">Courier Name</label>
                                            @isset($shipment)
                                            <select class="form-select" id="courier_id" name="courier_id" disabled>
                                                <option value="">Select Courier</option>
                                                @if($courierList->isNotEmpty())
                                                @foreach($courierList as $courier)
                                                @if($courier->id == $shipment->courier_id)
                                                <option selected value="{{$courier->id}}">{{$courier->courier_name}}</option>
                                                @else
                                                <option value="{{$courier->id}}">{{$courier->courier_name}}</option>
                                                @endif
                                                @endforeach
                                                @endif
                                            </select>
                                            @else
                                            <select class="form-select" id="courier_id" name="courier_id" {{$orderUpdate->isCancelled() ? 'disabled' : ''}}>
                                                <option value="">Select Courier</option>
                                                @if($courierList->isNotEmpty())
                                                @foreach($courierList as $courier)
                                                <option value="{{$courier->id}}">{{$courier->courier_name}}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                            @endif
                                        </div>
                                        <p id="error_courier"></p>

                                    </div>

                                    @isset($courier_detatils)
                                    <div class="col-sm-4 col-md-2" id="show_courier">
                                        <div class="mt10">
                                            <label class="bold">Other Courier Name</label>
                                            <input type="text" class="form-control" placeholder="Enter Courier Name"
                                            id="courierName" name="courierName" value="{{$courier_detatils->courier_provider_name}}" disabled>
                                        </div>
                                        <p id="error_courier_text"></p>
                                    </div>
                                    @else
                                    <div class="col-sm-4 col-md-2" id="show_courier">
                                        <div class="mt10">
                                            <label class="bold">Other Courier Name</label>
                                            <input type="text" class="form-control" placeholder="Enter Courier Name" {{$orderUpdate->isCancelled() ? 'disabled' : ''}}
                                            id="courierName" name="courierName">
                                        </div>
                                        <p id="error_courier_text"></p>
                                    </div>
                                    @endif
                                    <div class="col-sm-4 col-md-2">
                                        <div class="mt10">
                                            <label class="bold">Traking No</label>
                                            @isset($courier_detatils)
                                            <input type="text" class="form-control" placeholder="Enter Traking No"
                                            value="{{$courier_detatils->awb_number}}" id="trackingNo" name="trackingNo" disabled>
                                            @else
                                            <input type="text" class="form-control" placeholder="Enter Traking No" {{$orderUpdate->isCancelled() ? 'disabled' : ''}}
                                                value="" id="trackingNo" name="trackingNo">
                                            @endif
                                        </div>
                                        <p id="error_tracking"></p>

                                    </div>
                                    <div class="col-sm-4 col-md-2">
                                        <div class="mt10">
                                            <label class="bold">Shipping Date</label>
                                            @isset($courier_detatils)
                                            <input type="text" class="form-control" id="shippingDate"
                                            name="shippingDate" value="{{$shipment_date->format('d-m-Y')}}" disabled>
                                            @else
                                            <input type="text" class="form-control" id="shippingDate" {{$orderUpdate->isCancelled() ? 'disabled' : ''}}
                                                name="shippingDate">
                                            @endif

                                        </div>
                                        <p id="error_shipping_date"></p>

                                    </div>
                                    <div class="col-sm-4 col-md-2">
                                        <div class="mt10">
                                            <label class="bold">Delivery Date</label>
                                            @isset($courier_detatils)
                                            <input type="text" class="form-control"  id="deliveryDate" value="{{$delivery_date->format('d-m-Y')}}"
                                                name="deliveryDate" disabled>
                                            @else
                                            <input type="text" class="form-control" id="deliveryDate" {{$orderUpdate->isCancelled() ? 'disabled' : ''}}
                                            name="deliveryDate">
                                            @endif
                                        </div>
                                        <p id="error_delhivery_date"></p>

                                    </div>
                                </div>
                            </section>
                            @if(!empty($orderUpdate->orderCancellations->reson))
                            <section class="mt20">
                                <div class="alert alert-warning p-2" role="alert">
                                <h5 class="subheading m-0 text-danger mb-1">Cancellation Reson</h5> {{$orderUpdate->orderCancellations->reason}}
                            </div>
                            </section>
                            @endif
                            <section class="mt30">
                                <h4 class="subheading mb-1">Customer Details</h4>
                                @if($orderUpdate->isDropship())
                                <div class="orderStatus_d">
                                    <div><strong class="me-2">Full Name:</strong><span class="opacity-75">{{$orderUpdate->full_name}}</span></div>
                                    <div><strong class="me-2">Email Address:</strong><span
                                            class="opacity-75">{{$orderUpdate->email}}</span></div>
                                    <div><strong class="me-2">Phone No:</strong><span class="opacity-75">+91-{{$orderUpdate->mobile_number}}</span></div>
                                </div>
                                @else
                                <div class="orderStatus_d">
                                    <div><strong class="me-2">Full Name:</strong><span class="opacity-75">{{$orderUpdate->full_name}}</span></div>
                                    <div><strong class="me-2">Email Address:</strong><span
                                            class="opacity-75">support@ekomn.com</span></div>
                                    <div><strong class="me-2">Phone No:</strong><span class="opacity-75">+91-xxx-xxx-xxxx</span></div>
                                </div>
                                @endif
                            </section>
                            <section class="mt5">
                                <div class="row">
                                     <div class="col-sm-12 col-md-6 mt15">
                                        <h4 class="subheading mb-1">Delivery Address</h4>
                                        <div class="addressbox">
                                            <h6 class="m-0 pb-1">{{$orderUpdate->full_name}}</h6>
                                            <div>{{ $billing_address->street }}</div>
                                            <div>{{ $billing_address->city }}, {{ $billing_address->state }},
                                                {{ $billing_address->postal_code }}</div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 mt15">
                                        <h4 class="subheading mb-1">Billing Address</h4>
                                        <div class="addressbox">
                                            <h6 class="m-0 pb-1">{{$orderUpdate->full_name}}</h6>
                                            <div>{{ $delivery_address->street }}</div>
                                            <div>{{ $delivery_address->city }}, {{ $delivery_address->state }},
                                                {{ $delivery_address->postal_code }}</div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section class="mt30">
                                <h4 class="subheading mb-1 d-flex-ek align-items-center justify-content-between">
                                    <div class="d-flex-ek align-items-center gap-2">Order Summery
                                    <div class="detailSku">
                                        [
                                        <strong>SKU:</strong>
                                        @if($orderUpdate->orderItemsCharges->isNotEmpty())
                                        @foreach($orderUpdate->orderItemsCharges as $orderItem)
                                        <span>{{$orderItem->product->sku}},</span>
                                        @endforeach
                                        @endif
                                        ]
                                    </div>
                                    </div>
                                    @if($orderUpdate->isDropship() || $orderUpdate->isResell())
                                    <button class="btn CancelOrderbtn btn-sm px-2" onclick="downloadInvoice('{{salt_encrypt($orderUpdate->id)}}')">Download Invoice</button> 
                                    @endif
                                </h4>
                                <div class="table-responsive">
                                    <table class="payInvoiceTable">
                                        <thead>
                                            <tr>
                                                <th>Product Title</th>
                                                <th>SKU</th>
                                                <th class="text-center">HSN</th>
                                                <th class="text-center">Qty</th>
                                                <th class="text-right">Price/piece</th>
                                                <th class="text-right">GST%</th>
                                                <th class="text-right">GST Amount</th>
                                                <th class="text-right">Total Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $shipping_charges = 0;
                                            $shipping_gst_percent = 0;
                                            $gst = 0;
                                            $other_charges = 0;
                                            $total_order_cost = 0;
                                            $shipping_cost = 0;
                                            $shiping_gst_amount = 0;
                                            $other_charges_gst = 0;
                                            $other_charges_gst_amount = 0;
                                            ?>
                                            @if($orderUpdate->orderItemsCharges->isNotEmpty())
                                            @foreach($orderUpdate->orderItemsCharges as $orderItem)
                                            @php
                                            $shipping_charges += $orderItem->shipping_charges;
                                            $shipping_gst_percent = $orderItem->shipping_gst_percent;
                                            
                                            $shiping_gst_amount = ($shipping_charges * $shipping_gst_percent / 100);
                                            $shipping_cost = $shipping_charges + $shiping_gst_amount;
                                            $gst += $orderItem->total_price_inc_gst - $orderItem->total_price_exc_gst;
                                            $other_charges += $orderItem->packing_charges + $orderItem->labour_charges + $orderItem->processing_charges + $orderItem->payment_gateway_charges;
                                            $other_charges_gst = ($orderItem->packaging_gst_percent + $orderItem->labour_gst_percent + $orderItem->processing_gst_percent + $orderItem->payment_gateway_gst_percent)/4;
                                            $other_charges_gst_amount = $other_charges / (1+($other_charges_gst/100));
                                            @endphp
                                            <tr>
                                                <td>
                                                    <div class="productTitle_t3 bold">
                                                        {{$orderItem->product->title}}
                                                    </div>
                                                </td>
                                                <td>{{$orderItem->product->sku}}</td>
                                                <td class="text-center">{{$orderItem->product->product->hsn}}</td>
                                                <td class="text-center">{{$orderItem->quantity}}</td>
                                                <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>{{$orderItem->total_price_exc_gst}}
                                                </td>
                                                <td class="text-right">{{$orderItem->gst_percentage}} %</td>
                                                <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>{{$orderItem->total_price_inc_gst - $orderItem->total_price_exc_gst}}</td>
                                                <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>{{$orderItem->total_price_inc_gst}}
                                                </td>

                                            </tr>
                                            @endforeach
                                            @endif
                                            <tr>
                                                <td colspan="9" style="padding:10px 0px!important"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-left">Shipping Cost</td>
                                                <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>{{$shipping_charges}}</td>
                                                <td class="text-right">{{$shipping_gst_percent}} %</td>
                                                <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>{{number_format($shiping_gst_amount, 2)}}</td>
                                                <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>{{$shipping_cost}}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-left">Other Charges
                                                    <div class="dropdown info_inline">
                                                        <i class="fas fa-info-circle opacity-50 pointer" data-bs-toggle="dropdown" aria-expanded="false"></i>
                                                        <div class="dropdown-menu fs-13 px-2 py-1 text-muted">
                                                            Package Cost, Labour Charges, Platform Fee & Payment Processing Fee
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>{{number_format($other_charges_gst_amount, 2)}}</td>
                                                <td class="text-right">{{number_format($other_charges_gst, 2)}}%</td>
                                                <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>{{number_format(($other_charges - $other_charges_gst_amount) ,2)}}</td>
                                                <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>{{$other_charges}}</td>
                                            </tr> 
                                      
                                            <tr>
                                                <td colspan="7" class="text-left bold">Total Order Cost</td>
                                                <td class="text-right bold"><i class="fas fa-rupee-sign fs-12 me-1"></i>{{$orderUpdate->total_amount}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-right d-flex justify-content-end mt10">
                                    @if($orderUpdate->isDispatched() || $orderUpdate->isDelivered() || $orderUpdate->isInTransit() || $orderUpdate->isRTO() || $orderUpdate->isReturnFilled() || $orderUpdate->isCancelled())
                                    @else
                                    <button type="button" class="btn btn-primary btn-sm ml-10"  id="updateOrder">Update Order</button>
                                    <button class="btn CancelOrderbtn btn-sm px-2" onclick="cancelOrder('{{salt_encrypt($orderUpdate->id)}}')">Cancel Order</button>
                                    @endif
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            @endif
            <!-- view admin order -->

 
 
 
 @if (auth()->user()->hasRole(ROLE_ADMIN) || auth()->user()->hasRole(ROLE_SUB_ADMIN))
                <div class="card ekcard pa shadow-sm">
                <div class="cardhead d-flex justify-content-between align-items-center">
                        <h3 class="cardtitle">View Order Details</h3>
                        <div class="text-end">
                            <h4 class="subheading">Last Update - Activity/Order Tracking</h4>
                            <span class="fs-15">{{$orderUpdate->updated_at->toDateString()}} - ({{$orderUpdate->updated_at->diffForHumans()}})</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <section class="">
                                <div class="row">
                                <div class="col-sm-4 col-md-2">
                                        <div class="mt10">
                                            <label class="bold">eKomn Order No</label>
                                            <input type="text" class="form-control" value="{{$orderUpdate->order_number}}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-2">
                                        <div class="mt10">
                                            <label class="bold">Store Order</label>
                                            <input type="text" class="form-control" value="{{$orderUpdate->store_order}}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-2">
                                        <div class="mt10">
                                            <label class="bold">Order Date</label>
                                            <input type="text" class="form-control" value="{{$orderUpdate->order_date->format('d-m-Y')}}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-2">
                                        <div class="mt10">
                                            <label class="bold">Order Category</label>
                                            <input type="text" class="form-control" value="{{$orderUpdate->getOrderType()}}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-2">
                                        <div class="mt10">
                                            <label class="bold">Order Status</label>
                                            <input type="text" class="form-control" value="{{$orderUpdate->getStatus()}}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-2">
                                        <div class="mt10">
                                            <label class="bold">Courier Name</label>
                                            @isset($shipment)
                                            @if($orderUpdate->isDispatched() || $orderUpdate->isInTransit())
                                            <select class="form-select" id="courier_id" name="courier_id">
                                                <option value="">Select Courier</option>
                                                @if($courierList->isNotEmpty())
                                                @foreach($courierList as $courier)
                                                @if($courier->id == $shipment->courier_id)
                                                <option selected value="{{$courier->id}}">{{$courier->courier_name}}</option>
                                                @else
                                                <option value="{{$courier->id}}">{{$courier->courier_name}}</option>
                                                @endif
                                                @endforeach
                                                @endif
                                            </select>
                                            @else
                                            <select class="form-select" id="courier_id" name="courier_id" disabled>
                                                <option value="">Select Courier</option>
                                                @if($courierList->isNotEmpty())
                                                @foreach($courierList as $courier)
                                                @if($courier->id == $shipment->courier_id)
                                                <option selected value="{{$courier->id}}">{{$courier->courier_name}}</option>
                                                @else
                                                <option value="{{$courier->id}}">{{$courier->courier_name}}</option>
                                                @endif
                                                @endforeach
                                                @endif
                                            </select>
                                            @endif
                                            @else
                                            <select class="form-select" id="courier_id" name="courier_id" {{$orderUpdate->isCancelled() ? 'disabled' : ''}}>
                                                <option value="">Select Courier</option>
                                                @if($courierList->isNotEmpty())
                                                @foreach($courierList as $courier)
                                                <option value="{{$courier->id}}">{{$courier->courier_name}}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                            @endif
                                        </div>
                                        <p id="error_courier"></p>

                                    </div>

                                    @isset($courier_detatils)
                                    @if($orderUpdate->isDispatched() || $orderUpdate->isInTransit())
                                    <div class="col-sm-4 col-md-2" id="show_courier">
                                        <div class="mt10">
                                            <label class="bold">Other Courier Name</label>
                                            <input type="text" class="form-control" placeholder="Enter Courier Name"
                                            id="courierName" name="courierName" value="{{$courier_detatils->courier_provider_name}}">
                                        </div>
                                        <p id="error_courier_text"></p>
                                    </div>
                                    @else
                                    <div class="col-sm-4 col-md-2" id="show_courier">
                                        <div class="mt10">
                                            <label class="bold">Other Courier Name</label>
                                            <input type="text" class="form-control" placeholder="Enter Courier Name"
                                            id="courierName" name="courierName" value="{{$courier_detatils->courier_provider_name}}" disabled>
                                        </div>
                                        <p id="error_courier_text"></p>
                                    </div>
                                    @endif
                                    @else
                                    <div class="col-sm-4 col-md-2" id="show_courier">
                                        <div class="mt10">
                                            <label class="bold">Other Courier Name</label>
                                            <input type="text" class="form-control" placeholder="Enter Courier Name" {{$orderUpdate->isCancelled() ? 'disabled' : ''}}
                                            id="courierName" name="courierName">
                                        </div>
                                        <p id="error_courier_text"></p>
                                    </div>
                                    @endif
                                    <div class="col-sm-4 col-md-2">
                                        <div class="mt10">
                                            <label class="bold">Traking No</label>
                                            @isset($courier_detatils)
                                            @if($orderUpdate->isDispatched() || $orderUpdate->isInTransit())
                                            <input type="text" class="form-control" placeholder="Enter Traking No"
                                            value="{{$courier_detatils->awb_number}}" id="trackingNo" name="trackingNo">
                                            @else
                                            <input type="text" class="form-control" placeholder="Enter Traking No"
                                            value="{{$courier_detatils->awb_number}}" id="trackingNo" name="trackingNo" disabled>
                                            @endif
                                            @else
                                            <input type="text" class="form-control" placeholder="Enter Traking No"
                                                value="" id="trackingNo" name="trackingNo" {{$orderUpdate->isCancelled() ? 'disabled' : ''}}>
                                            @endif
                                        </div>
                                        <p id="error_tracking"></p>
                                    </div>
                                    <div class="col-sm-4 col-md-2">
                                        <div class="mt10">
                                            <label class="bold">Shipping Date</label>
                                            @isset($courier_detatils)
                                            <input type="text" class="form-control" id="shippingDate"
                                            name="shippingDate" value="{{$shipment_date->format('d-m-Y')}}" disabled>
                                            @else
                                            <input type="text" class="form-control" id="shippingDate" {{$orderUpdate->isCancelled() ? 'disabled' : ''}}
                                                name="shippingDate">
                                            @endif

                                        </div>
                                        <p id="error_shipping_date"></p>

                                    </div>
                                    <div class="col-sm-4 col-md-2">
                                        <div class="mt10">
                                            <label class="bold">Delivery Date</label>
                                            @isset($courier_detatils)
                                            <input type="text" class="form-control"  id="deliveryDate" value="{{$delivery_date->format('d-m-Y')}}"
                                                name="deliveryDate" disabled>
                                            @else
                                            <input type="text" class="form-control"  id="deliveryDate"
                                            name="deliveryDate" {{$orderUpdate->isCancelled() ? 'disabled' : ''}}>
                                            @endif
                                        </div>
                                        <p id="error_delhivery_date"></p>

                                    </div>
                                    <div class="col-sm-4 col-md-2">
                                        <div class="mt10">
                                            <label class="bold">Order Type</label>
                                            <input type="text" class="form-control" value="{{$orderUpdate->getOrderChannelType()}}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-2">
                                        <div class="mt10">
                                            <label class="bold">Supplier ID</label>
                                            <input type="text" class="form-control" placeholder="Enter Supplier ID" value="{{$orderUpdate->supplier->companyDetails->company_serial_id}}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-2">
                                        <div class="mt10">
                                            <label class="bold">Business Buyer ID</label>
                                            <input type="text" class="form-control" placeholder="Business Buyer ID" value="{{$orderUpdate->buyer->companyDetails->company_serial_id}}" disabled>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            @if(!empty($orderUpdate->orderCancellations->reason))
                            <section class="mt20">
                                <div class="alert alert-warning p-2" role="alert">
                                <h5 class="subheading m-0 text-danger mb-1">Cancellation Reson</h5> {{$orderUpdate->orderCancellations->reason}}
                            </div>
                            </section>
                            @endif
                            <section class="mt30">
                                <h4 class="subheading mb-1">Customer Details</h4>
                                <div class="orderStatus_d">
                                    <div><strong class="me-2">Full Name:</strong><span class="opacity-75">{{$orderUpdate->full_name}}</span></div>
                                    <div><strong class="me-2">Email Address:</strong><span
                                            class="opacity-75">{{$orderUpdate->email}}</span></div>
                                    <div><strong class="me-2">Phone No:</strong><span class="opacity-75">+91-{{$orderUpdate->mobile_number}}</span></div>
                                </div>
                            </section>
                            <section class="mt5">
                                <div class="row">
                                     <div class="col-sm-12 col-md-6 mt15">
                                        <h4 class="subheading mb-1">Delivery Address</h4>
                                        <div class="addressbox">
                                            <h6 class="m-0 pb-1">{{$orderUpdate->full_name}}</h6>
                                            <div>{{ $billing_address->street }}</div>
                                            <div>{{ $billing_address->city }}, {{ $billing_address->state }},
                                                {{ $billing_address->postal_code }}</div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 mt15">
                                        <h4 class="subheading mb-1">Billing Address</h4>
                                        <div class="addressbox">
                                            <h6 class="m-0 pb-1">{{$orderUpdate->full_name}}</h6>
                                            <div>{{ $delivery_address->street }}</div>
                                            <div>{{ $delivery_address->city }}, {{ $delivery_address->state }},
                                                {{ $delivery_address->postal_code }}</div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section class="mt30">
                                <h4 class="subheading mb-1 d-flex-ek align-items-center justify-content-between">
                                    <div class="d-flex-ek align-items-center gap-2">Order Summery
                                    <div class="detailSku">
                                        [
                                        <strong>SKU:</strong>
                                        @if($orderUpdate->orderItemsCharges->isNotEmpty())
                                        @foreach($orderUpdate->orderItemsCharges as $orderItem)
                                        <span>{{$orderItem->product->sku}},</span>
                                        @endforeach
                                        @endif
                                        ]
                                    </div>
                                    </div>
                                    @if($orderUpdate->isDropship() || $orderUpdate->isResell())
                                    <button class="btn CancelOrderbtn btn-sm px-2" onclick="downloadInvoice('{{salt_encrypt($orderUpdate->id)}}')">Download Invoice</button> 
                                    @endif
                                </h4>
                                <div class="table-responsive">
                                    <table class="payInvoiceTable">
                                        <thead>
                                            <tr>
                                                <th>Product Title</th>
                                                <th>SKU</th>
                                                <th class="text-center">HSN</th>
                                                <th class="text-center">Qty</th>
                                                <th class="text-right">Price/piece</th>
                                                <th class="text-right">GST%</th>
                                                <th class="text-right">GST Amount</th>
                                                <th class="text-right">Total Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $shipping_charges = 0;
                                            $shipping_gst_percent = 0;
                                            $gst = 0;
                                            $other_charges = 0;
                                            $total_order_cost = 0;
                                            $shipping_cost = 0;
                                            $shiping_gst_amount = 0;
                                            $other_charges_gst = 0;
                                            $other_charges_gst_amount = 0;
                                            ?>
                                            @if($orderUpdate->orderItemsCharges->isNotEmpty())
                                            @foreach($orderUpdate->orderItemsCharges as $orderItem)
                                            @php
                                            $shipping_charges += $orderItem->shipping_charges;
                                            $shipping_gst_percent = $orderItem->shipping_gst_percent;
                                            
                                            $shiping_gst_amount = ($shipping_charges * $shipping_gst_percent / 100);
                                            $shipping_cost = $shipping_charges + $shiping_gst_amount;
                                            $gst += $orderItem->total_price_inc_gst - $orderItem->total_price_exc_gst;
                                            $other_charges += $orderItem->packing_charges + $orderItem->labour_charges + $orderItem->processing_charges + $orderItem->payment_gateway_charges;
                                            $other_charges_gst = ($orderItem->packaging_gst_percent + $orderItem->labour_gst_percent + $orderItem->processing_gst_percent + $orderItem->payment_gateway_gst_percent)/4;
                                            $other_charges_gst_amount = $other_charges / (1+($other_charges_gst/100));
                                            @endphp
                                            <tr>
                                                <td>
                                                    <div class="productTitle_t3 bold">
                                                        {{$orderItem->product->title}}
                                                    </div>
                                                </td>
                                                <td>{{$orderItem->product->sku}}</td>
                                                <td class="text-center">{{$orderItem->product->product->hsn}}</td>
                                                <td class="text-center">{{$orderItem->quantity}}</td>
                                                <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>{{$orderItem->total_price_exc_gst}}
                                                </td>
                                                <td class="text-right">{{$orderItem->gst_percentage}} %</td>
                                                <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>{{$orderItem->total_price_inc_gst - $orderItem->total_price_exc_gst}}</td>
                                                <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>{{$orderItem->total_price_inc_gst}}
                                                </td>

                                            </tr>
                                            @endforeach
                                            @endif
                                            <tr>
                                                <td colspan="9" style="padding:10px 0px!important"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-left">Shipping Cost</td>
                                                <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>{{$shipping_charges}}</td>
                                                <td class="text-right">{{$shipping_gst_percent}} %</td>
                                                <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>{{number_format($shiping_gst_amount, 2)}}</td>
                                                <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>{{$shipping_cost}}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-left">Other Charges
                                                    <div class="dropdown info_inline">
                                                        <i class="fas fa-info-circle opacity-50 pointer" data-bs-toggle="dropdown" aria-expanded="false"></i>
                                                        <div class="dropdown-menu fs-13 px-2 py-1 text-muted">
                                                            Package Cost, Labour Charges, Platform Fee & Payment Processing Fee
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>{{number_format($other_charges_gst_amount, 2)}}</td>
                                                <td class="text-right">{{number_format($other_charges_gst, 2)}}%</td>
                                                <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>{{number_format(($other_charges - $other_charges_gst_amount) ,2)}}</td>
                                                <td class="text-right"><i class="fas fa-rupee-sign fs-12 me-1"></i>{{$other_charges}}</td>
                                            </tr> 
                                      
                                            <tr>
                                                <td colspan="7" class="text-left bold">Total Order Cost</td>
                                                <td class="text-right bold"><i class="fas fa-rupee-sign fs-12 me-1"></i>{{$orderUpdate->total_amount}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-right d-flex justify-content-end mt10">
                                    @if($orderUpdate->isDispatched() || $orderUpdate->isDelivered() || $orderUpdate->isInTransit() || $orderUpdate->isRTO() || $orderUpdate->isReturnFilled() || $orderUpdate->isCancelled())
                                    @else
                                    <button class="btn CancelOrderbtn btn-sm px-2" onclick="cancelOrder('{{salt_encrypt($orderUpdate->id)}}')">Cancel Order</button>
                                    @endif
                                    @if($orderUpdate->isDelivered()|| $orderUpdate->isRTO() || $orderUpdate->isReturnFilled() || $orderUpdate->isCancelled())
                                    @else
                                    <button type="button" class="btn btn-primary btn-sm ml-10"  id="updateOrder">Update Order</button>
                                    @endif

                                </div>
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
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>

$(document).ready(function() {
    @isset($shipment)
    @if($shipment->courier_id == 1)
    $('#show_courier').show();
    @else
    $('#show_courier').hide();
    @endif
    @else
    $('#show_courier').hide();
    @endif

    @if(!isset($courier_detatils))
    $(function() {
    const today = moment().format('DD-MM-YYYY');
    
    $('input[name="shippingDate"]').daterangepicker({
        singleDatePicker: true,    // Enables single date picker
        autoApply: true,
        opens: 'left',
        startDate: today,
        minDate: moment().startOf('day'), // Disable previous dates
        locale: {
            format: 'DD-MM-YYYY'   // Ensures the date format is consistent
        }
    },
    function(selectedDate) {
        const shippingDate = selectedDate.format('DD-MM-YYYY');
        $('input[name="shippingDate"]').val(shippingDate);
        
        // Update deliveryDate picker with the new minDate and startDate
        $('input[name="deliveryDate"]').daterangepicker({
            singleDatePicker: true,    
            autoApply: true,
            opens: 'left',
            startDate: shippingDate,
            minDate: shippingDate, // Disable dates earlier than shippingDate
            locale: {
                format: 'DD-MM-YYYY'
            }
        });
    });

    $('input[name="deliveryDate"]').daterangepicker({
            singleDatePicker: true,    
            autoApply: true,
            opens: 'left',
            startDate: today,
            minDate: moment().startOf('day'), // Disable previous dates
            locale: {
                format: 'DD-MM-YYYY'
            }
        },function(selectDate){
            const deliveryDate = selectedDate.format('DD-MM-YYYY');
            $('input[name="deliveryDate"]').val(deliveryDate);
        }
    );
});
@endif

});
        $('#courier_id').change(function() {
            var courier_id = $('#courier_id').val();
            if (courier_id == '1') {
                $('#show_courier').show();
            } else {
                $('#show_courier').hide();
            }
        });
        var ratingInput = document.getElementById('ratingInput');
        document.addEventListener('DOMContentLoaded', () => {
            const stars = document.querySelectorAll('.star');

            stars.forEach(star => {
                star.addEventListener('click', () => {
                    const rating = parseInt(star.getAttribute('data-value'));
                    stars.forEach((s, index) => {
                        if (index < rating) {
                            ratingInput.value = rating;
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
                var courier_id = $("#courier_id").val();
                var trackingNo = $("#trackingNo").val();
                var shippingDate = $("#shippingDate").val();
                var deliveryDate = $("#deliveryDate").val();
                var orderID = $('#orderID').val();
                if (trackingNo == '') {
                    $("#error_tracking").html('This Field is Required');
                    $("#error_tracking").css('color', '#dc3545');
                }else{
                    $("#error_tracking").html('');
                }
                if (shippingDate == '') {
                    $("#error_shipping_date").html('This Field is Required');
                    $("#error_shipping_date").css('color', '#dc3545');
                }else{
                    $("#error_shipping_date").html('');
                }
                if (deliveryDate == '') {
                    $("#error_delhivery_date").html('This Field is Required');
                    $("#error_delhivery_date").css('color', '#dc3545');
                }else{
                    $("#error_delhivery_date").html('');
                }
                if (courier_id == '1') {
                    if (courierName == '') {
                        $("#error_courier_text").html('This Field is Required');
                        $("#error_courier_text").css('color', '#dc3545');
                    }else{
                        $("#error_courier_text").html('');
                    }
                }else{
                    courierName ='';
                    $("#error_courier_text").html('');
                }
                const body = {
                    courierName: courierName,
                    trackingNo: trackingNo,
                    shippingDate: shippingDate,
                    deliveryDate: deliveryDate,
                    orderID: orderID,
                    courier_id: courier_id
                }
                if (courier_id != '' && trackingNo != '' && shippingDate != '' && deliveryDate != '' &&
                    orderID != '') {
                    ApiRequest("update-order", 'POST', body).then(response => {
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
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            });
                        }

                    }).catch(error => {
                        console.error(error);

                    });
                }
            });
        });




        // Cancel Order Function i want first take cancellation reason from user 
        function cancelOrder(orderId) {
          Swal.fire({
              title: "Please give the reason for cancellation.",
              input: "text",
              inputAttributes: {
                autocapitalize: "off"
              },
              showCancelButton: true,
              confirmButtonText: "Submit",
              confirmButtonColor: '#3085d6',
              showLoaderOnConfirm: true,
              didOpen: () => {
                    const title = Swal.getTitle();
                    title.style.fontSize = '25px';
                    // Apply inline CSS to the content
                    const content = Swal.getHtmlContainer();
                    const confirmButton = Swal.getConfirmButton();
                    confirmButton.style.backgroundColor = '#feca40';
                    confirmButton.style.color = 'white';
                },
              preConfirm: async (login) => {
                ApiRequest(`orders/cancel`, 'POST', {reason: login, order_id: orderId})
                .then(response => {
                    if (response.data.statusCode == 200) {
                        Swal.fire({
                            title: "Good job!",
                            text: response.data.message,
                            icon: "success",
                            didOpen: () => {
                                // Apply inline CSS to the title
                                const title = Swal.getTitle();
                                title.style.color = 'red';
                                title.style.fontSize = '20px';

                                // Apply inline CSS to the content
                                const content = Swal.getHtmlContainer();
                                //   content.style.color = 'blue';

                                // Apply inline CSS to the confirm button
                                const confirmButton = Swal.getConfirmButton();
                                confirmButton.style.backgroundColor = '#feca40';
                                confirmButton.style.color = 'white';
                            }
                        }).then(() => {
                            // Redirect to the inventory page
                            window.location.href = "{{ route('my.orders') }}";
                        });
                    } else {
                        Swal.fire({
                            title: "Error!",
                            text: response.data.message,
                            icon: "error",
                            didOpen: () => {
                                // Apply inline CSS to the title
                                const title = Swal.getTitle();
                                title.style.color = 'red';
                                title.style.fontSize = '20px';

                                // Apply inline CSS to the content
                                const content = Swal.getHtmlContainer();
                                //   content.style.color = 'blue';

                                // Apply inline CSS to the confirm button
                                const confirmButton = Swal.getConfirmButton();
                                confirmButton.style.backgroundColor = '#feca40';
                                confirmButton.style.color = 'white';
                            }
                        });
                    }
                })
              }
            });
        }

        // Api Request Function Razarpay Payment
        
        $('document').ready(function(){
            var formData = new FormData();
            $('#payBtn').on('click', function(){
                const formData = new FormData();
                formData.append('order_id', $('#orderID').val());
            ApiRequest('orders', 'POST', formData)
          .then(response => {
            if (response.data.statusCode == 200) {
              const payment = response.data.data;
              $('#order_id').val(payment.order_id);
              var options = {
                  "key": "{{env('RAZORPAY_KEY')}}", // Enter the Key ID generated from the Dashboard
                  "amount": payment.total_amount, // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
                  "currency": payment.currency,
                  "name": "{{env('APP_NAME')}}", //your business name
                  "description": "Create payment for order by Ekomn Platform",
                  "image": "{{asset('assets/images/Logo.svg')}}",
                  "order_id": payment.razorpy_order_id, //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
                  "callback_url": "{{route('order.payment.success')}}",
                  "prefill": { //We recommend using the prefill parameter to auto-fill customer's contact information especially their phone number
                      "name": payment.full_name, //your customer's name
                      "email": payment.email, //your customer's email
                      "contact": payment.mobile_number //Provide the customer's phone number for better conversion rates 
                  },
                  "notes": {
                      "address": "Gurugram, Haryana India"
                  },
                  "theme": {
                      "color": "#FECA40"
                  }
              };
              var rzp1 = new Razorpay(options);
              rzp1.open();
            }
            else if (response.data.statusCode == 422) {
                const field = response.data.key;
                $(`#${field}`).addClass('is-invalid');
                $(`#${field}Err`).text(response.data.message);
            } else if(response.data.statusCode == 201){
               // Handle error
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
          })
          .catch(error => {
            console.error(error);
          });
        });
      
    });
    

    function downloadInvoice(orderId) {
        // Make an API request to download the invoice
        fetch(`{{env('APP_URL')}}/api/download-invoice/${orderId}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            },
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.blob();
        })
        .then(blob => {
            const url = window.URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.style.display = 'none';
            link.href = url;
            link.download = `invoice_${Math.random().toString(36).substring(2)}_${Date.now()}.pdf`;
            document.body.appendChild(link);
            link.click();
            window.URL.revokeObjectURL(url);
            document.body.removeChild(link);
        })
        .catch(error => {
            console.error('Error downloading invoice:', error);
        });

        
    }
    </script>

    <script>
        $('document').ready(function(){
            var formData = new FormData();
            $('#ratingForm').submit(function(e){
                e.preventDefault();
                
                let rating = $('#ratingInput').val();
                let comment = $('#comment').val();
                let order_id = $('#orderID').val();

                formData.append('rating', rating);
                formData.append('comment', comment);
                formData.append('order_id', order_id);

                ApiRequest('rating', 'POST', formData)
                .then(response => {
                    if(response.data.statusCode == 200){
                        Swal.fire({
                            title: 'Success',
                            text: '"Thank you so much for your feedback and rating! We’re thrilled to hear that you had a positive experience."',
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
                    }
                })
                .catch(error => {
                    console.error(error);
                });
            }); 
        });
    </script>
    </script>
    </script>
@endsection
