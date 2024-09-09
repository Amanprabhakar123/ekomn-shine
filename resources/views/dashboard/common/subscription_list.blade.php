@extends('dashboard.layout.app')
@section('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection
@section('content')
<div class="ek_dashboard">
    <div class="ek_content">
        <div class="card ekcard pa shadow-sm">
            <div class="cardhead">
                <h3 class="cardtitle">Subscription List</h3>
            
         
        <button class="btn btnekomn_dark stripbtn" id="exportCsv"><i class="fas fa-file-csv me-2"></i>Export CSV</button>
      </div>
            <div class="filterStrip">
            <ul class="ekfilterList">
                
                <li class="search-width">
                    <input type="text" class="form-control searchicon" id="searchQuery" placeholder="Search" title="Search with business name, email, mobile">
                </li>
                <li>
                <!-- <div class="calanderWithName">
                    <div class="calUplabel dateRange_c">
                        <span class="calLabel">Date Range</span>
                        <input type="text" name="daterange" />
                    </div>
                </div> -->
                <div class="calanderWithName">
                    <div class="calUplabel">
                        <span class="calLabel">Start Date</span>
                        <input type="text" name="startdate">
                    </div>
                 </div>
                </li>
                <li>
                <div class="calanderWithName">
                    <div class="calUplabel">
                        <span class="calLabel">End Date</span>
                        <input type="text" name="enddate">
                    </div>
                 </div>
                </li>
                
                <li>
                    <div class="dropdown" id="sort_by_plan_name">
                        <button class="btn dropdown-toggle filterSelectBox" type="button" data-bs-toggle="dropdown" aria-expanded="false"><span class="opacity-50 me-2">Plan</span><strong class="dropdownValue">All</strong></button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" data-value="">All</a></li>
                             @foreach($plans as $plan)
                            <li><a class="dropdown-item" href="#" data-value="{{salt_encrypt($plan->id)}}">{{$plan->name}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </li>
                <li>
                    <div class="dropdown" id="sort_by_status">
                        <button class="btn dropdown-toggle filterSelectBox" type="button" data-bs-toggle="dropdown" aria-expanded="false"><span class="opacity-50 me-2">Status</span><strong class="dropdownValue">All</strong></button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" data-value="">All</a></li>
                            <li><a class="dropdown-item" href="#" data-value="1">Active</a></li>
                            <li><a class="dropdown-item" href="#" data-value="0">In Active</a></li>
                        </ul>
                    </div>
                </li>
           
            </ul>
        </div>
            <div class="table-responsive tres_border">
                <table class="normalTable tableSorting whitespace">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th data-sort-field="order_number">Compnay Name</th>
                            <th data-sort-field="title">User ID
                            </th>
                            <th data-sort-field="courier_name">Type</th>
                            <th data-sort-field="tracking_url">Plan</th>
                            <th data-sort-field="status">Plan Price</th>
                            <th data-sort-field="status">Paid Amount</th>
                            <th data-sort-field="status">Start Date</th>
                            <th data-sort-field="status">End Date</th>
                            <th data-sort-field="status">Inventory Count</th>
                            <th data-sort-field="status">Download Count</th>
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
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const rowsPerPage = document.getElementById("rowsPerPage");
        const rowInfo = document.getElementById("rowInfo");
        const pagination = document.getElementById("pagination");
        const prevPage = document.getElementById("prevPage");
        const nextPage = document.getElementById("nextPage");
        const dataContainer = document.getElementById("dataContainer");
        let start_date = last_date = '';
        let currentPage = 1;
        let rows = parseInt(rowsPerPage.value, 10);
        let totalRows = 0;
        let exportCsv = false;

        $(function() {
            const today = moment().format('YYYY-MM-DD');
            $('input[name="startdate"]').daterangepicker({
                singleDatePicker: true, 
                autoApply: true,
                opens: 'left',
                startDate: today,
                locale: {
                    format: 'YYYY-MM-DD' // Ensures the date format is consistent
                }
            }, function(start) {
                start_date = start.format('YYYY-MM-DD');
                fetchData();
            });

            $('input[name="enddate"]').daterangepicker({
                singleDatePicker: true, 
                autoApply: true,
                opens: 'left',
                startDate: today,
                locale: {
                    format: 'YYYY-MM-DD' // Ensures the date format is consistent
                }
            }, function(lastdate) {
                last_date = lastdate.format('YYYY-MM-DD');
                fetchData();
            });
        });
        
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

        // Event listener for the export CSV button
        const exportCsvButton = document.getElementById("exportCsv");
        exportCsvButton.addEventListener("click", () => {
            exportCsv = true;
            fetchData();
        });
        let selectedValues = {
            sortByStatus: "",
            sort_by_gst: "",
            sort_by_plan_name: "",
        };
        function handleDropdownSelection(dropdown, key) {
                const dropdownItems = dropdown.querySelectorAll('.dropdown-item');
                const dropdownValue = dropdown.querySelector('.dropdownValue');
                dropdownItems.forEach(function(item) {
                        item.addEventListener('click', function(e) {
                                e.preventDefault();
                                const value = this.getAttribute('data-value');
                                const text = this.textContent;
                                dropdownValue.textContent = text;
                                selectedValues[key] = value;
                                fetchData();
                        });
                });
        }
        const sort_by_status = document.getElementById('sort_by_status');
        handleDropdownSelection(sort_by_status, 'sortByStatus');

        const sort_by_plan_name = document.getElementById('sort_by_plan_name');
        handleDropdownSelection(sort_by_plan_name, 'sort_by_plan_name');

        // Function to fetch data from the server
        
        function fetchData() {
            // Make an API request to fetch inventory data
            let apiUrl = `get-payment-info?per_page=${rows}&page=${currentPage}`;

            if (searchQuery) {
            apiUrl += `&query=${searchQuery.value}`;
            }

            if (selectedValues.sortByStatus) {
            apiUrl += `&sort_by_status=${selectedValues.sortByStatus}`; 
            }

            if (selectedValues.sort_by_plan_name) {
            apiUrl += `&sort_by_plan_name=${selectedValues.sort_by_plan_name}`;
            }

            if(start_date || last_date) {
                apiUrl += `&start_date=${start_date}&last_date=${last_date}`;
            }

            if (exportCsv) {
            apiUrl += `&export_csv=${exportCsv}`;
            }

            ApiRequest(apiUrl, 'GET')
            .then(response => {
                const data = (response.data);
                if(data.length === 0) {
                dataContainer.innerHTML = `<tr><td colspan="10" class="text-center">No data found</td></tr>`;
                }else if(data.statusCode == 200){
                    exportCsv = false;
                    Swal.fire({
                                title: "Success!",
                                text: response.data.message,
                                icon: "success",
                                didOpen: () => {
                                    const titleElement = Swal.getTitle();
                                    titleElement.style.color = 'green';
                                    titleElement.style.fontSize = '20px';

                                    const confirmButton = Swal.getConfirmButton();
                                    confirmButton.style.backgroundColor = '#feca40';
                                    confirmButton.style.color = 'white';
                                }
                            });
                }
                else{
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
                   ${item.business_name}
                </div>
            </td>
            <td>
                 <div class="productTitle_t">
                ${item.company_serial_id}

                </div>
            </td>
             <td>
                <div class="productTitle_t">
                   ${item.type}

                </div>
            </td>
            <td>
                <div class="productTitle_t">
                   ${item.plan_name}

                </div>
             </td>
             <td>
                <div class="productTitle_t">
                   ${item.amount}

                </div>
             </td>
                 <td>
                <div class="productTitle_t">
                   ${item.amount_with_gst}

                </div>
             </td>
                <td>
                <div class="productTitle_t">
                   ${item.subscription_start_date}

                </div>
             </td>
           
               
                <td>
                <div class="productTitle_t">
                   ${item.subscription_end_date}

                </div>
                </td>
                <td>
                  <div class="productTitle_t">
                   ${item.inventory_count}

                </div>
                </td>
                <td>
                  <div class="productTitle_t">
                   ${item.download_count}

                </div>
             </td>
             <td>
                <div class="productTitle_t">
                   ${item.status}

                </div>
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