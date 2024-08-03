@extends('dashboard.layout.app')

@section('content')
<div class="ek_dashboard">
  <div class="ek_content">
    <div class="card ekcard pa shadow-sm">
      <div class="cardhead ">
        <h3 class="cardtitle">Bulk update payment</h3>
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
          <input type="file" name="import_file" id="fileInput" class="file-input" accept=".xls, .xlsx, .xlsm" required />
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

@endsection