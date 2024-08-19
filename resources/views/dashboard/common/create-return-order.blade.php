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
                        <div class="col-sm-12 col-md-4">
                            <div class="ek_group">
                                <label class="eklabel req">
                                    <span>Return Request:<span class="req_star">*</span></span>
                                </label>
                                <div class="ek_f_input">
                                    <input type="text" class="form-control" value="EK1050IND" id="full_name" disabled />
                                    <div id="full_nameErr" class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-4">
                            <div class="ek_group">
                                <label class="eklabel req">
                                    <span>Order No:<span class="req_star">*</span></span>
                                </label>
                                <div class="ek_f_input">
                                    <input type="text" class="form-control" value="EK1050IND" id="full_name" disabled />
                                    <div id="full_nameErr" class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-4">
                            <div class="ek_group">
                                <label class="eklabel req">Reason:<span class="r_color">*</span></label>
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
                    <div class="col-sm-12 col-md-7">
                        <div class="ek_group">
                            <label class="eklabel req">
                                <span>Comment:<span class="req_star">*</span></span>
                            </label>
                            <div class="ek_f_input">
                                <textarea name="" id="comment" class="form-control" style=" height:100px;"></textarea>
                                <div id="commentErr" class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="saveform_footer text-right single-button">
                    <button id="btnSubmit" class="btn btnekomn">Submit</button>
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
    reader.onload = function () {
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
        if($('#reason').val() == 0){
            $('#reason').addClass('is-invalid');
            $('#reasonErr').html('Please select reason');
            isValid = false;
        }else{
            $('#reason').removeClass('is-invalid');
            $('#reasonErr').html('');
        }
        if($('#otherReason').val() == ''){
            $('#otherReason').addClass('is-invalid');
            $('#otherReasonErr').html('Please enter other reason');
            isValid = false;
        }else if($('#otherReason').val().length > 100){
            $('#otherReason').addClass('is-invalid');
            $('#otherReasonErr').html('Please enter maximum 100 characters');
            isValid = false;
        }else{
            $('#otherReason').removeClass('is-invalid');
            $('#otherReasonErr').html('');
        }
        if($('#comment').val() == ''){
            $('#comment').addClass('is-invalid');
            $('#commentErr').html('Please enter comment');
            isValid = false;
        }else{
            $('#comment').removeClass('is-invalid');
            $('#commentErr').html('');
        }
        let fileUpload = document.querySelectorAll('.image-upload-box input[type="file"]');
            let filledCount = 0;

            fileUpload.forEach(function(file){
                if(file.files.length > 0){
                    filledCount++;
                    file.parentElement.classList.remove('is-invalid');
                } else {
                    file.parentElement.classList.add('is-invalid');
                }
            });

            if(filledCount < 3){
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

</script>
@endsection