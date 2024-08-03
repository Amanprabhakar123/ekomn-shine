@extends('dashboard.layout.app')

@section('content')
<div class="ek_dashboard">
  <div class="ek_content">
    <div class="card ekcard pa shadow-sm">
      <div class="cardhead ">
        <h3 class="cardtitle">Update Bulk Payment</h3>
      </div>
      <div class="uploadContainer_p">
        <div class="uploadContainer">
          <div class="u_d_text">
            <i class="far fa-file-excel"></i>
            Download the 'csv' template to add your payment update
          </div>
          <a href="{{ route('download-template-payment') }}" class="btn btnekomn-border mt25 mb5">Download</a>
        </div>
        <div class="bt_arrow">
          <i class="fas fa-long-arrow-alt-right"></i>
        </div>
        <div class="uploadContainer">
          <!-- <div class="ek_group">
            <label class="eklabel req"><span>Supplier Id:<span class="req_star">*</span></span></label>
            <div class="ek_f_input">
              <input type="text" class="form-control" placeholder="Supplier Id." id="supplier_id" required />
              <div id="supplier_idErr" class="invalid-feedback"></div>
            </div>
          </div> -->
          <div class="u_d_text">
            <i class="fas fa-upload"></i>
            Upload the filled 'csv' file with your payment update
          </div>
          <input type="file" name="import_file" id="fileInput" class="file-input" accept=".csv" required />
          <div class="d-flex gap-3 align-items-center">
            <label for="fileInput" class="file-label">
              <span class="file-label-text">Upload</span>
            </label>
            <div id="fileName" class="file-name mt20"></div>
          </div>
          <div id="fileInputErr" class="invalid-feedback"></div>
        </div>
      </div>
      <!-- <p class="mt15 opacity-50">
        The QC proces swill start after the upload of your payment.
      </p> -->

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
      if (['csv'].indexOf(fileExtension) === -1) {
        Swal.fire({
          title: 'Invalid file format. Please upload a valid Csv file.',
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
      if (!file) {
        $('#fileInput').addClass('is-invalid');
        $('#fileInputErr').text('No file chosen');
        isvalid = false;
      }
      if (isvalid) {
        $.ajax({
          url: "{{ route('import-payment') }}",
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
                  window.location.href = "{{ route('order.payment') }}";
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
</script>

@endsection