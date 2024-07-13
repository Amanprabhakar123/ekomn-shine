@extends('dashboard.layout.app')

@section('content')
<div class="ek_dashboard">
<div class="ek_content">
        <div class="card ekcard pa shadow-sm">
            <div class="cardhead">
                <h3 class="cardtitle">Bulk Upload List</h3>
                @if(auth()->user()->hasPermissionTo(PERMISSION_ADD_PRODUCT))
                <a href="{{route('bulk-upload')}}" class="btn btnekomn btn-sm">Bulk Upload<i class="fas fa-cloud-upload-alt ms-2"></i></a>
                @endif
            </div>
            <div class="tableTop">
                <input type="text" class="form-control w_350_f searchicon" id="searchQuery" placeholder="Search with Supplier ID or File name">
                <div class="filter">
                    <div class="ek_group m-0">
                        <label class="eklabel w_50_f">Sort by:</label>
                        <div class="ek_f_input">
                            <select class="form-select" id="sort_by_status">
                                <option value="0">Select</option>
                                <option value="1">Pending</option>
                                <option value="2">Processing</option>
                                <option value="3">Completed</option>
                                <option value="4">Failed</option>
                                <option value="5">Queued</option>
                                <option value="6">Validation Error</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive tres_border">
                <table class="normalTable tableSorting whitespace">
                <thead>
                    <tr>
                        <th>File Name</th>
                        <th>Upload Time</th>
                        <th>Processed Records
                            <span class="sort_pos">
                                <small class="sort_t"><i class="fas fa-caret-up"></i><i class="fas fa-caret-down"></i></small>
                            </span>
                        </th>
                        <th>Failed Records
                            <span class="sort_pos">
                                <small class="sort_t"><i class="fas fa-caret-up"></i><i class="fas fa-caret-down"></i></small>
                            </span>
                        </th>
                        <th>
                            Failed Resons
                        </th>
                        <th>Status
                            <span class="sort_pos">
                                <small class="sort_t"><i class="fas fa-caret-up"></i><i class="fas fa-caret-down"></i></small>
                            </span>
                        </th>
                        <th>Download File</th>
                    </tr>
                </thead>
                    <tbody id="dataContainer">
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


        const sortField = ""; // Set the sort field here (e.g. "sku", "stock", "selling_price")
        const sortOrder = ""; // Set the sort order here (e.g. "asc", "desc")
        // const selling_price_sort = document.getElementById("selling_price_sort");
        // selling_price_sort.addEventListener("click", () => {
        //     alert('asdd');
        //     sortField = "price_after_tax";
        //     sortOrder = (sortOrder === "asc") ? "desc" : "asc";
        //     // alert(sortOrder);
        //     fetchData();
        // });
        // Function to fetch data from the server
        function fetchData() {
            // Make an API request to fetch inventory data
            let apiUrl = `bulk-data?per_page=${rows}&page=${currentPage}`; // change the API endpoint here

            if (sortField && sortOrder) {
                apiUrl += `&sort_field=${sortField}&sort_order=${sortOrder}`;
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
    let a = status(item);
    return `
    <tr>
        <td>
            ${item.filename}
        </td>
        <td>
            ${item.created_at}
        </td>
        <td>
            ${item.success_count}
        </td>
        <td>
            ${item.fail_count}
        </td>
        <td>
            <a href="${item.id}" class="">View Reasons</a>
        </td>
        <td>
       ${a}
        </td>
        <td>
            <a href="${item.file_path}" class="btn btnekomn btn-sm">Download</a>
        </td>
    </tr>
    `;
}

function status(item){
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


</script>
@endsection