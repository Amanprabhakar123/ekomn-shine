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
                        <tbody>
                            <tr>
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
                            </tr>
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