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
              Upload the fulled excel file with your product details
            </div>
            <input type="file" id="fileInput" class="file-input" accept=".csv, .xls, .xlsx" />
            <div class="d-flex gap-3 align-items-center">
              <label for="fileInput" class="file-label">
                <span class="file-label-text">Upload</span>
              </label>
              <div id="fileName" class="file-name mt20"></div>
            </div>
          </div>
        </div>
        <p class="mt15 opacity-50">
          The QC proces swill start after the upload of your product.
        </p>
        <div class="saveform_footer text-right mt30">
          <button type="button" class="btn btn-login btnekomn card_f_btn next_Tab">Start Processing</button>
        </div>
      </div>
    </div>


@include('dashboard.layout.copyright')
</div>
@endsection

@section('scripts')
<script>
  document.getElementById('fileInput').addEventListener('change', function(event) {
    const fileName = event.target.files[0]?.name || 'No file chosen';
    document.getElementById('fileName').textContent = fileName;
});

</script>
@endsection