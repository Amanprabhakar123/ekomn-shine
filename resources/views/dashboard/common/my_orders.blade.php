@extends('dashboard.layout.app')

@section('content')

<div class="ek_dashboard">
    <div class="ek_content">
    @if(auth()->user()->hasRole(ROLE_BUYER))
      <div class="card ekcard pa shadow-sm">
        <div class="cardhead">
          <h3 class="cardtitle">My Orders</h3>
          <a href="create-order.html" class="btn btnekomn btn-sm"><i class="fas fa-plus fs-12 me-1"></i>Create New Order</a>
        </div>
        <div class="tableTop mt10">
          <input type="text" title="Search with eKomn Order, Store Order or Customer name" class="form-control w_300_f searchicon" placeholder="Search">
          <div class="ek_group m-0">
            <label class="eklabel eklabel_60 m-0">Status:</label>
            <div class="ek_f_input">
              <select class="form-select w_150_f">
                <option value="Pending" selected>Pending</option>
                <option value="In Progress">In Progress</option>
                <option value="Dispatched">Dispatched</option>
                <option value="Delivered">Delivered</option>
                <option value="Delivered">Cancelled</option>
              </select>
            </div>
          </div>
        </div>
        <div class="table-responsive tres_border"> 
          <table class="normalTable tableSorting whitespace">
            <thead>
              <tr>
                <th>eKomn Order</th>
                <th>Store Order</th>
                <th>Product Title
                  <span class="sort_pos">
                    <small class="sort_t"><i class="fas fa-caret-up"></i><i class="fas fa-caret-down"></i></small>
                  </span>
                </th>
                <th>Customer Name</th>
                <th>Qty
                  <span class="sort_pos">
                    <small class="sort_t"><i class="fas fa-caret-up"></i><i class="fas fa-caret-down"></i></small>
                  </span>
                </th>
                <th>Date
                  <span class="sort_pos">
                    <small class="sort_t"><i class="fas fa-caret-up"></i><i class="fas fa-caret-down"></i></small>
                  </span>
                </th>
                <th>Total Amt.
                  <span class="sort_pos">
                    <small class="sort_t"><i class="fas fa-caret-up"></i><i class="fas fa-caret-down"></i></small>
                  </span>
                </th>
                <th>Category
                  <span class="sort_pos">
                    <small class="sort_t"><i class="fas fa-caret-up"></i><i class="fas fa-caret-down"></i></small>
                  </span>
                </th>
                <th>Type
                  <span class="sort_pos">
                    <small class="sort_t"><i class="fas fa-caret-up"></i><i class="fas fa-caret-down"></i></small>
                  </span>
                </th>
                <th>Status
                  <span class="sort_pos">
                    <small class="sort_t"><i class="fas fa-caret-up"></i><i class="fas fa-caret-down"></i></small>
                  </span>
                </th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>EK1050IND</td>
                <td>
                  EK501IND
                </td>
                <td>
                  <div class="productTitle_t">
                    <a href="{{route('view.order')}}" class="a_link">Cushion covers</a>
                  </div>
                </td>
                <td>Junaid Khan</td>
                <td>5</td>
                <td>
                  <div>30 June 2014 18:36</div>
                </td>
                <td>
                  <div class="sell_t"><i class="fas fa-rupee-sign"></i> 1000</div>
                </td>
                <td>Dropship</td>
                <td>Manual Order</td>
                <td>Pending</td>
                <td class="text-center">
                  <button class="btn btn-sm btn-danger">Cancel</button>
                </td>
              </tr>
              <tr>
                <td>EK1050IND</td>
                <td>
                  EK501IND
                </td>
                <td>
                  <div class="productTitle_t">
                    <a href="view-order-bb.html" class="a_link">Dell WM126 Wireless Mouse</a>
                  </div>
                </td>
                <td>Mohd Imtyaj</td>
                <td>25</td>
                <td>
                  <div>30 June 2014 23:30</div>
                </td>
                <td>
                  <div class="sell_t"><i class="fas fa-rupee-sign"></i> 5000</div>
                </td>
                <td>Bulk Order</td>
                <td>Store Order</td>
                <td>In Progress</td>
                <td class="text-center" title="Order can be cancelled only in 'Pending' Status">
                  <button class="btn btn-sm btn-danger" disabled>Cancel</button>
                </td>
              </tr>
              <tr>
                <td>EK1050IND</td>
                <td>
                  EK501IND
                </td>
                <td>
                  <div class="productTitle_t">
                    <a href="view-order-bb.html" class="a_link">Cushion covers</a>
                  </div>
                </td>
                <td>Junaid Khan</td>
                <td>5</td>
                <td>
                  <div>30 June 2014 18:36</div>
                </td>
                <td>
                  <div class="sell_t"><i class="fas fa-rupee-sign"></i> 1000</div>
                </td>
                <td>Dropship</td>
                <td>Manual Order</td>
                <td>Pending</td>
                <td class="text-center">
                  <button class="btn btn-sm btn-danger">Cancel</button>
                </td>
              </tr>
              <tr>
                <td>EK1050IND</td>
                <td>
                  EK501IND
                </td>
                <td>
                  <div class="productTitle_t">
                    <a href="" class="a_link">Cushion covers</a>
                  </div>
                </td>
                <td>Junaid Khan</td>
                <td>5</td>
                <td>
                  <div>30 June 2014 18:36</div>
                </td>
                <td>
                  <div class="sell_t"><i class="fas fa-rupee-sign"></i> 1000</div>
                </td>
                <td>Dropship</td>
                <td>Manual Order</td>
                <td>Pending</td>
                <td class="text-center">
                  <button class="btn btn-sm btn-danger">Cancel</button>
                </td>
              </tr>
              <tr>
                <td>EK1050IND</td>
                <td>
                  EK501IND
                </td>
                <td>
                  <div class="productTitle_t">
                    <a href="" class="a_link">Cushion covers</a>
                  </div>
                </td>
                <td>Junaid Khan</td>
                <td>5</td>
                <td>
                  <div>30 June 2014 18:36</div>
                </td>
                <td>
                  <div class="sell_t"><i class="fas fa-rupee-sign"></i> 1000</div>
                </td>
                <td>Dropship</td>
                <td>Manual Order</td>
                <td>Pending</td>
                <td class="text-center">
                  <button class="btn btn-sm btn-danger">Cancel</button>
                </td>
              </tr>
              <tr>
                <td>EK1050IND</td>
                <td>
                  EK501IND
                </td>
                <td>
                  <div class="productTitle_t">
                    <a href="" class="a_link">Cushion covers</a>
                  </div>
                </td>
                <td>Junaid Khan</td>
                <td>5</td>
                <td>
                  <div>30 June 2014 18:36</div>
                </td>
                <td>
                  <div class="sell_t"><i class="fas fa-rupee-sign"></i> 1000</div>
                </td>
                <td>Dropship</td>
                <td>Manual Order</td>
                <td>Pending</td>
                <td class="text-center">
                  <button class="btn btn-sm btn-danger">Cancel</button>
                </td>
              </tr>
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
              <option value="50">50</option>
              <option selected value="100">100</option>
              <option value="200">200</option>
            </select>
          </div>
        </div>
        <!-- end pegination -->
      </div>
    @endif
    <!-- supplier orders -->
    @if(auth()->user()->hasRole(ROLE_SUPPLIER))
      <div class="card ekcard pa shadow-sm">
        <div class="cardhead">
          <h3 class="cardtitle">Supplier Orders</h3>
          <!-- <a href="create-order.html" class="btn btnekomn btn-sm"><i class="fas fa-plus fs-12 me-1"></i>Create New Order</a> -->
        </div>
        <div class="tableTop mt10">
          <input type="text" title="Search with eKomn Order, Store Order or Customer name" class="form-control w_300_f searchicon" placeholder="Search">
          <div class="d-flex gap-2">
            <div class="ek_group m-0">
              <label class="eklabel eklabel_60 m-0">Status:</label>
              <div class="ek_f_input">
                <select class="form-select w_150_f">
                  <option value="Pending" selected>Pending</option>
                  <option value="In Progress">In Progress</option>
                  <option value="Dispatched">Dispatched</option>
                  <option value="Delivered">Delivered</option>
                  <option value="Delivered">Cancelled</option>
                </select>
              </div>
            </div>
            <button class="btn btn-sm btnekomn_dark"><i class="fas fa-file-csv me-2"></i>Export CSV</button>
          </div>
        </div>
        <div class="table-responsive tres_border"> 
          <table class="normalTable tableSorting whitespace">
            <thead>
              <tr>
                <th>eKomn Order</th>
                <th>Product Title
                  <span class="sort_pos">
                    <small class="sort_t"><i class="fas fa-caret-up"></i><i class="fas fa-caret-down"></i></small>
                  </span>
                </th>
                <th>Customer Name</th>
                <th>Qty
                  <span class="sort_pos">
                    <small class="sort_t"><i class="fas fa-caret-up"></i><i class="fas fa-caret-down"></i></small>
                  </span>
                </th>
                <th>Date
                  <span class="sort_pos">
                    <small class="sort_t"><i class="fas fa-caret-up"></i><i class="fas fa-caret-down"></i></small>
                  </span>
                </th>
                <th>Total Amt
                  <span class="sort_pos">
                    <small class="sort_t"><i class="fas fa-caret-up"></i><i class="fas fa-caret-down"></i></small>
                  </span>
                </th>
                <th>Category
                  <span class="sort_pos">
                    <small class="sort_t"><i class="fas fa-caret-up"></i><i class="fas fa-caret-down"></i></small>
                  </span>
                </th>
                <th>Status
                  <span class="sort_pos">
                    <small class="sort_t"><i class="fas fa-caret-up"></i><i class="fas fa-caret-down"></i></small>
                  </span>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <div class="form-check">
                    <input type="checkbox" id="EK1050IND" class="form-check-input">
                    <label for="EK1050IND" class="ms-1">EK1048IND</label>
                  </div>
                </td>
                <td>
                  <div class="productTitle_t">
                   <a href="{{route('view.order')}}"  class="a_link">Cushion covers</a>
                  </div>
                </td>
                <td>Junaid Khan</td>
                <td>5</td>
                <td>
                  <div>30 June 2014 18:36</div>
                </td>
                <td>
                  <div class="sell_t"><i class="fas fa-rupee-sign"></i> 1000</div>
                </td>
                <td>Dropship</td>
                <td>Pending</td>
              </tr>
              <tr>
                <td>
                  <div class="form-check">
                    <input type="checkbox" id="EK1051IND" class="form-check-input">
                    <label for="EK1051IND" class="ms-1">EK1050IND</label>
                  </div>
                </td>
                <td>
                  <div class="productTitle_t">
                    <a href="view-order-supplier.html" class="a_link">Dell WM126 Wireless Mouse</a>
                  </div>
                </td>
                <td>Mohd Imtyaj</td>
                <td>25</td>
                <td>
                  <div>30 June 2014 23:30</div>
                </td>
                <td>
                  <div class="sell_t"><i class="fas fa-rupee-sign"></i> 5000</div>
                </td>
                <td>Bulk Order</td>
                <td>In Progress</td>
              </tr>
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
              <option value="50">50</option>
              <option selected value="100">100</option>
              <option value="200">200</option>
            </select>
          </div>
        </div>
        <!-- end pegination -->
      </div>
    @endif
      <!-- admin orders -->

 @if(auth()->user()->hasRole(ROLE_ADMIN))
      <div class="card ekcard pa shadow-sm">
        <div class="cardhead">
          <h3 class="cardtitle">Admin Orders</h3>
          <a href="{{route('create.order')}}" class="btn btnekomn btn-sm"><i class="fas fa-plus fs-12 me-1"></i>Create New Order</a>
        </div>
        <div class="tableTop mt10">
          <input type="text" title="Search with eKomn Order, Store Order or Customer name" class="form-control w_300_f searchicon" placeholder="Search">
          <div class="d-flex gap-2">
            <div class="ek_group m-0">
              <label class="eklabel eklabel_60 m-0">Status:</label>
              <div class="ek_f_input">
                <select class="form-select w_150_f">
                  <option value="Pending" selected>Pending</option>
                  <option value="In Progress">In Progress</option>
                  <option value="Dispatched">Dispatched</option>
                  <option value="Delivered">Delivered</option>
                  <option value="Delivered">Cancelled</option>
                </select>
              </div>
            </div>
            <button class="btn btn-sm btnekomn_dark"><i class="fas fa-file-csv me-2"></i>Export CSV</button>
          </div>
        </div>
        <div class="table-responsive tres_border"> 
          <table class="normalTable tableSorting whitespace">
            <thead>
              <tr>
                <th>eKomn Order</th>
                <th>Store Order</th>
                <th>Product Title
                  <span class="sort_pos">
                    <small class="sort_t"><i class="fas fa-caret-up"></i><i class="fas fa-caret-down"></i></small>
                  </span>
                </th>
                <th>Customer Name</th>
                <th>Supplier ID</th>
                <th>B Buyer ID</th>
                <th>Qty
                  <span class="sort_pos">
                    <small class="sort_t"><i class="fas fa-caret-up"></i><i class="fas fa-caret-down"></i></small>
                  </span>
                </th>
                <th>Date
                  <span class="sort_pos">
                    <small class="sort_t"><i class="fas fa-caret-up"></i><i class="fas fa-caret-down"></i></small>
                  </span>
                </th>
                <th>Total Amt.
                  <span class="sort_pos">
                    <small class="sort_t"><i class="fas fa-caret-up"></i><i class="fas fa-caret-down"></i></small>
                  </span>
                </th>
                <th>Category</th>
                <th>Type
                  <span class="sort_pos">
                    <small class="sort_t"><i class="fas fa-caret-up"></i><i class="fas fa-caret-down"></i></small>
                  </span>
                </th>
                <th>Status</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <div class="form-check">
                    <input type="checkbox" id="EK1048IND" class="form-check-input">
                    <label for="EK1048IND" class="ms-1">EK1048IND</label>
                  </div>
                </td>
                <td>
                  EK501IND
                </td>
                <td>
                  <div class="productTitle_t">
                    <a href="{{route('view.order')}}"  class="a_link">Cushion covers</a>
                  </div>
                </td>
                <td>Junaid Khan</td>
                <td>EK501IND</td>
                <td>EK501IND</td>
                <td>5</td>
                <td>
                  <div>30 June 2014 18:36</div>
                </td>
                <td>
                  <div class="sell_t"><i class="fas fa-rupee-sign"></i> 1000</div>
                </td>
                <td>Dropship</td>
                <td>Manual Order</td>
                <td>Pending</td>
                <td class="text-center">
                  <button class="btn btn-sm btn-danger">Cancel</button>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="form-check">
                    <input type="checkbox" id="EK1050IND" class="form-check-input">
                    <label for="EK1050IND" class="ms-1">EK1050IND</label>
                  </div>
                </td>
                <td>
                  EK501IND
                </td>
                <td>
                  <div class="productTitle_t">
                    <a href="view-order-admin.html" class="a_link">Dell WM126 Wireless Mouse</a>
                  </div>
                </td>
                <td>Mohd Imtyaj</td>
                <td>EK501IND</td>
                <td>EK501IND</td>
                <td>25</td>
                <td>
                  <div>30 June 2014 23:30</div>
                </td>
                <td>
                  <div class="sell_t"><i class="fas fa-rupee-sign"></i> 5000</div>
                </td>
                <td>Bulk Order</td>
                <td>Store Order</td>
                <td>In Progress</td>
                <td class="text-center" title="Order can be cancelled only in 'Pending' Status">
                  <button class="btn btn-sm btn-danger" disabled>Cancel</button>
                </td>
              </tr>
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
              <option value="50">50</option>
              <option selected value="100">100</option>
              <option value="200">200</option>
            </select>
          </div>
        </div>
        <!-- end pegination -->
      </div>
    
@endif
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
    // if API use then comment this part and enable the commented part
    let currentPage = 1;
    let rows = parseInt(rowsPerPage.value, 10);
    let totalRows = 80;
    const staticData = Array.from({ length: totalRows }, (_, i) => ({ id: i + 1, name: `Item ${i + 1}` }));
    function fetchData() {
      const start = (currentPage - 1) * rows;
      const end = start + rows;
      const data = staticData.slice(start, end);
      updatePagination();
      displayData(data);
    }
    // let currentPage = 1;
    // let rows = parseInt(rowsPerPage.value, 10);
    // let totalRows = 0;
    // function fetchData() {
    //   fetch(`https://api.example.com/data?limit=${rows}&page=${currentPage}`)
    //   .then(response => response.json())
    //   .then(data => {
    //     totalRows = data.total;
    //     updatePagination();
    //     displayData(data.items);
    //   })
    //   .catch(error => console.error('Error fetching data:', error));
    // }
    // end
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
    function updateRowInfo() {
      const startRow = (currentPage - 1) * rows + 1;
      const endRow = Math.min(currentPage * rows, totalRows);
      rowInfo.textContent = `Showing ${startRow} to ${endRow} of ${totalRows}`;
    }
    function displayData(items) {
      dataContainer.innerHTML = items.map((item) => `<div>${item.name}</div>`).join("");
    }
    rowsPerPage.addEventListener("change", (e) => {
      rows = parseInt(e.target.value, 10);
      currentPage = 1;
      fetchData();
    });
    pagination.addEventListener("click", (e) => {
      if (e.target.tagName === "A") {
        currentPage = parseInt(e.target.dataset.page, 10);
        fetchData();
      }
    });
    prevPage.addEventListener("click", () => {
      if (currentPage > 1) {
        currentPage--;
        fetchData();
      }
    });
    nextPage.addEventListener("click", () => {
      const totalPages = Math.ceil(totalRows / rows);
      if (currentPage < totalPages) {
        currentPage++;
        fetchData();
      }
    });
    fetchData();
  });
</script>

@endsection