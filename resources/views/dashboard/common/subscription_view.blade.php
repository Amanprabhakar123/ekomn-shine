@extends('dashboard.layout.app')

@section('content')
<div class="ek_dashboard">
    <div class="ek_content">
        <div class="card ekcard pa shadow-sm">
            <div class="cardhead">
                <h3 class="cardtitle">Subscription View</h3>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <table class="detail_s_t">
                        <thead>
                            <tr>
                                <th>Plan Name</th>
                                <th>Plan Price</th>
                                <th>Amount with GST</th>
                                <th>Subscription Start Date</th>
                                <th>Subscription End Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$companyDetail->subscription[0]->plan->name}}</td>
                                <td>{{$companyDetail->subscription[0]->plan->price}}</td>
                                <td>{{$companyDetail->companyPlanPayment->amount_with_gst}}</td>
                                <td>{{$companyDetail->subscription[0]->subscription_start_date->toDateString()}}</td>
                                <td>{{$companyDetail->subscription[0]->subscription_end_date->toDateString()}}</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="">
                        <div class="bulkBuing">
                            <label class="fs-14 bold">Bulk Buying Rates:</label>
                            <table class="detail_s_t width-100">
                                
                                <tbody>
                                    <tr>
                                        <td >My Inventory List Limit - Used</td>
                                        <td>{{$companyDetail->planSubscription->inventory_count}}</td>
                                    </tr>
                                    <tr>
                                        <td>Monthly Products Download Count</td>
                                        <td>{{$companyDetail->planSubscription->download_count}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

              

            </div>

            <div class="col-sm-12 col-md-4 mt-3">
                    <div class="ek_group">
                      <label class="eklabel req">
                        <span class="autodebitStatus fw-bold fs-6">Smart Pay:</span>
                      </label>
                      <div class="ek_f_input">
                      <div class="switch-container">
                            <label class="switch mt-2">
                                <input type="checkbox" id="autodebitToggle" onclick="toggleAutodebit()">
                                <span class="slider"></span>
                            </label>
                           <strong>AutoDebit: </strong> <span id="autodebitStatus"></span>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-sm-12 col-md-4 mt-3">
                    <div class="ek_group">
                      <label class="eklabel req">
                        <span class=" fw-bold fs-6">Smart Pay:</span>
                      </label>
                      <div class="ek_f_input">
                      <button id="btnSubmit" class="btn btn-danger">Cancel</button>
                      </div>
                    </div>
                  </div>
            
            <div class="saveform_footer text-right single-button">
                <button id="btnSubmit" class="btn btnekomn">Download Invoice</button>
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
        statusText.textContent = "Active";
        statusText.style.color = "green";
    } else {
        statusText.textContent = "Paused";
        statusText.style.color = "red";
    }
    
   
}
toggleAutodebit()

</script>
@endsection