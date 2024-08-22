@extends('dashboard.layout.app')

@section('content')
<div class="ek_dashboard">
    <div class="ek_content">
        <div class="ek_content">
            <div class="card ekcard pa shadow-sm">
                <div class="cardhead d-flex justify-content-between align-items-center">
                    <h3 class="cardtitle">Return Order</h3>
                    <!-- <div class="text-end">
                        <h4 class="subheading">Last Update - Activity/Order Tracking</h4>
                        <span class="fs-15">2024-08-16 - (2 days ago)</span>
                    </div> -->
                </div>
                <section class="">
                    <div class="row">
                        <div class="col-sm-12 col-md-4">
                            <div class="ek_group">
                                <label class="eklabel req">
                                    <span>Return Request:<span class="req_star">*</span></span>
                                </label>
                                <div class="ek_f_input">
                                    <input type="text" class="form-control" value="{{$return_request}}" id="full_name" disabled />
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
                                    <input type="text" class="form-control" id="order_number" />
                                    <div id="order_numberErr" class="invalid-feedback"></div>
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
                                        @foreach($reasons as $key => $reason)
                                        <option value="{{$key}}">{{$reason}}</option>
                                        @endforeach
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
                                                <textarea id="userCmnt" placeholder="Write your comment here. "></textarea>
                                                <div id="commentErr" class="invalid-feedback"></div>

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
                    <button id="btnSubmit" class="btn btnekomn">Submit</button>
                    <button class="btn btn-danger" style="margin-left:10px;">Cancel</button>
                </div>

            </div>
        </div>
        @include('dashboard.layout.copyright')
    </div>
    @endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Start code Image Upload and video upload Step 4
    document.addEventListener("DOMContentLoaded", function() {
        // Initial setup for existing containers
        const videoContainers = document.querySelectorAll(".video-container");
        videoContainers.forEach((container) => {
            initializeVideoUpload(container);
        });
        // Function to initialize video upload functionality
        function initializeVideoUpload(container) {
            const fileInput = container.querySelector(".file-input");
            const video = container.querySelector("video");
            const source = container.querySelector(".video-source");
            const placeholder = container.querySelector(".video-placeholder");
            const deleteButton = container.querySelector(".delete-icon");
            const playIcon = container.querySelector(".play-icon");

            function togglePlayPause() {
                if (video.paused) {
                    video.play();
                } else {
                    video.pause();
                }
            }

            function handleFileChange(event) {
                const file = event.target.files[0];
                if (file) {
                    source.src = URL.createObjectURL(file);
                    video.style.display = "block";
                    placeholder.style.display = "none";
                    playIcon.style.display = "block";
                    deleteButton.style.display = "block";
                    video.load();
                }
            }

            function handleDeleteClick(event) {
                event.stopPropagation();
                if (!video.paused) {
                    video.pause();
                } else {
                    resetVideo();
                }
            }

            function resetVideo() {
                source.src = "";
                video.style.display = "none";
                placeholder.style.display = "flex";
                deleteButton.style.display = "none";
                playIcon.style.display = "none";
                fileInput.value = null;
            }
            container.addEventListener("click", (event) => {
                if (event.target === video || event.target === playIcon) {
                    togglePlayPause();
                } else if (event.target === deleteButton) {
                    handleDeleteClick(event);
                } else {
                    fileInput.click();
                }
            });
            fileInput.addEventListener("change", handleFileChange);
            video.addEventListener("pause", () => {
                playIcon.style.display = "block";
                deleteButton.style.display = "block";
            });
            video.addEventListener("play", () => {
                playIcon.style.display = "none";
                deleteButton.style.display = "none";
            });
        }
    });

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

        if ($('#order_number').val() == 0) {
            $('#order_number').addClass('is-invalid');
            $('#order_numberErr').html('Please enter order number');
            isValid = false;
        } else {
            $('#order_number').removeClass('is-invalid');
            $('#order_numberErr').html('');
        }
        if ($('#reason').val() == 0) {
            $('#reason').addClass('is-invalid');
            $('#reasonErr').html('Please select reason');
            isValid = false;
        } else {
            $('#reason').removeClass('is-invalid');
            $('#reasonErr').html('');
        }
        if ($('#reason').val() == 5) {
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
        }
        if ($('#userCmnt').val() == '') {
            $('#userCmnt').addClass('is-invalid');
            $('#commentErr').html('Please enter comment');
            isValid = false;
        } else {
            $('#userCmnt').removeClass('is-invalid');
            $('#commentErr').html('');
        }
        let fileUpload = document.querySelectorAll('.multi-row input[type="file"]');
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
        }
        if (isValid) {
            const formData = new FormData();
            fileUpload.forEach((input, index) => {
                const files = input.files;
                if (files.length > 0) { // Ensure that there are files to append
                    for (let a = 0; a < files.length; a++) {
                        formData.append(`media[${index}]`, files[a]);
                    }
                }
            });
            formData.append('order_number', $('#order_number').val());
            formData.append('reason', $('#reason').val());
            formData.append('other_reason', $('#otherReason').val());
            formData.append('comment', $('#userCmnt').val());
            formData.append('return_number', '{{$return_request}}');
            ApiRequest('store-return-order', 'POST', formData).then(function(response) {
                if (response.data.statusCode == 200) {
                    Swal.fire({
                        title: 'Success!',
                        icon: "success",
                        text: response.data.message,
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
                    }).then(function() {
                        window.location.href = "{{route('create.return.order')}}";
                    });

                } else {
                    Swal.fire({
                        title: 'Opps!',
                        icon: "error",
                        text: response.data.message,
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
                    .then(function() {
                        window.location.href = "{{route('create.return.order')}}";
                    });
                }
            });
        }
    });
</script>
@endsection