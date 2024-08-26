@extends('dashboard.layout.app')

@section('content')
@section('scripts')
<div class="ek_dashboard">
    <div class="ek_content">
            <div class="card ekcard pa shadow-sm">
                <div class="cardhead">
                    <h3 class="cardtitle">My Return Orders</h3>
                    @if (auth()->user()->hasPermissionTo(PERMISSION_CREATE_RETURN_ORDER))
                        <a href="{{route('create.return.order')}}" class="btn btnekomn btn-sm"><i class="fas fa-plus fs-12 me-1"></i>Add New Return</a>
                    @endif
                </div>  
            <div class="tableTop">
                <input type="text" class="form-control w_350_f searchicon"  id="searchQuery" placeholder="Search with Order no and return no.">
                <div class="filter">
                    <div class="ek_group m-0">
                         <label class="eklabel eklabel_90 m-0">Sort by Dispute:</label>
                        <div class="ek_f_input w_150_f">
                            <select class="form-select" id="sort_by_dispute">
                                <option value="">Select</option>
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                                <option value="2">Resolved</option>

                            </select>
                        </div>
                        <label class="eklabel eklabel_90 ms-2">Sort by Status:</label>

                        <div class="ek_f_input w_150_f">
                            <select class="form-select" id="sort_by_status">
                                <option value="">Select</option>
                                <option value="1">Open</option>
                                <option value="2">In Progress</option>
                                <option value="3">Accepted</option>
                                <option value="4">Approved</option>
                                <option value="5">Decline</option>

                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive tres_border">
            <table class="normalTable tableSorting whitespace">
                    <thead>
                        <tr>
                            <!-- <th>Sr. No.</th> -->
                            <th>Return Number</th>
                            <th>Ekomn Order</th>
                            <th>Order Type</th>
                            <th>Product Title</th>
                            <th class="h_sorting" data-sort-field="quantity">Qty
                                <span class="sort_pos">
                                    <small class="sort_t">
                                        <i class="fas fa-caret-up"></i>
                                        <i class="fas fa-caret-down"></i>
                                    </small>
                                </span>
                            </th>
                            <th class="h_sorting" data-sort-field="return_date">Return date
                                <span class="sort_pos">
                                    <small class="sort_t">
                                        <i class="fas fa-caret-up"></i>
                                        <i class="fas fa-caret-down"></i>
                                    </small>
                                </span>
                            </th>
                            <th>Return reason</th>
                            <th>Order amount</th>
                            <th>Return status</th>
                            <th class="h_sorting" data-sort-field="dispute">Dispute
                                <span class="sort_pos">
                                    <small class="sort_t">
                                        <i class="fas fa-caret-up"></i>
                                        <i class="fas fa-caret-down"></i>
                                    </small>
                                </span>
                            </th>
                            <!-- <th>Action</th> -->
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
                        <option value="5">5</option>
                        <option selected value="10">10</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="200">200</option>
                    </select>
                </div>
            </div>
            <!-- end pegination -->
        </div>
    </div>
    @include('dashboard.layout.copyright')
</div>
@endsection
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
     $(document).ready(function(){
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

        const sortByStatus = document.getElementById("sort_by_status");
            sortByStatus.addEventListener("change", () => {
                fetchData();
            });

        const sortByDispute = document.getElementById("sort_by_dispute");
            sortByDispute.addEventListener("change", () => {
                fetchData();
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

        function fetchData() {
            // Make an API request to fetch inventory data
            let apiUrl = `return-order-list?per_page=${rows}&page=${currentPage}`;

            if (sortField && sortOrder) {
                    apiUrl += `&sort=${sortField}&order=${sortOrder}`;
                }

            if (searchQuery) {
            apiUrl += `&query=${searchQuery.value}`;

            if (sortByStatus) {
                    apiUrl += `&sort_by_status=${sortByStatus.value}`;
                }
            }
            if (sortByDispute) {
                    apiUrl += `&sort_by_dispute=${sortByDispute.value}`;
                }


            ApiRequest(apiUrl, 'GET')
            .then(response => {
                const data = (response.data);
                console.log(data);
                if(data.length === 0) {
                dataContainer.innerHTML = `<tr><td colspan="10" class="text-center">No data found</td></tr>`;
                }else{
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

        // Function to generate a table row for a single inventory item
        function generateTableRow(item) {
            return `
                <tr>
                    <td>  <a href="${item.view_return}" target="_blank">${item.return_number}</a></td>
                   <td>  <a href="${item.view_order}" target="_blank">${item.order_number}</a></td>
                    <td>${item.order_type}</td>
                    
                     <td>
                        <div class="productTitle_t"><a href="${item.link}" target="_blank">${item.title}<a/></div>    
                    </td>
                     <td>${item.qnty}</td>
                      <td>${item.return_date}</td>
                      <td>${item.reason}</td>
                      <td>${item.total_amount}</td>
                       <td>${item.status}</td>
                        <td>${item.dispute}</td>
                   
                </tr>
            `;
        }

    });
    
</script>
@endsection