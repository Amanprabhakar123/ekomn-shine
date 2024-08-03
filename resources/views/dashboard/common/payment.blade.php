@extends('dashboard.layout.app')

@section('content')
<div class="ek_dashboard">
    <div class="ek_content">
        <div class="card ekcard pa shadow-sm">
            <div class="cardhead">
                <h3 class="cardtitle">Order Payments</h3>
            </div>
            <div class="tableTop mt10">
                @if (auth()->user()->hasRole(ROLE_ADMIN))
                <input type="text" id="searchQuery" title="Search with eKomn Order, Store Order or Customer name" class="form-control w_300_f searchicon" placeholder="Search By Order No. and Supplier ID">
                @else
                <input type="text" id="searchQuery" title="Search with eKomn Order, Store Order or Customer name" class="form-control w_300_f searchicon" placeholder="Search By Order No">
                @endif
                <div class="ek_group m-0">
                    <label class="eklabel eklabel_80 m-0">Order Status:</label>
                    <div class="ek_f_input">
                        <select id="sort_by_order_status" class="form-select w_150_f">
                            <option value="0" selected>Select</option>
                            <option value="4">Dispatched</option>
                            <option value="5">In Transit</option>
                            <option value="6">Delivered</option>
                        </select>
                    </div>
                </div>
                <div class="ek_group m-0">
                    <label class="eklabel eklabel_80 m-0">Payment Status:</label>
                    <div class="ek_f_input">
                        <select id="sort_by_status" class="form-select w_150_f">
                            <option value="0" selected>Select</option>
                            <option value="1">Hold</option>
                            <option value="2">Accrued</option>
                            <option value="3">Paid</option>
                            <option value="4">Due</option>
                        </select>
                    </div>
                </div>

            </div>
            <div class="table-responsive tres_border">
                <table class="normalTable tableSorting whitespace">
                    <thead class="thead-dark">
                        <tr>
                            <th>Select</th>
                            <th>eKomn Order No</th>
                            @if(auth()->user()->hasRole(ROLE_ADMIN))
                            <th>Supplier Id</th>
                            @endif
                            <th>Date</th>
                            <th>Product Charges</th>
                            <th>Discount</th>
                            <th>Shipping Charges</th>
                            <th>Packing Charges</th>
                            <th>Labour Charges</th>
                            <th>Payment Charges</th>
                            <th>Total GST</th>
                            <th>Order Amount</th>
                            <th>Order Status</th>
                            <th>Category</th>
                            <th>Refunds</th>
                            <th>Referral Fee</th>
                            <th>Adjustments</th>
                            <th>TDS</th>
                            <th>TCS</th>
                            <th>Order Disbursement Amount</th>
                            <th>Payment Status</th>
                            <th>Statement Wk</th>
                            <th>Invoice</th>
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
                        <option value="10" selected>10</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="200">200</option>
                    </select>
                </div>
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

        const sort_by_order_status = document.getElementById("sort_by_order_status");
        sort_by_order_status.addEventListener("change", () => {
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
            let apiUrl = `payments/weekly?per_page=${rows}&page=${currentPage}`;

            if (sortField && sortOrder) {
                apiUrl += `&sort=${sortField}&order=${sortOrder}`;
            }

            if (searchQuery) {
                apiUrl += `&query=${searchQuery.value}`;
            }

            if (sortByStatus) {
                apiUrl += `&sort_by_status=${sortByStatus.value}`;
            }

            if (sort_by_order_status) {
                apiUrl += `&sort_by_order_status=${sort_by_order_status.value}`;
            }


            ApiRequest(apiUrl, 'GET')
                .then(response => {
                    const data = (response.data);
                    // console.log(data);
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

    function generateTableRow(item) {

        var orderType = '';
        // let a = status(item);
        return `
                        <tr>
                            <td><input type="checkbox"></td>
                            <td class="text-center">
                                <div class="productTitle_t">
                                    <a href="${item.view_order}" class="a_link">${item.order_no}</a>
                                </div>
                            </td>
                            @if(auth()->user()->hasRole(ROLE_ADMIN))
                            <td class="text-center">${item.supplier_id}</td>
                            @endif
                            <td class="text-center">${item.order_date}</td>
                            <td class="text-center">${item.product_cost_exc_gst}</td>
                            <td class="text-center">${item.discount}</td>
                            <td class="text-center">${item.shipping_charges_gst_exc_amount}</td>
                            <td class="text-center">${item.packing_charges_gst_exc_amount}</td>
                            <td class="text-center">${item.labour_charges_gst_exc_amount}</td>
                            <td class="text-center">${item.payment_gateway_charges_gst_exc_amount}</td>
                            <td class="text-center">${item.total_gst_amount}</td>
                            <td class="text-center">${item.order_total}</td>
                            <td class="text-center">${item.order_status}</td>
                            <td class="text-center">${item.order_type}</td>
                            <td class="text-center">${item.refund_amount}</td>
                            <td class="text-center">${item.processing_charges}</td>
                            
                             @if(auth()->user()->hasRole(ROLE_ADMIN))
                                <td><input type="text" class="stock_t" onchange="updateAdjustmentAmount('${item.id}', this)" adjustmentAmount" value="${item.adjustment_amount}"></td>
                                @else{
                                 <td class="text-center">${item.adjustment_amount}</td>
                                }
                                @endif
                                
                            
                           
                            <td class="text-center">${item.tds_amount}</td>
                            <td class="text-center">${item.tcs_amount}</td>
                            <td class="text-center">${item.disburse_amount}</td>
                            <td class="text-center">${item.payment_status}</td>
                            <td class="text-center">${item.statement_date}</td>
                             <td class="text-center">
                                <button class="btn btn-sm btn-warning text-white" ${!item.invoice_generated ? 'disabled' : ''} onclick="downloadInvoice('${item.id}')">Download</button>
                            </td>
                        </tr>
                `;
    }


    // Function to download invoice
    function updateAdjustmentAmount(id, element) {
        let value = element.value;
        ApiRequest('order-payment-update', 'POST', {
            order_id: id,
            adjustment_amount: value
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
                        location.reload();
                    }
                });


            }
        }).catch(error => {
            console.error('Error updating adjustment amount:', error);
        });
    }
</script>

@endsection