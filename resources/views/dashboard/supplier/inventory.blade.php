@extends('dashboard.layout.app')

@section('content')
<div class="ek_dashboard">
    <div class="ek_content">
        <div class="card ekcard pa shadow-sm">
            <div class="cardhead">
                <h3 class="cardtitle">My Inventory</h3>
                <a class="btn btnekomn btn-sm" href="{{route('add.inventory')}}"><i class="fas fa-plus fs-12 me-1"></i> New Product</a>
            </div>
            <div class="tableTop">
                <input type="text" class="form-control w_350_f searchicon" placeholder="Search with Product Title, SKU, Product ID">
                <div class="filter">
                    <div class="ek_group m-0">
                        <label class="eklabel w_50_f">Sort by:</label>
                        <div class="ek_f_input">
                            <select class="form-select">
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                                <option value="Out of Stock" selected>Out of Stock</option>
                                <option value="Draft">Draft</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive tres_border">
                <table class="normalTable tableSorting whitespace">
                    <thead>
                        <tr>
                            <th>Product Image</th>
                            <th>Product Title</th>
                            <th>SKU
                                <span class="sort_pos">
                                    <small class="sort_t"><i class="fas fa-caret-up"></i><i class="fas fa-caret-down"></i></small>
                                </span>
                            </th>
                            <th>Product ID</th>
                            <th>Stock
                                <span class="sort_pos">
                                    <small class="sort_t"><i class="fas fa-caret-up"></i><i class="fas fa-caret-down"></i></small>
                                </span>
                            </th>
                            <th>Selling Price
                                <span class="sort_pos">
                                    <small class="sort_t"><i class="fas fa-caret-up"></i><i class="fas fa-caret-down"></i></small>
                                </span>
                            </th>
                            <th>Category
                                <span class="sort_pos">
                                    <small class="sort_t"><i class="fas fa-caret-up"></i><i class="fas fa-caret-down"></i></small>
                                </span>
                            </th>
                            <th>Availability</th>
                            <th>Status
                                <span class="sort_pos">
                                    <small class="sort_t"><i class="fas fa-caret-up"></i><i class="fas fa-caret-down"></i></small>
                                </span>
                            </th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="dataContainer">
                        {{-- <tr>
                            <td>
                                <div class="productImg_t">
                                    <img src="assets/images/product/product_1.jpg" alt="Product Image">
                                </div>
                            </td>
                            <td>
                                <div class="productTitle_t">
                                    Cushion covers
                                </div>
                            </td>
                            <td>
                                <div class="sku_t">KS93528TUT</div>
                            </td>
                            <td>
                                EK501IND
                            </td>
                            <td>
                                <input type="text" class="stock_t" value="200">
                            </td>
                            <td>
                                <div class="sell_t"><i class="fas fa-rupee-sign"></i> 1000</div>
                            </td>
                            <td>
                                <div>Home Decor</div>
                            </td>
                            <td>
                                <div>Till Stock Lasts</div>
                            </td>
                            <td>
                                <select class="changeStatus_t form-select">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                    <option value="Out of Stock" selected>Out of Stock</option>
                                    <option value="Draft">Draft</option>
                                </select>
                            </td>
                            <td>
                                <button class="btn btn-link btn-sm">Edit</button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="productImg_t">
                                    <img src="assets/images/product/product_5.jpg" alt="Product Image">
                                </div>
                            </td>
                            <td>
                                <div class="productTitle_t">
                                    Dell WM126 Wireless Mouse
                                </div>
                            </td>
                            <td>
                                <div class="sku_t">KS93528TUT</div>
                            </td>
                            <td>
                                EK502IND
                            </td>
                            <td>
                                <input type="text" class="stock_t" value="200">
                            </td>
                            <td>
                                <div class="sell_t"><i class="fas fa-rupee-sign"></i> 1000</div>
                            </td>
                            <td>
                                <div>Home Decor</div>
                            </td>
                            <td>
                                <div>Regular Available</div>
                            </td>
                            <td>
                                <select class="changeStatus_t form-select">
                                    <option value="Active" selected>Active</option>
                                    <option value="Inactive">Inactive</option>
                                    <option value="Out of Stock">Out of Stock</option>
                                    <option value="Draft">Draft</option>
                                </select>
                            </td>
                            <td>
                                <button class="btn btn-link btn-sm">Edit</button>
                            </td>
                        </tr> --}}
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

        // Function to fetch data from the server
        function fetchData() {
            // Make an API request to fetch inventory data
            ApiRequest(`product/inventory?per_page=${rows}&page=${currentPage}`, 'GET')
                .then(response => {
                    const data = (response.data);
                    response = (response.meta.pagination);
                    totalRows = response.total;
                    updatePagination();
                    displayData(data);
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
        return `
        <tr>
            <td>
                <div class="productImg_t">
                    <img src="${item.product_image}" alt="Product Image">
                </div>
            </td>
            <td>
                <div class="productTitle_t">
                    ${item.title}
                </div>
            </td>
            <td>
                <div class="sku_t">${item.sku}</div>
            </td>
            <td>
                ${item.product_id}
            </td>
            <td>
                <input type="text" class="stock_t" value="${item.stock}">
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
                <select class="changeStatus_t form-select">
                    <option value="Active" ${item.status === "Active" ? "selected" : ""}>Active</option>
                    <option value="Inactive" ${item.status === "Inactive" ? "selected" : ""}>Inactive</option>
                    <option value="Out of Stock" ${item.status === "Out of Stock" ? "selected" : ""}>Out of Stock</option>
                    <option value="Draft" ${item.status === "Draft" ? "selected" : ""}>Draft</option>
                </select>
            </td>
            <td>
                <button class="btn btn-link btn-sm">Edit</button>
            </td>
        </tr>
    `;
    }
</script>
@endsection