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
                            onclick="exportMisReport('out_of_stock')">Product Out of Stock - Export</button>

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

                </div>
            </div>
        </div>

        @include('dashboard.layout.copyright')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function exportMisReport(type) {
            ApiRequest(`mis-export-csv/${type}`, 'GET')
                .then(response => {
                    console.log(response);

                    if (response.data.statusCode == 200) {
                        Swal.fire({
                            title: "Good job!",
                            text: response.data.message,
                            icon: "success",
                            didOpen: () => {
                                // Apply inline CSS to the title
                                const title = Swal.getTitle();
                                title.style.color = 'red';
                                title.style.fontSize = '20px';

                                // Apply inline CSS to the content
                                const content = Swal.getHtmlContainer();
                                //   content.style.color = 'blue';

                                // Apply inline CSS to the confirm button
                                const confirmButton = Swal.getConfirmButton();
                                confirmButton.style.backgroundColor = '#feca40';
                                confirmButton.style.color = 'white';
                            }
                        }).then(() => {
                            // Redirect to the inventory page
                            window.location.href = "{{ route('mis.setting.inventory') }}";
                        })
                    }

                })
                .catch(error => {
                    console.error('Error updating stock:', error);
                });

        }
    </script>
@endsection
