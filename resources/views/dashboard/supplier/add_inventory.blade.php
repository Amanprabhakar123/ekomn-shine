@extends('dashboard.layout.app')

@section('content')
<div class="ek_dashboard">
    <div class="ek_content">
        <div class="card ekcard pa shadow-sm">
            <div class="cardhead">
                <h3 class="cardtitle">Add Inventory</h3>
                <button type="button" class="btn btnekomn btn-sm">Bulk Upload<i class="fas fa-cloud-upload-alt ms-2"></i></button>
            </div>
            <div>
                <ul class="nav nav-underline ekom_tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" role="tab" aria-controls="general" aria-selected="true">General</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="data-tab" data-bs-toggle="tab" data-bs-target="#data" role="tab" aria-controls="data" aria-selected="false">Data</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="shipping-tab" data-bs-toggle="tab" data-bs-target="#shipping" role="tab" aria-controls="shipping" aria-selected="false">Pricing & Shipping</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="images-tab" data-bs-toggle="tab" data-bs-target="#images" type="button" role="tab" aria-controls="images" aria-selected="false">Product Images & Variants</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="dimensions-tab" data-bs-toggle="tab" data-bs-target="#dimensions" type="button" role="tab" aria-controls="dimensions" aria-selected="false">Dimensions</button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab" tabindex="0">
                        <form action="">
                            <div class="addProductForm">
                                <div class="ek_group">
                                    <label class="eklabel req"><span>Product Name:<span class="req_star">*</span></span></label>
                                    <div class="ek_f_input">
                                        <input type="text" class="form-control" placeholder="Your business name" />
                                        <span class="text-danger hide">errr message</span>
                                    </div>
                                </div>
                                <div class="ek_group">
                                    <label class="eklabel req"><span>Description:<span class="req_star">*</span></span></label>
                                    <div class="ek_f_input">
                                        <textarea class="form-control" placeholder="Product description"></textarea>
                                        <span class="text-danger hide">errr message</span>
                                    </div>
                                </div>
                                <div class="ek_group">
                                    <label class="eklabel"><span>Product Keywords:<span class="req_star">*</span></span></label>
                                    <div class="ek_f_input">
                                        <div class="tag-container">
                                            <div class="tag-input">
                                                <input type="text" id="tag-input" placeholder="Type and press comma" class="form-control">
                                            </div>
                                        </div>
                                        <span class="text-danger hide">errr message</span>
                                    </div>
                                </div>
                                <div class="ek_group">
                                    <label class="eklabel req"><span>Product Features:<span class="req_star">*</span></span></label>
                                    <div class="ek_f_input">
                                        <textarea id="product-description" class="form-control" placeholder="Enter Product Features & Press Add Button"></textarea>
                                        <div class="clearfix">
                                            <span class="fs-14 opacity-25">You can only add up to 7 features</span>
                                            <button id="add-feature" type="button" class="btn addNewRow px-3">Add</button>
                                        </div>
                                        <span id="error-message" class="text-danger hide">errr message</span>
                                        <ol id="features-list" class="featureslisting"></ol>
                                    </div>
                                </div>
                                <div class="ek_group">
                                    <label class="eklabel mt20"><span>Product Category:<span class="req_star">*</span></span></label>
                                    <div class="ek_f_input">
                                        <div class="row">
                                            <div class="mb10 col-sm-12 col-md-3">
                                                <label style="font-size: 13px;opacity: 0.6;">Main Category</label>
                                                <select class="form-select">
                                                    <option value="category1">Category</option>
                                                </select>
                                                <span class="text-danger hide">errr message</span>
                                            </div>
                                            <div class="form-group col-sm-12 col-md-3">
                                                <label style="font-size: 13px;opacity: 0.6;">Sub Category</label>
                                                <select class="form-select">
                                                    <option value="category1">Sub Category</option>
                                                </select>
                                                <span class="text-danger hide">errr message</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="saveform_footer text-right">
                                <button type="button" class="btn btn-login btnekomn card_f_btn next_Tab">Save & Next</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="data" role="tabpanel" aria-labelledby="data-tab" tabindex="0">
                        <form action="">
                            <div class="addProductForm">
                                <div class="row">
                                    <div class="col-sm-12 col-md-4">
                                        <div class="ek_group">
                                            <label class="eklabel req"><span>Model:<span class="req_star">*</span></span></label>
                                            <div class="ek_f_input">
                                                <input type="text" class="form-control" placeholder="Enter Modal Number" />
                                                <span class="text-danger hide">errr message</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="ek_group">
                                            <label class="eklabel req"><span>Product HSN:<span class="req_star">*</span></span></label>
                                            <div class="ek_f_input">
                                                <input type="text" class="form-control" placeholder="Enter HSN Code" />
                                                <span class="text-danger hide">errr message</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="ek_group">
                                            <label class="eklabel req"><span>GST Bracket:<span class="req_star">*</span></span></label>
                                            <div class="ek_f_input">
                                                <select class="form-select">
                                                    <option value="0">0%</option>
                                                    <option value="5" selected>5%</option>
                                                    <option value="12">12%</option>
                                                    <option value="18">18%</option>
                                                    <option value="28">28%</option>
                                                </select>
                                                <span class="text-danger hide">errr message</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="ek_group">
                                            <label class="eklabel req"><span>Availability:<span class="req_star">*</span></span></label>
                                            <div class="ek_f_input">
                                                <select class="form-select">
                                                    <option value="till">Till Stock Lasts</option>
                                                    <option value="available" selected>Regular Available</option>
                                                </select>
                                                <span class="text-danger hide">errr message</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="ek_group">
                                            <label class="eklabel req">UPC:</label>
                                            <div class="ek_f_input">
                                                <input type="text" class="form-control" placeholder="Universal Product Code" />
                                                <span class="text-danger hide">errr message</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="ek_group">
                                            <label class="eklabel req">ISBN:</label>
                                            <div class="ek_f_input">
                                                <input type="text" class="form-control" placeholder="International Standard Book Number" />
                                                <span class="text-danger hide">errr message</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="ek_group">
                                            <label class="eklabel req">MPN:</label>
                                            <div class="ek_f_input">
                                                <input type="text" class="form-control" placeholder="Manufacturer Port Number" />
                                                <span class="text-danger hide">errr message</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="saveform_footer">
                                <button type="button" class="btn btn-login btnekomn card_f_btn previous_Tab"><i class="fas fa-arrow-left me-3 fs-13"></i>Back</button>
                                <button type="button" class="btn btn-login btnekomn card_f_btn next_Tab">Save & Next</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="shipping" role="tabpanel" aria-labelledby="shipping-tab" tabindex="0">
                        <form action="">
                            <div class="addProductForm">
                                <div class="row">
                                    <div class="col-sm-12 col-md-4">
                                        <div class="ek_group">
                                            <label class="eklabel req"><span>Dropship Rate:<span class="req_star">*</span></span></label>
                                            <div class="ek_f_input">
                                                <input type="text" class="form-control" placeholder="Enter Dropship Rate" />
                                                <span class="text-danger hide">errr message</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="ek_group">
                                            <label class="eklabel req"><span>Potential MRP:<span class="req_star">*</span></span></label>
                                            <div class="ek_f_input">
                                                <input type="text" class="form-control" placeholder="Enter Potential MRP" />
                                                <span class="text-danger hide">errr message</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <div class="ek_group">
                                            <label class="eklabel req"><span>Bulk Rate:<span class="req_star">*</span></span></label>
                                            <div class="ek_f_input">
                                                <div class="">
                                                    <table class="normalTable addrowTable" id="bulkRateTable">
                                                        <thead>
                                                            <tr>
                                                                <th>Quantity upto</th>
                                                                <th>Price / Per Piece</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <input type="text" class="smallInput_n" placeholder="Qty. Upto">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="smallInput_n" placeholder="Rs. 0.00">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <input type="text" class="smallInput_n" placeholder="Qty. Upto">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="smallInput_n" placeholder="Rs. 0.00">
                                                                    <button class="deleteRow deleteBulkRow"><i class="far fa-trash-alt"></i></button>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <button class="addNewRow" id="addNewRowButton" type="button">Add More</button>
                                                </div>
                                                <span class="text-danger hide">errr message</span>
                                            </div>
                                        </div>
                                        <div class="ek_group">
                                            <label class="eklabel req"><span>Shipping Rate:<span class="req_star">*</span></span></label>
                                            <div class="ek_f_input">
                                                <div class="">
                                                    <table class="normalTable addrowTable" id="shippingRateTable">
                                                        <thead>
                                                            <tr>
                                                                <th>Quantity upto</th>
                                                                <th>Local</th>
                                                                <th>Regional</th>
                                                                <th>National</th>
                                                                <th style="width: 20px;"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <input type="text" class="smallInput_n w_40" placeholder="0"><span class="totext">To</span><input type="text" class="smallInput_n w_40" placeholder="0">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="smallInput_n" placeholder="Rs. 0.00">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="smallInput_n" placeholder="Rs. 0.00">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="smallInput_n" placeholder="Rs. 0.00">
                                                                </td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <input type="text" class="smallInput_n w_40" placeholder="0"><span class="totext">To</span><input type="text" class="smallInput_n w_40" placeholder="0">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="smallInput_n" placeholder="Rs. 0.00">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="smallInput_n" placeholder="Rs. 0.00">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="smallInput_n" placeholder="Rs. 0.00">
                                                                </td>
                                                                <td>
                                                                    <button class="deleteRow deleteShippingRow" type="button"><i class="far fa-trash-alt"></i></button>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <button class="addNewRow" id="addShippingRow" type="button">Add More</button>
                                                </div>
                                                <span class="text-danger hide">errr message</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="saveform_footer">
                                <button type="button" class="btn btn-login btnekomn card_f_btn previous_Tab"><i class="fas fa-arrow-left me-3 fs-13"></i>Back</button>
                                <button type="button" class="btn btn-login btnekomn card_f_btn next_Tab">Save & Next</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="images" role="tabpanel" aria-labelledby="images-tab" tabindex="0">
                        <form action="">
                            <div class="addProductForm">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequuntur qui beatae dolores pariatur, dicta molestiae quasi eum unde ipsum cum exercitationem officia iusto ex aliquid temporibus, illo corrupti! Vero, nesciunt?
                            </div>
                            <div class="saveform_footer">
                                <button type="button" class="btn btn-login btnekomn card_f_btn previous_Tab"><i class="fas fa-arrow-left me-3 fs-13"></i>Back</button>
                                <button type="button" class="btn btn-login btnekomn card_f_btn next_Tab">Save & Next</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="dimensions" role="tabpanel" aria-labelledby="dimensions-tab" tabindex="0">
                        <form action="">
                            <div class="addProductForm eklabel_w">
                                <h4 class="subheading">Product Dimensions</h4>
                                <div class="row">
                                    <div class="col-sm-12 col-md-3">
                                        <div class="ek_group">
                                            <label class="eklabel req"><span>Length:<span class="req_star">*</span></span></label>
                                            <div class="ek_f_input">
                                                <input type="text" class="form-control" placeholder="100" />
                                                <span class="text-danger hide">errr message</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3">
                                        <div class="ek_group">
                                            <label class="eklabel req"><span>width:<span class="req_star">*</span></span></label>
                                            <div class="ek_f_input">
                                                <input type="text" class="form-control" placeholder="100" />
                                                <span class="text-danger hide">errr message</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3">
                                        <div class="ek_group">
                                            <label class="eklabel req"><span>Height:<span class="req_star">*</span></span></label>
                                            <div class="ek_f_input">
                                                <input type="text" class="form-control" placeholder="100" />
                                                <span class="text-danger hide">errr message</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3">
                                        <div class="ek_group">
                                            <label class="eklabel req"><span>Dimension Class:<span class="req_star">*</span></span></label>
                                            <div class="ek_f_input">
                                                <input type="text" class="form-control" placeholder="mm/cm/Inch" />
                                                <span class="text-danger hide">errr message</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3">
                                        <div class="ek_group">
                                            <label class="eklabel req"><span>Weight:<span class="req_star">*</span></span></label>
                                            <div class="ek_f_input">
                                                <input type="text" class="form-control" placeholder="mm/cm/Inch" />
                                                <span class="text-danger hide">errr message</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3">
                                        <div class="ek_group">
                                            <label class="eklabel req"><span>Weight Class:<span class="req_star">*</span></span></label>
                                            <div class="ek_f_input">
                                                <input type="text" class="form-control" placeholder="gram/ml" />
                                                <span class="text-danger hide">errr message</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h4 class="subheading">Package Dimensions Per Piece</h4>
                                <div class="row">
                                    <div class="col-sm-12 col-md-3">
                                        <div class="ek_group">
                                            <label class="eklabel req"><span>Length:<span class="req_star">*</span></span></label>
                                            <div class="ek_f_input">
                                                <input type="text" class="form-control" placeholder="100" />
                                                <span class="text-danger hide">errr message</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3">
                                        <div class="ek_group">
                                            <label class="eklabel req"><span>width:<span class="req_star">*</span></span></label>
                                            <div class="ek_f_input">
                                                <input type="text" class="form-control" placeholder="100" />
                                                <span class="text-danger hide">errr message</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3">
                                        <div class="ek_group">
                                            <label class="eklabel req"><span>Height:<span class="req_star">*</span></span></label>
                                            <div class="ek_f_input">
                                                <input type="text" class="form-control" placeholder="100" />
                                                <span class="text-danger hide">errr message</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3">
                                        <div class="ek_group">
                                            <label class="eklabel req"><span>Dimension Class:<span class="req_star">*</span></span></label>
                                            <div class="ek_f_input">
                                                <input type="text" class="form-control" placeholder="mm/cm/Inch" />
                                                <span class="text-danger hide">errr message</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3">
                                        <div class="ek_group">
                                            <label class="eklabel req"><span>Weight:<span class="req_star">*</span></span></label>
                                            <div class="ek_f_input">
                                                <input type="text" class="form-control" placeholder="mm/cm/Inch" />
                                                <span class="text-danger hide">errr message</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3">
                                        <div class="ek_group">
                                            <label class="eklabel req"><span>Weight Class:<span class="req_star">*</span></span></label>
                                            <div class="ek_f_input">
                                                <input type="text" class="form-control" placeholder="gram/ml" />
                                                <span class="text-danger hide">errr message</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3">
                                        <div class="ek_group">
                                            <label class="eklabel req"><span>Volumetric Weight:<span class="req_star">*</span></span></label>
                                            <div class="ek_f_input">
                                                <input type="text" class="form-control" placeholder="L*W*H/5000" />
                                                <span class="text-danger hide">errr message</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="saveform_footer">
                                <button type="button" class="btn btn-login btnekomn card_f_btn previous_Tab"><i class="fas fa-arrow-left me-3 fs-13"></i>Back</button>
                                <button type="button" class="btn btn-login btnekomn card_f_btn px-5">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('dashboard.layout.copyright')
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // form footer button
        const footers = document.querySelectorAll('.saveform_footer');
        footers.forEach(function(footer) {
            const buttons = footer.querySelectorAll('button');
            if (buttons.length === 1) {
                footer.classList.add('single-button');
            }
        });
        // end
        // add product tab next & previous
        const next_Tab = document.querySelectorAll('.next_Tab');
        const previous_Tab = document.querySelectorAll('.previous_Tab');
        next_Tab.forEach(button => {
            button.addEventListener('click', function() {
                const currentTab = document.querySelector('.tab-pane.active');
                const nextTab = currentTab.nextElementSibling;
                if (nextTab && nextTab.classList.contains('tab-pane')) {
                    const currentTabId = currentTab.getAttribute('id');
                    const nextTabId = nextTab.getAttribute('id');
                    document.querySelector(`[data-bs-target="#${currentTabId}"]`).classList.remove('active');
                    document.querySelector(`[data-bs-target="#${nextTabId}"]`).classList.add('active');
                    currentTab.classList.remove('show', 'active');
                    nextTab.classList.add('show', 'active');
                }
            });
        });
        previous_Tab.forEach(button => {
            button.addEventListener('click', function() {
                const currentTab = document.querySelector('.tab-pane.active');
                const prevTab = currentTab.previousElementSibling;
                if (prevTab && prevTab.classList.contains('tab-pane')) {
                    const currentTabId = currentTab.getAttribute('id');
                    const prevTabId = prevTab.getAttribute('id');
                    document.querySelector(`[data-bs-target="#${currentTabId}"]`).classList.remove('active');
                    document.querySelector(`[data-bs-target="#${prevTabId}"]`).classList.add('active');
                    currentTab.classList.remove('show', 'active');
                    prevTab.classList.add('show', 'active');
                }
            });
        });
        // end

        // Add or Remove Bulk Rate Row
        document.getElementById('addNewRowButton').addEventListener('click', function() {
            const tableBody = document.querySelector('#bulkRateTable tbody');
            const newRow = document.createElement('tr');
            const quantityCell = document.createElement('td');
            const quantityInput = document.createElement('input');
            quantityInput.type = 'text';
            quantityInput.className = 'smallInput_n';
            quantityInput.placeholder = 'Qty. Upto';
            quantityCell.appendChild(quantityInput);

            const priceCell = document.createElement('td');
            const priceInput = document.createElement('input');
            priceInput.type = 'text';
            priceInput.className = 'smallInput_n';
            priceInput.placeholder = 'Rs. 0.00';
            priceCell.appendChild(priceInput);

            const deleteButton = document.createElement('button');
            deleteButton.className = 'deleteRow deleteBulkRow';
            deleteButton.innerHTML = '<i class="far fa-trash-alt"></i>';
            priceCell.appendChild(deleteButton);

            newRow.appendChild(quantityCell);
            newRow.appendChild(priceCell);
            tableBody.appendChild(newRow);
            deleteButton.addEventListener('click', function() {
                newRow.remove();
            });
        });
        document.querySelectorAll('.deleteBulkRow').forEach(button => {
            button.addEventListener('click', function() {
                button.closest('#bulkRateTable tr').remove();
            });
        });
        // end


        // Add or Remove Shipping Rate Row
        const addShippingDetails = document.getElementById('addShippingRow')
        addShippingDetails.addEventListener('click', function() {
            const shippingTableBody = document.querySelector('#shippingRateTable tbody');
            const newShipingRow = document.createElement('tr');
            const quantityuptoCell = document.createElement('td');
            const quantityuptoInput = document.createElement('input');
            quantityuptoInput.type = 'text';
            quantityuptoInput.className = 'smallInput_n w_40';
            quantityuptoInput.placeholder = '0';
            const toText = document.createElement('span');
            toText.className = 'totext';
            toText.textContent = 'To';
            const quantityuptoInput_2 = document.createElement('input');
            quantityuptoInput_2.type = 'text';
            quantityuptoInput_2.className = 'smallInput_n w_40';
            quantityuptoInput_2.placeholder = '0';
            quantityuptoCell.appendChild(quantityuptoInput);
            quantityuptoCell.appendChild(toText);
            quantityuptoCell.appendChild(quantityuptoInput_2);

            const localPrice = document.createElement('td');
            const localPriceInput = document.createElement('input');
            localPriceInput.type = 'text';
            localPriceInput.className = 'smallInput_n';
            localPriceInput.placeholder = 'Rs. 0.00';
            localPrice.appendChild(localPriceInput);

            const regionalPrice = document.createElement('td');
            const regionalPriceInput = document.createElement('input');
            regionalPriceInput.type = 'text';
            regionalPriceInput.className = 'smallInput_n';
            regionalPriceInput.placeholder = 'Rs. 0.00';
            regionalPrice.appendChild(regionalPriceInput);

            const nationalPrice = document.createElement('td');
            const nationalPriceInput = document.createElement('input');
            nationalPriceInput.type = 'text';
            nationalPriceInput.className = 'smallInput_n';
            nationalPriceInput.placeholder = 'Rs. 0.00';
            nationalPrice.appendChild(nationalPriceInput);

            const deletShippingRow = document.createElement('td');
            const deletShippingBtn = document.createElement('button');
            deletShippingBtn.type = 'button';
            deletShippingBtn.className = 'deleteRow deleteShippingRow';
            deletShippingBtn.innerHTML = '<i class="far fa-trash-alt"></i>';
            deletShippingRow.appendChild(deletShippingBtn);

            newShipingRow.appendChild(quantityuptoCell);
            newShipingRow.appendChild(localPrice);
            newShipingRow.appendChild(regionalPrice);
            newShipingRow.appendChild(nationalPrice);
            newShipingRow.appendChild(deletShippingRow);
            shippingTableBody.appendChild(newShipingRow);

            deletShippingRow.addEventListener('click', function() {
                newShipingRow.remove();
            });
        });
        document.querySelectorAll('.deleteShippingRow').forEach(button => {
            button.addEventListener('click', function() {
                console.log('hiiii')
                button.closest('#shippingRateTable tr').remove();
            });
        });
        // end

        // add product keywords
        const tagContainer = document.querySelector(".tag-container");
        const input = document.querySelector("#tag-input");

        function createTag(label) {
            const div = document.createElement("div");
            div.setAttribute("class", "tag");
            const span = document.createElement("span");
            span.innerHTML = label.trim();
            div.appendChild(span);
            const closeIcon = document.createElement("span");
            closeIcon.innerHTML = "x";
            closeIcon.setAttribute("class", "remove-tag");
            closeIcon.onclick = function() {
                tagContainer.removeChild(div);
            };
            div.appendChild(closeIcon);
            return div;
        }

        function addTag() {
            const inputValue = input.value.trim().replace(/,$/, '');
            if (inputValue !== "") {
                const tag = createTag(inputValue);
                tagContainer.insertBefore(tag, input.parentElement);
                input.value = "";
            }
        }
        input.addEventListener("keyup", function(e) {
            if (e.key === "Enter" || e.key === ",") {
                addTag();
            }
        });
        input.addEventListener("blur", function() {
            addTag();
        });
    });
    document.getElementById('add-feature').addEventListener('click', function() {
        const textarea = document.getElementById('product-description');
        const featureList = document.getElementById('features-list');
        const errorMessage = document.getElementById('error-message');
        if (textarea.value.trim() === '') {
            errorMessage.classList.remove('hide');
            return;
        } else {
            errorMessage.classList.add('hide');
        }
        const newFeature = document.createElement('li');
        newFeature.innerHTML = `
      <div class="featurescontent">
        ${textarea.value.replace(/\n/g, '<br>')}
        <div class="f_btn f_btn_rightSide">
          <button class="btn btn-link btn-sm me-1 p-1 edit-feature" type="button"><i class="fas fa-pencil-alt"></i></button>
          <button class="btn btn-link btn-sm text-danger p-1 delete-feature" type="button"><i class="fas fa-trash"></i></button>
        </div>
      </div>
    `;
        featureList.appendChild(newFeature);
        textarea.value = '';
        if (featureList.children.length >= 7) {
            document.getElementById('add-feature').disabled = true;
        }
        newFeature.querySelector('.delete-feature').addEventListener('click', function() {
            newFeature.remove();
            if (featureList.children.length < 7) {
                document.getElementById('add-feature').disabled = false;
            }
        });
        newFeature.querySelector('.edit-feature').addEventListener('click', function() {
            const content = newFeature.querySelector('.featurescontent').innerHTML
                .split('<div')[0].trim().replace(/<br>/g, '\n');
            textarea.value = content;
            newFeature.remove();
            if (featureList.children.length < 7) {
                document.getElementById('add-feature').disabled = false;
            }
        });
    });
</script>
@endsection