@extends('dashboard.layout.app')

@section('content')
<div class="ek_dashboard">
    <div class="ek_content">
        <div class="card ekcard pa shadow-sm">
            <div class="cardhead">
                <h3 class="cardtitle">User List</h3>
            </div>
            <div class="tableTop">
                <input type="text" class="form-control w_350_f searchicon"  id="searchQuery" placeholder="Search with Product Title, SKU, Product ID">
                <div class="filter">
                    <div class="ek_group m-0">
                        <label class="eklabel w_100_f">GST Verified:</label>
                        <div class="ek_f_input w_150_f">
                            <select class="form-select" id="sort_by_gst">
                                <option value="">Select</option>
                                <option value="{{GST_VERIFIED}}">Yes</option>
                                <option value="{{GST_NOT_VERIFIED}}">No</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="filter">
                    <div class="ek_group m-0">
                        <label class="eklabel w_100_f">PAN Verified:</label>
                        <div class="ek_f_input w_150_f">
                            <select class="form-select" id="sort_by_pan">
                                <option value="">Select</option>
                                <option value="{{PAN_VERIFIED}}">Yes</option>
                                <option value="{{PAN_NOT_VERIFIED}}">No</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="filter">
                    <div class="ek_group m-0">
                        <label class="eklabel w_100_f">Sort by:</label>
                        <div class="ek_f_input w_150_f">
                            <select class="form-select" id="sort_by_status">
                                <option value="0">Select</option>
                                <option value="{{ROLE_BUYER}}">Buyer</option>
                                <option value="{{ROLE_SUPPLIER}}">Supplier</option>
                            </select>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive tres_border">
                <table class="normalTable tableSorting whitespace">
                    <thead>
                        <tr>
                            <th data-sort-field="order_number">Name</th>
                            <th data-sort-field="title">Business Name
                            </th>
                            <th data-sort-field="courier_name">Email</th>
                            <th data-sort-field="tracking_url">Mobile</th>
                            <th data-sort-field="status">Role</th>
                            <th data-sort-field="status">Gst Verified</th>
                            <th data-sort-field="status">Pan Verified</th>
                            <th data-sort-field="status">Company Serial Id</th>
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

        const sort_by_gst = document.getElementById("sort_by_gst");
        sort_by_gst.addEventListener("change", () => {
            fetchData();
        });

        const sort_by_pan = document.getElementById("sort_by_pan");
        sort_by_pan.addEventListener("change", () => {
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
            let apiUrl = `get-user-list?per_page=${rows}&page=${currentPage}`;

            if (sortField && sortOrder) {
                apiUrl += `&sort=${sortField}&order=${sortOrder}`;
            }

            if (searchQuery) {
            apiUrl += `&query=${searchQuery.value}`;
            }

            if (sortByStatus) {
            apiUrl += `&sort_by_status=${sortByStatus.value}`;
            }

            if (sort_by_gst) {
            apiUrl += `&sort_by_gst=${sort_by_gst.value}`;
            }

            if (sort_by_pan) {
            apiUrl += `&sort_by_pan=${sort_by_pan.value}`;
            }

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

    });

    /**
     * Generates a table row HTML markup for a given item.
     *
     * @param {Object} item - The item object containing the details.
     * @returns {string} - The HTML markup for the table row.
     */
    function generateTableRow(item) {
        // let stock = allowEditable(item);
        let isDisabled = "";
        if(item.order_action_status == 6){
            isDisabled = "disabled";
        }
        return `
        <tr>
            <td>
                 <div class="productTitle_t">
                   ${item.name}
                </div>
            </td>
            <td>
                 <div class="productTitle_t">
                  <a href="${item.link}" target="_blank">${item.business_name}</a> 

                </div>
            </td>
             <td>
                <div class="productTitle_t">
                   ${item.email}

                </div>
            </td>
            <td>
                <div class="productTitle_t">
                   ${item.mobile_no}

                </div>
             </td>
             <td>
                <div class="productTitle_t">
                   ${item.role}

                </div>
             </td>
                 <td>
                <div class="productTitle_t">
                   ${item.gst_verified == 1 ? 'Yes' : 'No'}

                </div>
             </td>
                <td>
                <div class="productTitle_t">
                   ${item.pan_verified == 1 ? 'Yes' : 'No'}

                </div>
             </td>
           
               
                <td>
                <div class="productTitle_t">
                   ${item.company_serial_id}

                </div>
             </td>
             <td>
                <select class="changeStatus_t form-select" ${isDisabled} onchange="handleInput('${item.id}', 2, this)">
                   <option value="1" ${item.status == "1" ? "selected" : ""}>Active</option>
                   <option value="2" ${item.status == "2   " ? "selected" : ""}>In Active</option>
                </select>
            </td>
        </tr>
    `;
    }

    /**
     * Copies the provided text to the clipboard.
     *
     * @param {string} text - The text to be copied.
     */
    function copyText(text) {
        const textarea = document.createElement('textarea');
        textarea.value = text;
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand('copy');
        document.body.removeChild(textarea);
    }



    /**
     * Handles the input event for the status dropdown.
     *
     * @param {number} itemId - The ID of the item.
     * @param {number} type - The type of the input.
     * @param {HTMLElement} element - The input element.
     */
    function handleInput(itemId,  type, element) {
            updateStatus(itemId, element.value);
    }

    
    /**
     * Updates the status of a product.
     *
     * @param {number} productId - The ID of the product.
     */
    function updateStatus(itemId,  newStatus) {
        Swal.fire({
            title: "Do you want to update status?",
            showCancelButton: true,
            confirmButtonText: "Save",
            denyButtonText: `Don't save`,
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
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                  // Make an API request to update the status of the product
                ApiRequest(`update-user-status`, 'POST', {
                status: newStatus,
                'id': itemId
            })
            .then(response => {
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

                    // Apply inline CSS to the confirm button
                    const confirmButton = Swal.getConfirmButton();
                    confirmButton.style.backgroundColor = '#feca40';
                    confirmButton.style.color = 'white';
                    }
                }).then(() => {
                    // Redirect to the inventory page
                    window.location.href = "{{ route('user.list') }}";
                })
            })
            .catch(error => {
                console.error('Error updating status:', error);
            });
                
            } else if (result.isDenied) {
                Swal.fire("The status is not updated.", "", "info");
            }
            });
      
        }
</script>
@endsection