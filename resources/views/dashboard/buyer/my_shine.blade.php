@extends('dashboard.layout.app')
@section('content')
@section('title')
My Shine
@endsection

<div class="ek_dashboard">
    <div class="ek_content">
      <div class="card ekcard pa shadow-sm">
        <div class="cardhead ">
          <h3 class="cardtitle">Shine</h3>
          <div style="display: flex; flex-direction: column; align-items: flex-end; margin-left: 10px;">
            <div>
              <label for="fname">
                <h6>Shine Credit :</h6>
              </label>
              {{-- <a href="#" class="btn btnekomn btn-sm">₹ 2000</a>
              <a href="#" id="" style="margin-left: 10px;" class="btn btnekomn btn-sm bold">Read me</a>
              <a href="#" id="openModal" class="btn btnekomn btn-sm bold">+ New Shine</a> --}}
            </div>
            <div class="showTotalBox _productID" style="margin-top: 10px;">
              <div>Shine Credit: <strong><i class="fas fa-rupee-sign fs-13 me-1"></i>2000</strong></div>
            </div>
            {{-- <a href="#" id="openModal" style="margin-top: 10px;" class="btn btnekomn btn-sm">+ Add New Shine</a> --}}
          </div>
        </div>    
        <div>
          <ul class="nav nav-underline ekom_tab" role="tablist">
            <li class="nav-item" role="presentation">
              <a class="nav-link active" id="shine-tab" data-bs-toggle="tab" data-bs-target="#shine" role="tab"
                aria-controls="shine" aria-selected="true">My Shine</a>
            </li>
            <li class="nav-item" role="presentation">
              <a class="nav-link" id="live-shine-tab" data-bs-toggle="tab" data-bs-target="#live-shine" role="tab"
                aria-controls="live-shine" aria-selected="false">Assigned Shine</a>
            </li>
          </ul>
          <div class="ekomn_Shine_btn"><a href="#" id="openModal" class="btn btnekomn btn-sm">+ Add New Shine</a></div>
          <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="shine" role="tabpanel" aria-labelledby="shine-tab" tabindex="0">
              <div class="o_bannerimg">
                <img src="{{asset('assets/images/order/order-banner-1.jpg')}}" alt="" style="width: 100%;" />
              </div>
              <div class="tableTop pt-3">
                <input type="text" class="form-control w_300_f searchicon"
                  placeholder="Search with Product Name, Batch ID, Request No, Product ID/ASIN" id="searchInput">
                <div class="filter">
                  <div class="ek_group m-0">
                    <label class="eklabel w_50_f">Sort by:</label>
                    <div class="ek_f_input">
                      <select class="form-select" id="sort_by_status">
                        <option value="NA" selected>Select</option>
                        <option value="0">Draft</option>
                        <option value="1">Pending</option>
                        <option value="2">Inprogress</option>
                        <option value="3">Order Placed</option>
                        <option value="4">Order Confirm</option>
                        <option value="5">Review Submited</option>
                        <option value="6">Complete</option>
                        <option value="7">Cancelled</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="table-responsive tres_border">
                <table class="normalTable tableSorting whitespace" id="productTable">
                  <thead>
                    <tr>
                      <th>Batch ID
                        <span class="sort_pos">
                          <small class="sort_t"><i class="fas fa-caret-up"></i><i class="fas fa-caret-down"></i></small>
                        </span>
                      </th>
                      <th>Request No
                        <span class="sort_pos">
                          <small class="sort_t"><i class="fas fa-caret-up"></i><i class="fas fa-caret-down"></i></small>
                        </span>
                      </th>
                      <th>Product Name/URL/Link</th>
                      {{-- <th>Platform</th> --}}
                      {{-- <th>Product URL/Link</th> --}}
                      <th>Product ID/ASIN</th>
                      {{-- <th>Seller/Brand Name</th> --}}
                      {{-- <th>Product Search Term </th> --}}
                      <th>Product amount</th>
                      {{-- <th>Feedback/Review Title</th> --}}
                      {{-- <th>Feedback/Review comment</th> --}}
                      {{-- <th>Review Rating</th> --}}
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                    <tbody id="dataShine">
                      @if($shineProducts->isEmpty())
                          <tr>
                              <td colspan="9" style="text-align: center;">No Shine Data Found, Add New Shine First...</td>
                          </tr>
                      @else
                      @foreach($shineProducts->reverse() as $product)
                          <tr data-status="{{ $product->status }}">
                            <td>
                              <span id="batchId-{{ $product->id }}">{{ $product->batch_id }}</span>
                              <i class="fas fa-copy copy-icon" style="cursor: pointer; margin-left: 5px;" onclick="copyToClipboard('batchId-{{ $product->id }}', this)"></i>
                              <span class="copy-message" style="display: none; margin-left: 5px; color: #FECA40;">Copied</span>
                            </td>
                            <td>
                                <span id="requestNo-{{ $product->id }}">{{ $product->request_no }}</span>
                                <i class="fas fa-copy copy-icon" style="cursor: pointer; margin-left: 5px;" onclick="copyToClipboard('requestNo-{{ $product->id }}', this)"></i>
                                <span class="copy-message" style="display: none; margin-left: 5px; color: #FECA40;">Copied</span>
                            </td>
                            <td class="product-name" data-original-name="{{ $product->name }}">
                              <a href="{{ $product->url }}" target="_blank" id="name-{{ $product->id }}" class="product-link">
                                  {{ $product->name }}
                              </a>
                            </td>
                            {{-- <td>
                              <a target="_blank" href="{{ $product->url }}" id="url-{{ $product->id }}">Product Link</a>
                              <i class="fas fa-copy copy-icon" style="cursor: pointer; margin-left: 5px;" onclick="copyToClipboard('url-{{ $product->id }}', this)"></i>
                              <div class="copy-message" style="display: none; color: #FECA40;">Copied</div>
                            </td> --}}
                            <td>
                                <span id="productId-{{ $product->id }}">{{ $product->product_id }}</span>
                                {{-- <i class="fas fa-copy copy-icon" style="cursor: pointer; margin-left: 5px;" onclick="copyToClipboard('productId-{{ $product->id }}', this)"></i>
                                <span class="copy-message" style="display: none; margin-left: 5px; color: #FECA40;">Copied</span> --}}
                            </td>
                            

                              {{-- <td>{{ $product->seller_name }}</td> --}}
                              {{-- <td>{{ $product->search_term }}</td> --}}
                              <td>₹ {{ $product->amount }}</td>
                              {{-- <td>{{ $product->feedback_title }}</td> --}}
                              {{-- <td>{{ $product->feedback_comment }}</td> --}}
                              {{-- <td class="star-rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $product->review_rating)
                                        <i class="fas fa-star"></i> <!-- Filled star -->
                                    @else
                                        <i class="far fa-star"></i> <!-- Empty star -->
                                    @endif
                                @endfor
                              </td> --}}
                              <td>
                                @if($product->status == 0)
                                    <span style='padding: 3px 7px; border-radius: 3px; background-color: #6c757d; color: #fff;'>Draft</span>
                                @elseif($product->status == 1)
                                    <span style='padding: 3px 7px; border-radius: 3px; background-color: #ffc107; color: #000;'>Pending</span>
                                @elseif($product->status == 2)
                                    <span style='padding: 3px 7px; border-radius: 3px; background-color: #17a2b8; color: #fff;'>Inprogress</span>
                                @elseif($product->status == 3)
                                    <span style='padding: 3px 7px; border-radius: 3px; background-color: #007bff; color: #fff;'>Order Placed</span>
                                @elseif($product->status == 4)
                                    <span style='padding: 3px 7px; border-radius: 3px; background-color: #28a745; color: #fff;'>Order Confirm</span>
                                @elseif($product->status == 5)
                                    <span style='padding: 3px 7px; border-radius: 3px; background-color: #ffc107; color: #000;'>Review Submitted</span>
                                @elseif($product->status == 6)
                                    <span style='padding: 3px 7px; border-radius: 3px; background-color: #28a745; color: #fff;'>Complete</span>
                                @elseif($product->status == 7)
                                    <span style='padding: 3px 7px; border-radius: 3px; background-color: #dc3545; color: #fff;'>Cancelled</span>
                                @endif
                              </td>
                              <td>
                                <a href="{{ route('shine-status', $product->id) }}" class="btn btnekomn btn-sm {{ $product->status == 3 || $product->status == 5 ? 'blink' : '' }}">View Details</a>
                              </td>
                          </tr>
                      @endforeach
                      @endif
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
                    <option value="10">10</option>
                    <option selected value="50">50</option>
                    <option value="100">100</option>
                    <option value="200">200</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="live-shine" role="tabpanel" aria-labelledby="live-shine-tab" tabindex="0">
              <div class="tableTop">
                <input type="text" class="form-control w_300_f searchicon"
                  placeholder="Search with Product Name, Batch ID, Request No, Product ID/ASIN" id="searchInputassigned">
                <div class="filter">
                  <div class="ek_group m-0">
                    <label class="eklabel w_50_f">Sort by:</label>
                    <div class="ek_f_input">
                      <select class="form-select" id="sort_by_statusassigned">
                        <option value="NA" selected>Select</option>
                        <option value="0">Draft</option>
                        <option value="1">Pending</option>
                        <option value="2">Inprogress</option>
                        <option value="3">Order Placed</option>
                        <option value="4">Order Confirm</option>
                        <option value="5">Review Submited</option>
                        <option value="6">Complete</option>
                        <option value="7">Cancelled</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="table-responsive tres_border">
                <table class="normalTable tableSorting whitespace" id="productTableassigned">
                  <thead>
                    <tr>
                      <th>Batch ID
                        <span class="sort_pos">
                          <small class="sort_t"><i class="fas fa-caret-up"></i><i class="fas fa-caret-down"></i></small>
                        </span>
                      </th>
                      <th>Request No
                        <span class="sort_pos">
                          <small class="sort_t"><i class="fas fa-caret-up"></i><i class="fas fa-caret-down"></i></small>
                        </span>
                      </th>
                      <th>Product Name/URL/Link</th>
                      <th>Platform</th>
                      {{-- <th>Product URL/Link</th> --}}
                      <th>Product ID/ASIN</th>
                      {{-- <th>Seller/Brand Name</th>
                      <th>Product Search Term </th> --}}
                      <th>Product amount</th>
                      {{-- <th>Feedback/Review Title</th>
                      <th>Feedback/Review comment</th>
                      <th>Review Rating</th> --}}
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody id="dataShineassigned">
                    @if($assignedProducts->isEmpty())
                        <tr>
                            <td colspan="9" style="text-align: center;">Not Assigned Shine Yet, Add New Shine First...</td>
                        </tr>
                    @else
                    @foreach($assignedProducts->reverse() as $product)
                    <tr data-status-assigned="{{ $product->status }}">
                      <td>
                        <span id="batchId-{{ $product->id }}">{{ $product->batch_id }}</span>
                        <i class="fas fa-copy copy-icon" style="cursor: pointer; margin-left: 5px;" onclick="copyToClipboard('batchId-{{ $product->id }}', this)"></i>
                        <div class="copy-message" style="display: none; color: #FECA40;">Copied</div>
                      </td>
                      <td>
                        <span id="requestNo-{{ $product->id }}">{{ $product->request_no }}</span>
                        <i class="fas fa-copy copy-icon" style="cursor: pointer; margin-left: 5px;" onclick="copyToClipboard('requestNo-{{ $product->id }}', this)"></i>
                        <div class="copy-message" style="display: none; color: #FECA40;">Copied</div>
                      </td>
                      <td class="product-name" data-original-name="{{ $product->name }}">
                        <a href="{{ $product->url }}" target="_blank" id="name-{{ $product->id }}" class="product-link">
                            {{ $product->name }}
                        </a>
                      </td>
                      <td>{{ $product->platform }}</td>
                      {{-- <td>
                        <a target="_blank" href="{{ $product->url }}" id="url-{{ $product->id }}">Product Link</a>
                        <i class="fas fa-copy copy-icon" style="cursor: pointer; margin-left: 5px;" onclick="copyToClipboard('url-{{ $product->id }}', this)"></i>
                        <div class="copy-message" style="display: none; color: #FECA40;">Copied</div>
                      </td> --}}
                      <td>
                        <span id="productId-{{ $product->id }}">{{ $product->product_id }}</span>
                        {{-- <i class="fas fa-copy copy-icon" style="cursor: pointer; margin-left: 5px;" onclick="copyToClipboard('productId-{{ $product->id }}', this)"></i>
                        <div class="copy-message" style="display: none; color: #FECA40;">Copied</div> --}}
                      </td>
                  
                      {{-- <td>{{ $product->seller_name }}</td> --}}
                      {{-- <td>{{ $product->search_term }}</td> --}}
                      <td>₹ {{ $product->amount }}</td>
                      {{-- <td>{{ $product->feedback_title }}</td> --}}
                      {{-- <td>{{ $product->feedback_comment }}</td> --}}
                      {{-- <td class="star-rating">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $product->review_rating)
                                <i class="fas fa-star"></i> 
                            @else
                                <i class="far fa-star"></i> 
                            @endif
                        @endfor
                      </td> --}}
                      <td>
                        @if($product->status == 0)
                            <span style='padding: 3px 7px; border-radius: 3px; background-color: #6c757d; color: #fff;'>Draft</span>
                        @elseif($product->status == 1)
                            <span style='padding: 3px 7px; border-radius: 3px; background-color: #ffc107; color: #000;'>Pending</span>
                        @elseif($product->status == 2)
                            <span style='padding: 3px 7px; border-radius: 3px; background-color: #17a2b8; color: #fff;'>Inprogress</span>
                        @elseif($product->status == 3)
                            <span style='padding: 3px 7px; border-radius: 3px; background-color: #007bff; color: #fff;'>Order Placed</span>
                        @elseif($product->status == 4)
                            <span style='padding: 3px 7px; border-radius: 3px; background-color: #28a745; color: #fff;'>Order Confirm</span>
                        @elseif($product->status == 5)
                            <span style='padding: 3px 7px; border-radius: 3px; background-color: #ffc107; color: #000;'>Review Submitted</span>
                        @elseif($product->status == 6)
                            <span style='padding: 3px 7px; border-radius: 3px; background-color: #28a745; color: #fff;'>Complete</span>
                        @elseif($product->status == 7)
                            <span style='padding: 3px 7px; border-radius: 3px; background-color: #dc3545; color: #fff;'>Cancelled</span>
                        @endif
                      </td>
                      <td>
                        <a href="{{ route('complete-shine', $product->id) }}" class="btn btnekomn btn-sm">Complete Shine</a>
                        <div class="text-center mt-1 text-danger blink countdown" data-created-at="{{ $product->created_at }}" data-status="{{ $product->status }}"></div>
                        {{-- <a href="{{ route('complete-shine', $product->id) }}" class="btn btnekomn btn-sm {{ $product->status == 2 || $product->status == 4 ? 'blink' : '' }}">Complete Shine</a> --}}
                      </td>
                    </tr>
                    @endforeach
                    @endif                
                  </tbody>
                </table>
              </div>
              <div class="ek_pagination">
                <span class="row_select rowcount" id="rowInfoassigned"></span>
                <div class="pager_box">
                  <button id="prevPageassigned" class="pager_btn"><i class="fas fa-chevron-left"></i></button>
                  <ul class="pager_" id="paginationassigned"></ul>
                  <button id="nextPageassigned" class="pager_btn"><i class="fas fa-chevron-right"></i></button>
                </div>
                <div class="row_select jumper">Go to
                  <select id="rowsPerPageassigned">
                    <option value="10">10</option>
                    <option selected value="50">50</option>
                    <option value="100">100</option>
                    <option value="200">200</option>
                  </select>
                </div>
              </div>
            </div>
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
  // Script for copy the field
  function copyToClipboard(elementId, iconElement) {
      var element = document.getElementById(elementId);
      var parentElement = element.closest('.product-name');
      var text;
  
      if (parentElement && parentElement.hasAttribute('data-original-name')) {
          text = parentElement.getAttribute('data-original-name');
      } else {
          if (element.tagName === 'A') {
              text = element.href;
          } else {
              text = element.innerText || element.textContent;
          }
      }
  
      var textArea = document.createElement("textarea");
      textArea.value = text;
      document.body.appendChild(textArea);
      textArea.select();
      document.execCommand("copy");
      document.body.removeChild(textArea);
  
      // Show the copied message
      var copyMessage = iconElement.nextElementSibling;
      copyMessage.style.display = 'inline';
      setTimeout(function() {
          copyMessage.style.display = 'none';
      }, 2000); // Hide after 2 seconds
  }
  
  // Script for product Name shorting
  function truncateWords(element, wordLimit) {
    var text = element.textContent.trim();
    var words = text.split(' ');
    if (words.length > wordLimit) {
        element.textContent = words.slice(0, wordLimit).join(' ') + '...';
    }
  }

  document.addEventListener('DOMContentLoaded', function() {
    var productLinks = document.querySelectorAll('.product-name .product-link');
    productLinks.forEach(function(element) {
        truncateWords(element, 3);
    });
  });
  

  document.addEventListener('DOMContentLoaded', function() {
    function activateTab(tabId) {
        var tabTrigger = document.querySelector(`a[data-bs-target="#${tabId}"]`);
        if (tabTrigger) {
            var tab = new bootstrap.Tab(tabTrigger);
            tab.show();
        }
    }

    var urlParams = new URLSearchParams(window.location.search);
    var tabId = urlParams.get('tab');
    
    if (tabId) {
        activateTab(tabId);
    } else {
        // Optionally handle the default case if no query parameter is provided
        activateTab('shine'); // Default to 'shine' if no tab parameter is present
    }
  });

// My Shine Search And status shorting and pegination
  document.addEventListener('DOMContentLoaded', function() {
  const searchInput = document.getElementById('searchInput');
  const sortByStatus = document.getElementById('sort_by_status');
  const rowsPerPageSelect = document.getElementById('rowsPerPage');
  const prevPageButton = document.getElementById('prevPage');
  const nextPageButton = document.getElementById('nextPage');
  const paginationUl = document.getElementById('pagination');
  const rowInfo = document.getElementById('rowInfo');
  const table = document.getElementById('productTable');
  const tableBody = document.getElementById('dataShine');
  const tableRows = Array.from(tableBody.querySelectorAll('tr'));
  
  let currentPage = 1;
  let rowsPerPage = parseInt(rowsPerPageSelect.value);
  let filteredRows = tableRows;

  // Function to render pagination
  function renderPagination() {
    paginationUl.innerHTML = '';
    const totalPages = Math.ceil(filteredRows.length / rowsPerPage);

    for (let i = 1; i <= totalPages; i++) {
      const li = document.createElement('li');
      li.textContent = i;
      li.className = 'page-item' + (i === currentPage ? ' active' : '');
      li.addEventListener('click', () => {
        currentPage = i;
        renderTable();
      });
      paginationUl.appendChild(li);
    }

    prevPageButton.disabled = currentPage === 1;
    nextPageButton.disabled = currentPage === totalPages;
    rowInfo.textContent = `Showing ${(currentPage - 1) * rowsPerPage + 1} to ${Math.min(currentPage * rowsPerPage, filteredRows.length)} of ${filteredRows.length} entries`;
  }

  // Function to render table rows based on pagination
  function renderTable() {
    tableBody.innerHTML = '';
    const start = (currentPage - 1) * rowsPerPage;
    const end = Math.min(currentPage * rowsPerPage, filteredRows.length);

    for (let i = start; i < end; i++) {
      tableBody.appendChild(filteredRows[i]);
    }

    renderPagination();
  }

  // Function to filter rows based on search and sort
  function filterRows() {
    const searchTerm = searchInput.value.toLowerCase();
    const selectedStatus = sortByStatus.value;

    filteredRows = tableRows.filter(row => {
      const cells = row.getElementsByTagName('td');
      let match = false;

      // Check if the row matches the search term
      for (let i = 0; i < cells.length - 1; i++) {
        if (cells[i].textContent.toLowerCase().includes(searchTerm)) {
          match = true;
          break;
        }
      }

      // Check if the row matches the selected status
      const rowStatus = row.getAttribute('data-status');
      if (selectedStatus !== 'NA' && rowStatus !== selectedStatus) {
        match = false;
      }

      return match;
    });

    currentPage = 1;
    renderTable();
  }

  // Event listeners
  searchInput.addEventListener('input', filterRows);
  sortByStatus.addEventListener('change', filterRows);
  rowsPerPageSelect.addEventListener('change', () => {
    rowsPerPage = parseInt(rowsPerPageSelect.value);
    renderTable();
  });

  prevPageButton.addEventListener('click', () => {
    if (currentPage > 1) {
      currentPage--;
      renderTable();
    }
  });

  nextPageButton.addEventListener('click', () => {
    const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
    if (currentPage < totalPages) {
      currentPage++;
      renderTable();
    }
  });

  // Initial render
  renderTable();
});


// Assigned Shine Search And status shorting and pegination
document.addEventListener('DOMContentLoaded', function() {
  const searchInput = document.getElementById('searchInputassigned');
  const sortByStatus = document.getElementById('sort_by_statusassigned');
  const rowsPerPageSelect = document.getElementById('rowsPerPageassigned');
  const prevPageButton = document.getElementById('prevPageassigned');
  const nextPageButton = document.getElementById('nextPageassigned');
  const paginationUl = document.getElementById('paginationassigned');
  const rowInfo = document.getElementById('rowInfoassigned');
  const table = document.getElementById('productTableassigned');
  const tableBody = document.getElementById('dataShineassigned');
  const tableRows = Array.from(tableBody.querySelectorAll('tr'));

  let currentPage = 1;
  let rowsPerPage = parseInt(rowsPerPageSelect.value, 10);
  let filteredRows = tableRows;

  function renderPagination() {
    paginationUl.innerHTML = '';
    const totalPages = Math.ceil(filteredRows.length / rowsPerPage);

    for (let i = 1; i <= totalPages; i++) {
      const li = document.createElement('li');
      li.textContent = i;
      li.className = 'page-item' + (i === currentPage ? ' active' : '');
      li.addEventListener('click', () => {
        currentPage = i;
        renderTable();
      });
      paginationUl.appendChild(li);
    }

    prevPageButton.disabled = currentPage === 1;
    nextPageButton.disabled = currentPage === totalPages;
    rowInfo.textContent = `Showing ${(currentPage - 1) * rowsPerPage + 1} to ${Math.min(currentPage * rowsPerPage, filteredRows.length)} of ${filteredRows.length} entries`;
  }

  function renderTable() {
    tableBody.innerHTML = '';
    const start = (currentPage - 1) * rowsPerPage;
    const end = Math.min(currentPage * rowsPerPage, filteredRows.length);

    for (let i = start; i < end; i++) {
      tableBody.appendChild(filteredRows[i]);
    }
    renderPagination();
  }

  function filterRows() {
    const searchTerm = searchInput.value.toLowerCase();
    const selectedStatus = sortByStatus.value;

    filteredRows = tableRows.filter(row => {
      const cells = row.getElementsByTagName('td');
      let match = false;

      for (let i = 0; i < cells.length - 1; i++) {
        if (cells[i].textContent.toLowerCase().includes(searchTerm)) {
          match = true;
          break;
        }
      }

      const rowStatus = row.getAttribute('data-status-assigned');
      if (selectedStatus !== 'NA' && rowStatus !== selectedStatus) {
        match = false;
      }

      return match;
    });

    currentPage = 1;
    renderTable();
  }

  searchInput.addEventListener('input', filterRows);
  sortByStatus.addEventListener('change', filterRows);
  rowsPerPageSelect.addEventListener('change', () => {
    rowsPerPage = parseInt(rowsPerPageSelect.value, 10);
    renderTable();
  });

  prevPageButton.addEventListener('click', () => {
    if (currentPage > 1) {
      currentPage--;
      renderTable();
    }
  });

  nextPageButton.addEventListener('click', () => {
    const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
    if (currentPage < totalPages) {
      currentPage++;
      renderTable();
    }
  });

  renderTable();
});

</script>
  
  
 <script>
document.addEventListener('DOMContentLoaded', function() {
    // Get all countdown elements
    const countdownElements = document.querySelectorAll('.countdown');
    
    countdownElements.forEach(function(countdownElement) {
        const status = countdownElement.getAttribute('data-status');

        // Check if status is 3, if so, stop and hide the countdown
        if (status != 2) {
            countdownElement.style.display = 'none';
            return; // Skip further processing for this element
        }

        const createdAt = new Date(countdownElement.getAttribute('data-created-at')).getTime();
        
        // Set the countdown duration (24 hours in milliseconds)
        const countdownDuration = 24 * 60 * 60 * 1000;
        
        // Function to update the countdown timer
        function updateCountdown() {
            const now = new Date().getTime();
            const timeElapsed = now - createdAt;
            const timeLeft = countdownDuration - timeElapsed;
            
            // Calculate hours, minutes, and seconds left
            const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

            // Display the result
            if (timeLeft >= 0) {
                countdownElement.innerHTML = `${hours}h ${minutes}m ${seconds}s`;
            } else {
                // If the countdown is over, display "Expired"
                countdownElement.innerHTML = "Expired";
                clearInterval(countdownInterval);
            }
        }

        // Update the countdown every second
        updateCountdown();  // Initial call
        const countdownInterval = setInterval(updateCountdown, 1000);
    });
});
</script> 

<script>
  document.getElementById('openModal').addEventListener('click', async function(event) {
    event.preventDefault(); // Prevent the default link behavior

    const { value: accept } = await Swal.fire({
        title: "Must Read...!",
        html: `
            <div>
                <h4 style="margin: 0;"><b>eKomn Shine - Usage guidelines and Terms<b></h4>
                <p class="pt-3">eKomn shine is a product feedback/review program that you can use to get professional reviews for your product and showcase them on selected platforms. It is a voluntary program primarily designed to assist online sellers to support each other as a community. The objective is to create better opportunities to grow their online selling business across various platforms. We urge you to review below guidelines and terms before you start using this module.</p>
                <ul>
                    <li>Term 1: Shine is a product review module and you are requested to participate mutually and reciprocate for every product feedback request that you raise for your products.</li>
                    <li>Term 2: You are not required to make any payment for this service. For each request raised, an equal value request shall be assigned to you that you must complete.</li>
                    <li>Term 3: Your product review request shall be processed only when you complete your own assigned requests.</li>
                    <li>Term 4: Each assigned Shine request must be processed within <b>48</b> hours else your own request will be disqualified and you will be asked to reinitiate it again.</li>
                    <li>Term 5: For beginners, the product value of each Shine request is restricted between <b>200 to 500</b>. As you use the service, you will auto qualify for higher value product orders.</li>
                    <li>Term 6: Usually, a Shine product review takes <b>15-20</b> days before a product review is visible on the selected platform. You are advised to regularly visit Shine module and take action on all notifications related to your Own as well as Assigned requests.</li>
                    <li>Term 7: You are advised to opt for products that you dispatch from your own store and not done through a platform warehouse. This will help you manage the shipment of actual products for each Shine request optimally.</li>
                </ul>
                <p>Please read the Guidelines and Terms carefully before proceeding.</p>
            </div>
        `,
        input: "checkbox",
        inputValue: 0,
        inputPlaceholder: "I agree with the Guidelines and Terms",
        confirmButtonText: "I Agree !  &nbsp;<i class='fa fa-arrow-right'></i>",
        inputValidator: (result) => {
            return !result && "You need to agree with Guidelines and Terms";
        },
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Close",
        customClass: {
            title: 'swal2-title-red', 
            confirmButton: 'swal2-confirm-btn',
            cancelButton: 'swal2-cancel-btn'
        },
        didOpen: () => {
            const title = Swal.getTitle();
            title.style.fontSize = '25px';
            const confirmButton = Swal.getConfirmButton();
            confirmButton.style.backgroundColor = '#FFB20C';
            confirmButton.style.color = 'white';
        }
    });
    
    if (accept) {
      Swal.fire({
        title: "Thanks for reading the shine guidelines. We wish you great business growth !!",
        icon: "success",
        confirmButtonColor: "#FFB20C", // Directly sets the button color
      }).then(() => {
        // Redirect to the new page
        window.location.href = "{{ route('new-shine') }}";
      });
    }
  });

  // Attach the same function to both elements
  document.getElementById('newrequest').addEventListener('click', showTermsAndConditions);
  document.getElementById('newshine-link').addEventListener('click', showTermsAndConditions);
</script>

@endsection
