@extends('dashboard.layout.app')

@section('content')
<div class="ek_dashboard">
<div class="ek_content">
        <div class="card ekcard pa shadow-sm">
            <div class="cardhead">
                <h3 class="cardtitle">Order Tracking</h3>
            </div>
    <form action="#" id="formData">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="courier_name">Courier Name</label>
                        <input type="text" class="form-control" id="courier_name" name="courier_name" placeholder="Enter Courier Name">
                        <div id="courierErr" class="invalid-feedback"> </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="traicking">Tracking URL.</label>
                        <input type="text" class="form-control" id="tracking" name="tracking" placeholder="Enter Tracking URL.">
                        <div id="trackingErr" class="invalid-feedback">
                        </div>
                    </div>
                </div>
               
                 </div>
                 <button type="submit" class="btn btnekomn">Submit</button>
            </div>
    </form>
        </div>
    </div>
    @include('dashboard.layout.copyright')
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        var formData = new FormData();
        isvalid = true;
        $('#formData').submit(function(e) {
            e.preventDefault();

            if ($('#courier_name').val() == '') {
                $('#courier_name').addClass('is-invalid');
                $('#courierErr').text('Please enter courier name');
                isvalid = false;
            } else {
                $('#courier_name').removeClass('is-invalid');
                $('#courierErr').text('');
                isvalid = true;
            }

            if ($('#tracking').val() == '') {
                $('#tracking').addClass('is-invalid');
                $('#trackingErr').text('Please enter tracking url');
                isvalid = false;
            } else {
                $('#tracking').removeClass('is-invalid');
                $('#trackingErr').text('');
                isvalid = true;
            }

            formData.append('courier_name', $('#courier_name').val());
            formData.append('tracking_url', $('#tracking').val());

            ApiRequest('courier-detail', 'POST', formData)
                .then(response => {
                    console.log(response);
                    if (response.data.statusCode == 200) {
                        Swal.fire({
                            title: 'Success',
                            text: 'Courier Details Added Successfully',
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
                    }
                })
                .catch(error => {
                    console.error(error);
                });

        });
    });
</script>
@endsection