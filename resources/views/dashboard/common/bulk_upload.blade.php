@extends('dashboard.layout.app')

@section('content')
<div class="ek_dashboard">
  <div class="ek_content">
    <div class="card ekcard pa shadow-sm">
      <div class="cardhead ">
        <h3 class="cardtitle">Add Listings in Bulk</h3>
      </div>
      <div class="uploadContainer_p">
        <div class="uploadContainer">
          <div class="u_d_text">
            <i class="far fa-file-excel"></i>
            Download the excel template to add your product details
          </div>
          <a href="{{ route('download-template') }}" class="btn btnekomn-border downborder mt25 mb5">Download</a>
        </div>
        <div class="bt_arrow">
          <i class="fas fa-long-arrow-alt-right"></i>
        </div>
        <div class="uploadContainer">
          @if((auth()->user()->hasRole(ROLE_ADMIN) || auth()->user()->hasRole(ROLE_SUB_ADMIN)) && auth()->user()->hasPermissionTo(PERMISSION_LIST_PRODUCT))
          <div class="ek_group">
            <label class="eklabel req"><span>Supplier Id:<span class="req_star">*</span></span></label>
            <div class="ek_f_input">
              <input type="text" class="form-control" placeholder="Supplier Id." id="supplier_id" required />
              <div id="supplier_idErr" class="invalid-feedback"></div>
            </div>
          </div>
          @endif
          <div class="u_d_text">
            <i class="fas fa-upload"></i>
            Upload the filled excel file with your product details
          </div>
          <input type="file" name="import_file" id="fileInput" class="file-input" accept=".xls, .xlsx, .xlsm" required />
          <div class="d-flex gap-3 align-items-center">
            <label for="fileInput" class="file-label">
              <span class="file-label-text">Upload</span>
            </label>
            <div id="fileName" class="file-name mt20"></div>
          </div>
          <div id="fileInputErr" class="invalid-feedback"></div>
        </div>
        <div class="video-container bulkuploadvideo">
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
      <p class="mt15 opacity-50">
        The QC proces swill start after the upload of your product.
      </p>
      <div class="saveform_footer text-right mt30">
        <button type="button" id="processing" class="btn btn-login btnekomn card_f_btn next_Tab">Start Processing</button>
      </div>
    </div>
  </div>


  @include('dashboard.layout.copyright')
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  formData = new FormData();
  isvalid = true;
  $('document').ready(function() {
    $('#fileInput').change(function() {
      var file = $('#fileInput')[0].files[0];
      $('#fileName').text(file.name);
      var fileExtension = file.name.split('.').pop().toLowerCase();
      if (['xls', 'xlsx', 'xlsm'].indexOf(fileExtension) === -1) {
        Swal.fire({
          title: 'Invalid file format. Please upload a valid Excel file.',
          icon: 'error',
          confirmButtonText: 'OK'
        });
        isvalid = false;
      } else {
        $('#fileInput').removeClass('is-invalid');
        $('#fileInputErr').text('');
        formData.append('import_file', file);
        isvalid = true;
      }
    });
    $('#processing').click(function() {
      var file = $('#fileInput')[0].files[0];
      @if(auth()->user()-> hasRole(ROLE_ADMIN) && auth()->user()->hasPermissionTo(PERMISSION_LIST_PRODUCT))
      var supplier_id = $('#supplier_id').val();
      if (supplier_id == '' || supplier_id == null) {
        $('#supplier_id').addClass('is-invalid');
        $('#supplier_idErr').text('Supplier Id is required.');
        isvalid = false;
      } else {
        $('#supplier_id').removeClass('is-invalid');
        $('#supplier_idErr').text('');
        formData.append('supplier_id', supplier_id);
        isvalid = true;
      }
      formData.append('supplier_id', supplier_id);
      @endif
      if (!file) {
        $('#fileInput').addClass('is-invalid');
        $('#fileInputErr').text('No file chosen');
        isvalid = false;
      }
      if (isvalid) {
        $.ajax({
          url: "{{ route('import-product-inventory') }}",
          type: 'POST',
          data: formData,
          contentType: false,
          processData: false,
          success: function(response) {
            if (response.data.statusCode == 200) {
              // alert(response.data.message);
              // Swal.fire("SweetAlert2 is working!");
              Swal.fire({
                title: response.data.message,
                icon: "success",
                didOpen: () => {
                  // Apply inline CSS to the title
                  const title = Swal.getTitle();
                  title.style.color = 'red';
                  title.style.fontSize = '20px';

                  // Apply inline CSS to the content
                  const content = Swal.getHtmlContainer();
                  content.style.color = 'blue';

                  // Apply inline CSS to the confirm button
                  const confirmButton = Swal.getConfirmButton();
                  confirmButton.style.backgroundColor = '#feca40';
                  confirmButton.style.color = 'white';
                }
              }).then((result) => {
                if (result.isConfirmed) {
                  window.location.href = "{{ route('bulk-upload.list') }}";
                }
              });
            } else {
              Swal.fire({
                title: response.data.message,
                icon: "error",
                didOpen: () => {
                  // Apply inline CSS to the title
                  const title = Swal.getTitle();
                  title.style.color = 'red';
                  title.style.fontSize = '20px';

                  // Apply inline CSS to the content
                  const content = Swal.getHtmlContainer();
                  content.style.color = 'blue';

                  // Apply inline CSS to the confirm button
                  const confirmButton = Swal.getConfirmButton();
                  confirmButton.style.backgroundColor = '#feca40';
                  confirmButton.style.color = 'white';
                }
              });
            }
          }
        });
      }
    });
  });


   // Start code Image Upload and video upload Step 4
   document.addEventListener("DOMContentLoaded", function() {
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
 
    // Initial setup for existing containers
    const videoContainers = document.querySelectorAll(".video-container");
    videoContainers.forEach((container) => {
      initializeVideoUpload(container);
    });
  });
  
</script>

<!-- <script>
  document.getElementById('fileInput').addEventListener('change', function(event) {
    const fileName = event.target.files[0]?.name || 'No file chosen';
    document.getElementById('fileName').textContent = fileName;
});

</script> -->
@endsection