@extends('dashboard.layout.app')

@section('content')
@section('title')
Shine
@endsection
<div class="ek_dashboard">
    <div class="ek_content">
        <div class="card ekcard pa shadow-sm">
            <div class="cardhead">
                <h3 class="cardtitle">Shine</h3>
                <a class="btn btnekomn btn-sm" href="#"><i class="fas fa-plus fs-12 me-1"></i> New Request</a>
            </div>
            <div class="tableTop pt-3">
              <input type="text" class="form-control w_300_f searchicon"
                placeholder="Search with Batch ID, Requestor ID, Asssigner ID" id="searchInput">
              <div class="filter">
                <div class="ek_group m-0">
                  <label class="eklabel w_50_f">Sort by:</label>
                  <div class="ek_f_input">
                    <select class="form-select" id="sort_by_status">
                      <option value="NA" selected>Select</option>
                      <option value="0">Draft</option>
                      <option value="1">Pending</option>
                      <option value="2">Inprogress</option>
                      <option value="3">Order Placed</option>
                      <option value="4">Order Confirm</option>
                      <option value="5">Review Submited</option>
                      <option value="6">Complete</option>
                      <option value="7">Cancelled</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="table-responsive tres_border">
                <table class="normalTable tableSorting whitespace">
                    <thead>
                        <tr>
                            <th>Batch ID
                              <span class="sort_pos">
                                  <small class="sort_t"><i class="fas fa-caret-up"></i><i class="fas fa-caret-down"></i></small>
                              </span>
                            </th>
                            <th>Requestor ID
                              <span class="sort_pos">
                                  <small class="sort_t"><i class="fas fa-caret-up"></i><i class="fas fa-caret-down"></i></small>
                              </span>
                            </th>
                            <th>Date</th>
                            <th>Batch Value</th>
                            <th>Pending</th>
                            <th>Inprogress</th>
                            <th>Complete</th>
                            <th>Cancelled</th>
                            <th>Batch Status</th>
                        </tr>
                    </thead>
                    <tbody id="dataContainer">
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
                        <option value="5">5</option>
                        <option selected value="10">10</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="200">200</option>
                    </select>
                </div>
            </div>
            <!-- end pegination -->
        </div>
    </div>
    @include('dashboard.layout.copyright')
</div>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Fetch the shine products data when the page loads
    fetchShineProducts();

    function fetchShineProducts() {
        $.ajax({
            url: "{{ route('fetch.shine.products') }}",
            method: 'GET',
            success: function(data) {
                let rows = '';
                const seenBatchIds = new Set();
                const batchAmounts = {};
                const batchInprogressTotals = {};
                const batchPending = {}; // To store the combined inprogress totals
                const batchComplete = {};
                const batchCancelled = {};

                // Sort data by created_at in descending order
                data.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));

                // Calculate total amount and inprogress_total for each batch_id
                data.forEach(product => {
                    if (!batchAmounts[product.batch_id]) {
                        batchAmounts[product.batch_id] = 0;
                        batchInprogressTotals[product.batch_id] = 0; // Initialize inprogress total
                        batchPending[product.batch_id] = 0;
                        batchComplete[product.batch_id] = 0;
                        batchCancelled[product.batch_id] = 0;
                    }
                    batchAmounts[product.batch_id] += parseFloat(product.amount);
                    batchInprogressTotals[product.batch_id] += parseFloat(product.inprogress_total); // Accumulate inprogress total
                    batchPending[product.batch_id] += parseFloat(product.pending);
                    batchComplete[product.batch_id] += parseFloat(product.complete);
                    batchCancelled[product.batch_id] += parseFloat(product.cancelled);
                });

                // Generate table rows using aggregated data
                data.forEach(product => {
                    if (!seenBatchIds.has(product.batch_id)) {
                        seenBatchIds.add(product.batch_id);

                        // Format created_at
                        const createdAt = new Date(product.created_at);
                        const formattedDate = `${createdAt.getFullYear()}-${String(createdAt.getMonth() + 1).padStart(2, '0')}-${String(createdAt.getDate()).padStart(2, '0')} ${String(createdAt.getHours()).padStart(2, '0')}:${String(createdAt.getMinutes()).padStart(2, '0')}:${String(createdAt.getSeconds()).padStart(2, '0')}`;

                        // Determine the overall status label and style
                        let overallStatus = '';
                        if (product.overall_status === 'Pending') {
                            overallStatus = "<span style='padding: 3px 7px; border-radius: 3px; background-color: #ffc107; color: #000;'>Pending</span>";
                        } else if (product.overall_status === 'Inprogress') {
                            overallStatus = "<span style='padding: 3px 7px; border-radius: 3px; background-color: #17a2b8; color: #fff;'>Inprogress</span>";
                        }
                        
                        rows += `<tr>
                            <td><a href="/shine-batch-details/${product.batch_id}" class="target-blank">${product.batch_id}</a></td>
                            <td>${product.user_id}</td>
                            <td>${formattedDate}</td>
                            <td>${batchAmounts[product.batch_id]}</td>
                            <td>${batchPending[product.batch_id] || 0}</td>
                            <td>${batchInprogressTotals[product.batch_id] || 0}</td>
                            <td>${batchComplete[product.batch_id] || 0}</td>
                            <td>${batchCancelled[product.batch_id] || 0}</td>
                            <td>${overallStatus}</td>
                        </tr>`;
                    }
                });

                $('#dataContainer').html(rows);
                updateRowInfo(seenBatchIds.size);
            },
            error: function(error) {
                Swal.fire('Error', 'Unable to fetch data.', 'error');
            }
        });
    }

    function updateRowInfo(count) {
        $('#rowInfo').text(`Showing ${count} rows`);
    }
});

</script>

@endsection