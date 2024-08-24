@extends('dashboard.layout.app')

@section('content')
    <div class="ek_dashboard">
        <div class="ek_content">
            <div class="card ekcard pa shadow-sm">
                <div class="cardhead">
                    <h3 class="cardtitle">Mis Setting Supplier</h3>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <button type="button" class="btn btn-login btnekomn" onclick="exportMisReport('total_supplier')">Total
                            Supplier/Buyer
                            - Export</button>

                    </div>
                    <div class="col-md-4">
                        <button type="button" class="btn btn-login btnekomn"
                            onclick="exportMisReport('total_active_buyer')">Total Active Buyer Subscription
                            - Export</button>

                    </div>
                    <div class="col-md-4">
                        <button type="button" class="btn btn-login btnekomn"
                            onclick="exportMisReport('supplier_login_history')">Supplier/Buyer Login History
                            - Export</button>

                    </div>



                </div>
            </div>
        </div>

        @include('dashboard.layout.copyright')
    </div>
    @include('dashboard.layout.MisScript')
@endsection
