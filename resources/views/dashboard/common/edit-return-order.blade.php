@extends('dashboard.layout.app')

@section('content')
<div class="ek_dashboard">
    <div class="ek_content">
        <div class="ek_content">
            <div class="card ekcard pa shadow-sm">
                <div class="cardhead d-flex justify-content-between align-items-center">
                    <h3 class="cardtitle">Return Order</h3>
                    <div class="text-end">
                        <h4 class="subheading">Last Update - Activity/Order Tracking</h4>
                        <span class="fs-15">2024-08-16 - (2 days ago)</span>
                    </div>
                </div>
                <section class="">
                    <div class="row">
                        <div class="col-sm-12 col-md-3">
                           
                                <label class="bold">
                                    Return Request:
                                </label>
                                <div class="ek_f_input">
                                    <input type="text" class="form-control" value="EK1050IND" id="full_name" disabled />
                                    <div id="full_nameErr" class="invalid-feedback"></div>
                                </div>
                            
                        </div>
                        <div class="col-sm-12 col-md-3">
                            
                                <label class="bold">
                                    <span>Order No:<span class="req_star">*</span></span>
                                </label>
                                <div class="ek_f_input">
                                    <input type="text" class="form-control" value="EK1050IND" id="full_name" disabled />
                                    <div id="full_nameErr" class="invalid-feedback"></div>
                                </div>
                            
                        </div>
                        <div class="col-sm-12 col-md-3">
                            
                                <label class="bold">Courier Name:<span class="r_color">*</span></label>
                                <div class="ek_f_input">
                                    <select class="form-select" id="reason">
                                        <option value="0" selected> Select Reason </option>
                                        <option value="1">
                                            Product Not Delivered </option>
                                        <option value="2"> Defective Product </option>
                                        <option value="3"> Incorrect Quantity Delivered </option>
                                        <option value="4"> Wrong product Delivered </option>
                                        <option value="5"> Other </option>

                                    </select>
                                    <div id="reasonErr" class="invalid-feedback"></div>
                                </div>
                            
                        </div>
                        <div class="col-sm-12 col-md-3">
                            
                                <label class="bold">
                                    <span>Tracking Number:<span class="req_star">*</span></span>
                                </label>
                                <div class="ek_f_input">
                                    <input type="text" class="form-control" value="EK1050IND" id="full_name" disabled />
                                    <div id="full_nameErr" class="invalid-feedback"></div>
                                </div>
                            
                        </div>
                    </div>
                    <div class="row mt-5">
                        
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-4">
                            <div class="ek_group">
                                <label class="eklabel req">Order:<span class="r_color">*</span></label>
                                <div class="ek_f_input">
                                    <select class="form-select" id="reason">
                                        <option value="0" selected> Select Reason </option>
                                        <option value="1">
                                            Product Not Delivered </option>
                                        <option value="2"> Defective Product </option>
                                        <option value="3"> Incorrect Quantity Delivered </option>
                                        <option value="4"> Wrong product Delivered </option>
                                        <option value="5"> Other </option>

                                    </select>
                                    <div id="reasonErr" class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4" id="other" style="display: none;">
                            <input type="text" class="form-control" value="" placeholder="Write your reason......" id="otherReason" />
                            <div id="otherReasonErr" class="invalid-feedback"></div>
                        </div>
                    </div>
                </section>
                <div class="multi-row">Attachement:<span class="req_star">*</span>
                    <div class="image-upload-box" id="box1-2" onclick="triggerUpload('box1-2')">
                        <input type="file" accept="image/*" onchange="previewImage(event, 'box1-2')" />
                        <img id="img-box1-2" src="#" alt="Image 2" style="display: none;" />
                        <div class="delete-icon" id="delete-box1-2" onclick="deleteImage(event, 'box1-2')">&#10006;</div>
                        <div class="placeholdertext">
                            <img src="{{asset('assets/images/icon/placeholder-img-1.png')}}" />
                            <h6>Attachement 1</h6>
                        </div>
                    </div>
                    <div class="image-upload-box" id="box1-3" onclick="triggerUpload('box1-3')">
                        <input type="file" accept="image/*" onchange="previewImage(event, 'box1-3')" />
                        <img id="img-box1-3" src="#" alt="Image 3" style="display: none;" />
                        <div class="delete-icon" id="delete-box1-3" onclick="deleteImage(event, 'box1-3')">&#10006;</div>
                        <div class="placeholdertext">
                            <img src="{{asset('assets/images/icon/placeholder-img-1.png')}}" />
                            <h6>Attachement 2</h6>
                        </div>
                    </div>
                    <div class="image-upload-box" id="box1-4" onclick="triggerUpload('box1-4')">
                        <input type="file" accept="image/*" onchange="previewImage(event, 'box1-4')" />
                        <img id="img-box1-4" src="#" alt="Image 4" style="display: none;" />
                        <div class="delete-icon" id="delete-box1-4" onclick="deleteImage(event, 'box1-4')">&#10006;</div>
                        <div class="placeholdertext">
                            <img src="{{asset('assets/images/icon/placeholder-img-1.png')}}" />
                            <h6>Attachement 3</h6>
                        </div>
                    </div>


                    <div class="image-upload-box" id="box1-9" onclick="triggerUpload('box1-9')">
                        <input type="file" accept="image/*" onchange="previewImage(event, 'box1-9')" />
                        <img id="img-box1-9" src="#" alt="Image" style="display: none;" />
                        <div class="delete-icon" id="delete-box1-9" onclick="deleteImage(event, 'box1-9')">&#10006;</div>
                        <div class="placeholdertext">
                            <img src="{{asset('assets/images/icon/placeholder-img-1.png')}}" />
                            <h6>Attachement 4</h6>
                        </div>
                    </div>
                    <div class="video-container">
                        <div class="video-placeholder">
                            <div style="margin: 4px 0px 2px 0px;">
                                <svg viewBox="0 0 64 64" width="38" height="38" fill="#FAFAFA">
                                    <circle cx="32" cy="32" r="32" fill="rgba(0,0,0,0.15)" />
                                    <polygon points="25,16 25,48 48,32" />
                                </svg>
                            </div>
                            <h6>Upload Video</h6>
                        </div>
                        <video class="video-element">
                            <source src="" class="video-source">
                        </video>
                        <div class="play-icon">
                            <svg viewBox="0 0 64 64" width="44" height="44" fill="white">
                                <circle cx="32" cy="32" r="32" fill="rgba(0,0,0,0.5)" />
                                <polygon points="25,16 25,48 48,32" />
                            </svg>
                        </div>
                        <div class="delete-icon">&#10006;</div>
                        <input type="file" class="file-input" accept="video/*">
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-sm-12 col-md-8">
                        <div class="ek_group">

                            <label class="eklabel req">
                                Comments
                            </label>
                            <div class="ek_f_input">
                                <div id="commnetBox" style="padding:10px">
                                    <div class="cardhead d-flex justify-content-between align-items-center">
                                        <h3 class="cardtitle">Buyer</h3>
                                        <div class="text-end">
                                            <span class="fs-12">2024-08-16 - (2 days ago)</span>
                                        </div>
                                    </div>
                                    <div style="padding-left:10px; text-align:justify;" id="cmntContr">
                                        s simply dummy text of the printing and typesetting industry.
                                        Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                                        when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                                        It has survived not only five centuries, but also the leap into electronic typesetting,
                                        remaining essentially unchanged.
                                        It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages,
                                        and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                                    </div>
                                    <hr>
                                    <div class="cardhead d-flex justify-content-between align-items-center">
                                        <span class="fs-12">2024-08-16 - (2 days ago)</span>
                                        <div class="text-end">
                                            <h4 class="cardtitle">Supplier</h4>

                                        </div>
                                    </div>
                                    <div style="padding-left:10px; text-align:justify;">
                                        s simply dummy text of the printing and typesetting industry.
                                        Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                                        when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                                        It has survived not only five centuries, but also the leap into electronic typesetting,
                                        remaining essentially unchanged.
                                        It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages,
                                        and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class=" col-md-5">
                        <div class="ek_group">
                            <label class="eklabel req">
                                <span>Selcet :<span class="req_star">*</span></span>
                            </label>
                            <button class="btn btn-success ">Accept</button>
                            <button class="btn btn-danger ms-2">Decline</button>
                            <button class="btn btn-primary ms-2">Approve</button>
                            
                        </div>
                        <div class="ek_group">
                            <h5 class="ps-5">Amount to refund</h5><input type="text" class="border ms-5 ps-2" value="3443">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <table class="table table-bordered">
                            <thead>
                                <!-- <tr>
                                    <th>Order No</th>
                                    <th>Order Date</th>
                                </tr> -->
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Product</td>
                                    <td>4449</td>
                                   
                                  
                                    
                                   
                                </tr>
                                <tr>
                                <td>Shipping</td>
                                <td>784</td>
                                </tr>
                                <tr>
                                <td>Others</td>
                                <td>0</td>
                                </tr>
                                <tr>
                                <td>GST</td>
                                <td>0</td>
                                </tr>
                                <tr>
                                <td>Order Amount</td>
                                <td>5233</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                <div class="d-flex">
                
                  <div class="upload-original-invoice">
                    <label class="eklabe">
                      <span>	
                      Please book a return shipment and update below details<span class="req_star">*</span></span>
                    </label>
                    <input type="file" id="UploadInvoice" class="upload_invoice" accept=".pdf" style="display: none;">
                    <div class="d-flex gap-2 align-items-center">
                      <div class="UploadInvoiceName fs-14 opacity-75" id=""></div>
                      <div id="UploadInvoiceErr" class="text-danger"></div>
                      <label for="UploadInvoice" class="file-label invice m-0">
                        <span class="file-label-text">Upload Original Invoice</span>
                      </label>
                    </div>
                  </div>
                </div>
                </div>
                </div>
                <div class="row mt-5">
                    <div class="col-sm-12 col-md-8">
                        <div class="ek_group">
                            <label class="eklabel req">
                                <span>Comment:<span class="req_star">*</span></span>
                            </label>
                            <div class="wrapperComment">
                                <div class="commentBoxfloat">
                                    <form id="cmnt">
                                        <fieldset>
                                            <div class="form_grp">
                                                <label id="comment">comment</label>
                                                <textarea id="userCmnt" placeholder="Write your comment here. You can Edit and Delete options. Just Hover in Your comment, you see the both buttons"></textarea>
                                            </div>
                                            <div class="form_grp">
                                                <button type="button" id="submit">Submit</button>
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>

                                <!-- <div id="cmntContr"></div> -->
                            </div>
                        </div>
                    </div>
                </div>



                <div class="saveform_footer text-right single-button">
                    <button id="btnSubmit" class="btn btnekomn_dark">Dispute</button>
                    <button id="btnSubmit" style="margin-left:10px;" class="btn btnekomn">Submit</button>
                    <button class="btn btn-danger" style="margin-left:10px;">Cancel</button>
                </div>

            </div>
        </div>
    </div>
    @endsection
</div>
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function triggerUpload(boxId) {
        document.querySelector(`#${boxId} input[type="file"]`).click();
    }

    function previewImage(event, boxId) {
        event.stopPropagation();
        const reader = new FileReader();
        reader.onload = function() {
            const img = document.getElementById(`img-${boxId}`);
            img.src = reader.result;
            img.style.display = "block";
            document.getElementById(`delete-${boxId}`).style.display = "block";
            document.querySelector(`#${boxId} .placeholdertext`).style.display = "none";
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    function deleteImage(event, boxId) {
        event.stopPropagation();
        const img = document.getElementById(`img-${boxId}`);
        img.src = "";
        img.style.display = "none";
        document.getElementById(`delete-${boxId}`).style.display = "none";
        document.querySelector(`#${boxId} input[type="file"]`).value = "";
        document.querySelector(`#${boxId} .placeholdertext`).style.display = "flex";
    }

    $('#reason').change(function() {
        if ($(this).val() == 5) {
            $('#other').show();
        } else {
            $('#other').hide();
            // $('#otherReason').val('');
        }

    });

    $('#btnSubmit').click(function() {
        var isValid = true;
        if ($('#reason').val() == 0) {
            $('#reason').addClass('is-invalid');
            $('#reasonErr').html('Please select reason');
            isValid = false;
        } else {
            $('#reason').removeClass('is-invalid');
            $('#reasonErr').html('');
        }
        if ($('#otherReason').val() == '') {
            $('#otherReason').addClass('is-invalid');
            $('#otherReasonErr').html('Please enter other reason');
            isValid = false;
        } else if ($('#otherReason').val().length > 100) {
            $('#otherReason').addClass('is-invalid');
            $('#otherReasonErr').html('Please enter maximum 100 characters');
            isValid = false;
        } else {
            $('#otherReason').removeClass('is-invalid');
            $('#otherReasonErr').html('');
        }
        if ($('#comment').val() == '') {
            $('#comment').addClass('is-invalid');
            $('#commentErr').html('Please enter comment');
            isValid = false;
        } else {
            $('#comment').removeClass('is-invalid');
            $('#commentErr').html('');
        }
        let fileUpload = document.querySelectorAll('.image-upload-box input[type="file"]');
        let filledCount = 0;

        fileUpload.forEach(function(file) {
            if (file.files.length > 0) {
                filledCount++;
                file.parentElement.classList.remove('is-invalid');
            } else {
                file.parentElement.classList.add('is-invalid');
            }
        });

        if (filledCount < 3) {
            Swal.fire({
                title: 'Opps!',
                icon: "error",
                text: 'Please upload at least 3 images.',
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
            })
            isValid = false;
            // alert('Please upload at least 3 images.');
        }
    });

    $(function() {
        var inDexValue;

        $('button').click(function() {
            if ($('#userCmnt').val().length == '') {
                alert('Please Enter Your Comment');
                return true;
            }
            var userCmnt = $('#userCmnt').val();
            if ($('#submit').hasClass('editNow')) {

                $('#cmntContr>div.viewCmnt').eq(inDexValue).children('p').html(userCmnt);

            } else {

                $('#cmntContr').append("<div class='viewCmnt'><p>" + userCmnt + "</p><span class='edit'></span><span class='delete'></span></div>");
            }
            $('#userCmnt').val('');
            $(this).removeClass('editNow');
        });

        // Delete 
        $('#cmntContr').on('click', '.delete', function() {
            confirm("Delete Coformation");
            $(this).parent().remove();
        });
        // Edit
        $('#cmntContr').on('click', '.edit', function() {

            var toEdit = $(this).prev('p').html();
            //alert(toEdit);
            $('#userCmnt').val(toEdit);
            $('button').addClass('editNow');
            inDexValue = $(this).parent('div.viewCmnt').index();

        });
    });
</script>
@endsection