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
            <a href="{{ route('download-template') }}" class="btn btnekomn-border mt25 mb5">Download</a>
          </div>
          <div class="bt_arrow">
            <i class="fas fa-long-arrow-alt-right"></i>
          </div>
          <div class="uploadContainer">
            <div class="u_d_text">
              <i class="fas fa-upload"></i>
              Upload the filled excel file with your product details
            </div>
            <!-- <form id="uploadForm" action="{{ route('import-product-inventory') }}" method="POST" enctype="multipart/form-data"> -->
            
              <input type="file" name="import_file" id="fileInput" class="file-input" accept=".csv, .xls, .xlsx" required />
              <div class="d-flex gap-3 align-items-center">
                  <label for="fileInput" class="file-label">
                      <span class="file-label-text">Upload</span>
                  </label>
                  <div id="fileName" class="file-name mt20"></div>
              </div>
              <!-- <button type="submit" class="btn btn-login btnekomn card_f_btn next_Tab">Start Processing</button> -->
          </form>
          @if ($errors->any())
          <div class="alert alert-danger mt-3">
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif
      @if (session('success'))
          <div class="alert alert-success mt-3">
              {{ session('success') }}
          </div>
      @endif
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
  $('document').ready(function(){
    $('#fileInput').change(function(){
      var file = $('#fileInput')[0].files[0];
      $('#fileName').text(file.name);
      var fileExtension = file.name.split('.').pop().toLowerCase();
      if (['xls', 'xlsx'].indexOf(fileExtension) === -1) {
        alert('Invalid file format. Please upload a valid Excel file.');
        isvalid = false;
      } else {
        formData.append('import_file', file);
        isvalid = true;
      }
    });
    $('#processing').click(function(){
      console.log(formData);
      if(isvalid){
        $.ajax({
          url: "{{ route('import-product-inventory') }}",
          type: 'POST',
          data: formData,
          contentType: false,
          processData: false,
          success: function(response){
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
            // console.log(response);
          }
        });
      }
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