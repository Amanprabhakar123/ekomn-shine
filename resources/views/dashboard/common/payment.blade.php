@extends('dashboard.layout.app')
@section('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection
@section('content')
<div class="ek_dashboard">
  <div class="ek_content">
    <div class="card ekcard pa shadow-sm">
      <div class="cardhead paymentcardhead">
        <h3 class="cardtitle">Order Payments</h3>
        <div class="showTotalBox _productID">
          <div>Total Balance: <strong><i class="fas fa-rupee-sign fs-13 me-1"></i>{{$total_balance_due}}</strong></div>
          <div>Payment Due: <strong><i class="fas fa-rupee-sign fs-13 me-1"></i>{{$total_payment_due}}</strong></div>
        </div>
      </div>
			<div class="filterStrip filterStripwithbtn">
        <ul class="ekfilterList">
        <li>
                <div class="calanderWithName">
                    <div class="calUplabel dateRange_c">
                        <span class="calLabel">Date Range</span>
                        <input type="text" name="daterange" />
                    </div>
                </div>
            </li>
          <li>
            <div class="calanderWithName">
                <div class="calUplabel">
                    <span class="calLabel">Statement Week</span>
                    <input type="text" name="date" />
                </div>
                <div class="weekamount"><i class="fas fa-rupee-sign fs-13 me-1"></i>0.00</div>
            </div>
          </li>
          <li>
            <div class="dropdown" id="orderStatusDropdown">
              <button class="btn dropdown-toggle filterSelectBox" type="button" data-bs-toggle="dropdown" aria-expanded="false"><span class="opacity-50 me-2">Order Status</span><strong class="dropdownValue">All</strong></button>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#" data-value="0">All</a></li>
                <li><a class="dropdown-item" href="#" data-value="4">Dispatched</a></li>
                <li><a class="dropdown-item" href="#" data-value="5">In Transit</a></li>
                <li><a class="dropdown-item" href="#" data-value="6">Delivered</a></li>
                <li><a class="dropdown-item" href="#" data-value="8">RTO</a></li>
                <li><a class="dropdown-item" href="#" data-value="9">Return Filled</a></li>
              </ul>
            </div>
          </li>
          <li>
            <div class="dropdown" id="paymentStatusDropdown">
              <button class="btn dropdown-toggle filterSelectBox" type="button" data-bs-toggle="dropdown" aria-expanded="false"><span class="opacity-50 me-2">Payment Status</span><strong class="dropdownValue">All</strong></button>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#" data-value="0">All</a></li>
                <li><a class="dropdown-item" href="#" data-value="1">Hold</a></li>
                <li><a class="dropdown-item" href="#" data-value="2">Accrued</a></li>
                <li><a class="dropdown-item" href="#" data-value="3">Paid</a></li>
                <li><a class="dropdown-item" href="#" data-value="4">Due</a></li>
              </ul>
            </div>
          </li>
          <li>
            @if (auth()->user()->hasRole(ROLE_ADMIN) || auth()->user()->hasRole(ROLE_SUB_ADMIN))
            <input type="text" id="searchQuery" title="Search with eKomn Order, Store Order or Customer name" class="form-control  searchicon" placeholder="Search" />
            @else
            <input type="text" id="searchQuery" title="Search with eKomn Order, Store Order or Customer name" class="form-control  searchicon" placeholder="Search" />
            @endif
          </li>
        </ul>
        <button class="btn btnekomn_dark stripbtn" onclick="collectCheckedIdsForCsv()"><i class="fas fa-file-csv me-2"></i>Export CSV</button>
      </div>
      <div class="table-responsive tres_border">
        <table class="normalTable whitespace">
          <thead class="thead-dark">
            <tr>
              <th>
                <div class="form-check form-check-sm form-check-custom form-check-solid">
                  <input class="form-check-input" type="checkbox" id="select-all" />
                </div>
              </th>
              <th>eKomn Order No</th>
              @if(auth()->user()->hasRole(ROLE_ADMIN) || auth()->user()->hasRole(ROLE_SUB_ADMIN))
              <th>Supplier Id</th>
              @endif
              <th>Date</th>
              <th class="collapse-group-1">Product Charges</th>
              <th class="collapse-group-1">Discount</th>
              <th class="collapse-group-1">Shipping Charges</th>
              <th class="collapse-group-1">Packing Charges</th>
              <th class="collapse-group-1">Labour Charges</th>
              <th class="collapse-group-1">Payment Charges</th>
              <th class="collapse-group-1">Total GST</th>
              <th>Order Amount<i class="fas fa-plus-square collapse-toggle fs-14 ms-1" data-target="group1"></i></th>
              <th>Order Status</th>
              <th>Category</th>
              <th class="collapse-group-2">Refunds</th>
              <th class="collapse-group-2">Referral Fee</th>
              <th class="collapse-group-2">Adjustments</th>
              <th class="collapse-group-2">TDS</th>
              <th class="collapse-group-2">TCS</th>
              <th>Order Disbursement Amount<i class="fas fa-plus-square collapse-toggle fs-14 ms-1" data-target="group2"></i></th>
              <th>Supplier Payment Status</th>
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
        <div class="row_select jumper">
          Go to
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
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
	$('.collapse-toggle').on('click', function() {
		var targetGroup = $(this).data('target');
		var groupSelector = '.collapse-group-' + targetGroup.slice(-1);
		$(groupSelector).toggle();
		$(this).toggleClass('fa-plus-square fa-minus-square');
	});


		$('#select-all').on('change', function() {
      var isChecked = $(this).prop('checked');
      $('.row_ckeck').prop('checked', isChecked);
    });
    $('.row_ckeck').on('change', function() {
      var allChecked = $('.row_ckeck').length === $('.row_ckeck:checked').length;
      $('#select-all').prop('checked', allChecked);
    });
</script>
<script>
document.querySelectorAll('.calUplabel').forEach(function(element) {
    element.addEventListener('click', function() {
        this.querySelector('input').focus();  // Focus on the input field to trigger the calendar.
    });
});
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
        let order_date = order_last_date = statement_date = '';

        $(function() {
            const today = moment().format('YYYY-MM-DD');
            const thirtyDaysAgo = moment().subtract(30, 'days').format('YYYY-MM-DD');
            $('input[name="daterange"]').daterangepicker({
                autoApply: true,
                opens: 'left',
                startDate: thirtyDaysAgo,
                endDate: today,
                locale: {
                    format: 'YYYY-MM-DD' // Ensures the date format is consistent
                }
            }, function(start, end, label) {
                // console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
                order_date = start.format('YYYY-MM-DD');
                order_last_date = end.format('YYYY-MM-DD');
                fetchData();
            });

            //
            $('input[name="date"]').daterangepicker({
                singleDatePicker: true,    // Enables single date picker
                autoApply: true,
                opens: 'left',
                startDate: today,
                locale: {
                    format: 'YYYY-MM-DD'   // Ensures the date format is consistent
                }
            },
            function(selectedDate) {
                statement_date = selectedDate.format('YYYY-MM-DD');
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

        let selectedValues = {
            sort_by_order_status: "0",
            sortByStatus: "0"
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
            const orderStatusDropdown = document.getElementById('orderStatusDropdown');
            const paymentStatusDropdown = document.getElementById('paymentStatusDropdown');
            handleDropdownSelection(orderStatusDropdown, 'sort_by_order_status');
            handleDropdownSelection(paymentStatusDropdown, 'sortByStatus');
     

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

            if (selectedValues.sortByStatus) {
                apiUrl += `&sort_by_status=${selectedValues.sortByStatus}`;
            }

            if (selectedValues.sort_by_order_status) {
                apiUrl += `&sort_by_order_status=${selectedValues.sort_by_order_status}`;
            }

            if(order_date && order_last_date) {
                apiUrl += `&order_date=${order_date}&order_last_date=${order_last_date}`;
            }

            if(statement_date){
                apiUrl += `&statement_date=${statement_date}`;
            }


            ApiRequest(apiUrl, 'GET')
                .then(response => {
                    const data = (response.data);
                    if (data.length === 0) {
                        document.querySelector('.weekamount').innerHTML = `<i class="fas fa-rupee-sign fs-13 me-1"></i>0.00`;
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
        document.querySelector('.weekamount').innerHTML = `<i class="fas fa-rupee-sign fs-13 me-1"></i>${item.total_statement_amount}`;

        return `
                        <tr>
                            <td> 
                                <div class="form-check form-check-sm form-check-custom form-check-solid mt-0">
                                    <input class="form-check-input row_ckeck" type="checkbox"
                                        value="${item.id}">
                                </div>
                            </td>
                            <td>
                                <a href="${item.view_order}" class="a_link" target="_blank">${item.order_no}</a>
                            </td>
                            @if(auth()->user()->hasRole(ROLE_ADMIN) || auth()->user()->hasRole(ROLE_SUB_ADMIN))
                            <td class="text-center">${item.supplier_id}</td>
                            @endif
                            <td class="text-center">${item.order_date}</td>
                            <td class="text-center  collapse-group-1">${item.product_cost_exc_gst}</td>
                            <td class="text-center collapse-group-1">${item.discount}</td>
                            <td class="text-center collapse-group-1">${item.shipping_charges_gst_exc_amount}</td>
                            <td class="text-center collapse-group-1">${item.packing_charges_gst_exc_amount}</td>
                            <td class="text-center collapse-group-1">${item.labour_charges_gst_exc_amount}</td>
                            <td class="text-center collapse-group-1">${item.payment_gateway_charges_gst_exc_amount}</td>
                            <td class="text-center collapse-group-1">${item.total_gst_amount}</td>
                            <td class="text-center">${item.order_total}</td>
                            <td class="text-center">${item.order_status}</td>
                            <td class="text-center">${item.order_type}</td>
                            <td class="text-center collapse-group-2">${item.refund_amount}</td>
                            <td class="text-center collapse-group-2">${item.processing_charges}</td>
                            
                             @if(auth()->user()->hasRole(ROLE_ADMIN) || auth()->user()->hasRole(ROLE_SUB_ADMIN))
                                <td class="text-center collapse-group-2"><input type="text" class="stock_t" onchange="updateAdjustmentAmount('${item.id}', this)" ${item.payment_status == 'Paid' ? 'disabled' : ''} adjustmentAmount" value="${item.adjustment_amount}"></td>
                                @else
                                 <td class="text-center collapse-group-2">${item.adjustment_amount}</td>
                                @endif
                                
                            
                           
                            <td class="text-center collapse-group-2">${item.tds_amount}</td>
                            <td class="text-center collapse-group-2">${item.tcs_amount}</td>
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

    /**
     * Collects the IDs of all checked checkboxes for CSV download.
     * Displays an error message if no checkboxes are selected.
     */
    function collectCheckedIdsForCsv() {
        // Select all checkboxes with the class 'form-check-input'
        const allCheckboxes = document.querySelectorAll('.row_ckeck');

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
            fetch('{{ route('payment.export.weekly') }}', {
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
                    a.download = 'Supplier-Payments_' + Date.now() + '.csv';
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
                    a.download = 'Reciept_' + Date.now() + '.pdf';
                    document.body.appendChild(a);
                    a.click();
                    window.URL.revokeObjectURL(url);
                })
                .catch(error => {
                    console.error('Error downloading products:', error);
                });


        }
</script>

@endsection