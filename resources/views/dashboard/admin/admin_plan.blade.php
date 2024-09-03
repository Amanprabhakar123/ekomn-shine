@extends('dashboard.layout.app')

@section('content')
    <div class="ek_dashboard">
        <div class="ek_content">
            <div class="card ekcard pa shadow-sm">
                <div class="cardhead">
                    <h3 class="cardtitle">Admin plans</h3>
                </div>

        
                <div class="table-responsive tres_border mt-5">

                <table class="normalTable tableSorting whitespace">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>GST</th>
                            <th>HSN</th>
                            <th>Duration</th>
                            <th>Features</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!--  Data display here Dynamic -->
                    </tbody>
                </table>
                </div>
            </div>

        </div>
        @include('dashboard.layout.copyright')
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {

            ApiRequest('plans-list', 'GET')
                .then((res) => {
                    // console.log(res);
                    if (res.data.statusCode == 200) {
                        let data = res.data.data;
                        if(data.length == 0){
                            $('tbody').append(`
                                <tr>
                                    <td colspan="3" class="text-center">No data found</td>
                                </tr>
                            `);
                        }
                        data.forEach((item) => {
                            // const productTitles = item.product.map(p => `<li><a href="${p.slug}" class="text_u">${p.title.trim()}</a></li><br>`).join('');
                            $('tbody').append(`
                                <tr>
                                    <td>${item.name}</td>
                                    <td>${item.description}</td>
                                    <td>${item.price}</td>
                                    <td>${item.gst}</td>
                                    <td>${item.hsn}</td>
                                    <td>${item.duration}</td>
                                    <td>
                                    <div class="productTitle_t">${item.features}</div>
                                    </td>
                                    <td>${item.status}</td>
                                    <td>
                                        <a href="/edit-admin-plan/${item.id}" class="btn btn-primary">Edit</a>
                                    </td>
                                  
                            `);
                        });
                    }
                })
                .catch((err) => {
                    console.log(err);
                });
            });
                function deleteProduct(id){
                    var formData = new FormData();
                    formData.append('id', id);

                    // First, show the confirmation dialog
                    Swal.fire({
                        title: "Do you want to delete?",
                        text: "You won't be able to revert this!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, delete it!",
                        customClass: {
                            confirmButton: 'swal2-confirm-btn',
                            cancelButton: 'swal2-cancel-btn'
                        },
                        didOpen: () => {
                            const title = Swal.getTitle();
                            title.style.fontSize = '25px';
                            const confirmButton = Swal.getConfirmButton();
                            confirmButton.style.backgroundColor = '#feca40';
                            confirmButton.style.color = 'white';
                        }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Send the delete request only after confirmation
                                ApiRequest('delete-top-product', 'POST', formData)
                                    .then((res) => {
                                        if (res.data.statusCode == 200) {
                                            Swal.fire({
                                                title: "Deleted!",
                                                text: "Your file has been deleted.",
                                                icon: "success",
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
                                            }).then(() => {
                                                window.location.href = '/top-product';
                                            });
                                        }
                                    })
                                    .catch(error => {
                                        console.error(error);
                                        Swal.fire({
                                            title: "Error!",
                                            text: "There was an error deleting the item.",
                                            icon: "error"
                                        });
                                    });
                            }
                        });
                }

       
    </script>
@endsection
