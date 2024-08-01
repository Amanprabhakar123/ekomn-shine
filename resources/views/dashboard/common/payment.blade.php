@extends('dashboard.layout.app')

@section('content')
<div class="ek_dashboard">
    <div class="ek_content">
        <div class="card ekcard pa shadow-sm">
            <div class="cardhead">
                <h3 class="cardtitle">Order Table</h3>
            </div>
            <div class="tableTop mt10">
                <input type="text" id="searchQuery" title="Search with eKomn Order, Store Order or Customer name" class="form-control w_300_f searchicon" placeholder="Search">
                <div class="d-flex gap-2">
                    <button class="btn btn-sm btnekomn_dark"><i class="fas fa-file-csv me-2"></i>Export CSV</button>
                </div>
            </div>
           
                <div class="table-responsive tres_border">
                    <table class="normalTable tableSorting whitespace">
                        <thead class="thead-dark">
                            <tr>
                                <th>Select</th>
                                <th>eKomn Order No</th>
                                <th>Date</th>
                                <th>Product Cost</th>
                                <th>Discount</th>
                                <th>Shipping Cost</th>
                                <th>Packing Cost</th>
                                <th>Labour Cost</th>
                                <th>GST</th>
                                <th>Payment Charge</th>
                                <th>Order Amount</th>
                                <th>Order Status</th>
                                <th>Refunds</th>
                                <th>Service Charge</th>
                                <th>Adjustments</th>
                                <th>Order Disbursement Amount</th>
                                <th>Payment Status</th>
                                <th>Statement Wk</th>
                                <th>Invoice</th>
                            </tr>
                        </thead>
                        <tbody id="dataContainer">
                            <!-- <tr>
                                <td><input type="checkbox"></td>
                                <td>12345</td>
                                <td>2023-07-31</td>
                                <td>$100.00</td>
                                <td>$5.00</td>
                                <td>$10.00</td>
                                <td>$2.00</td>
                                <td>$3.00</td>
                                <td>$1.50</td>
                                <td>$0.50</td>
                                <td>$111.00</td>
                                <td>Shipped</td>
                                <td>$0.00</td>
                                <td>$2.00</td>
                                <td>$0.00</td>
                                <td>$106.50</td>
                                <td>Paid</td>
                                <td>31</td>
                                <td>INV12345</td>
                            </tr> -->
                            <!-- Additional rows can go here -->
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
                alert('fetchData');
                // Make an API request to fetch inventory data
                let apiUrl = `payment-info?per_page=${rows}&page=${currentPage}`;

                if (sortField && sortOrder) {
                    apiUrl += `&sort=${sortField}&order=${sortOrder}`;
                }

                if (searchQuery) {
                    apiUrl += `&query=${searchQuery.value}`;
                }


                ApiRequest(apiUrl, 'GET')
                    .then(response => {
                        const data = (response.data.data);
                        console.log(data);
                        if (data.length === 0) {
                            dataContainer.innerHTML =
                                `<tr><td colspan="10" class="text-center">No data found</td></tr>`;
                        } else {
                            response = (response.data.meta.pagination);
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
                            <td>${item.order_no}</td>
                            <td>${item.order_date}</td>
                            <td>20</td>
                            <td>10</td>
                            <td>10</td>
                            <td>5</td>
                            <td>2</td>
                            <td>18</td>
                            <td>5</td>
                            <td>20</td>
                            <td>Dropshi</td>
                            <td>pending</td>
                            <td>21</td>
                            <td>1</td>
                            <td>2</td>
                            <td>success</td>
                            <td>pending</td>
                            <td>Amazone</td>
                        </tr>
                `;
            }


//--------------------------------------------------------------
            // backup for data when get original data whenever you want to use

                        //  <tr>
                        //     <td><input type="checkbox"></td>
                        //     <td>${item.order_id}</td>
                        //     <td>${item.date}</td>
                        //     <td>${item.product_cost}</td>
                        //     <td>${item.discount}</td>
                        //     <td>${item.shipping_cost}</td>
                        //     <td>${item.packing_cost}</td>
                        //     <td>${item.labour_cost}</td>
                        //     <td>${item.gst}</td>
                        //     <td>${item.payment_charge}</td>
                        //     <td>${item.order_amount}</td>
                        //     <td>${item.order_status}</td>
                        //     <td>${item.refunds}</td>
                        //     <td>${item.service_charge}</td>
                        //     <td>${item.adjustment_amount}</td>
                        //     <td>${item.disburse_amount}</td>
                        //     <td>${item.payment_status}</td>
                        //     <td>${item.statement_date}</td>
                        //     <td>${item.invoice}</td>
                        // </tr>

            
</script>

@endsection