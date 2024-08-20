@extends('dashboard.layout.app')

@section('content')
<div class="ek_dashboard">
    <div class="ek_content">
        <div class="card ekcard pa shadow-sm">
            <div class="cardhead">
                <h3 class="cardtitle">Courier List</h3>
            </div>
            <div class="table-responsive tres_border">
            <div class="tableTop mt10">
                        <input type="text" id="searchQuery" title="Search with eKomn Order, Store Order or Customer name"
                            class="form-control w_300_f searchicon" placeholder="Search">
                        <div class="ek_group m-0">
                            <label class="eklabel eklabel_60 m-0">Status:</label>
                            <div class="ek_f_input">
                                <select id="sort_by_status" class="form-select w_150_f">
                                    <option value="0" selected>Select</option>
                                    <option value="1">Draft</option>
                                    <option value="2">Pending</option>
                                    <option value="3">In Progress</option>
                                    <option value="4">Dispatched</option>
                                    <option value="6">Delivered</option>
                                    <option value="7">Cancelled</option>
                                </select>
                            </div>

                        </div>

                    </div>

                <table class="normalTable tableSorting whitespace">
                    <thead>
                        <tr>
                            <th>Sr. No.</th>
                            <th>Ekomn Order</th>
                            <th>Order Type</th>
                            <th>Return Req #</th>
                            <th>Product Title</th>
                            <th>Qty</th>
                            <th>Return date</th>
                            <th>Return reason</th>
                            <th>Order amount</th>
                            <th>Return status</th>
                            <th>Dispute</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <tr>
                           
                        </tr>
                     
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('dashboard.layout.copyright')
</div>
@endsection