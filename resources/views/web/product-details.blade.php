@extends('web.layout.app')
@section('content')
    <div class="ekcontent">
        <section class="ek-section">
            <div class="ekom_card prod_detail_section">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12 col-md-5">
                            <div class="prod_image_box">
                            
                                <div class="img-card">
                                @foreach ($productVariations->media as $media)
                                    @if($media->is_master == 1)
                                    <img src="{{$media->thumbnail_path}}" alt="" id="main-img">
                                    @endif
                                @endforeach
                                </div>
                              
                                <div class="carousel-container">
                                    <button class="carousel-button prev"><i class="fas fa-chevron-left"></i></button>
                                    <div class="carousel-wrapper">
                                        <div class="small-card">
                                            @foreach ($productVariations->media as $media)
                                            <img src="{{ $media->file_path }}" alt="" class="smImg active" data-src="{{ $media->file_path }}">
                                            @endforeach
                                        </div>
                                    </div>
                                    <button class="carousel-button next"><i class="fas fa-chevron-right"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-7">
                            <div class="prod_name_stock">
                                <h1 class="fs-22 m-0 bold">{{ $productVariations->title }}</h1>
                                <div class="mt10 d-flex justify-content-between align-items-center">
                                    <h3 class="m-0 fs-16 opacity-75">XYZ Product Store</h3>
                                    <span class="_productID">Product SKU : {{ $productVariations->sku }}</span>
                                </div>
                                <h4 class="fs-24 bold my-3"><sup class="suptop"><i
                                            class="fas fa-rupee-sign fs-14 me-1"></i></sup>{{ $productVariations->price_before_tax }}
                                </h4>
                                <div class="form-group">
                                    <label class="bold mb3 fs-16">Color:</label>
                                    <select class="changeStatus_t form-select h_30">
                                        <option value="{{$productVariations->color}}" selected>{{$productVariations->color}}</option>
                                        <option value="red">Red</option>
                                        <option value="green">Green</option>
                                        <option value="blue">Blue</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="bold mb5 fs-16">Size:</label>
                                    <div class="radioinline">
                                        <label class="radio-item">
                                            <input type="radio" checked name="size">
                                            <span class="radio-text h_30">{{$productVariations->size}}</span>
                                        </label>
                                        <label class="radio-item">
                                            <input type="radio" name="size">
                                            <span class="radio-text h_30">M</span>
                                        </label>
                                        <label class="radio-item">
                                            <input type="radio" name="size">
                                            <span class="radio-text h_30">L</span>
                                        </label>
                                        <label class="radio-item">
                                            <input type="radio" name="size">
                                            <span class="radio-text h_30">XL</span>
                                        </label>
                                        <label class="radio-item">
                                            <input type="radio" name="size">
                                            <span class="radio-text h_30">XXL</span>
                                        </label>
                                        <label class="radio-item">
                                            <input type="radio" name="size">
                                            <span class="radio-text h_30">XXXL</span>
                                        </label>
                                        <label class="radio-item">
                                            <input type="radio" name="size">
                                            <span class="radio-text h_30">1.5x3 feet</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="">
                                            <div class="bulkBuing">
                                                <label class="fs-14 bold">Bulk Buying Rates:</label>
                                                <table class="detail_s_t">
                                                    <thead>
                                                        <tr>
                                                            <th>Quantity/Upto</th>
                                                            <th>Price/Piece</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                       
                                                        @foreach ($tier_rate as $rateQnty)
                                                        <tr>
                                                            <td>{{ $rateQnty['range']['min'] }} - {{ $rateQnty['range']['max'] }}</td>
                                                            <td>{{$rateQnty['price']}}</td>
                                                        </tr>
                              
                                                         @endforeach
                                                        
                                                    </tbody>
                                                </table>
                                                <div class="fs-14 mt3">Availability:<small class="ms-1 opacity-75">Till
                                                        Stock Last</small></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 align-self-end">
                                        <div class="det_btnbox">
                                            @if($productVariations->status == 3)
                                            <div class="outofstock">
                                                <strong class="text-danger me-2">Currently Out Of Stock</strong><span
                                                    class="opacity-75 me-1">Interested?</span><a href="#outStock"
                                                    data-bs-toggle="collapse" class="a_color">Click here</a>
                                                <div class="collapse" id="outStock">
                                                    <div class="inputwithOk mt5">
                                                        <input type="text" class="form-control"
                                                            placeholder="Quantity Needed">
                                                        <button class="inputokbtn">Ok</button>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            <button type="button" class="btn btnekomn_dark btnround"><i
                                                    class="fas fa-plus fs-14 me-2"></i>Add to Inventory</button>
                                            <button type="button" class="btn btnekomn_dark btnround">Connect to
                                                Amazon</button>
                                            <button type="button" class="btn btnekomn btnround"><i
                                                    class="fas fa-shopping-cart me-2"></i>Buy Now</button>
                                            <button type="button" class="btn btnekomn-border btnround"><i
                                                    class="fa fa-download me-2"></i>Download</button>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group doyouinput">
                                            <label class="bold fs-16">Do you have any queries?</label>
                                            <div class="textareabtn">
                                                <textarea name="" class="form-control" id="" placeholder="Type your message"></textarea>
                                                <button class="textareabtn_submit">Send</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ekfeaturesBox">
                        <ul class="nav nav-underline ekom_tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="details-tab" data-bs-toggle="tab"
                                    data-bs-target="#details" role="tab" aria-controls="details"
                                    aria-selected="true">Product Details</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="shipping-tab" data-bs-toggle="tab" data-bs-target="#shipping"
                                    role="tab" aria-controls="shipping" aria-selected="false">Shipping</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="refund-tab" data-bs-toggle="tab" data-bs-target="#refund"
                                    role="tab" aria-controls="refund" aria-selected="false">Return/Refund Policy</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="details" role="tabpanel"
                                aria-labelledby="details-tab" tabindex="0">
                                <div class="descList">
                                    <table class="decinnertable">
                                        <tbody>
                                            <tr>
                                                <td>Brand Name</td>
                                                <td>XYZ</td>
                                            </tr>
                                            <tr>
                                                <td>SKU</td>
                                                <td>{{ $productVariations->sku }}</td>
                                            </tr>
                                            <tr>
                                                <td>HSN</td>
                                                <td>{{ $productVariations->hsn }}</td>
                                            </tr>
                                            <tr>
                                                <td>GST Bracket</td>
                                                <td>18%</td>
                                            </tr>
                                            <tr>
                                                <td>Product Dimensions</td>
                                                <td>{{ $productVariations->package_lenght ?? 0 }}L x
                                                    {{ $productVariations->package_width ?? 0 }}W x
                                                    {{ $productVariations->package_height ?? 0 }}H Centimeters</td>
                                            </tr>
                                            <tr>
                                                <td>Product Weight</td>
                                                <td>{{ $productVariations->package_weight ?? 0 }} Grams</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="descList">
                                    <h4 class="mt-0 fs-18 bold">Features </h4>
                                    <ul>
                                        @foreach( $productVariations->product->features as $feature)
                                            <li>{{$feature->value}}</li>
                                        @endforeach
                                        

                                    </ul>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="shipping" role="tabpanel" aria-labelledby="shipping-tab"
                                tabindex="0">
                                <div class="descList">
                                    <h4 class="mt-0 fs-18 bold">Shipping Rate</h4>
                                    <table class="decinnertablerate">
                                        <thead>
                                            <tr>
                                                <th>Qty Upto</th>
                                                <th>Local</th>
                                                <th>Regional</th>
                                                <th>National</th>
                                            </tr>
                                        </thead>

                                        <tbody>


                                            @foreach ($shippingRatesTier as $rate)
                                                <tr>
                                                    <td>{{ $rate['range']['min'] }} - {{ $rate['range']['max'] }}</td>
                                                    <td><i class="fas fa-rupee-sign fs-12 me-1"></i>{{ $rate['local'] }}
                                                    </td>
                                                    <td><i
                                                            class="fas fa-rupee-sign fs-12 me-1"></i>{{ $rate['regional'] }}
                                                    </td>
                                                    <td><i
                                                            class="fas fa-rupee-sign fs-12 me-1"></i>{{ $rate['national'] }}
                                                    </td>

                                                </tr>
                                            @endforeach



                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="refund" role="tabpanel" aria-labelledby="refund-tab"
                                tabindex="0">
                                <div class="descList">
                                    <h4 class="mt-0 fs-18 bold">Refund Policy</h4>
                                    <ul>
                                        <li>
                                            LUXURIOUSLY 2000 GSM THICK SOFT BATHMAT– Our microfibre Bath Mats are thick and
                                            fluffy which makes these Bath Mats a good quality and a long lasting product.
                                            Don’t sacrifice quality for durability. Your feet will say thank you when
                                            stepping out of the shower on the soft microfibre mat. Use in your Bathroom,
                                            Living room, Kitchen or as Door Mat.
                                        </li>
                                        <li>
                                            NON SLIP – Anti Skid will help the bath mat stay still in wet areas. The
                                            Bathroom Mats have been tested and can be machine washed. This non-skid backing
                                            ensures the bathroom won’t move and you’ll be safe when stepping out of your
                                            shower. We use hot melt glue which is stickier, stronger, and more durable for
                                            long lasting use.
                                        </li>
                                        <li>
                                            SUPER ABSORBENT– The Microfiber Bathmat is much more absorbent than cotton or
                                            memory foam bath rugs, so it won't stay soggy all day or start to stink after
                                            just a couple uses. High-pile, thick microfiber helps save your floors from
                                            dripping water while you're stepping out of the bath, shower, or getting ready
                                            by the sink. Moisture is trapped in the mat's deep pile, allowing the bath mat
                                            to dry quickly.
                                        </li>
                                        <li>
                                            MACHINE WASHABLE - After your toddler or kids get out of the bath tub, just
                                            throw the bath mat into the washing machine. Hang to dry, and you’re done. Quick
                                            drying and long lasting, the microfiber bath rugs are durable accessories for
                                            your restroom and will last for years to come
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection
