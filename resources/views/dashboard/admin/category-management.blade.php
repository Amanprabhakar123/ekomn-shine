@extends('dashboard.layout.app')

@section('content')
<div class="ek_dashboard">
    <div class="ek_content">
            <div class="card ekcard pa shadow-sm">
                <div class="cardhead">
                    <h3 class="cardtitle">Category Management</h3>
                </div>
            <!-- <div class="cardhead">
                <h3 class="cardtitle">My Inventory</h3>
                @if(auth()->user()->hasRole(ROLE_ADMIN))
                @if(auth()->user()->hasPermissionTo(PERMISSION_ADD_PRODUCT))
                <a class="btn btnekomn btn-sm" href="{{route('add.inventory')}}"><i class="fas fa-plus fs-12 me-1"></i> New Product</a>
                @endif
                @endif
            </div> -->
            <!-- <div class="tableTop">
                <input type="text" class="form-control w_350_f searchicon"  id="searchQuery" placeholder="Search with Product Title, SKU, Product ID">
                <div class="filter">
                    <div class="ek_group m-0">
                         <label class="eklabel w_50_f">Sort by:</label>
                        <div class="ek_f_input w_150_f">
                            <select class="form-select" id="sort_by_status">
                                <option value="0">Select</option>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                                <option value="3">Out of Stock</option>
                                <option value="4">Draft</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div> -->
            <div class="table-responsive tres_border">
                <table class="normalTable whitespace">
                    <thead>
                        <tr>
                            <th class="">Name
                                
                            </th>
                            <th class="">Slug
                                
                            </th>
                            <th class="">Action
                                
                            </th>
                            <th>Status</th>
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

@section('scripts')
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

        function fetchData() {
            // Make an API request to fetch inventory data
            let apiUrl = `mis-setting-categories?per_page=${rows}&page=${currentPage}`;


            ApiRequest(apiUrl, 'GET')
            .then(response => {
                const data = (response.data);
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
                    <td>${item.name}</td>
                    <td>${item.slug}</td>
                    <td>
                        <a href="#" class="nbtn btn-link btn-sm">Edit</a>
                    </td>
                    <td>
                        <select onChange="updateStatus('${item.id}')" class="form-select">
                            <option value="1" ${item.is_active ? 'selected' : ''}>Active</option>
                            <option value="0"  ${!item.is_active ? 'selected' : ''}>Inactive</option>
                        </select>
                    </td>
                </tr>
            `;
        }

    });

    // update api request function
    function updateStatus(id) {
        var formData = new FormData();
        formData.append('id', id);
        ApiRequest('update-category-status', 'POST', formData)
        .then(response => {
            if (response.data.statusCode == 200) {
                                // Redirect to the inventory index page
                                Swal.fire({
                                    title: 'Success',
                                    icon: "success",
                                    text: response.data.message,
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
                                    window.location.href = '/category-management';
                                });
                            }
        })
        .catch(error => {
            console.error('Error updating status:', error);
        });
    }

</script>
@endsection
