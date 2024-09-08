@extends('web.layout.app')
@section('content')
    <div class="ekcontent">
        <section class="ek-section">
            <div class="ekom_card prod_detail_section">
                <div class="container-fluid">
                    <div class="row">
                        {{--
                        <div class="col-sm-12 col-md-5">
                            <div class="prod_image_box">
                                <div class="img-card">
                                    @php
                                        $main_image = '';
                                    @endphp
                                    @if (!empty($productVariations->media))
                                        @foreach ($productVariations->media as $media)
                                            @if ($media->is_master == IS_MASTER_TRUE)
                                                @php
                                                    if(isset($media->thumbnail_path)){
                                                    $main_image = url($media->file_path);
                                                    }else{
                                                    $main_image = url('storage/'.$media->file_path);
                                                    }

                                                @endphp
                                                <img src="{{ $main_image }}" alt="" id="main-img">
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                                <div class="carousel-container">
                                    <button class="carousel-button prev"><i class="fas fa-chevron-left"></i></button>
                                    <div class="carousel-wrapper">
                                        <div class="small-card">
                                            @if (!empty($productVariations->media))
                                                @foreach ($productVariations->media as $media)
                                                    @if ($media->media_type == MEDIA_TYPE_IMAGE)
                                                        @if ($media->is_master == IS_MASTER_TRUE)
                                                            @isset($media->thumbnail_path)
                                                            <img src="{{ url($media->thumbnail_path) }}" alt="Main-Image"
                                                                class="smImg active"
                                                                data-src="{{ url($media->file_path) }}">
                                                            @else
                                                            <img src="{{ url('storage/'.$media->file_path) }}" alt="Main-Image"
                                                                class="smImg active"
                                                                data-src="{{ url('storage/'.$media->file_path) }}">
                                                            @endif
                                                        @else
                                                            @isset($media->thumbnail_path)
                                                            <img src="{{ url($media->thumbnail_path) }}" alt="Other-Image"
                                                                class="smImg" data-src="{{ url($media->file_path) }}">
                                                            @else
                                                            <img src="{{ url('storage/'.$media->file_path) }}" alt="Main-Image"
                                                                class="smImg active"
                                                                data-src="{{ url('storage/'.$media->file_path) }}">
                                                            @endif
                                                        @endif
                                                    @else
                                                    <div class="smImg smImgVideo">
                                                        <video controlslist="nodownload">
                                                        <source src="{{ url('storage/' . $media->file_path) }}" data-src="{{ url('storage/' . $media->file_path) }}" type="video/mp4">
                                                        </video>
                                                        <div class="play-icon">
                                                        <svg viewBox="0 0 64 64" width="44" height="44" fill="white">
                                                            <circle cx="32" cy="32" r="32" fill="rgba(0,0,0,0.8)" />
                                                            <polygon points="25,16 25,48 48,32" />
                                                        </svg>
                                                        </div>
                                                    </div>
                                                    @endif
                                                @endforeach
                                            @endif

                                        </div>
                                    </div>
                                    <button class="carousel-button next"><i class="fas fa-chevron-right"></i></button>
                                </div>
                            </div>
                        </div>
                        --}}
                        <div class="col-sm-12 col-md-5">
                            <div class="prod_image_box">
                                    @php
                                        $main_image = '';
                                    @endphp
                                    @if (!empty($productVariations->media))
                                        @foreach ($productVariations->media as $media)
                                            @if ($media->is_master == IS_MASTER_TRUE)
                                                @php
                                                    if(isset($media->thumbnail_path)){
                                                    $main_image = url($media->file_path);
                                                    }else{
                                                    $main_image = url('storage/'.$media->file_path);
                                                    }

                                                @endphp
                                                <div class="img-card" id="main-img">
                                                <!-- The media (image or video) will be dynamically inserted here -->
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                
                                <div class="carousel-container">
                                    <button class="carousel-button prev"><i class="fas fa-chevron-left"></i></button>
                                    <div class="carousel-wrapper">
                                        <div class="small-card">
                                            @if (!empty($productVariations->media))
                                                @foreach ($productVariations->media as $media)
                                                    @if ($media->media_type == MEDIA_TYPE_IMAGE)
                                                        @if ($media->is_master == IS_MASTER_TRUE)
                                                            @isset($media->thumbnail_path)
                                                            <div class="smImg active">
                                                            <img src="{{ url($media->thumbnail_path) }}" alt="Main-Image"
                                                                
                                                                data-src="{{ url($media->file_path) }}">
                                                            </div>
                                                            @else
                                                            <div class="smImg active">
                                                            <img src="{{ url('storage/'.$media->file_path) }}" alt="Main-Image"
                                                                
                                                                data-src="{{ url('storage/'.$media->file_path) }}">
                                                            </div>
                                                            @endif
                                                        @else
                                                            @isset($media->thumbnail_path)
                                                            <div class="smImg">
                                                            <img src="{{ url($media->thumbnail_path) }}" alt="Other-Image"
                                                                 data-src="{{ url($media->file_path) }}">
                                                            </div>
                                                            @else
                                                            <div class="smImg active">
                                                            <img src="{{ url('storage/'.$media->file_path) }}" alt="Main-Image"
                                                                
                                                                data-src="{{ url('storage/'.$media->file_path) }}">
                                                            </div>
                                                            @endif
                                                        @endif
                                                    @else
                                                        <div class="smImg smImgVideo">
                                                            <video controlslist="nodownload">
                                                            <source src="{{ url('storage/' . $media->file_path) }}" data-src="{{ url('storage/' . $media->file_path) }}" type="video/mp4">
                                                            </video>
                                                            <div class="play-icon">
                                                            <svg viewBox="0 0 64 64" width="44" height="44" fill="white">
                                                                <circle cx="32" cy="32" r="32" fill="rgba(0,0,0,0.8)" />
                                                                <polygon points="25,16 25,48 48,32" />
                                                            </svg>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endif

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
                                    <h3 class="m-0 fs-16 opacity-75">{{ $productVariations->company->display_name }}</h3>
                                    <span class="_productID">Product SKU : {{ $productVariations->sku }}</span>
                                </div>
                                @if (auth()->check())
                                <h4 class="fs-26 bold my-3"><sup class="suptop"><i
                                            class="fas fa-rupee-sign fs-14 me-1"></i></sup>{{ number_format($productVariations->price_before_tax, 2) }}
                                    <del class="opacity-50 fs-16 ms-2">
                                        <i
                                            class="fas fa-rupee-sign fs-13 me-1"></i>{{ number_format($productVariations->potential_mrp, 2) }}</del>
                                    @php
                                        $diff =
                                            $productVariations->potential_mrp - $productVariations->price_before_tax;
                                        $discount = ($diff / $productVariations->potential_mrp) * 100;
                                    @endphp
                                    <small class="ms-2 fs-16 text-success">%{{ number_format(round($discount)) }}
                                        Off</small>
                                </h4>
                                @else
                                <h4 class="fs-26 bold my-3"> <a href="{{route('buyer.login')}}" class="link-dark"> Login to see price </a></h4>
                                @endif
                                <div class="form-group">
                                    <label class="bold mb3 fs-16">Color:</label>
                                    <select class="changeStatus_t form-select h_30" id="colorChange">
                                        @foreach ($colors as $color)
                                            @if ($productVariations->color == $color['color'])
                                                <option value="{{ route('product.details', $productVariations->slug) }}"
                                                    selected>{{ ucfirst($productVariations->color) }}</option>
                                            @else
                                                <option value="{{ route('product.details', $color['slug']) }}">
                                                    {{ ucfirst($color['color']) }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="bold mb5 fs-16">Size:</label>
                                    <div class="radioinline">
                                        @foreach ($sizes as $size)
                                            @if ($productVariations->size == $size['size'])
                                                <label class="radio-item">
                                                    <input type="radio" checked name="size"
                                                        value="{route('product.details', $size['slug'])}}">
                                                    <span class="radio-text h_30">{{ $size['size'] }}</span>
                                                </label>
                                            @else
                                                <label class="radio-item">
                                                    <input type="radio" name="size"
                                                        value="{{ route('product.details', $size['slug']) }}">
                                                    <span class="radio-text h_30">{{ $size['size'] }}</span>
                                                </label>
                                            @endif
                                        @endforeach
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
                                                                <td>{{ $rateQnty['range']['min'] }} -
                                                                    {{ $rateQnty['range']['max'] }}</td>
                                                                <td>{{ number_format($rateQnty['price'], 2) }}</td>
                                                            </tr>
                                                        @endforeach

                                                    </tbody>
                                                </table>
                                                <div class="fs-14 mt3">Availability:<small
                                                        class="ms-1 opacity-75">{{ getAvailablityStatusName($productVariations->availability_status) }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 align-self-end">
                                        <div class="det_btnbox">
                                            @if ($productVariations->status == 3)
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
                                            @if (auth()->check())
                                                <button type="button" class="btn btnekomn_dark btnround"
                                                    onclick="addToInventory('Inventory', '{{ salt_encrypt($productVariations->id) }}')"><i
                                                        class="fas fa-plus fs-14 me-2"></i>Add to Inventory</button>
                                                <button type="button" class="btn btnekomn_dark btnround">Connect to
                                                    Amazon</button>
                                                <button type="button" class="btn btnekomn btnround"
                                                    onclick="addToCart('{{ salt_encrypt($productVariations->id) }}')"><i
                                                        class="fas fa-shopping-cart me-2"></i>Buy Now</button>
                                                <button type="button" class="btn btnekomn-border btnround"
                                                    onclick="addToInventory('Download', '{{ salt_encrypt($productVariations->id) }}')"><i
                                                        class="fa fa-download me-2"></i>Download</button>
                                            @else
                                                <a href="{{ route('buyer.login') }}"
                                                    class="btn btnekomn_dark btnround"><i
                                                        class="fas fa-plus fs-14 me-2"></i>Add to Inventory</a>
                                                <a href="{{ route('buyer.login') }}"
                                                    class="btn btnekomn_dark btnround">Connect to Amazon</a>
                                                <a href="{{ route('buyer.login') }}" class="btn btnekomn btnround"><i
                                                        class="fas fa-shopping-cart me-2"></i>Buy Now</a>
                                                <a href="{{ route('buyer.login') }}"
                                                    class="btn btnekomn-border btnround"><i
                                                        class="fa fa-download me-2"></i>Download</a>
                                            @endif
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
                                                <td>SKU</td>
                                                <td>{{ $productVariations->sku }}</td>
                                            </tr>
                                            <tr>
                                                <td>HSN</td>
                                                <td>{{ $productVariations->product->hsn }}</td>
                                            </tr>
                                            <tr>
                                                <td>GST Bracket</td>
                                                <td>{{ $productVariations->product->gst_percentage }}%</td>
                                            </tr>
                                            <tr>
                                                <td>Product Dimensions</td>
                                                <td>{{ $productVariations->length ?? 0 }} L x
                                                    {{ $productVariations->width ?? 0 }} W x
                                                    {{ $productVariations->height ?? 0 }} H 
                                                    {{ $productVariations->dimension_class }} </td>
                                            </tr>
                                            <tr>
                                                <td>Product Weight</td>
                                                <td>{{ $productVariations->weight ?? 0 }}
                                                    {{ $productVariations->weight_class }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="decList">
                                    <h4 class="mt-0 fs-18 bold">Description</h4>
                                    <p>{{ $productVariations->product->description }}</p>
                                </div>
                                <div class="descList">
                                    <h4 class="mt-0 fs-18 bold">Features </h4>
                                    <ul>
                                        @foreach ($productVariations->product->features as $feature)
                                            <li>{{ $feature->value }}</li>
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
                                    <p>All products on eKomn are governed by a standard policy. Please refer <a href="{{route('return.policy')}}">Return & Refund Policy</a> here
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {


            // Fetch categories and populate the menu
            $.ajax({
                url: '{{ route('categories.list') }}', // Endpoint for fetching categories
                type: 'GET', // HTTP method
                dataType: 'json', // Expected data type
                success: function(res) {
                    // jQuery object for the category menu

                    const $mobileMenu = $("#mob_cat_list");
                    const url = "{{ route('product.category', ['slug' => 'SLUG']) }}";

                    if (res.data.statusCode == 200) {
                        const data = res.data.data;

                        // Clear existing content

                        $mobileMenu.empty();

                        // Populate menu with categories
                        $.each(data, function(index, category) {

                            // Begin HTML structure for mobile menu
                            var mobileCategory = '<li class="nav-item">';
                            mobileCategory += `<a class="nav-link collapsed nav-link-arrow" data-bs-toggle="collapse" href="#${category.parent_slug}"
                                                    data-bs-parent="#mob_cat_list" id="components">
                                                    <span class="nav-link-text">${category.parent_name}</span>
                                                    <span class="menu_arrowIcon"><i class="fas fa-angle-right"></i></span>
                                                    </a>`;

                            // Loop through sub-parent categories and build HTML for each
                            $.each(category.sub_parents, function(index, subParent) {
                                // Begin HTML structure for sub-parent category
                                var mobilesubParentHtml =
                                    `<ul class="sidenav-second-level collapse" id="${category.parent_slug}" data-bs-parent="#mob_cat_list">`;

                                // Loop through child categories of the sub-parent
                                $.each(subParent.children, function(index, child) {
                                    // Add child category links dynamically using its slug and name
                                    mobilesubParentHtml +=
                                        '<li><a class="nav-link" href="' + url
                                        .replace('SLUG', child.child_slug) +
                                        '">' + child.child_name + '</a></li>';
                                });

                                // Close the sub-parent's child category list
                                mobilesubParentHtml += '</ul>';

                                // Append the sub-parent HTML to the main category structure
                                mobileCategory += mobilesubParentHtml;
                            });

                            // Append the completed category structure to the mobile menu
                            $mobileMenu.append(mobileCategory);


                        });
                    }
                },
                fail: function() {
                    console.log("Error fetching categories");
                }
            });
        });
        // Function to add products to inventory or download them as a ZIP file
        function addToInventory(action, id = '') {
            // Object to store selected product variation IDs
            let product_id = {
                variation_id: [],
            };

            if (id) {
                product_id.variation_id.push(id);
            }

            // If no products are selected, show a warning using Swal
            if (product_id.variation_id.length == 0) {
                Swal.fire({
                    title: "No products selected!",
                    text: "Please select at least one checkbox.",
                    icon: "warning",
                    didOpen: () => {
                        // Apply inline CSS to the title
                        const titleElement = Swal.getTitle();
                        titleElement.style.color = 'red';
                        titleElement.style.fontSize = '20px';

                        // Apply inline CSS to the confirm button
                        const confirmButton = Swal.getConfirmButton();
                        confirmButton.style.backgroundColor = '#feca40';
                        confirmButton.style.color = 'white';
                    }
                });
                return; // Exit the function early if no products are selected
            }

            // If action is 'Inventory', send a POST request to add products to the inventory
            if (action == 'Inventory') {
                ApiRequest('store/product/inventory', 'POST', {
                        product_id
                    })
                    .then(response => {
                        // Handle success response
                        if (response.data.statusCode == 200) {
                            Swal.fire({
                                title: "Success!",
                                text: response.data.message,
                                icon: "success",
                                didOpen: () => {
                                    const titleElement = Swal.getTitle();
                                    titleElement.style.color = 'green';
                                    titleElement.style.fontSize = '20px';

                                    const confirmButton = Swal.getConfirmButton();
                                    confirmButton.style.backgroundColor = '#feca40';
                                    confirmButton.style.color = 'white';
                                }
                            });
                        }
                        // Handle error response with status code 201
                        else if (response.data.statusCode == 201) {
                            Swal.fire({
                                title: "Error!",
                                text: response.data.message,
                                icon: "error",
                                didOpen: () => {
                                    const titleElement = Swal.getTitle();
                                    titleElement.style.color = 'green';
                                    titleElement.style.fontSize = '20px';

                                    const confirmButton = Swal.getConfirmButton();
                                    confirmButton.style.backgroundColor = '#feca40';
                                    confirmButton.style.color = 'white';
                                }
                            });
                        }
                        // Handle other error responses
                        else {
                            Swal.fire({
                                title: "Error!",
                                text: response.data.message,
                                icon: "error",
                                didOpen: () => {
                                    const titleElement = Swal.getTitle();
                                    titleElement.style.color = 'red';
                                    titleElement.style.fontSize = '20px';

                                    const confirmButton = Swal.getConfirmButton();
                                    confirmButton.style.backgroundColor = '#feca40';
                                    confirmButton.style.color = 'white';
                                }
                            });
                        }
                    });
            }
            // If action is 'Download', download the selected products as a ZIP file
            else if (action == 'Download') { // Corrected the syntax here
                fetch('{{ route('product.inventory.export') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(product_id)
                    })
                    .then(response => {
                        if (response.status === 403) {
                            return response.json().then(data => {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Forbidden',
                                    text: data.data.message || 'You do not have permission to perform this action.',
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

                                throw new Error('Forbidden');
                            });
                        } else if (response.status === 422) {
                            return response.json().then(data => {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: data.data.message || 'Something went wrong. Please try again later.',
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

                                throw new Error('Error');
                            });
                        }
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.blob(); // Convert response to a Blob
                    })
                    .then(blob => {
                        const url = window.URL.createObjectURL(blob); // Create a URL for the Blob
                        const a = document.createElement('a');
                        a.style.display = 'none';
                        a.href = url;
                        a.download = 'products_' + Date.now() + '.zip'; // Set download file name
                        document.body.appendChild(a);
                        a.click(); // Programmatically click the link to trigger download
                        window.URL.revokeObjectURL(url); // Revoke the URL after download
                    })
                    .catch(error => {
                        console.error('Error downloading products:', error); // Log any errors
                    });
            }
        }

        function addToCart(id) {
            let product_id = [];

            if (id) {
                product_id.push(id);
            }
            ApiRequest("product/add-to-cart", 'POST', {
                    product_id: product_id
                })
                .then(response => {
                    if (response.data.statusCode == 200) {
                        Swal.fire({
                            title: "Success!",
                            text: response.data.message,
                            icon: "success",
                            didOpen: () => {
                                const titleElement = Swal.getTitle();
                                titleElement.style.color = 'green';
                                titleElement.style.fontSize = '20px';

                                const confirmButton = Swal.getConfirmButton();
                                confirmButton.style.backgroundColor = '#feca40';
                                confirmButton.style.color = 'white';
                            }
                        }).then(() => {
                            window.location.href = "{{ route('create.order') }}";
                        });
                    } else {
                        Swal.fire({
                            title: "Error!",
                            text: response.data.message,
                            icon: "error",
                            didOpen: () => {
                                const titleElement = Swal.getTitle();
                                titleElement.style.color = 'red';
                                titleElement.style.fontSize = '20px';

                                const confirmButton = Swal.getConfirmButton();
                                confirmButton.style.backgroundColor = '#feca40';
                                confirmButton.style.color = 'white';
                            }
                        });
                    }
                });
        }

        // Function to add a click count to the product variation
        function addToClickCount(url) {
            // Send a POST request to the API endpoint
            ApiRequest('add-click-count', 'POST', {
                    url: url
                })
                .then(response => {
                    window.location.href = url; // Redirect to the selected URL
                })
                .catch(error => {
                    console.error('Error adding click count:', error); // Log any errors
                });
        }
        // Function to handle the change event of the color dropdown
        document.getElementById('colorChange').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            addToClickCount(selectedOption.value);

        });

        document.querySelectorAll('input[name="size"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                if (this.checked) {
                    addToClickCount(this.value);
                }
            });
        });
    </script>
@endsection
