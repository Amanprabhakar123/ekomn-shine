<!-- resources/views/complete-shine.blade.php -->
@extends('dashboard.layout.app')

@section('content')
@section('title')
Complete Shine
@endsection
<div class="ek_dashboard">
    <div class="ek_content">
      <div class="card ekcard pa shadow-sm">
        <div class="cardhead">
          <h4 class="cardtitle">Assigned Requests</h4>
          <div style="margin: 0; margin-left: 10px; display: inline-block;">
            <label for="fname">
              <h5>Shine Value :</h5>
            </label>
            <a href="#" class="btn btnekomn btn-sm">₹ {{ $product->amount }}
            </a>
          </div>
        </div>
        {{-- <form action="" method="post"> --}}
          <div class="addProductForm">
            <h4 class="subheading">Product Shine Details</h4>
            <div class="row">
              <div class="col-sm-12 col-md-12">
                <div class="ek_group">
                  <label class="eklabel req"><span>Product Name:</span></label>
                  <div class="ek_f_input">
                    <input type="text" class="form-control" placeholder="" value="{{ $product->name }}" disabled />
                    <span class="text-danger hide">Error message</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-4">
                <div class="ek_group">
                  <label class="eklabel req"><span>Platform :</span></label>
                  <div class="ek_f_input">
                    <input type="text" class="form-control" placeholder="" value="{{ $product->platform }}" disabled />
                    <span class="text-danger hide">Error message</span>
                  </div>
                </div>
              </div>
              <div class="col-sm-12 col-md-4">
                <div class="ek_group">
                  <label class="eklabel req"><span>Product URL/Link :</span></label>
                  <div class="ek_f_input">
                    <a target="_blank" href="{{ $product->url }}">Product Link</a>
                  </div>
                </div>
              </div>
              <div class="col-sm-12 col-md-4">
                <div class="ek_group">
                  <label class="eklabel req"><span>Product ID/ASIN:</span></label>
                  <div class="ek_f_input">
                    <input type="text" class="form-control" placeholder="" value="{{ $product->product_id }}" disabled />
                    <span class="text-danger hide">Error message</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-4">
                <div class="ek_group">
                  <label class="eklabel req"><span>Seller/Brand Name :</span></label>
                  <div class="ek_f_input">
                    <input type="text" class="form-control" placeholder="" value="{{ $product->seller_name }}" disabled />
                    <span class="text-danger hide">Error message</span>
                  </div>
                </div>
              </div>
              <div class="col-sm-12 col-md-8">
                <div class="ek_group">
                  <label class="eklabel req"><span>Product Search Term :</span></label>
                  <div class="ek_f_input">
                    <input type="text" class="form-control" placeholder="" value="{{ $product->search_term }}" disabled />
                    <span class="text-danger hide">Error message</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-4">
                <div class="ek_group">
                  <label class="eklabel req"><span>Product amount :</span></label>
                  <div class="ek_f_input">
                    <input type="text" class="form-control" placeholder="" value="₹ {{ $product->amount }}" disabled />
                    <span class="text-danger hide">Error message</span>
                  </div>
                </div>
              </div>
              <div class="col-sm-12 col-md-5">
                <div class="ek_group">
                  <label class="eklabel req"><span>Feedback/Review Title :</span></label>
                  <div class="ek_f_input">
                    <input type="text" class="form-control" placeholder="" value="{{ $product->feedback_title }}" disabled />
                    <span class="text-danger hide">Error message</span>
                  </div>
                </div>
              </div>
              <div class="col-sm-12 col-md-3">
                <div class="ek_group">
                  <label class="eklabel req">Review Rating :</label>
                  <div class="star-rating">
                    <div class="ek_f_input">
                      <div class="star-rating">
                        <div class="star-rating">
                            @for ($i = 1; $i <= 5; $i++)
                                <span class="star" data-value="{{ $i }}" @if ($i <= $product->review_rating) style="color: #FECA40;" @endif>
                                    &#9733;
                                </span>
                            @endfor
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-12">
                <div class="ek_group">
                  <label class="eklabel req"><span>Feedback/Review comment :</span></label>
                  <div class="ek_f_input">
                    <textarea class="form-control" placeholder="" disabled>{{ $product->feedback_comment }}</textarea>
                    <span class="text-danger hide">Error message</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="imagecontainer" id="imagecontainerVariation-1">
            @if(!$productReview->order_number)
              <h6 class="text-danger pt-2">Your product is under Inprogress... Please wait for product Order Dtails.</h6>
            @endif
            <!-- Other product details here -->
            <input type="hidden" class="form-control" name="batch_id" value="{{ $product->batch_id }}">
            <input type="hidden" class="form-control" name="request_no" value="{{ $product->request_no }}">
            <input type="hidden" class="form-control" id="productId" name="product_id" value="{{ $product->id }}">
            <h4 class="subheading">Updated Order Details (by assigner)</h4>
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="ek_group">
                        <label class="eklabel req"><span>Order No :</span></label>
                        <div class="ek_f_input">
                            <input type="text" class="form-control" id="orderNumber" value="{{ $productReview->order_number }}"  placeholder="Updated Soon." disabled />
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                  <div class="ek_group">
                      <label class="eklabel req"><span>Order Invoice :</span></label>
                      @if($productReview->order_invoice)
                          <a href="{{ route('download_shine_order_invoice.download', ['id' => $productReview->shine_product_id]) }}" class="btn btn-login btnekomn">
                              <i class="fas fa-download me-3 fs-13"></i> Download
                          </a>
                          <label class="eklabel req ms-2"><span>Updated</span></label>
                      @else
                          <a href="#" class="btn btn-login btnekomn disabled" aria-disabled="true">
                              <i class="fas fa-download me-3 fs-13"></i> Download
                          </a>
                          <label class="eklabel req ms-2"><span>To be Updated Soon.</span></label>
                      @endif
                  </div>
              </div>
            </div>
            <div class="row pt-4">
              @if($productReview->order_invoice)
                @if(!$productReview->requestor_confirmation)
                  <h6 class="text-danger">Your Shine review order has been placed. Please review the order details above and confirm receipt.</h6>
                @else
                  <h6 class="text-primary">Thanks for your confirmation, Now wait for the Assigner's Acknowledgment of Shine Completion.</h6>
                @endif
                <div class="col-sm-12 col-md-5 mt-4">
                  <div class="ek_group">
                    <label class="eklabel req ms-2"><span>Shine Order received?</span></label>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="requestor_confirmation" value="1" id="yes"
                        {{ $productReview->requestor_confirmation == 1 ? 'checked' : '' }}
                        {{ $productReview->requestor_comment ? 'disabled' : '' }} />
                      <label class="form-check-label" for="yes">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="requestor_confirmation" value="0" id="no"
                        {{ $productReview->requestor_confirmation == 0 ? 'checked' : '' }}
                        {{ $productReview->requestor_comment ? 'disabled' : '' }} />
                      <label class="form-check-label" for="no">No</label>
                    </div>
                    <span class="text-danger hide" id="requestor_confirmationError">Please Select Yes/No.</span>
                  </div>
                </div>   
                <div class="col-sm-12 col-md-5">
                  <div class="ek_group">
                    <label class="eklabel req"><span>Comment:</span></label>
                    <div class="ek_f_input">
                      <textarea class="form-control" id="requestor_comment" placeholder="Write your comment." {{ $productReview->requestor_comment ? 'disabled' : '' }}>{{ $productReview->requestor_comment }}</textarea>
                      <span class="text-danger hide" id="requestor_commentError">Comment is required.</span>
                      <span class="text-danger hide" id="requestor_commentInvalidError">Numbers and email addresses are not allowed.</span>
                    </div>
                  </div>
                </div>
                
                <div class="col-sm-12 col-md-2 mt-2">
                  <div class="ek_group">
                    <button type="button" onclick="validateForm1(event)" class="btn btn-login btnekomn" id="downloadButton" {{ $productReview->requestor_comment ? 'disabled' : '' }}>Confirm</button>
                  </div>
                </div>
              @endif
            </div>
            </div>
            <div class="imagecontainer" id="imagecontainerVariation-1">
              @if($productReview->requestor_confirmation)
                <h6 class="text-danger pt-2">Assigner's Acknowledgment of Shine Completion is processed. Now Please Review below your Review and comment is live.</h6>
              @endif
            <div class="row pt-1">
                <div class="col-sm-12 col-md-12">
                    <h6 class="bold">Assigner's Acknowledgment of Shine Completion :</h6>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="ek_group">
                        <label class="eklabel req"><span>Review Screenshot :</span></label>
                        @if($productReview->screenshots)
                            <a href="{{ route('download_shine_screenshots.download', ['id' => $productReview->shine_product_id]) }}" class="btn btn-login btnekomn">
                                <i class="fas fa-download me-3 fs-13"></i> Download
                            </a>
                            <label class="eklabel req ms-2"><span>Updated</span></label>
                        @else
                            <a href="#" class="btn btn-login btnekomn disabled" aria-disabled="true">
                                <i class="fas fa-download me-3 fs-13"></i> Download
                            </a>
                            <label class="eklabel req ms-2"><span>To be Updated Soon.</span></label>
                        @endif

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="ek_group">
                        <label class="eklabel req"><span>Comment by assigner :</span></label>
                        <div class="ek_f_input">
                            <textarea class="form-control" id="comments" placeholder="Updated Soon." disabled>{{ $productReview->feedback_comment }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row pt-4">
              @if($productReview->screenshots)
                @if($productReview->requestor_confirmation_complition)
                  <h6 class="text-primary">Thanks for your confirmation.</h6>
                @else
                  <h6 class="text-danger pt-2">Please Confirm your Review and comment is live.</h6>
                @endif
                <div class="col-sm-12 col-md-10">
                  <div class="ek_group">
                    <label class="eklabel req ms-2"><span>Review and comment is live?</span></label>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="requestor_confirmation_complition" value="1" id="yes"
                        {{ $productReview->requestor_confirmation_complition == 1 ? 'checked' : '' }}
                        {{ $productReview->requestor_confirmation_complition ? 'disabled' : '' }} />
                      <label class="form-check-label" for="yes">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="requestor_confirmation_complition" value="0" id="no"
                        {{ $productReview->requestor_confirmation_complition == 0 ? 'checked' : '' }}
                        {{ $productReview->requestor_confirmation_complition ? 'disabled' : '' }} />
                      <label class="form-check-label" for="no">No</label>
                    </div>
                    <span class="text-danger hide" id="requestor_confirmation_complitionError">Please Select Yes/No.</span>
                  </div>
                </div>
                <div class="col-sm-12 col-md-2 mt-2">
                  <div class="ek_group">
                    <button type="button" onclick="validateForm(event)" class="btn btn-login btnekomn" id="downloadButton" {{ $productReview->requestor_confirmation_complition ? 'disabled' : '' }}>Confirm</button>
                  </div>
                </div>
              @endif
            </div>
            <div class="row pt-3">
              <div class="col-sm-12 col-md-12">
                <div class="ek_group">
                  <label class="eklabel req"><span>Shine Status :</span></label>
                  <div class="ek_f_input pt-2">
                    @php
                      $statusLabels = [
                        0 => ['label' => 'Draft', 'bgColor' => '#6c757d', 'color' => '#fff'],
                        1 => ['label' => 'Pending', 'bgColor' => '#ffc107', 'color' => '#000'],
                        2 => ['label' => 'Inprogress', 'bgColor' => '#17a2b8', 'color' => '#fff'],
                        3 => ['label' => 'Order Placed', 'bgColor' => '#007bff', 'color' => '#fff'],
                        4 => ['label' => 'Order Confirm', 'bgColor' => '#28a745', 'color' => '#fff'],
                        5 => ['label' => 'Review Submitted', 'bgColor' => '#ffc107', 'color' => '#000'],
                        6 => ['label' => 'Complete', 'bgColor' => '#28a745', 'color' => '#fff'],
                        7 => ['label' => 'Cancelled', 'bgColor' => '#dc3545', 'color' => '#fff']
                      ];
                    @endphp
                    @php
                      $status = $statusLabels[$product->status] ?? ['label' => 'Unknown', 'bgColor' => '#000', 'color' => '#fff'];
                    @endphp
                      <span style="padding: 3px 7px; border-radius: 3px; background-color: {{ $status['bgColor'] }}; color: {{ $status['color'] }};">
                        {{ $status['label'] }}
                      </span>
                  </div>
                </div>
              </div>
            </div>
            </div>
            <div class="saveform_footer">
              <button type="button" class="btn btn-login btnekomn card_f_btn previous_Tab" id="cancelButton">
                  <i class="fas fa-arrow-left me-3 fs-13"></i>Back
              </button>
            </div>
          </div>
          </div>
        {{-- </form> --}}
      </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
  // Go Back
  document.getElementById('cancelButton').addEventListener('click', function() {
    window.location.href = "{{ route('my-shine') }}?tab=shine";
  });
  // Form1 Validation
function validateForm1(event) {
  event.preventDefault();
  let isValid = true;

  const requestor_confirmation = document.querySelector('input[name="requestor_confirmation"]:checked');
  const requestor_comment = $('#requestor_comment').val();
  const productId = $('#productId').val();

  if (!requestor_confirmation) {
    $('#requestor_confirmationError').removeClass('hide');
    isValid = false;
  } else {
    $('#requestor_confirmationError').addClass('hide');
  }

  // Validate comment
  if (!requestor_comment) {
    $('#requestor_commentError').removeClass('hide');
    isValid = false;
  } else {
    $('#requestor_commentError').addClass('hide');
        
    // Check if comment contains numbers or email addresses
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const containsEmail = emailPattern.test(requestor_comment);
    const containsNumber = /\d/.test(requestor_comment);
        
    if (containsEmail || containsNumber) {
      $('#requestor_commentInvalidError').removeClass('hide');
      isValid = false;
    } else {
      $('#requestor_commentInvalidError').addClass('hide');
    }
  }

  if (isValid) {
    const formData = new FormData();
    formData.append('requestor_confirmation', requestor_confirmation.value);
    formData.append('requestor_comment', requestor_comment);
    formData.append('_method', 'PUT'); // Laravel requires this for PUT method
    formData.append('_token', '{{ csrf_token() }}');

    $.ajax({
      url: `/shine-product-reviews2/${$('#productId').val()}`,
      type: 'POST', // Use POST for method override
      data: formData,
      contentType: false,
      processData: false,
      success: function(response) {
        Swal.fire({
            title: 'Success',
            text: 'Thanks for your confirmation.',
            icon: 'success',
            confirmButtonText: 'OK',
            customClass: {
                confirmButton: 'custom-confirm-btn'
            }
          }).then(() => {
            $('#saveButton1').prop('disabled', true);
            location.reload(); // Reload the page after the user acknowledges the success message
          });
        },
        error: function(xhr) {
        Swal.fire({
            title: 'Error',
            text: 'Please do after some time.',
            icon: 'error',
            confirmButtonText: 'OK',
            customClass: {
                confirmButton: 'custom-error-btn'
            }
          });
        }
    });
  }
}

  // Form2 Validation
  function validateForm(event) {
  event.preventDefault();
  let isValid = true;

  const requestor_confirmation_complition = document.querySelector('input[name="requestor_confirmation_complition"]:checked');
  const productId = $('#productId').val();

  if (!requestor_confirmation_complition) {
    $('#requestor_confirmation_complitionError').removeClass('hide');
    isValid = false;
  } else {
    $('#requestor_confirmation_complitionError').addClass('hide');
  }

  if (isValid) {
    const formData = new FormData();
    formData.append('requestor_confirmation_complition', requestor_confirmation_complition.value);
    formData.append('_method', 'PUT'); // Laravel requires this for PUT method
    formData.append('_token', '{{ csrf_token() }}');

    $.ajax({
      url: `/shine-product-reviews4/${$('#productId').val()}`,
      type: 'POST', // Use POST for method override
      data: formData,
      contentType: false,
      processData: false,
      success: function(response) {
        Swal.fire({
            title: 'Success',
            text: 'Thanks for your confirmation.',
            icon: 'success',
            confirmButtonText: 'OK',
            customClass: {
                confirmButton: 'custom-confirm-btn'
            }
          }).then(() => {
            $('#saveButton1').prop('disabled', true);
            location.reload(); // Reload the page after the user acknowledges the success message
          });
        },
        error: function(xhr) {
        Swal.fire({
            title: 'Error',
            text: 'Please do after some time.',
            icon: 'error',
            confirmButtonText: 'OK',
            customClass: {
                confirmButton: 'custom-error-btn'
            }
          });
        }
    });
  }
}
</script>
@endsection
