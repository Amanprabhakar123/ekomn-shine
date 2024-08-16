@extends('dashboard.layout.app')

@section('content')
    <div class="ek_dashboard">
        <div class="ek_content">
            <div class="card ekcard pa shadow-sm">
                <div class="cardhead">
                    <h3 class="cardtitle">Mis Setting Order</h3>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <button type="button" class="btn btn-login btnekomn" onclick="exportMisReport('orders')">Orders -
                            Export</button>

                    </div>



                </div>
            </div>
        </div>

        @include('dashboard.layout.copyright')
    </div>
    @include('dashboard.layout.MisScript')
@endsection
