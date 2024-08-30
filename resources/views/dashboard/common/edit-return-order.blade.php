@extends('dashboard.layout.app')
@section('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection
@section('content')
<div class="ek_dashboard">
    <div class="ek_content">
        @if(auth()->user()->hasRole(ROLE_BUYER))
            <div class="card ekcard pa shadow-sm">
                <div class="cardhead d-flex justify-content-between align-items-center">
                    <h3 class="cardtitle">Return Order</h3>
                    <div class="text-end">
                        <h4 class="subheading">Last Update Activity - {{$returnOrder->getStatus()}}</h4>
                        <span class="fs-15">{{$returnOrder->updated_at->toDateString()}} - ({{$returnOrder->updated_at->diffForHumans()}})</span>
                    </div>
                </div>
                <section class="">
                    <div class="row">
                        <div class="col-sm-12 col-md-2">
                            <div class="mt10">

                                <label class="bold">
                                    Return Request:
                                </label>
                                <div class="ek_f_input">
                                    <input type="text" class="form-control" value="{{$returnOrder->return_number}}" id="order_number" disabled />
                                    <div id="order_numberErr" class="invalid-feedback"></div>
                                </div>

                            </div>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <div class="mt10">

                                <label class="bold">
                                    <span>Order No:<span class="req_star">*</span></span>
                                </label>
                                <div class="ek_f_input">
                                    <input type="text" class="form-control" value="{{$returnOrder->order->order_number}}" id="order_number" disabled />
                                    <div id="order_numberErr" class="invalid-feedback"></div>
                                </div>

                            </div>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <div class="mt10">

                                <label class="bold">Courier Name:<span class="r_color">*</span></label>
                                <div class="ek_f_input">
                                    @isset($courier_detatils)
                                    <select class="form-select" id="courier_id" disabled>
                                        <option value="">Select Courier</option>
                                        @if($courierList->isNotEmpty())
                                        @foreach($courierList as $courier)
                                        <option value="{{$courier->id}}" @if($courier_detatils->courier_id == $courier->id) selected @endif>{{$courier->courier_name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @else
                                    <select class="form-select" id="courier_id" disabled>
                                        <option value="">Select Courier</option>
                                        @if($courierList->isNotEmpty())
                                        @foreach($courierList as $courier)
                                        <option value="{{$courier->id}}">{{$courier->courier_name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @endif
                                    <div id="reasonErr" class="invalid-feedback"></div>
                                </div>

                            </div>
                        </div>
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
                        @isset($courier_detatils)
                        <div class="col-sm-4 col-md-2" id="show_courier">
                            <div class="mt10">
                                <label class="bold">Other Courier Name</label>
                                <input type="text" class="form-control" placeholder="Enter Courier Name"
                                    id="courierName" name="courierName" value="{{$courier_detatils->provider_name}}" disabled>
                            </div>
                            <p id="error_courier_text"></p>
                        </div>
                        @else
                        <div class="col-sm-4 col-md-2" id="show_courier">
                            <div class="mt10">
                                <label class="bold">Other Courier Name</label>
                                <input type="text" class="form-control" placeholder="Enter Courier Name"
                                    id="courierName" name="courierName" disabled>
                            </div>
                            <p id="error_courier_text"></p>
                        </div>
                        @endif
                        <div class="col-sm-4 col-md-2">
                        <div class="mt10">
                            <label class="bold">Shipping Date</label>
                            @isset($courier_detatils)
                            <input type="date" class="form-control" id="shippingDate"
                            name="shippingDate" value="{{$courier_detatils->shipment_date->toDateString()}}" disabled>
                            @else
                            <input type="date" class="form-control" id="shippingDate" disabled
                                name="shippingDate">
                            @endif

                        </div>
                        <p id="error_shipping_date"></p>

                    </div>
                    <div class="col-sm-4 col-md-2">
                        <div class="mt10">
                            <label class="bold">Delivery Date</label>
                            @isset($courier_detatils)
                            <input type="date" class="form-control"  value="{{$courier_detatils->expected_delivery_date->toDateString()}}" id="deliveryDate" value=""
                                name="deliveryDate" disabled>
                            @else
                            <input type="date" class="form-control" id="deliveryDate" disabled
                            name="deliveryDate">
                            @endif
                        </div>
                        <p id="error_delhivery_date"></p>

                    </div>
                    </div>
                    <div class="row mt-5">

                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="ek_group">
                                <label class="eklabel req" style="width: 32%;">Cancellation Reason:<span class="r_color">*</span></label>
                                <div class="ek_f_input">
                                    <select class="form-select" id="reason" disabled>
                                        <option value="{{$returnOrder->reason}}" selected> {{$returnOrder->reason}} </option>
                                    </select>
                                    <div id="reasonErr" class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <div class="multi-row">Attachement:<span class="req_star">*</span>
                @if(!empty($attachment))
                    @if(!empty($attachment['image']))
                    @foreach($attachment['image'] as $key => $attach)
                    <div class="image-upload-box" id="box-{{$loop->index+1}}" >
                        <img id="img-box-{{$loop->index+1}}" src="{{asset($attach)}}" alt="Image" onclick="dowloadFile(`{{asset($attach)}}`)" />
                    </div>
                    @endforeach
                    @endif
                    @if(!empty($attachment['video']))
                    @foreach($attachment['video'] as $key => $attach)
                    <div class="video-container" onclick="dowloadFile(`{{asset($attach)}}`)">
                        <div class="video-placeholder">
                            <div style="margin: 4px 0px 2px 0px;">
                                <svg viewBox="0 0 64 64" width="38" height="38" fill="#FAFAFA">
                                    <circle cx="32" cy="32" r="32" fill="rgba(0,0,0,0.15)" />
                                    <polygon points="25,16 25,48 48,32" />
                                </svg>
                            </div>
                        </div>
                        <video class="video-element" style="display:block;">
                        <source src="{{asset($attach)}}" class="video-source" >
                        </video>
                        <div class="play-icon">
                            <svg viewBox="0 0 64 64" width="44" height="44" fill="white">
                                <circle cx="32" cy="32" r="32" fill="rgba(0,0,0,0.5)" />
                                <polygon points="25,16 25,48 48,32" />
                            </svg>
                        </div>
                    </div>
                    @endforeach
                    @endif
                @endif
                    
                </div>
                <div class="row mt-5">
                    <div class="col-sm-12 col-md-8">
                        <div class="ek_group">

                            <label class="eklabel req">
                                Comments
                            </label>
                            <div class="ek_f_input">
                                <div id="commnetBox" style="padding:10px">
                                    @if($returnOrder->returnComments->isNotEmpty())
                                    @foreach($returnOrder->returnComments as $key => $comment)
                                    @if($comment->role_type == ROLE_BUYER)
                                    @if($key > 0)
                                    <hr>
                                    @endif
                                    <div class="cardhead d-flex justify-content-between align-items-center">
                                        <h3 class="cardtitle">Buyer</h3>
                                        <div class="text-end">
                                            <span class="fs-12">{{$comment->created_at->toDateString()}} - ({{$comment->created_at->diffForHumans()}})</span>
                                        </div>
                                    </div>
                                    <div style="padding-left:10px; text-align:justify;" id="cmntContr">
                                        {{$comment->comment}}
                                    </div>
                                    @elseif($comment->role_type == ROLE_SUPPLIER)
                                    @if($key > 0)
                                    <hr>
                                    @endif
                                    <div class="cardhead d-flex justify-content-between align-items-center">
                                        <span class="fs-12">{{$comment->created_at->toDateString()}} - ({{$comment->created_at->diffForHumans()}})</span>
                                        <div class="text-end">
                                            <h4 class="cardtitle">Supplier</h4>

                                        </div>
                                    </div>
                                    <div style="padding-left:10px; text-align:justify;" id="cmntContr">
                                        {{$comment->comment}}
                                    </div>
                                    @elseif($comment->role_type == ROLE_ADMIN)
                                    @if($key > 0)
                                    <hr>
                                    @endif
                                    <div class="cardhead d-flex justify-content-between align-items-center">
                                        <h3 class="cardtitle">Admin</h3>
                                        <div class="text-end">
                                            <span class="fs-12">{{$comment->created_at->toDateString()}} - ({{$comment->created_at->diffForHumans()}})</span>
                                        </div>
                                    </div>
                                    <div style="padding-left:10px; text-align:justify;" id="cmntContr">
                                        {{$comment->comment}}
                                    </div>
                                    @endif
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-md-5">
                        <div class="ek_group">
                        <label class="eklabel req"  style="width: 32%;">
                                <span>Amount to be refund</span>
                            </label>
                            <input type="text" class="border ms-5 ps-2" disabled value="{{number_format($returnOrder->amount,2)}}">
                        </div>
                        <div class="ek_group">
                            <label class="eklabel req " style="width: 30%;">
                                <span>Select an Option:<span class="req_star">*</span></span>
                            </label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="selection" id="accept" {{$returnOrder->isAccepted() ? 'checked' : ''}} value="3" disabled>
                                <label class="form-check-label" for="accept">
                                    {{$returnOrder->isAccepted() ? $returnOrder->getStatus() : 'Accept'}}
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="selection" id="decline" {{$returnOrder->isRejected() ? 'checked ' : ''}} value="5" disabled>
                                <label class="form-check-label" for="decline">
                                    
                                    {{$returnOrder->isRejected() ? $returnOrder->getStatus() : 'Decline'}}
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="selection" id="approve"  {{$returnOrder->isApproved() ? 'checked' : ''}} value="4" disabled>
                                <label class="form-check-label" for="approve">
                                {{$returnOrder->isApproved() ? $returnOrder->getStatus() : 'Approve'}}
                                </label>
                            </div>
                        </div>

                        <div class="ek_group">
                        <div class="d-flex">

                        <div class="upload-original-invoice">
                            <label>
                                <span>
                                    Download Shipping Label<span class="req_star">*</span>
                                    @isset($courier_detatils)
                                    <button class="file-label-text btn btnekomn_dark ms-2" onclick="dowloadFile(`{{asset($courier_detatils->file_path)}}`)">Download</button>
                                    @else
                                    <button class="file-label-text btn btnekomn_dark ms-2" disabled>Download</button>
                                    @endif
                                </span>
                            </label>
                        </div>
                        </div>
                        </div>
                    </div>

                    <?php
                    $shipping_cost = 0;
                    $gst = 0;
                    $other_charges = 0;
                    $total_order_cost = 0;
                    $product = 0;
                    ?>
                    @if($returnOrder->order->orderItemsCharges->isNotEmpty())
                    @foreach($returnOrder->order->orderItemsCharges as $orderItem)
                    @php
                    $product += $orderItem->total_price_exc_gst;
                    $shipping_cost += $orderItem->shipping_charges;
                    $gst += $orderItem->total_price_inc_gst - $orderItem->total_price_exc_gst;
                    $other_charges += $orderItem->packing_charges + $orderItem->labour_charges + $orderItem->processing_charges + $orderItem->payment_gateway_charges;
                    @endphp
                    @endforeach
                    @endif
                    <div class="col-md-3">
                        <table class="table table-bordered">
                            <thead>
                                <!-- <tr>
                                    <th>Order No</th>
                                    <th>Order Date</th>
                                </tr> -->
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Product Charges</td>
                                    <td>{{number_format($product,2)}}</td>
                                </tr>
                                <tr>
                                    <td>Shipping Charges</td>
                                    <td>{{number_format($shipping_cost,2)}}</td>
                                </tr>
                                <tr>
                                    <td>Other Charges</td>
                                    <td>{{number_format($other_charges,2)}}</td>
                                </tr>
                                <tr>
                                    <td>GST Charges</td>
                                    <td>{{number_format($gst,2)}}</td>
                                </tr>
                                <tr>
                                    <td>Total Order Amount</td>
                                    <td>{{number_format($returnOrder->order->total_amount,2)}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- <div class="row mt-3">
                    <div class="col-md-6">
                        
                    </div>
                </div> -->
                <div class="row mt-5">
                    <div class="col-sm-12 col-md-8">
                        <div class="ek_group">
                            <label class="eklabel req">
                                <span>Comment:</span>
                            </label>
                            <div class="wrapperComment">
                                <div class="commentBoxfloat">
                                    <form id="cmnt">
                                        <fieldset>
                                        @if($returnOrder->isRejected() || $returnOrder->isApproved())
                                                @if($returnOrder->updated_at->diffInHours() >= 48)
                                                <div class="form_grp">
                                                <label id="comment">comment </label>
                                                <textarea id="userCmnt" placeholder="Write your comment here." disabled></textarea>
                                            </div>
                                            <div class="form_grp">
                                                <button type="button" id="comment_submit" disabled>Submit</button>
                                            </div>
                                                @else
                                                <div class="form_grp">
                                                <label id="comment">comment</label>
                                                <textarea id="userCmnt" placeholder="Write your comment here."></textarea>
                                            </div>
                                            <div class="form_grp">
                                                <button type="button" id="comment_submit">Submit</button>
                                            </div>
                                                @endif
                                            @endif
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="saveform_footer text-right single-button">
                     @if($returnOrder->isRejected() || $returnOrder->isApproved())
                     @if($returnOrder->isDisputed() || $returnOrder->isDisputeResolved() || $returnOrder->updated_at->diffInHours() >= 48)
                    <button id="btnDispute" class="btn btnekomn_dark" disabled>Dispute</button>
                    @else
                    <button id="btnDispute" class="btn btnekomn_dark">Dispute</button>
                    @endif
                    @else
                    <button id="btnDispute" class="btn btnekomn_dark" disabled>Dispute</button>
                    @endif
                </div>

            </div>
        @elseif(auth()->user()->hasRole(ROLE_SUPPLIER))
        <div class="card ekcard pa shadow-sm">
                <div class="cardhead d-flex justify-content-between align-items-center">
                    <h3 class="cardtitle">Return Order</h3>
                    <div class="text-end">
                        <h4 class="subheading">Last Update Activity - {{$returnOrder->getStatus()}}</h4>
                        <span class="fs-15">{{$returnOrder->updated_at->toDateString()}} - ({{$returnOrder->updated_at->diffForHumans()}})</span>
                    </div>
                </div>
                <section class="">
                    <div class="row">
                        <div class="col-sm-12 col-md-2">
                            <div class="mt10">

                                <label class="bold">
                                    Return Request:
                                </label>
                                <div class="ek_f_input">
                                    <input type="text" class="form-control" value="{{$returnOrder->return_number}}" id="order_number" disabled />
                                    <div id="order_numberErr" class="invalid-feedback"></div>
                                </div>

                            </div>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <div class="mt10">

                                <label class="bold">
                                    <span>Order No:<span class="req_star">*</span></span>
                                </label>
                                <div class="ek_f_input">
                                    <input type="text" class="form-control" value="{{$returnOrder->order->order_number}}" id="order_number" disabled />
                                    <div id="order_numberErr" class="invalid-feedback"></div>
                                </div>

                            </div>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <div class="mt10">

                                <label class="bold">Courier Name:<span class="r_color">*</span></label>
                                <div class="ek_f_input">
                                    @isset($courier_detatils)
                                    <select class="form-select" id="courier_id" disabled>
                                        <option value="">Select Courier</option>
                                        @if($courierList->isNotEmpty())
                                        @foreach($courierList as $courier)
                                        <option value="{{$courier->id}}" @if($courier_detatils->courier_id == $courier->id) selected @endif>{{$courier->courier_name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @else
                                    <select class="form-select" id="courier_id" {{$returnOrder->isApproved() ? 'disabled' : ''}}>
                                        <option value="">Select Courier</option>
                                        @if($courierList->isNotEmpty())
                                        @foreach($courierList as $courier)
                                        <option value="{{$courier->id}}">{{$courier->courier_name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @endif
                                    <div id="reasonErr" class="invalid-feedback"></div>
                                </div>

                            </div>
                        </div>
                        <div class="col-sm-4 col-md-2">
                            <div class="mt10">
                                <label class="bold">Traking No</label>
                                @isset($courier_detatils)
                                <input type="text" class="form-control" placeholder="Enter Traking No"
                                    value="{{$courier_detatils->awb_number}}" id="trackingNo" name="trackingNo" disabled>
                                @else
                                <input type="text" class="form-control" placeholder="Enter Traking No"
                                    value="" id="trackingNo" name="trackingNo" {{$returnOrder->isApproved() ? 'disabled' : ''}}>
                                @endif
                            </div>
                            <p id="error_tracking"></p>
                        </div>
                        @isset($courier_detatils)
                        <div class="col-sm-4 col-md-2" id="show_courier">
                            <div class="mt10">
                                <label class="bold">Other Courier Name</label>
                                <input type="text" class="form-control" placeholder="Enter Courier Name"
                                    id="courierName" name="courierName" value="{{$courier_detatils->provider_name}}" disabled>
                            </div>
                            <p id="error_courier_text"></p>
                        </div>
                        @else
                        <div class="col-sm-4 col-md-2" id="show_courier">
                            <div class="mt10">
                                <label class="bold">Other Courier Name</label>
                                <input type="text" class="form-control" placeholder="Enter Courier Name"
                                    id="courierName" name="courierName" {{$returnOrder->isApproved() ? 'disabled' : ''}}>
                            </div>
                            <p id="error_courier_text"></p>
                        </div>
                        @endif
                        <div class="col-sm-4 col-md-2">
                        <div class="mt10">
                            <label class="bold">Shipping Date</label>
                            @isset($courier_detatils)
                            <input type="text" class="form-control" id="shippingDate"
                            name="shippingDate" value="{{$courier_detatils->shipment_date->format('d-m-Y')}}" disabled>
                            @else
                            <input type="text" class="form-control" id="shippingDate"
                                name="shippingDate" {{$returnOrder->isApproved() ? 'disabled' : ''}}>
                            @endif

                        </div>
                        <p id="error_shipping_date"></p>

                    </div>
                    <div class="col-sm-4 col-md-2">
                        <div class="mt10">
                            <label class="bold">Delivery Date</label>
                            @isset($courier_detatils)
                            <input type="text" class="form-control"  value="{{$courier_detatils->expected_delivery_date->format('d-m-Y')}}" id="deliveryDate" value=""
                                name="deliveryDate" disabled>
                            @else
                            <input type="text" class="form-control" id="deliveryDate" {{$returnOrder->isApproved() ? 'disabled' : ''}}
                            name="deliveryDate">
                            @endif
                        </div>
                        <p id="error_delhivery_date"></p>

                    </div>
                    </div>
                    <div class="row mt-5">

                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="ek_group">
                                <label class="eklabel req" style="width: 32%;">Cancellation Reason:<span class="r_color">*</span></label>
                                <div class="ek_f_input">
                                    <select class="form-select" id="reason" disabled>
                                        <option value="{{$returnOrder->reason}}" selected> {{$returnOrder->reason}} </option>
                                    </select>
                                    <div id="reasonErr" class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <div class="multi-row">Attachement:<span class="req_star">*</span>
                @if(!empty($attachment))
                    @if(!empty($attachment['image']))
                    @foreach($attachment['image'] as $key => $attach)
                    <div class="image-upload-box" id="box-{{$loop->index+1}}" >
                        <img id="img-box-{{$loop->index+1}}" src="{{asset($attach)}}" alt="Image" onclick="dowloadFile(`{{asset($attach)}}`)" />
                    </div>
                    @endforeach
                    @endif
                    @if(!empty($attachment['video']))
                    @foreach($attachment['video'] as $key => $attach)
                    <div class="video-container" onclick="dowloadFile(`{{asset($attach)}}`)">
                        <div class="video-placeholder">
                            <div style="margin: 4px 0px 2px 0px;">
                                <svg viewBox="0 0 64 64" width="38" height="38" fill="#FAFAFA">
                                    <circle cx="32" cy="32" r="32" fill="rgba(0,0,0,0.15)" />
                                    <polygon points="25,16 25,48 48,32" />
                                </svg>
                            </div>
                        </div>
                        <video class="video-element" style="display:block;">
                        <source src="{{asset($attach)}}" class="video-source" >
                        </video>
                        <div class="play-icon">
                            <svg viewBox="0 0 64 64" width="44" height="44" fill="white">
                                <circle cx="32" cy="32" r="32" fill="rgba(0,0,0,0.5)" />
                                <polygon points="25,16 25,48 48,32" />
                            </svg>
                        </div>
                    </div>
                    @endforeach
                    @endif
                @endif
                    
                </div>
                <div class="row mt-5">
                    <div class="col-sm-12 col-md-8">
                        <div class="ek_group">

                            <label class="eklabel req">
                                Comments
                            </label>
                            <div class="ek_f_input">
                                <div id="commnetBox" style="padding:10px">
                                    @if($returnOrder->returnComments->isNotEmpty())
                                    @foreach($returnOrder->returnComments as $key => $comment)
                                    @if($comment->role_type == ROLE_BUYER)
                                    @if($key > 0)
                                    <hr>
                                    @endif
                                    <div class="cardhead d-flex justify-content-between align-items-center">
                                        <h3 class="cardtitle">Buyer</h3>
                                        <div class="text-end">
                                            <span class="fs-12">{{$comment->created_at->toDateString()}} - ({{$comment->created_at->diffForHumans()}})</span>
                                        </div>
                                    </div>
                                    <div style="padding-left:10px; text-align:justify;" id="cmntContr">
                                        {{$comment->comment}}
                                    </div>
                                    @elseif($comment->role_type == ROLE_SUPPLIER)
                                    @if($key > 0)
                                    <hr>
                                    @endif
                                    <div class="cardhead d-flex justify-content-between align-items-center">
                                        <span class="fs-12">{{$comment->created_at->toDateString()}} - ({{$comment->created_at->diffForHumans()}})</span>
                                        <div class="text-end">
                                            <h4 class="cardtitle">Supplier</h4>

                                        </div>
                                    </div>
                                    <div style="padding-left:10px; text-align:justify;" id="cmntContr">
                                        {{$comment->comment}}
                                    </div>
                                    @elseif($comment->role_type == ROLE_ADMIN)
                                    @if($key > 0)
                                    <hr>
                                    @endif
                                    <div class="cardhead d-flex justify-content-between align-items-center">
                                        <h3 class="cardtitle">Admin</h3>
                                        <div class="text-end">
                                            <span class="fs-12">{{$comment->created_at->toDateString()}} - ({{$comment->created_at->diffForHumans()}})</span>
                                        </div>
                                    </div>
                                    <div style="padding-left:10px; text-align:justify;" id="cmntContr">
                                        {{$comment->comment}}
                                    </div>
                                    @endif
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-md-5">
                        <div class="ek_group">
                        <label class="eklabel req"  style="width: 32%;">
                                <span>Amount to be refund</span>
                            </label>
                            <input type="text" class="border ms-5 ps-2" id="amount" value="{{number_format($returnOrder->amount,2)}}" {{$returnOrder->isApproved() ? 'disabled' : ''}}>
                        </div>
                        <div class="ek_group">
                            <label class="eklabel req " style="width: 30%;">
                                <span>Select an Option:<span class="req_star">*</span></span>
                            </label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="selection" id="accept" {{$returnOrder->isAccepted() ? 'checked' : ''}} value="3" {{($returnOrder->isApproved() || $returnOrder ->isRejected()) ? 'disabled' : ''}}>
                                <label class="form-check-label" for="accept">
                                    {{$returnOrder->isAccepted() ? $returnOrder->getStatus() : 'Accept'}}
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="selection" id="decline" {{$returnOrder->isRejected() ? 'checked ' : ''}} value="5" {{($returnOrder->isApproved() || $returnOrder ->isRejected()) ? 'disabled' : ''}}>
                                <label class="form-check-label" for="decline">
                                    
                                    {{$returnOrder->isRejected() ? $returnOrder->getStatus() : 'Decline'}}
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="selection" id="approve"  {{$returnOrder->isApproved() ? 'checked' : ''}} value="4" {{($returnOrder->isApproved() || $returnOrder ->isRejected()) ? 'disabled' : ''}}>
                                <label class="form-check-label" for="approve">
                                {{$returnOrder->isApproved() ? $returnOrder->getStatus() : 'Approve'}}
                                </label>
                            </div>
                        </div>
                   
                        <div class="ek_group">
                        <div class="d-flex">

                        <div class="upload-original-invoice">
                            <label>
                                <span>
                                    Please book a return shipment and upload the shipping label<span class="req_star">*</span>
                                </span>
                            </label>
                            <input type="file" id="UploadInvoice" class="upload_invoice" accept=".pdf,jpeg,jpg" style="display: none;" {{$returnOrder->isApproved() ? 'disabled' : ''}}>
                            <div class="d-flex gap-2 align-items-center">
                                 <!-- <div class="UploadInvoiceName fs-14 opacity-75"></div> -->
                                
                               
                                <label for="UploadInvoice" class="file-label invice m-0" {{$returnOrder->isApproved() ? 'disabled' : ''}}>
                                    <span class="file-label-text">Upload Shipping Label</span>
                                </label>
                                 <div class="UploadInvoiceName fs-14 opacity-75"></div>
                                 <div id="UploadInvoiceErr" class="text-danger"></div>
                            </div>
                        </div>
                        </div>
                        </div>
                    </div>

                    <?php
                    $shipping_cost = 0;
                    $gst = 0;
                    $other_charges = 0;
                    $total_order_cost = 0;
                    $product = 0;
                    ?>
                    @if($returnOrder->order->orderItemsCharges->isNotEmpty())
                    @foreach($returnOrder->order->orderItemsCharges as $orderItem)
                    @php
                    $product += $orderItem->total_price_exc_gst;
                    $shipping_cost += $orderItem->shipping_charges;
                    $gst += $orderItem->total_price_inc_gst - $orderItem->total_price_exc_gst;
                    $other_charges += $orderItem->packing_charges + $orderItem->labour_charges + $orderItem->processing_charges + $orderItem->payment_gateway_charges;
                    @endphp
                    @endforeach
                    @endif
                    <div class="col-md-3">
                        <table class="table table-bordered">
                            <thead>
                                <!-- <tr>
                                    <th>Order No</th>
                                    <th>Order Date</th>
                                </tr> -->
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Product Charges</td>
                                    <td>{{number_format($product,2)}}</td>
                                </tr>
                                <tr>
                                    <td>Shipping Charges</td>
                                    <td>{{number_format($shipping_cost,2)}}</td>
                                </tr>
                                <tr>
                                    <td>Other Charges</td>
                                    <td>{{number_format($other_charges,2)}}</td>
                                </tr>
                                <tr>
                                    <td>GST Charges</td>
                                    <td>{{number_format($gst,2)}}</td>
                                </tr>
                                <tr>
                                    <td>Total Order Amount</td>
                                    <td>{{number_format($returnOrder->order->total_amount,2)}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- <div class="row mt-3">
                    <div class="col-md-6">
                        
                    </div>
                </div> -->
                <div class="row mt-5">
                    <div class="col-sm-12 col-md-8">
                        <div class="ek_group">
                            <label class="eklabel req">
                                <span>Comment:</span>
                            </label>
                            <div class="wrapperComment">
                                <div class="commentBoxfloat">
                                    <form id="cmnt">
                                        <fieldset>
                                        @if($returnOrder->isRejected() || $returnOrder->isApproved())
                                                @if($returnOrder->updated_at->diffInHours() >= 48)
                                                <div class="form_grp">
                                                <label id="comment">comment </label>
                                                <textarea id="userCmnt" placeholder="Write your comment here." disabled></textarea>
                                            </div>
                                            <div class="form_grp">
                                                <button type="button" id="comment_submit" disabled>Submit</button>
                                            </div>
                                                @else
                                                <div class="form_grp">
                                                <label id="comment">comment</label>
                                                <textarea id="userCmnt" placeholder="Write your comment here."></textarea>
                                            </div>
                                            <div class="form_grp">
                                                <button type="button" id="comment_submit">Submit</button>
                                            </div>
                                                @endif
                                            @else
                                            <div class="form_grp">
                                                <label id="comment">comment</label>
                                                <textarea id="userCmnt" placeholder="Write your comment here."></textarea>
                                            </div>
                                            <div class="form_grp">
                                                <button type="button" id="comment_submit">Submit</button>
                                            </div>
                                            @endif
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="saveform_footer text-right single-button">
                    <button id="btnSubmit" style="margin-left:10px;" class="btn btnekomn" {{$returnOrder->isApproved() ? 'disabled' : ''}}>Submit</button>
                    <a class="btn btn-danger" href="{{route('list.return.order')}}" style="margin-left:10px;">Cancel</a>
                </div>

            </div>
        @elseif(auth()->user()->hasRole(ROLE_ADMIN) || auth()->user()->hasRole(ROLE_SUB_ADMIN))
        <div class="card ekcard pa shadow-sm">
                <div class="cardhead d-flex justify-content-between align-items-center">
                    <h3 class="cardtitle">Return Order</h3>
                    <div class="text-end">
                        <h4 class="subheading">Last Update Activity - {{$returnOrder->getStatus()}}</h4>
                        <span class="fs-15">{{$returnOrder->updated_at->toDateString()}} - ({{$returnOrder->updated_at->diffForHumans()}})</span>
                    </div>
                </div>
                <section class="">
                    <div class="row">
                        <div class="col-sm-12 col-md-2">
                            <div class="mt10">

                                <label class="bold">
                                    Return Request:
                                </label>
                                <div class="ek_f_input">
                                    <input type="text" class="form-control" value="{{$returnOrder->return_number}}" id="order_number" disabled />
                                    <div id="order_numberErr" class="invalid-feedback"></div>
                                </div>

                            </div>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <div class="mt10">

                                <label class="bold">
                                    <span>Order No:<span class="req_star">*</span></span>
                                </label>
                                <div class="ek_f_input">
                                    <input type="text" class="form-control" value="{{$returnOrder->order->order_number}}" id="order_number" disabled />
                                    <div id="order_numberErr" class="invalid-feedback"></div>
                                </div>

                            </div>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <div class="mt10">

                                <label class="bold">Courier Name:<span class="r_color">*</span></label>
                                <div class="ek_f_input">
                                    @isset($courier_detatils)
                                    <select class="form-select" id="courier_id" disabled>
                                        <option value="">Select Courier</option>
                                        @if($courierList->isNotEmpty())
                                        @foreach($courierList as $courier)
                                        <option value="{{$courier->id}}" @if($courier_detatils->courier_id == $courier->id) selected @endif>{{$courier->courier_name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @else
                                    <select class="form-select" id="courier_id">
                                        <option value="">Select Courier</option>
                                        @if($courierList->isNotEmpty())
                                        @foreach($courierList as $courier)
                                        <option value="{{$courier->id}}">{{$courier->courier_name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @endif
                                    <div id="reasonErr" class="invalid-feedback"></div>
                                </div>

                            </div>
                        </div>
                        <div class="col-sm-4 col-md-2">
                            <div class="mt10">
                                <label class="bold">Traking No</label>
                                @isset($courier_detatils)
                                <input type="text" class="form-control" placeholder="Enter Traking No"
                                    value="{{$courier_detatils->awb_number}}" id="trackingNo" name="trackingNo" disabled>
                                @else
                                <input type="text" class="form-control" placeholder="Enter Traking No"
                                    value="" id="trackingNo" name="trackingNo">
                                @endif
                            </div>
                            <p id="error_tracking"></p>
                        </div>
                        @isset($courier_detatils)
                        <div class="col-sm-4 col-md-2" id="show_courier">
                            <div class="mt10">
                                <label class="bold">Other Courier Name</label>
                                <input type="text" class="form-control" placeholder="Enter Courier Name"
                                    id="courierName" name="courierName" value="{{$courier_detatils->provider_name}}" disabled>
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
                            <label class="bold">Shipping Date</label>
                            @isset($courier_detatils)
                            <input type="text" class="form-control" id="shippingDate"
                            name="shippingDate" value="{{$courier_detatils->shipment_date->format('d-m-Y')}}" disabled>
                            @else
                            <input type="text" class="form-control" id="shippingDate"
                                name="shippingDate">
                            @endif

                        </div>
                        <p id="error_shipping_date"></p>

                    </div>
                    <div class="col-sm-4 col-md-2">
                        <div class="mt10">
                            <label class="bold">Delivery Date</label>
                            @isset($courier_detatils)
                            <input type="text" class="form-control"  value="{{$courier_detatils->expected_delivery_date->format('d-m-Y')}}" id="deliveryDate" value=""
                                name="deliveryDate" disabled>
                            @else
                            <input type="text" class="form-control" id="deliveryDate"
                            name="deliveryDate">
                            @endif
                        </div>
                        <p id="error_delhivery_date"></p>

                    </div>
                    </div>
                    <div class="row mt-5">

                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="ek_group">
                                <label class="eklabel req" style="width: 32%;">Cancellation Reason:<span class="r_color">*</span></label>
                                <div class="ek_f_input">
                                    <select class="form-select" id="reason" disabled>
                                        <option value="{{$returnOrder->reason}}" selected> {{$returnOrder->reason}} </option>
                                    </select>
                                    <div id="reasonErr" class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <div class="multi-row">Attachement:<span class="req_star">*</span>
                @if(!empty($attachment))
                    @if(!empty($attachment['image']))
                    @foreach($attachment['image'] as $key => $attach)
                    <div class="image-upload-box" id="box-{{$loop->index+1}}" >
                        <img id="img-box-{{$loop->index+1}}" src="{{asset($attach)}}" alt="Image" onclick="dowloadFile(`{{asset($attach)}}`)" />
                    </div>
                    @endforeach
                    @endif
                    @if(!empty($attachment['video']))
                    @foreach($attachment['video'] as $key => $attach)
                    <div class="video-container" onclick="dowloadFile(`{{asset($attach)}}`)">
                        <div class="video-placeholder">
                            <div style="margin: 4px 0px 2px 0px;">
                                <svg viewBox="0 0 64 64" width="38" height="38" fill="#FAFAFA">
                                    <circle cx="32" cy="32" r="32" fill="rgba(0,0,0,0.15)" />
                                    <polygon points="25,16 25,48 48,32" />
                                </svg>
                            </div>
                        </div>
                        <video class="video-element" style="display:block;">
                        <source src="{{asset($attach)}}" class="video-source" >
                        </video>
                        <div class="play-icon">
                            <svg viewBox="0 0 64 64" width="44" height="44" fill="white">
                                <circle cx="32" cy="32" r="32" fill="rgba(0,0,0,0.5)" />
                                <polygon points="25,16 25,48 48,32" />
                            </svg>
                        </div>
                    </div>
                    @endforeach
                    @endif
                @endif
                    
                </div>
                <div class="row mt-5">
                    <div class="col-sm-12 col-md-8">
                        <div class="ek_group">

                            <label class="eklabel req">
                                Comments
                            </label>
                            <div class="ek_f_input">
                                <div id="commnetBox" style="padding:10px">
                                    @if($returnOrder->returnComments->isNotEmpty())
                                    @foreach($returnOrder->returnComments as $key => $comment)
                                    @if($comment->role_type == ROLE_BUYER)
                                    @if($key > 0)
                                    <hr>
                                    @endif
                                    <div class="cardhead d-flex justify-content-between align-items-center">
                                        <h3 class="cardtitle">Buyer</h3>
                                        <div class="text-end">
                                            <span class="fs-12">{{$comment->created_at->toDateString()}} - ({{$comment->created_at->diffForHumans()}})</span>
                                        </div>
                                    </div>
                                    <div style="padding-left:10px; text-align:justify;" id="cmntContr">
                                        {{$comment->comment}}
                                    </div>
                                    @elseif($comment->role_type == ROLE_SUPPLIER)
                                    @if($key > 0)
                                    <hr>
                                    @endif
                                    <div class="cardhead d-flex justify-content-between align-items-center">
                                        <span class="fs-12">{{$comment->created_at->toDateString()}} - ({{$comment->created_at->diffForHumans()}})</span>
                                        <div class="text-end">
                                            <h4 class="cardtitle">Supplier</h4>

                                        </div>
                                    </div>
                                    <div style="padding-left:10px; text-align:justify;" id="cmntContr">
                                        {{$comment->comment}}
                                    </div>
                                    @elseif($comment->role_type == ROLE_ADMIN)
                                    @if($key > 0)
                                    <hr>
                                    @endif
                                    <div class="cardhead d-flex justify-content-between align-items-center">
                                        <h3 class="cardtitle">Admin</h3>
                                        <div class="text-end">
                                            <span class="fs-12">{{$comment->created_at->toDateString()}} - ({{$comment->created_at->diffForHumans()}})</span>
                                        </div>
                                    </div>
                                    <div style="padding-left:10px; text-align:justify;" id="cmntContr">
                                        {{$comment->comment}}
                                    </div>
                                    @endif
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-md-5">
                        <div class="ek_group">
                        <label class="eklabel req"  style="width: 32%;">
                                <span>Amount to be refund</span>
                            </label>
                            <input type="text" class="border ms-5 ps-2" id="amount" value="{{number_format($returnOrder->amount,2)}}">
                        </div>
                        <div class="ek_group">
                            <label class="eklabel req " style="width: 30%;">
                                <span>Select an Option:<span class="req_star">*</span></span>
                            </label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="selection" id="accept" {{$returnOrder->isAccepted() ? 'checked' : ''}} value="3">
                                <label class="form-check-label" for="accept">
                                    {{$returnOrder->isAccepted() ? $returnOrder->getStatus() : 'Accept'}}
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="selection" id="decline" {{$returnOrder->isRejected() ? 'checked ' : ''}} value="5">
                                <label class="form-check-label" for="decline">
                                    
                                    {{$returnOrder->isRejected() ? $returnOrder->getStatus() : 'Decline'}}
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="selection" id="approve"  {{$returnOrder->isApproved() ? 'checked' : ''}} value="4">
                                <label class="form-check-label" for="approve">
                                {{$returnOrder->isApproved() ? $returnOrder->getStatus() : 'Approve'}}
                                </label>
                            </div>
                        </div>

                        <div class="ek_group">
                        <div class="d-flex">

                        <div class="upload-original-invoice">
                            <label>
                                <span>
                                    Please book a return shipment and upload the shipping label<span class="req_star">*</span>
                                </span>
                            </label>
                            <input type="file" id="UploadInvoice" class="upload_invoice" accept=".pdf,jpeg,jpg" style="display: none;">
                            <div class="d-flex gap-2 align-items-center">
                                <div id="UploadInvoiceErr" class="text-danger"></div>
                                <label for="UploadInvoice" class="file-label invice m-0">
                                    <span class="file-label-text">Upload Shipping Label</span>
                                </label>
                            </div>
                        </div>
                        </div>
                        </div>
                    </div>

                    <?php
                    $shipping_cost = 0;
                    $gst = 0;
                    $other_charges = 0;
                    $total_order_cost = 0;
                    $product = 0;
                    ?>
                    @if($returnOrder->order->orderItemsCharges->isNotEmpty())
                    @foreach($returnOrder->order->orderItemsCharges as $orderItem)
                    @php
                    $product += $orderItem->total_price_exc_gst;
                    $shipping_cost += $orderItem->shipping_charges;
                    $gst += $orderItem->total_price_inc_gst - $orderItem->total_price_exc_gst;
                    $other_charges += $orderItem->packing_charges + $orderItem->labour_charges + $orderItem->processing_charges + $orderItem->payment_gateway_charges;
                    @endphp
                    @endforeach
                    @endif
                    <div class="col-md-3">
                        <table class="table table-bordered">
                            <thead>
                                <!-- <tr>
                                    <th>Order No</th>
                                    <th>Order Date</th>
                                </tr> -->
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Product Charges</td>
                                    <td>{{number_format($product,2)}}</td>
                                </tr>
                                <tr>
                                    <td>Shipping Charges</td>
                                    <td>{{number_format($shipping_cost,2)}}</td>
                                </tr>
                                <tr>
                                    <td>Other Charges</td>
                                    <td>{{number_format($other_charges,2)}}</td>
                                </tr>
                                <tr>
                                    <td>GST Charges</td>
                                    <td>{{number_format($gst,2)}}</td>
                                </tr>
                                <tr>
                                    <td>Total Order Amount</td>
                                    <td>{{number_format($returnOrder->order->total_amount,2)}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- <div class="row mt-3">
                    <div class="col-md-6">
                        
                    </div>
                </div> -->
                <div class="row mt-5">
                    <div class="col-sm-12 col-md-8">
                        <div class="ek_group">
                            <label class="eklabel req">
                                <span>Comment:</span>
                            </label>
                            <div class="wrapperComment">
                                <div class="commentBoxfloat">
                                    <form id="cmnt">
                                        <fieldset>
                                            <div class="form_grp">
                                                <label id="comment">comment</label>
                                                <textarea id="userCmnt" placeholder="Write your comment here."></textarea>
                                            </div>
                                            <div class="form_grp">
                                                <button type="button" id="comment_submit">Submit</button>
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="saveform_footer text-right single-button">
                    <button id="btnSubmit" style="margin-left:10px;" class="btn btnekomn">Submit</button>
                    <a class="btn btn-danger" href="{{route('list.return.order')}}" style="margin-left:10px;">Cancel</a>
                </div>

            </div>
        @endif
        @include('dashboard.layout.copyright')
    </div>
    @endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
  // Upload Invoice 
  document.addEventListener('change', function(event) {
    if (event.target.classList.contains('upload_invoice')) {
      const invoice = event.target.closest('.upload-original-invoice');
      const invoiceName = invoice.querySelector('.UploadInvoiceName');
      const invoicefileName = event.target.files[0]?.name || '';
      invoiceName.textContent = invoicefileName;
    }
  });
  // end upload Invoice


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

    $('#btnSubmit').click(function() {
        var isValid = true;
       // selection
        if ($('input[name="selection"]:checked').length === 0) {
            isValid = false;
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please select an option',
            });
        }

        if($('#courier_id').val() != ''){

            if ($('#trackingNo').val() == '') {
                $('#error_tracking').text('Please enter tracking number');
                $("#error_tracking").css('color', '#dc3545');
                isValid = false;
            } else {
                $('#error_tracking').text('');
            }

            if ($('#courier_id').val() == '1') {
                if ($('#courierName').val() == '') {
                    $('#error_courier_text').text('Please enter courier name');
                    $("#error_courier_text").css('color', '#dc3545');
                    isValid = false;
                } else {
                    $('#error_courier_text').text('');
                }
            } else {
                $('#error_courier_text').text('');
            }

            if ($('#shippingDate').val() == '') {
                $('#error_shipping_date').text('Please enter shipping date');
                $("#error_shipping_date").css('color', '#dc3545');
                isValid = false;
            } else {
                $('#error_shipping_date').text('');
            }

            if ($('#deliveryDate').val() == '') {
                $('#error_delhivery_date').text('Please enter delivery date');
                $("#error_delhivery_date").css('color', '#dc3545');
                isValid = false;
            } else {
                $('#error_delhivery_date').text('');
            }

            @if(!isset($courier_detatils))
            const fileInput = $('#UploadInvoice')[0];
            const file = fileInput.files[0];
            // Check if a file is selected
            if (!file) {
                $('#UploadInvoiceErr').text('Please upload an courier label file.');
                isvalid = false;
            }
            fileInput.addEventListener('change', function() {
                const file = fileInput.files[0];
                // Check if a file is selected
                if (file) {
                $('#UploadInvoiceErr').text('');
                isvalid = true;
                }
            });
            @endif

        }

        if (isValid) {
            var formData = new FormData();
            @if(!isset($courier_detatils))
            formData.append('UploadLabel', $('#UploadInvoice')[0].files[0]);
            formData.append('courier_id', $('#courier_id').val());
            formData.append('tracking_number', $('#trackingNo').val());
            formData.append('courier_name', $('#courierName').val());
            formData.append('shippingDate', $('#shippingDate').val());
            formData.append('deliveryDate', $('#deliveryDate').val());
            @endif
            formData.append('amount', $('#amount').val());
            formData.append('comment', $('#userCmnt').val());
            formData.append('return_order_id', '{{salt_encrypt($returnOrder->id)}}');
            formData.append('status', $('input[name="selection"]:checked').val());
            ApiRequest('update-return-order', 'POST', formData).then(response => {
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

                    }).catch(error => {
                        console.error(error);

                    });
        }
    });

    $(function() {
        var inDexValue;
        $('#comment_submit').click(function() {
            if ($('#userCmnt').val().length == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please enter comment',
                });
                return true;
            }
            var userCmnt = $('#userCmnt').val();
            // if ($('#submit').hasClass('editNow')) {
            //     $('#cmntContr>div.viewCmnt').eq(inDexValue).children('p').html(userCmnt);

            // } else {

                $('#cmntContr').append("<div class='viewCmnt'><p>" + userCmnt + "</p></div>");
                // $('#cmntContr').append("<div class='viewCmnt'><p>" + userCmnt + "</p><span class='edit'></span><span class='delete'></span></div>");
            // }

            ApiRequest('add-return-comment', 'POST', {
                return_order_id: '{{salt_encrypt($returnOrder->id)}}',
                comment: userCmnt
            }, function(response) {
            });
            $('#userCmnt').val('');
            // $(this).removeClass('editNow');
        });

        // // Delete 
        // $('#cmntContr').on('click', '.delete', function() {
        //     confirm("Delete Coformation");
        //     $(this).parent().remove();
        // });
        // // Edit
        // $('#cmntContr').on('click', '.edit', function() {
        //     var toEdit = $(this).prev('p').html();
        //     //alert(toEdit);
        //     $('#userCmnt').val(toEdit);
        //     $('button').addClass('editNow');
        //     inDexValue = $(this).parent('div.viewCmnt').index();

        // });
    });

    function dowloadFile(url) {
        var a = document.createElement('a');
        a.href = url;
        a.download = url.split('/').pop();
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    }   

    @if (auth()->user()->hasRole(ROLE_BUYER))
    $('#btnDispute').click(function() {
        var userCmnt = $('#userCmnt').val();
        ApiRequest('raise-dispute', 'POST', {
            return_order_id: '{{salt_encrypt($returnOrder->id)}}',
            comment: userCmnt
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
    });
    @endif
</script>
@endsection