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
                                <td>Paid Amount</td>
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

            <div class="col-sm-12 col-md-4 mt-5">
                    <div class="ek_group">
                      <label class="eklabel req">
                        <span class="autodebitStatus fw-bold fs-5">Smart Pay:</span>
                      </label>
                      <div class="ek_f_input">
                      <div class="switch-container">
                            <label class="switch">
                                <input type="checkbox" id="autodebitToggle" onclick="toggleAutodebit()">
                                <span class="slider"></span>
                            </label>
                            <span id="autodebitStatus">AutoDebit: Paused</span>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-sm-12 col-md-4 mt-3">
                    <div class="ek_group">
                      <label class="eklabel req">
                        <span class=" fw-bold fs-5">Smart Pay:</span>
                      </label>
                      <div class="ek_f_input">
                      <button id="btnSubmit" class="btn btn-danger">Cancel</button>
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
@section('scripts')
<script>
    function toggleAutodebit() {
    var checkbox = document.getElementById("autodebitToggle");
    var statusText = document.getElementById("autodebitStatus");
    
    if (checkbox.checked) {
        statusText.textContent = "AutoDebit: Active";
    } else {
        statusText.textContent = "AutoDebit: Paused";
    }
}

</script>
@endsection