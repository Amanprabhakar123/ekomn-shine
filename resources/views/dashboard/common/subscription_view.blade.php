@extends('dashboard.layout.app')

@section('content')
<div class="ek_dashboard">
    <div class="ek_content">
        <div class="card ekcard pa shadow-sm">
            <div class="cardhead">
                <h3 class="cardtitle">Subscription View</h3>
                <button class="btn btnekomn_dark stripbtn" onclick="collectCheckedIdsForCsv()"><i class="fas fa-file-pdf me-2"></i>Download Invoice</button>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <table class="detail_s_t">
                        <thead>
                            <tr>
                                <th>Plan Name</th>
                                <th>Plan Status</th>
                                <th>Plan Price</th>
                                <th>Paid Amount</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$companyDetail->subscription[0]->plan->name}}</td>
                                <td>{{getCompanyPlanStatus($companyDetail->subscription[0]->status)}}</td>
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
            @if(!is_null($companyDetail->razorpay_subscription_id))

            <div class="col-sm-12 col-md-4 mt-3">
                    <div class="ek_group">
                      <label class="eklabel req">
                        <span class="autodebitStatus fw-bold fs-6">Smart Pay:</span>
                      </label>
                      <div class="ek_f_input">
                      <div class="switch-container">
                            <label class="switch mt-2">
                                @if($companyDetail->isSubscriptionActive() )
                                <input type="checkbox" id="autodebitToggle" onclick="toggleAutodebit()" checked>
                                @elseif($companyDetail->isSubscriptionInActive())
                                <input type="checkbox" id="autodebitToggle" onclick="toggleAutodebit()">
                                @else
                                <input type="checkbox" id="autodebitToggle" disabled>
                                @endif
                                <span class="slider"></span>
                            </label>
                           <strong>AutoDebit: </strong> <span id="autodebitStatus"></span>
                        </div>
                      </div>
                    </div>
                  </div>
                  @endif

                  <div class="col-sm-12 col-md-4 mt-3">
                    <div class="ek_group">
                      <div class="ek_f_input">
                       <button id="btnSubmit" class="btn btn-login btnekomn card_f_btn payment_button">Renew/Upgrade</button>
                       @if($companyDetail->isSubscriptionActive() || $companyDetail->isSubscriptionInActive() || $companyDetail->isSubscriptionAuth() || $companyDetail->isSubscriptionPending())
                       <button id="cancelSmartPay" class="btn btn-danger">Cancel Smart Pay</button>
                       @else
                       @if($companyDetail->subscription[0]->isPlanActive())
                       <button id="enableSmartPay" class="btn btn-success" >Enable Smart Pay</button>
                       @else
                          <button id="enableSmartPay" class="btn btn-success" disabled>Enable Smart Pay</button>
                        @endif
                        @endif
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
    function toggleAutodebit() {
    var checkbox = document.getElementById("autodebitToggle");
    var statusText = document.getElementById("autodebitStatus");
    
    @if($companyDetail->isSubscriptionActive() || $companyDetail->isSubscriptionInActive())
    if (checkbox.checked) {
        statusText.textContent = "{{$companyDetail->subscriptionStatus()}}";
        statusText.style.color = "green";
    } else {
        statusText.textContent = "{{$companyDetail->subscriptionStatus()}}";
        statusText.style.color = "red";
    }
    @else
        checkbox.disabled = true;
        statusText.textContent = "{{$companyDetail->subscriptionStatus()}}";
        statusText.style.color = "#cccccc";
    @endif

}
toggleAutodebit()

$('#autodebitToggle').change(function() {
    let company_id = (`{{ salt_encrypt($companyDetail->id) }}`);
    ChangeStatus(company_id);
});

$('#cancelSmartPay').click(function() {
    let company_id = (`{{ salt_encrypt($companyDetail->id) }}`);
    // add sweet alert confirmation
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to cancel the Smart Pay!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Cancel it!',
        didOpen: () => {
            const title = Swal.getTitle();
            title.style.fontSize = '25px';
            // Apply inline CSS to the content
            const content = Swal.getHtmlContainer();
            // Apply inline CSS to the confirm button
            const confirmButton = Swal.getConfirmButton();
            confirmButton.style.backgroundColor = '#feca40';
            confirmButton.style.color = 'white';
        }
    }).then((result) => {
        if (result.isConfirmed) {
            ChangeStatus(company_id, true);
        }
    });
});

function ChangeStatus(company_id, is_cancel = false) {
    ApiRequest("change-subscription-status", 'POST', {
        company_id: company_id,
        is_cancel: is_cancel
    }).then(response => {
        if (response.data.statusCode == 200) {
            Swal.fire({
                title: 'Success',
                text: response.data.message,
                icon: 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK',
                didOpen: () => {
                    const title = Swal.getTitle();
                    title.style.fontSize = '25px';
                    // Apply inline CSS to the content
                    const content = Swal.getHtmlContainer();
                    // Apply inline CSS to the confirm button
                    const confirmButton = Swal.getConfirmButton();
                    confirmButton.style.backgroundColor = '#feca40';
                    confirmButton.style.color = 'white';
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.reload();
                }
            });
        }else{
            Swal.fire({
                title: 'Error',
                text: response.data.message,
                icon: 'error',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK',
                didOpen: () => {
                    const title = Swal.getTitle();
                    title.style.fontSize = '25px';
                    // Apply inline CSS to the content
                    const content = Swal.getHtmlContainer();
                    // Apply inline CSS to the confirm button
                    const confirmButton = Swal.getConfirmButton();
                    confirmButton.style.backgroundColor = '#feca40';
                    confirmButton.style.color = 'white';
                }
            });
        }
    });
}

$('#enableSmartPay').click(function() {
    let company_id = (`{{ salt_encrypt($companyDetail->id) }}`);
    ApiRequest("enable-subscription", 'POST', {
        company_id: company_id,
        plan_id: "{{salt_encrypt($companyDetail->subscription[0]->plan_id)}}",
        subscription_end_date: "{{$companyDetail->subscription[0]->subscription_end_date->toDateString()}}"
    }).then(response => {
        if (response.data.statusCode == 200) {
            window.open(response.data.payment_link, '_blank');
        }
    });
});
</script>
@endsection