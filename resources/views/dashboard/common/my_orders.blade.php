@extends('dashboard.layout.app')

@section('content')
    <div class="ek_dashboard">
        <div class="ek_content">
            @if (auth()->user()->hasRole(ROLE_BUYER))
                <div class="card ekcard pa shadow-sm">
                    <div class="cardhead">
                        <h3 class="cardtitle">My Orders</h3>
                        <a href="{{ route('create.order') }}" class="btn btnekomn btn-sm"><i
                                class="fas fa-plus fs-12 me-1"></i>Create New Order</a>
                    </div>
                    <div class="tableTop mt10">
                        <input type="text" id="searchQuery" title="Search with eKomn Order, Store Order or Customer name"
                            class="form-control w_300_f searchicon" placeholder="Search">
                        <div class="ek_group m-0">
                            <label class="eklabel eklabel_60 m-0">Status:</label>
                            <div class="ek_f_input">
                                <select id="sort_by_status" class="form-select w_150_f">
                                    <option value="0" selected>Select</option>
                                    <option value="2">Pending</option>
                                    <option value="3">In Progress</option>
                                    <option value="4">Dispatched</option>
                                    <option value="6">Delivered</option>
                                    <option value="7">Cancelled</option>
                                    <option value="8">RTO</option>
                                </select>
                            </div>

                        </div>

                    </div>
                    <div class="table-responsive tres_border">
                        <table class="normalTable tableSorting whitespace">
                            <thead>
                                <tr>
                                    <th data-sort-field="order_number">eKomn Order</th>
                                    <th data-sort-field="title">Product Title
                                    </th>
                                    <th data-sort-field="full_name">Customer Name</th>
                                    <th class="h_sorting" data-sort-field="quantity">Qty
                                        <span class="sort_pos">
                                            <small class="sort_t"><i class="fas fa-caret-up"></i><i
                                                    class="fas fa-caret-down"></i></small>
                                        </span>
                                    </th>
                                    <th class="h_sorting" data-sort-field="order_date">Date
                                        <span class="sort_pos">
                                            <small class="sort_t"><i class="fas fa-caret-up"></i><i
                                                    class="fas fa-caret-down"></i></small>
                                        </span>
                                    </th>
                                    <th class="h_sorting" data-sort-field="total_amount">Total Amt.
                                    </th>
                                    <th class="h_sorting" data-sort-field="order_type">Category
                                        <span class="sort_pos">
                                            <small class="sort_t"><i class="fas fa-caret-up"></i><i
                                                    class="fas fa-caret-down"></i></small>
                                        </span>
                                    </th>
                                    <th>Store Order</th>

                                    <th class="h_sorting" data-sort-field="order_channel_type">Type
                                        <span class="sort_pos">
                                            <small class="sort_t"><i class="fas fa-caret-up"></i><i
                                                    class="fas fa-caret-down"></i></small>
                                        </span>
                                    </th>
                                    <th class="h_sorting" data-sort-field="status">Status
                                        <span class="sort_pos">
                                            <small class="sort_t"><i class="fas fa-caret-up"></i><i
                                                    class="fas fa-caret-down"></i></small>
                                        </span>
                                    </th>
                                    <th class="h_sorting" data-sort-field="payment_status">Order Payment Status
                                        <span class="sort_pos">
                                            <small class="sort_t"><i class="fas fa-caret-up"></i><i
                                                    class="fas fa-caret-down"></i></small>
                                        </span>
                                    </th>
                                    <th class="text-center">Action</th>
                                    <th class="text-center">Invoice</th>
                                </tr>
                            </thead>
                            <tbody id="dataContainer">
                                <!--  -->
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
                                <option value="10" selected>10</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="200">200</option>
                            </select>
                        </div>
                    </div>
                    <!-- end pegination -->
                </div>
            @endif
            <!-- supplier orders -->
            @if (auth()->user()->hasRole(ROLE_SUPPLIER))
                <div class="card ekcard pa shadow-sm">
                    <div class="cardhead">
                        <h3 class="cardtitle">Supplier Orders</h3>
                        <!-- <a href="create-order.html" class="btn btnekomn btn-sm"><i class="fas fa-plus fs-12 me-1"></i>Create New Order</a> -->
                    </div>
                    <div class="tableTop mt10">
                        <input type="text" id="searchQuery"
                            title="Search with eKomn Order, Store Order or Customer name"
                            class="form-control w_300_f searchicon" placeholder="Search">
                        <div class="d-flex gap-2">
                            <div class="ek_group m-0">
                                <label class="eklabel eklabel_60 m-0">Status:</label>
                                <div class="ek_f_input">
                                    <select id="sort_by_status" class="form-select w_150_f">
                                        <option value="0" selected>Select</option>
                                        <option value="2">Pending</option>
                                        <option value="3">In Progress</option>
                                        <option value="4">Dispatched</option>
                                        <option value="6">Delivered</option>
                                        <option value="7">Cancelled</option>
                                        <option value="8">RTO</option>
                                    </select>
                                </div>
                            </div>
                            <button class="btn btn-sm btnekomn_dark" onclick="collectCheckedIdsForCsv()"><i
                                    class="fas fa-file-csv me-2"></i>Export
                                CSV</button>
                        </div>
                    </div>
                    <div class="table-responsive tres_border">
                        <table class="normalTable tableSorting whitespace">
                            <thead>
                                <tr>
                                    <th>Select</th>
                                    <th>eKomn Order</th>
                                    <th>Product Title
                                    </th>
                                    <th>Customer Name</th>
                                    <th class="h_sorting" data-sort-field="quantity">Qty
                                        <span class="sort_pos">
                                            <small class="sort_t"><i class="fas fa-caret-up"></i><i
                                                    class="fas fa-caret-down"></i></small>
                                        </span>
                                    </th>
                                    <th class="h_sorting" data-sort-field="order_date">Date
                                        <span class="sort_pos">
                                            <small class="sort_t"><i class="fas fa-caret-up"></i><i
                                                    class="fas fa-caret-down"></i></small>
                                        </span>
                                    </th>
                                    <th>Total Amt
                                    </th>
                                    <th class="h_sorting" data-sort-field="order_type">Category
                                        <span class="sort_pos">
                                            <small class="sort_t"><i class="fas fa-caret-up"></i><i
                                                    class="fas fa-caret-down"></i></small>
                                        </span>
                                    </th>
                                    <th>Store Order</th>

                                    <th class="h_sorting" data-sort-field="order_channel_type">Type
                                        <span class="sort_pos">
                                            <small class="sort_t"><i class="fas fa-caret-up"></i><i
                                                    class="fas fa-caret-down"></i></small>
                                        </span>
                                    </th>
                                    <th class="h_sorting" data-sort-field="status">Status
                                        <span class="sort_pos">
                                            <small class="sort_t"><i class="fas fa-caret-up"></i><i
                                                    class="fas fa-caret-down"></i></small>
                                        </span>
                                    </th>
                                    <th class="h_sorting" data-sort-field="payment_status">Order Payment Status
                                        <span class="sort_pos">
                                            <small class="sort_t"><i class="fas fa-caret-up"></i><i
                                                    class="fas fa-caret-down"></i></small>
                                        </span>
                                    </th>
                                    <th class="text-center">Action</th>
                                    <th class="text-center">Invoice</th>

                                </tr>
                            </thead>
                            <tbody id="dataContainer">
                                <!--  -->
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
                                <option value="10" selected>10</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="200">200</option>
                            </select>
                        </div>
                    </div>
                    <!-- end pegination -->
                </div>
            @endif
            <!-- admin orders -->

            @if (auth()->user()->hasRole(ROLE_ADMIN) || auth()->user()->hasRole(ROLE_SUB_ADMIN))
                <div class="card ekcard pa shadow-sm">
                    <div class="cardhead">
                        <h3 class="cardtitle">Admin Orders</h3>
                        <!-- <a href="{{ route('create.order') }}" class="btn btnekomn btn-sm"><i class="fas fa-plus fs-12 me-1"></i>Create New Order</a> -->
                    </div>
                    <div class="tableTop mt10">
                        <input type="text" id="searchQuery"
                            title="Search with eKomn Order, Store Order or Customer name"
                            class="form-control w_300_f searchicon" placeholder="Search">
                        <div class="d-flex gap-2">
                            <div class="ek_group m-0">
                                <label class="eklabel eklabel_60 m-0">Status:</label>
                                <div class="ek_f_input">
                                    <select id="sort_by_status" class="form-select w_150_f">
                                        <option value="0" selected>Select</option>
                                        <option value="1">Draft</option>
                                        <option value="2">Pending</option>
                                        <option value="3">In Progress</option>
                                        <option value="4">Dispatched</option>
                                        <option value="6">Delivered</option>
                                        <option value="7">Cancelled</option>
                                        <option value="8">RTO</option>
                                    </select>
                                </div>
                            </div>
                            <button class="btn btn-sm btnekomn_dark" onclick="collectCheckedIdsForCsv();"><i
                                    class="fas fa-file-csv me-2"></i>Export
                                CSV</button>
                        </div>
                    </div>
                    <div class="table-responsive tres_border">
                        <table class="normalTable tableSorting whitespace">
                            <thead>
                                <tr>
                                    <th><div
                        class="form-check min-height m-0">
                        <input class="form-check-input" type="checkbox" id="selectAll">
                        <label for="selectAll" class="m-0">All</label>
                    </div></th>
                                    <th>eKomn Order</th>
                                    <th>Product Title
                                    <th>Customer Name</th>
                                    <th>Supplier ID</th>
                                    <th>Buyer ID</th>
                                    <th class="h_sorting" data-sort-field="quantity">Qty
                                        <span class="sort_pos">
                                            <small class="sort_t"><i class="fas fa-caret-up"></i><i
                                                    class="fas fa-caret-down"></i></small>
                                        </span>
                                    </th>
                                    <th class="h_sorting" data-sort-field="order_date">Date
                                        <span class="sort_pos">
                                            <small class="sort_t"><i class="fas fa-caret-up"></i><i
                                                    class="fas fa-caret-down"></i></small>
                                        </span>
                                    </th>

                                    <th>Total Amt
                                    </th>
                                    <th class="h_sorting" data-sort-field="order_type">Category
                                        <span class="sort_pos">
                                            <small class="sort_t"><i class="fas fa-caret-up"></i><i
                                                    class="fas fa-caret-down"></i></small>
                                        </span>
                                    </th>
                                    <th>Store Order</th>

                                    <th class="h_sorting" data-sort-field="order_channel_type">Type
                                        <span class="sort_pos">
                                            <small class="sort_t"><i class="fas fa-caret-up"></i><i
                                                    class="fas fa-caret-down"></i></small>
                                        </span>
                                    </th>
                                    <th class="h_sorting" data-sort-field="status">Status
                                        <span class="sort_pos">
                                            <small class="sort_t"><i class="fas fa-caret-up"></i><i
                                                    class="fas fa-caret-down"></i></small>
                                        </span>
                                    </th>
                                    <th class="h_sorting" data-sort-field="payment_status">Order Payment Status
                                        <span class="sort_pos">
                                            <small class="sort_t"><i class="fas fa-caret-up"></i><i
                                                    class="fas fa-caret-down"></i></small>
                                        </span>
                                    </th>
                                    <th class="text-center">Action</th>
                                    <th class="text-center">Invoice</th>

                                </tr>
                            </thead>
                            <tbody id="dataContainer">
                                <!--  -->
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
                                <option value="10" selected>10</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="200">200</option>
                            </select>
                        </div>
                    </div>
                    <!-- end pegination -->
                </div>
            @endif
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
                let apiUrl = `orders?per_page=${rows}&page=${currentPage}`;

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
                            dataContainer.innerHTML =
                                `<tr><td colspan="10" class="text-center">No data found</td></tr>`;
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
                        pageList +=
                            `<li><a href="#" class="${i === currentPage ? "active" : ""}" data-page="${i}">${i}</a></li>`;
                    }
                } else {
                    if (currentPage <= 3) {
                        for (let i = 1; i <= 4; i++) {
                            pageList +=
                                `<li><a href="#" class="${i === currentPage ? "active" : ""}" data-page="${i}">${i}</a></li>`;
                        }
                        pageList += `<li>...</li>`;
                        pageList += `<li><a href="#" data-page="${totalPages}">${totalPages}</a></li>`;
                    } else if (currentPage >= totalPages - 2) {
                        pageList += `<li><a href="#" data-page="1">1</a></li>`;
                        pageList += `<li>...</li>`;
                        for (let i = totalPages - 3; i <= totalPages; i++) {
                            pageList +=
                                `<li><a href="#" class="${i === currentPage ? "active" : ""}" data-page="${i}">${i}</a></li>`;
                        }
                    } else {
                        pageList += `<li><a href="#" data-page="1">1</a></li>`;
                        pageList += `<li>...</li>`;
                        for (let i = currentPage - 1; i <= currentPage + 1; i++) {
                            pageList +=
                                `<li><a href="#" class="${i === currentPage ? "active" : ""}" data-page="${i}">${i}</a></li>`;
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
        @if (auth()->user()->hasRole(ROLE_ADMIN) || auth()->user()->hasRole(ROLE_SUB_ADMIN))
            function generateTableRow(item) {
                var isvalid = false;
                if(item.status == "Cancelled" || item.payment_status == "Pending"){
                isvalid = true;
            }
                var orderType = '';

                let a = status(item);
                return `
               <tr>
                <td> <div
                        class="form-check form-check-sm form-check-custom form-check-solid">
                        <input class="form-check-input" type="checkbox"
                            value="${item.id}">
                    </div></td>
                <td>
                  <div class="productTitle_t">
                    <a href="${item.view_order}" class="a_link">${item.order_no}</a>
                  </div>
                </td>
                <td>
                  <div class="productTitle_t" title="${item.title}">
                    <a href="${item.link}" class="a_link" target="_blank">${item.title}</a>
                  </div>
                </td>
                <td>${item.customer_name}</td>
                <td>${item.supplier_id}</td>
                <td>${item.buyer_id}</td>
                <td>${item.quantity}</td>
                <td>
                  <div>${item.order_date}</div>
                </td>
                <td>
                  <div class="sell_t"><i class="fas fa-rupee-sign"></i>${item.total_amount}</div>
                </td>
                <td>${item.order_type}</td>
                <td>
                  ${item.store_order}
                </td>
                <td>${item.order_channel_type}</td>
                <td>${item.status}</td>
                <td>${item.payment_status}</td>
                <td class="text-center">
                  <button class="btn btn-sm btn-danger" onclick="cancelOrder('${item.id}')" ${item.is_cancelled ? 'disabled' : ''} >Cancel</button>
                </td>
                  <td class="text-center">
                  <button class="btn btn-sm btn-warning text-white" onclick="downloadInvoice('${item.id}')" ${isvalid ? 'disabled' : ''}>Download</button>
                </td>
              </tr>
    `;
            }
        @elseif (auth()->user()->hasRole(ROLE_SUPPLIER)) 
            function generateTableRow(item) {
                var isvalid = false;
                if(item.status == "Cancelled" || item.payment_status == "Pending" || item.payment_status == "Failed"){
                isvalid = true;
            }
                var orderType = '';

                let a = status(item);
                return `
               <tr>
                <td> <div
                        class="form-check form-check-sm form-check-custom form-check-solid">
                        <input class="form-check-input" type="checkbox"
                            value="${item.id}">
                    </div></td>
                <td>
                <a href="${item.view_order}" class="a_link">${item.order_no}</a>
                </td>
                <td>
                  <div class="productTitle_t" title="${item.title}">
                    <a href="${item.link}" class="a_link" target="_blank">${item.title}</a>
                  </div>
                </td>
                <td>${item.customer_name}</td>
                <td>${item.quantity}</td>
                <td>
                  <div>${item.order_date}</div>
                </td>
                <td>
                  <div class="sell_t"><i class="fas fa-rupee-sign"></i>${item.total_amount}</div>
                </td>
                <td>${item.order_type}</td>
                 <td>
                  ${item.store_order}
                </td>
                <td>${item.order_channel_type}</td>
                <td>${item.status}</td>
                <td>${item.payment_status}</td>
                <td class="text-center">
                  <button class="btn btn-sm btn-danger" onclick="cancelOrder('${item.id}')" ${item.is_cancelled ? 'disabled' : ''}>Cancel</button>
                </td>
                <td>
                  <button class="btn btn-sm btn-warning text-white" onclick="downloadInvoice('${item.id}')" ${isvalid ? 'disabled' : ''}>Download</button>
                    </td>
              </tr>
    `;
            }
        @elseif (auth()->user()->hasRole(ROLE_BUYER))

        function generateTableRow(item) {
            var isvalid = false;
                if(item.status == "Cancelled" || item.payment_status == "Pending" || item.payment_status == "Failed"){
                isvalid = true;
            }
            
                var orderType = '';

                let a = status(item);
                return `
               <tr>
             
                <td>
                 <a href="${item.view_order}" class="a_link">${item.order_no}</a>
                </td>
                <td>
                  <div class="productTitle_t" title="${item.title}">
                    <a href="${item.link}" class="a_link" target="_blank">${item.title}</a>
                  </div>
                </td>
                <td>${item.customer_name}</td>
                <td>${item.quantity}</td>
                <td>
                  <div>${item.order_date}</div>
                </td>
                <td>
                  <div class="sell_t"><i class="fas fa-rupee-sign"></i>${item.total_amount}</div>
                </td>
                <td>${item.order_type}</td>
                 <td>
                  ${item.store_order}
                </td>
                <td>${item.order_channel_type}</td>
                <td>${item.status}</td>
                <td>${item.payment_status}</td>
                <td class="text-center">
                  <button class="btn btn-sm btn-danger" onclick="cancelOrder('${item.id}')" ${item.is_cancelled ? 'disabled' : ''}>Cancel</button>
                </td>
                <td>
                  <button class="btn btn-sm btn-warning text-white" onclick="downloadInvoice('${item.id}')" ${isvalid ? 'disabled' : ''}>Download</button>
                    </td>
              </tr>
    `;
            }
          
        @endif

        function status(item) {
            if (item.status === 1) {
                return "Pending";
            } else if (item.status === 2) {
                return "Processing";
            } else if (item.status === 3) {
                return "Completed";
            } else if (item.status === 4) {
                return "Failed";
            } else if (item.status === 5) {
                return "Queued";
            } else if (item.status === 6) {
                return "Validation Error";
            } else {
                return "Unknown";
            }
        }
        // download the invoice pdf
        function downloadInvoice(orderId) {
            fetch('{{ route('orders.invoice') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(orderId)
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
                    a.download = 'Invoice_' + Date.now() + '.pdf';
                    document.body.appendChild(a);
                    a.click();
                    window.URL.revokeObjectURL(url);
                })
                .catch(error => {
                    console.error('Error downloading products:', error);
                });


        }

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
                    ApiRequest(`orders/cancel`, 'POST', {
                            reason: login,
                            order_id: orderId
                        })
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

        /**
         * Collects the IDs of all checked checkboxes for CSV download.
         * Displays an error message if no checkboxes are selected.
         */
        function collectCheckedIdsForCsv() {
            // Select all checkboxes with the class 'form-check-input'
            const allCheckboxes = document.querySelectorAll('.form-check-input');

            // Initialize an array to store the IDs of checked checkboxes
            const orderId = {
                data: []
            };

            // Iterate over each checkbox
            allCheckboxes.forEach(checkbox => {
                // Check if the checkbox is checked
                if (checkbox.checked) {
                    // Add the value (ID) of the checked checkbox to the array
                    orderId.data.push(checkbox.value);
                }
            });

            // Check if any IDs have been selected
            if (orderId.data.length > 0) {
                // Handle the selected IDs (e.g., prepare for CSV download)
                // Make an API request to download the selected products
                fetch('{{ route('orders.export') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(orderId)
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
                        a.download = 'Orders_' + Date.now() + '.zip';
                        document.body.appendChild(a);
                        a.click();
                        window.URL.revokeObjectURL(url);
                    })
                    .catch(error => {
                        console.error('Error downloading products:', error);
                    });

            } else {
                // Display an error message if no checkboxes are selected
                Swal.fire({
                    title: "Error!",
                    text: "Please select at least one checkbox.",
                    icon: "error",
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
            }
        }
    </script>
@endsection
