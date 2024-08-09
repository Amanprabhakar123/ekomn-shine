@extends('dashboard.layout.app')

@section('content')
<div class="ek_dashboard">
<div class="ek_content">
      <div class="card ekcard pa shadow-sm">
        <div class="cardhead">
          <h3 class="cardtitle">Buyer Inventory ({{$inventory_count}})</h3>
          <!-- <a href="create-order.html" class="btn btnekomn btn-sm"><i class="fas fa-plus fs-12 me-1"></i>Create New Order</a> -->
        </div>
        <div class="tableTop mt10">
          <input type="text" id="searchQuery" title="Search with Product Title, SKU, Product ID" class="form-control w_350_f searchicon" placeholder="Search with Product Title, SKU, Product ID">
          <div class="d-flex gap-2">
            <div class="ek_group m-0">
              <label class="eklabel eklabel_60 m-0">Status:</label>
                <div class="ek_f_input w_150_f">
                    <select class="form-select" id="sort_by_status">
                        <option value="0">Select</option>
                        <option value="1">Active</option>
                        <option value="2">Inactive</option>
                        <option value="3">Out of Stock</option>
                    </select>
                </div>
            </div>
            <button class="btn btn-sm btnekomn_dark" id="download_product"><i class="fas fa-download me-2"></i>Download</button>
          </div>
        </div>
        <div class="table-responsive tres_border"> 
          <table class="normalTable tableSorting whitespace">
            <thead>
              <tr>
                <th>Select</th>
                <th>Product Image</th>
                <th class="h_sorting"  data-sort-field="title">Product Title
                    <span class="sort_pos">
                        <small class="sort_t"><i class="fas fa-caret-up"></i><i class="fas fa-caret-down"></i></small>
                    </span>
                </th>
                <th class="h_sorting"  data-sort-field="sku">SKU
                    <span class="sort_pos">
                        <small class="sort_t"><i class="fas fa-caret-up"></i><i class="fas fa-caret-down"></i></small>
                    </span>
                </th>
                <th class="h_sorting" data-sort-field="product_slug_id">Product ID
                    <span class="sort_pos">
                        <small class="sort_t"><i class="fas fa-caret-up"></i><i class="fas fa-caret-down"></i></small>
                    </span>
                </th>
                <th class="h_sorting"  data-sort-field="stock">Stock
                    <span class="sort_pos">
                        <small class="sort_t"><i class="fas fa-caret-up"></i><i class="fas fa-caret-down"></i></small>
                    </span>
                </th>
                <th class="h_sorting" data-sort-field="price_after_tax">Selling Price
                    <span class="sort_pos">
                        <small class="sort_t"><i class="fas fa-caret-up"></i><i class="fas fa-caret-down"></i></small>
                    </span>
                </th>
                <th class="h_sorting"  data-sort-field="name">Category
                    <span class="sort_pos">
                        <small class="sort_t"><i class="fas fa-caret-up"></i><i class="fas fa-caret-down"></i></small>
                    </span>
                </th>
                <th>Availability</th>
                <th>Status</th>
                <th>Action</th>
                <th>Platform Live</th>
              </tr>
            </thead>
            <tbody id="dataContainer">
              <!-- Data will be displayed here -->
            </tbody>
          </table>
        </div>
        <div class="ek_pagination">
          <span class="row_select rowcount" id="rowInfo"></span>
          <div class="pager_box">
            <button id="prevPage" class="pager_btn"><i class="fas fa-chevron-left"></i></button>
            <ul class="pager_" id="pagination"></ul>
            <button id="nextPage" class="pager_btn"><i class="fas fa-chevron-right"></i></button>
          </div>
          <div class="row_select jumper">Go to
            <select id="rowsPerPage">
              <option value="10">10</option>
              <option value="50">50</option>
              <option selected value="100">100</option>
              <option value="200">200</option>
            </select>
          </div>
        </div>
        <!-- end pegination -->

          <!-- popup code -->

          <div id="overlay"></div>
            <div id="popupDialog">
                <h4 class="text-center">Product variation map with sales channel </h4>
                <hr>
                <div class="ek_group">
                    <!-- <label class="eklabel req"><span>Bulk Rate:<span class="req_star">*</span></span></label> -->
                    <div class="ek_f_input">
                      <div class="ekdiv">
                        <input type="hidden" name="product_variation_id" id="product_variation_id" value="">
                        <table class="normalTable addrowTable" id="bulkRateTable">
                          <thead>
                            <tr>
                              <th>Sales Channel</th>
                              <th>Sku</th>
                              <th style="width: 20px;"></th>
                            </tr>
                          </thead>
                          <tbody id="empty">
                          </tbody>
                        </table>
                        <button class="addNewRow" id="addNewRowButton" type="button">Add More</button>
                      </div>
                    </div>
                  </div>
                  
                <button class="btn btn-sm popup-btn text-white bg-secondary" style="margin-left:10px" onclick="closeFn()">
                    Close
                </button>
                <button id="popup-save-btn" class="btn btnekomn btn-sm popup-btn">
                    Save
                </button>
            </div>
      </div>
    </div>
@include('dashboard.layout.copyright')
</div>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const rowsPerPage = document.getElementById("rowsPerPage");
        const rowInfo = document.getElementById("rowInfo");
        const pagination = document.getElementById("pagination");
        const prevPage = document.getElementById("prevPage");
        const nextPage = document.getElementById("nextPage");
        const dataContainer = document.getElementById("dataContainer");
        let currentPage = 1;
        let rows = parseInt(rowsPerPage.value, 10);
        let totalRows = 0;

        // Event listener for the search input field
        const searchQuery = document.getElementById("searchQuery");
        searchQuery.addEventListener("keydown", (e) => {
            if (e.key === "Enter") {
                fetchData();
            }
        });

        // Event listener for clicking outside the search input field
        searchQuery.addEventListener("blur", (e) => {
            fetchData();
        });

        const sortByStatus = document.getElementById("sort_by_status");
        sortByStatus.addEventListener("change", () => {
            fetchData();
        });


        let sortField = ""; // Set the sort field here (e.g. "sku", "stock", "selling_price")
        let sortOrder = ""; // Set the sort order here (e.g. "asc", "desc")
        const h_sorting = document.querySelectorAll(".h_sorting");
        h_sorting.forEach(element => {
            element.addEventListener("click", () => {
            const sortFieldElement = element;
            sortField = sortFieldElement.getAttribute("data-sort-field");
            sortOrder = (sortOrder === "asc") ? "desc" : "asc";
            fetchData();
            h_sorting.forEach(el => {
                el.classList.remove("active");
                el.classList.remove("asc");
                el.classList.remove("desc");
            });
            element.classList.add("active");
            element.classList.add(sortOrder);
            });
        });
        // Function to fetch data from the server
        function fetchData() {
            // Make an API request to fetch inventory data
            let apiUrl = `my/product/inventory/?per_page=${rows}&page=${currentPage}`;

            if (sortField && sortOrder) {
                apiUrl += `&sort=${sortField}&order=${sortOrder}`;
            }

            if (searchQuery) {
                apiUrl += `&query=${searchQuery.value}`;
            }

            if (sortByStatus) {
                apiUrl += `&sort_by_status=${sortByStatus.value}`;
            }

            ApiRequest(apiUrl, 'GET')
                .then(response => {
                    const data = (response.data);
                    if (data.length === 0) {
                        dataContainer.innerHTML = `<tr><td colspan="10" class="text-center">No data found</td></tr>`;
                    } else {
                        response = (response.meta.pagination);
                        totalRows = response.total;
                        updatePagination();
                        displayData(data);
                    }
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        }

        // Function to update the pagination UI
        function updatePagination() {
            const totalPages = Math.ceil(totalRows / rows);
            pagination.innerHTML = "";
            let pageList = "";
            if (totalPages <= 5) {
                for (let i = 1; i <= totalPages; i++) {
                    pageList += `<li><a href="#" class="${i === currentPage ? "active" : ""}" data-page="${i}">${i}</a></li>`;
                }
            } else {
                if (currentPage <= 3) {
                    for (let i = 1; i <= 4; i++) {
                        pageList += `<li><a href="#" class="${i === currentPage ? "active" : ""}" data-page="${i}">${i}</a></li>`;
                    }
                    pageList += `<li>...</li>`;
                    pageList += `<li><a href="#" data-page="${totalPages}">${totalPages}</a></li>`;
                } else if (currentPage >= totalPages - 2) {
                    pageList += `<li><a href="#" data-page="1">1</a></li>`;
                    pageList += `<li>...</li>`;
                    for (let i = totalPages - 3; i <= totalPages; i++) {
                        pageList += `<li><a href="#" class="${i === currentPage ? "active" : ""}" data-page="${i}">${i}</a></li>`;
                    }
                } else {
                    pageList += `<li><a href="#" data-page="1">1</a></li>`;
                    pageList += `<li>...</li>`;
                    for (let i = currentPage - 1; i <= currentPage + 1; i++) {
                        pageList += `<li><a href="#" class="${i === currentPage ? "active" : ""}" data-page="${i}">${i}</a></li>`;
                    }
                    pageList += `<li>...</li>`;
                    pageList += `<li><a href="#" data-page="${totalPages}">${totalPages}</a></li>`;
                }
            }
            pagination.innerHTML = pageList;
            updateRowInfo();
            prevPage.disabled = currentPage === 1;
            nextPage.disabled = currentPage === totalPages;
        }

        // Function to update the row information
        function updateRowInfo() {
            const startRow = (currentPage - 1) * rows + 1;
            const endRow = Math.min(currentPage * rows, totalRows);
            rowInfo.textContent = `Showing ${startRow} to ${endRow} of ${totalRows}`;
        }

        // Function to display the inventory data in the table
        function displayData(items) {
            dataContainer.innerHTML = items.map(generateTableRow).join("");
        }

        // Event listener for the "rowsPerPage" select element
        rowsPerPage.addEventListener("change", (e) => {
            rows = parseInt(e.target.value, 10);
            currentPage = 1;
            fetchData();
        });

        // Event listener for the pagination links
        pagination.addEventListener("click", (e) => {
            if (e.target.tagName === "A") {
                currentPage = parseInt(e.target.dataset.page, 10);
                fetchData();
            }
        });

        // Event listener for the "prevPage" button
        prevPage.addEventListener("click", () => {
            if (currentPage > 1) {
                currentPage--;
                fetchData();
            }
        });

        // Event listener for the "nextPage" button
        nextPage.addEventListener("click", () => {
            const totalPages = Math.ceil(totalRows / rows);
            if (currentPage < totalPages) {
                currentPage++;
                fetchData();
            }
        });

        // Initial fetch of data
        fetchData();

    });

    /**
     * Generates a table row HTML markup for a given item.
     *
     * @param {Object} item - The item object containing the details.
     * @returns {string} - The HTML markup for the table row.
     */
    function generateTableRow(item) {
        let btn = ``;
        if(item.live){
            btn = `<button class="btn btn-sm btnekomn" onclick="popupEditFn('${item.variation_id}')"> Edit</button>
            <button class="btn btn-sm btn-danger" onclick="deleteFn('${item.variation_id}')"> Delete</button>`;
        }else{
            btn = `<button class="btn btn-sm btnekomn" onclick="popupFn('${item.variation_id}')"> Add</button>`;
        }
               
        return `
        <tr>
            <td>
                <div class="form-check">
                <input type="checkbox" id="${item.variation_id}" class="form-check-input">
                <label for="${item.variation_id}" class="ms-1"></label>
                </div>
            </td>
            <td>
                <div class="productImg_t">
                    <img src="${item.product_image}" alt="Product Image">
                </div>
            </td>
            <td>
                <div class="productTitle_t">
                    <a href="${item.link}" class="a_link">${item.title}</a>
                </div>
            </td>
            <td>
                <div class="sku_t">${item.sku}</div>
            </td>
            <td>
                ${item.product_id}
            </td>
            <td>
                <div class="sell_t"> ${item.stock}</div>
            </td>
            <td>
                <div class="sell_t"><i class="fas fa-rupee-sign"></i> ${item.selling_price}</div>
            </td>
            <td>
                <div>${item.product_category}</div>
            </td>
            <td>
                <div>${item.availability_status}</div>
            </td>
              <td>
                <div>${item.status}</div>
            </td>
            <td>
               <button class="btn btn-sm btn-danger" ${item.live ? "disabled" : ""}  onclick="remove('${item.id}')"> Remove</button>
            </td>
             <td>
                ${btn}
            </td>
        </tr>
    `;
    }

    /**
     * Removes a product from the inventory.
     *
     * @param {number} id - The ID of the product to be removed.
     */
    function remove(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to remove this product from your inventory!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, remove it!',
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
                ApiRequest(`remove/product/inventory/${id}`, 'DELETE')
                    .then(response => {
                        if (response.data.statusCode == 200) {
                                Swal.fire({
                                 title:'Deleted!',
                                 text: response.data.message,
                                 icon: "success",
                                didOpen: () => {
                                // Apply inline CSS to the title
                                const title = Swal.getTitle();
                                title.style.color = 'red';
                                title.style.fontSize = '20px';

                                // Apply inline CSS to the content
                                const content = Swal.getHtmlContainer();

                                // Apply inline CSS to the confirm button
                                const confirmButton = Swal.getConfirmButton();
                                confirmButton.style.backgroundColor = '#feca40';
                                confirmButton.style.color = 'white';
                                }
                            }).then(() => {
                                window.location.reload();
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error deleting product:', error);
                    });
            }
        });
    }
    const downloadProduct = document.getElementById("download_product");
    downloadProduct.addEventListener("click", () => {
    const checkboxes = document.querySelectorAll(".form-check-input:checked");
    const variationIds = Array.from(checkboxes).map(checkbox => checkbox.id);
    const data = { variation_id: [] };
    
    // add variationIds to the form data
    variationIds.forEach(variationId => {
        data.variation_id.push(variationId);
    });

    if (variationIds.length === 0) {
        Swal.fire({
            title: 'No products selected',
            text: 'Please select at least one product to download',
            icon: 'warning',
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
    } else {
        // Make an API request to download the selected products
        fetch('{{route("product.inventory.export")}}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
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
            a.download = 'products_' + Date.now() + '.zip';
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
        })
        .catch(error => {
            console.error('Error downloading products:', error);
        });
    }
});

    </script>
    <!-- popup javascript code here  -->

    <script>
        function popupFn(id) {
            document.getElementById("overlay").style.display = "block";
            document.getElementById("popupDialog").style.display = "block";
            document.getElementById("product_variation_id").value = id;
            document.getElementById("empty").innerHTML = '';
            let index = $('#bulkRateTable tbody tr').length;

                const newRow = `
                    <tr>
                        <td>
                            <select class="form-select" id="salesChannel" required>
                                <option value="">Select</option>
                                @if(is_array($selectData))
                                    @foreach($selectData as $data)
                                        <option value="{{ $data['id'] }}">{{ $data['name'] }}</option>
                                    @endforeach
                                @else
                                    <option value="">No data available</option>
                                @endif
                            </select>
                            <div id="salesChannelErr" class="invalid-feedback"></div>
                        </td>
                        <td>
                            <input type="text" class="smallInput_n " id="sku" placeholder="Sku" name="sku" required>
                        <div id="skuErr" class="invalid-feedback"></div>
                            </td>
                        <td>
                        </td>
                    </tr>`;
                        $('#bulkRateTable tbody').append(newRow);
        }
                            
          function closeFn() {
            document.getElementById("overlay").style.display = "none";
            document.getElementById("popupDialog").style.display = "none";
        }

        document.getElementById("overlay").addEventListener("click", function(event) {
            if (event.target === this) {
                closeFn();
            }
        });

        $('#addNewRowButton').click(function() {
    let index = $('#bulkRateTable tbody tr').length;

    const newRow = `
        <tr>
            <td>
                <select class="form-select" id="salesChannel${index}" required>
                    <option value="">Select</option>
                    @if(is_array($selectData))
                        @foreach($selectData as $data)
                            <option value="{{ $data['id'] }}">{{ $data['name'] }}</option>
                        @endforeach
                    @else
                        <option value="">No data available</option>
                    @endif
                </select>
                <div id="salesChannelErr${index}" class="invalid-feedback"></div>
            </td>
            <td>
                <input type="text" class="smallInput_n " id="sku${index}" placeholder="Sku" name="sku" required>
            <div id="skuErr${index}" class="invalid-feedback"></div>
                </td>
            <td>
                 <button type="button" class="deleteRow deleteBulkRow"><i class="far fa-trash-alt"></i></button>
                 
            </td>
        </tr>`;
            $('#bulkRateTable tbody').append(newRow);
        });

   // Event delegation for dynamically created delete buttons
        $('#bulkRateTable').on('click', '.deleteRow', function() {
            $(this).closest('tr').remove();
        });

        $('#popup-save-btn').click(function() {
            let formData = new FormData();
            let salesChannelIds = [];
            let duplicateFound = false;

            $('#bulkRateTable tbody tr').each(function() {
                const salesChannelId = $(this).find('select').val();
                if (salesChannelIds.includes(salesChannelId)) {
                    duplicateFound = true;
                    return false; // exit the loop
                }
                salesChannelIds.push(salesChannelId);

                formData.append('sales_channel_id[]', salesChannelId);
                formData.append('sales_channel_product_sku[]', $(this).find('input').val());
            });

            if (duplicateFound) {
               Swal.fire({
                    title: 'Error',
                    text: 'Duplicate sales channels found. Please select unique sales channels.',
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
                return; // stop further execution
            }

            formData.append('product_variation_id', $('#product_variation_id').val());

            ApiRequest(`store/product/mapchannel`, 'POST', formData)
                .then(response => {
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
                        }).then(() => {
                            closeFn();
                            window.location.reload();
                        });
                    }
                })
                .catch(error => {
                    console.error('Error adding product:', error);
                });
        });

        function popupEditFn(id){
          
            let formData = new FormData();
            formData.append('product_variation_id', id);
            
            ApiRequest(`edit/product/mapchannel`, 'POST', formData)
            .then(response => {
                const data = response.data;
                document.getElementById("empty").innerHTML = '';
                if(data.statusCode ==200){
                    data.list.forEach((item, index)=>{
                        const selectOptions = <?php echo json_encode($selectData); ?>;
                        const newRow = `
                            <tr>
                                <td>
                                    <select class="form-select" id="salesChannel${index}" required>
                                        <option value="">Select</option>
                                        ${selectOptions.map(option => {
                                            return `<option value="${option.id}" ${option.id == item.sales_channel_id ? 'selected' : ''}>${option.name}</option>`;
                                        }).join('')}
                                    </select>
                                    <div id="salesChannelErr${index}" class="invalid-feedback"></div>
                                </td>
                                <td>
                                    <input type="text" class="smallInput_n " id="sku${index}" placeholder="Sku" name="sku" value="${item.sales_channel_product_sku}" required>
                                    <div id="skuErr${index}" class="invalid-feedback"></div>
                                </td>
                                <td>
                                    <button type="button" class="deleteRow deleteBulkRow"><i class="far fa-trash-alt"></i></button>
                                </td>
                            </tr>`;
                            $('#bulkRateTable tbody').append(newRow);
                    });

                    document.getElementById("overlay").style.display = "block";
                    document.getElementById("popupDialog").style.display = "block";
                    document.getElementById("product_variation_id").value = id;
                }
            })  
            .catch(error => {
                console.error('Error fetching data:', error);
            });
            
        }

        // delete function
        function deleteFn(id){

            // add swal confirmation popup
            Swal.fire({
                title: 'Confirmation',
                text: 'Are you sure you want to delete this product?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
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
                    // Perform delete operation here
                    let formData = new FormData();
                    formData.append('product_variation_id', id);
                    ApiRequest(`delete/product/mapchannel`, 'POST', formData)
                        .then(response => {
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
                                }).then(() => {
                                    closeFn();
                                    window.location.reload();
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error deleting product:', error);
                        });
                }
            });
        }
    </script>
    
@endsection