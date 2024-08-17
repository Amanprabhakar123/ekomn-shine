@extends('dashboard.layout.app')

@section('content')
    <div class="ek_dashboard">
        <div class="ek_content">
            <div class="card ekcard pa shadow-sm">
                <div class="cardhead">
                    <h3 class="cardtitle">Mis Setting Inventory</h3>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <button type="button" class="btn btn-login btnekomn" onclick="exportMisReport('in_demand')">Product In
                            Demand - Export</button>

                    </div>
                    <div class="col-md-4">
                        <button type="button" class="btn btn-login btnekomn"
                            onclick="exportMisReport('product_master')">Product Master - Export</button>

                    </div>
                    <div class="col-md-4">
                        <button type="button" class="btn btn-login btnekomn"
                            onclick="exportMisReport('product_events')">Product Events - Export</button>

                    </div>
                    <div class="col-md-4 mt-5">
                        <button type="button" class="btn btn-login btnekomn"
                            onclick="exportMisReport('product_inventory_price')">Product Price History - Export</button>

                    </div>
                    <div class="col-md-4 mt-5">
                        <button type="button" class="btn btn-login btnekomn"
                            onclick="exportMisReport('product_inventory_stock')">Product Stock History - Export</button>

                    </div>
                    <div class="col-md-4 mt-5">
                        <button type="button" class="btn btn-login btnekomn"
                            onclick="exportMisReport('product_inventory_growth')">Product Growth History - Export</button>

                    </div>

                </div>
            </div>
        </div>

        @include('dashboard.layout.copyright')
    </div>
    @include('dashboard.layout.MisScript')
@endsection
