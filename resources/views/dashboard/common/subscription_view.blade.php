@extends('dashboard.layout.app')

@section('content')
<div class="ek_dashboard">
    <div class="ek_content">
        <div class="card ekcard pa shadow-sm">
            <div class="cardhead">
                <h3 class="cardtitle">Subscription View</h3>
            </div>
            <div class="row">
                <div class="col-12">
                    <table class="detail_s_t">
                        <thead>
                            <tr>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Free Trial - 14 days</td>
                                <td>INR 0.00</td>
                                <td>Start Date</td>
                                <td>End Date</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <div class="col-md-6 mt-5">
                    <div class="">
                        <div class="bulkBuing">
                            <label class="fs-14 bold">Bulk Buying Rates:</label>
                            <table class="detail_s_t">
                                <thead>
                                    <tr>

                                </thead>
                                <tbody>
                                    <tr>
                                        <td>My Inventory List Limit - Used</td>
                                        <td>30</td>
                                    </tr>
                                    <tr>
                                        <td>My Inventory List Limit - Used</td>
                                        <td>30</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="saveform_footer text-right single-button">
                <button id="btnSubmit" class="btn btnekomn">Download</button>
            </div>
        </div>
    </div>
    @include('dashboard.layout.copyright')
</div>
@endsection
