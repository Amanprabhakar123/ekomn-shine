@extends('dashboard.layout.app')
@section('content')
<div class="ek_dashboard">
    <div class="ek_content">
        <div class="card ekcard pa shadow-sm">
            <div class="cardhead">
                <h3 class="cardtitle">Banners</h3>
            </div>
            <div class="row">
                    <div class="col-md-4">
                        <div class="ek_f_input">
                            <label for="category">Title</label>
                            <input type="text" class="form-control" id="title" value="">
                            <div id="titleErr" class="invalid-feedback"></div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="ek_f_input">
                            <label for="category">Banner Type</label>
                            <select class="form-select" id="bannertype" value="">
                                <option value="" selected>Select banner type</option>
                                @foreach($type as $key => $type)
                                <option value="{{$key}}">{{$type}}</option>
                                @endforeach
                                
                            </select>
                            <div id="bannerTypeErr" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="profilesectionRight mt-3">
                    <label>Uplaod Banner image<span class="r_color">*</span></label>
                    <label class="picture" style="height:250px;" for="banner" tabIndex="0">
                        <span class="" style="">
                            <!-- Uplaod banner image here -->
                            <img id="bannerImage" src="" alt="Banner Image" style="display: none; max-width: 100%;"/>
                        </span>
                    </label>
                    <input type="file" name="banner" id="banner" accept="image/jpeg, image/png, image/jpg image/webp" style="display: none;">
                    <div id="bannerErr" class="invalid-feedback"></div>
                    <button id="deleteBanner" class="" style="display: none; border:none;">Delete</button>
                </div>
                </div>

                <div class="saveform_footer text-right single-button">
                    <button type="button" id="btnSubmit" class="btn btn-login btnekomn card_f_btn"
                        id="generaltab">Submit</button>
                </div>

                <table class="normalTable tableSorting whitespace mt-5">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Banner Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!--  Data display here Dynamic -->
                    </tbody>
                </table>

        </div>
    </div>
    @include('dashboard.layout.copyright')
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
     
    document.addEventListener('DOMContentLoaded', function() {
    const bannerInput = document.getElementById('banner');
    const bannerImage = document.getElementById('bannerImage');
    const deleteButton = document.getElementById('deleteBanner');

    // Handle file input change
    bannerInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                bannerImage.src = e.target.result;
                bannerImage.style.display = 'block';
                deleteButton.style.display = 'block';
            };
            
            reader.readAsDataURL(file);
        }
    });

    // Handle delete button click
    deleteButton.addEventListener('click', function() {
        bannerImage.src = '';
        bannerImage.style.display = 'none';
        deleteButton.style.display = 'none';
        bannerInput.value = ''; // Clear the file input
    });
});

    $(document).ready(function() {
        $('#btnSubmit').click(function() {

            var isValid = true;
            if ($('#title').val() ) {
                $('#title').removeClass('is-invalid');
                $('#titleErr').text('');
            } else {
                $('#title').addClass('is-invalid');
                $('#titleErr').text('Title is required');
                isValid = false;
            }

            if ($('#bannertype').val() ) {
                $('#bannertype').removeClass('is-invalid');
                $('#bannerTypeErr').text('');
            } else {
                $('#bannertype').addClass('is-invalid');
                $('#bannerTypeErr').text('Banner type is required');
                isValid = false;
            }

            if ($('#banner')[0].files[0]) {
                $('#banner').removeClass('is-invalid');
                $('#bannerErr').text('');
            } else {
                $('#banner').addClass('is-invalid');
                $('#bannerErr').text('Banner is required');
                isValid = false;
            }



            if (isValid) {
                
            

            var title = $('#title').val();
            var bannertype = $('#bannertype').val();
            var banner = $('#banner')[0].files[0];
            console.log(banner);
            var formData = new FormData();
            formData.append('title', title);
            formData.append('banner_type', bannertype);
            formData.append('banner', banner);
            
            ApiRequest('store-banner', 'POST', formData)
                .then(res => {
                    console.log(res);
                    if (res.data.statusCode == 200) {
                            // Redirect to the inventory index page
                            Swal.fire({
                                    title: 'Success',
                                    icon: "success",
                                    text: res.data.message,
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
                                    window.location.href = '/banner';
                                });
        
                    } else {
                        Swal.fire({
                                    title: 'Error',
                                    icon: "error",
                                    text: res.data.message,
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
                })
                .catch(err => {
                    console.log(err);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong',
                    });
                });
            }
               

            
        });
    });

        ApiRequest('get-banner', 'GET')
            .then(res => {
                if (res.data.statusCode == 200) {
                    var html = '';
                    if(res.data.data.length == 0){
                        html +=`
                                <tr>
                                    <td colspan="4" class="text-center">No data found</td>
                                </tr>
                        `;
                        }
                    res.data.data.forEach(element => {
                        html += `<tr>
                            <td>${element.title}</td>
                            <td>${element.banner_type}</td>
                            <td>
                                <button class="btn btn-danger btn-sm" onclick="deleteBanner('${element.id}')">Delete</button>
                            </td>
                        </tr>`;
                    });
                    $('table tbody').html(html);
                } 
            })
            .catch(err => {
                console.log(err);
              
            });

          function deleteBanner(id) {
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
                                ApiRequest('delete-banner', 'POST', formData)
                                    .then((res) => {
                                        if (res.data.statusCode == 200) {
                                            Swal.fire({
                                                title: "Deleted!",
                                                text: "Your banner has been deleted.",
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
                                                window.location.href = '/banner';
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