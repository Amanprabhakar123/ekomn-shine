<!-- resources/views/complete-shine.blade.php -->
@extends('dashboard.layout.app')

@section('content')
@section('title')
Assign Shine
@endsection
<div class="ek_dashboard">
    <div class="ek_content">
      <div class="card ekcard pa shadow-sm">
        <div class="cardhead">
          <h4 class="cardtitle">Assigned Requests</h4>
          <div style="margin: 0; margin-left: 10px; display: inline-block;">
            <label for="fname">
              <h5>Assigned Value :</h5>
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
              <!-- Other product details here -->
              @if(!$productReview->order_number)
                <h6 class="text-danger pt-2">Please do order your assigned Product Shine and Upload your Order Dtails.</h6>
              @endif
              <input type="hidden" class="form-control" id="productId" name="product_id" value="{{ $product->id }}">
              <h4 class="subheading">Order Details</h4>
              <div class="row">
                <div class="col-sm-12 col-md-6">
                  <div class="ek_group">
                    <label class="eklabel req"><span>Order ID/No :</span></label>
                    <div class="ek_f_input">
                      <input type="text" class="form-control" id="orderNumber" value="{{ $productReview->order_number }}" placeholder="Please type your order number." {{ $productReview->order_number ? 'disabled' : '' }} />
                      <span class="text-danger hide" id="orderNumberError">Order number is required.</span>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12 col-md-4">
                  <div class="ek_group">
                    <label class="eklabel req"><span>Upload Order Invoice/ Order Confirmation Screenshot:</span></label>
                    <div class="d-flex align-items-center justify-content-between ms-2">
                      <input type="file" id="orderInvoice" style="display: none;" onchange="updateFileNameAndDisableButton(this, 'invoiceButton')" />
                      <button type="button" class="btn btn-light border" id="invoiceButton" onclick="document.getElementById('orderInvoice').click();" {{ $productReview->order_invoice ? 'disabled' : '' }}>
                          {{ $productReview->order_invoice ? 'Invoice.' . pathinfo($productReview->order_invoice, PATHINFO_EXTENSION) : 'Select file' }}
                      </button>
                      <span class="text-danger hide" id="orderInvoiceError">Order invoice is required.</span>
                    </div>
                    {{-- @if ($productReview->order_invoice)
                      <div class="mt-2">
                        <a href="{{ asset('storage/' . $productReview->order_invoice) }}" target="_blank">View Uploaded Invoice</a>
                      </div>
                    @endif --}}
                  </div>
                </div>
                <div class="col-sm-12 col-md-2">
                  <div class="ek_group"><button type="submit" id="saveButton1" onclick="validateForm1(event)" class="btn btn-login btnekomn card_f_btn"
                    {{ $productReview->order_invoice ? 'disabled' : '' }}>
                    Upload
                  </button>
                  </div>
                </div> 
                @if($productReview->order_invoice)
                  @if(!$productReview->requestor_confirmation)
                    <h6 class="text-danger pt-2">Please wait for the confirmation of your Order Details.</h6>
                  @else
                    <h6 class="text-primary pt-2">Your Order Details Confirmed.</h6>
                  @endif
                @endif   
                @if($productReview->requestor_comment)
                <div class="col-sm-12 col-md-12 mt-3">
                  <div class="ek_group">
                    <label class="eklabel req"><span>Confirmation Massage:</span></label>
                    <div class="ek_f_input">
                      <textarea class="form-control" placeholder="Write your comment." disabled>{{ $productReview->requestor_comment }}</textarea>
                      <span class="text-danger hide" id="requestor_commentError">Comment is required.</span>
                    </div>
                  </div>
                </div>
                @endif 
              </div>
            </div>
            <div class="imagecontainer" id="imagecontainerVariation-1">
              @if($productReview->requestor_comment)
                @if(!$productReview->feedback_comment)
                  <h6 class="text-danger pt-2">Now Complete your Acknowledgment of Shine Completion Below.</h6>
                @endif
              @endif 
            @if($productReview->requestor_comment)
            <div class="row pt-1">
                <div class="col-sm-12 col-md-12">
                    <h6 class="bold">Acknowledgment of Shine Completion :</h6>
                    <div class="ek_group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="checkbox2" {{ $productReview->feedback_comment ? 'checked disabled' : '' }}>
                            <label class="form-check-label" for="checkbox2">
                                I have purchased the product, provided a review, and completed the Shine request.
                            </label>
                            <span class="text-danger hide" id="checkboxError">Acknowledgment is required.</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-4">
                    <div class="ek_group">
                        <label class="eklabel req"><span>Upload Review Screenshot :</span></label>
                        <div class="d-flex align-items-center justify-content-between ms-2">
                          <input type="file" id="orderScreenshots" style="display: none;" onchange="updateFileNameAndDisableButton(this, 'ScreenshotsButton')" />
                          <button type="button" class="btn btn-light border" id="ScreenshotsButton" onclick="document.getElementById('orderScreenshots').click();" {{ $productReview->screenshots ? 'disabled' : '' }}>
                              {{ $productReview->screenshots ? 'Screenshots.' . pathinfo($productReview->screenshots, PATHINFO_EXTENSION) : 'Select file' }}
                          </button>              
                            <span class="text-danger hide" id="orderScreenshotsError">Review screenshot is required.</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-8">
                    <div class="ek_group">
                        <label class="eklabel req"><span>Any Other Comments :</span></label>
                        <div class="ek_f_input">
                            <textarea class="form-control" id="feedback_comment" placeholder="Share your feedback comment or review on this order." {{ $productReview->feedback_comment ? 'disabled' : '' }}>{{ $productReview->feedback_comment }}</textarea>
                            <span class="text-danger hide" id="feedback_commentError">Comments are required.</span>
                        </div>
                    </div>
                </div>
            </div>
            @endif 
            @if(($productReview->feedback_comment)AND(!$productReview->requestor_confirmation_complition))
              <h6 class="text-primary pt-2">You have completed Acknowledgment of Shine successfully. Now wait for the confirmation</h6>
            @endif
            @if(($productReview->requestor_confirmation_complition))
              <h6 class="text-primary pt-2">Congratulations...! You have completed your shine request.</h6>
            @endif
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
            <div class="saveform_footer">
                <button type="button" class="btn btn-login btnekomn card_f_btn previous_Tab" id="cancelButton">
                    <i class="fas fa-arrow-left me-3 fs-13"></i>Back
                </button>
                <button type="submit" id="saveButton2" onclick="validateForm2(event)" class="btn btn-login btnekomn card_f_btn next_Tab"
                  {{ $productReview->feedback_comment && $productReview->shine_product_id ? 'disabled' : '' }} >
                  Submit
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
<script type="text/javascript" src="assets/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="assets/js/ek.common.js"></script>
<script>
    // Go Back
    document.getElementById('cancelButton').addEventListener('click', function() {
      window.location.href = "{{ route('my-shine') }}?tab=live-shine";
    });
    document.getElementById('order_invoice').addEventListener('change', function() {
        document.getElementById('invoicefilename').textContent = this.files[0].name;
    });
    document.getElementById('review_screenshot').addEventListener('change', function() {
        document.getElementById('screenshotfilename').textContent = this.files[0].name;
    });


    function updateFileNameAndDisableButton(input, buttonId) {
    const fileName = input.files[0].name;
    const fileExtension = fileName.split('.').pop();
    const button = document.getElementById(buttonId);
    button.textContent = buttonId.charAt(0).toUpperCase() + buttonId.slice(1, -6) + '.' + fileExtension;
    button.disabled = true;
  }



// Form1 Validation
function validateForm1(event) {
  event.preventDefault();
  let isValid = true;

  const orderNumber = $('#orderNumber').val();
  const orderInvoice = $('#orderInvoice')[0].files[0];

  if (!orderNumber) {
    $('#orderNumberError').removeClass('hide');
    isValid = false;
  } else {
    $('#orderNumberError').addClass('hide');
  }

  if (!orderInvoice) {
    $('#orderInvoiceError').removeClass('hide');
    isValid = false;
  } else {
    $('#orderInvoiceError').addClass('hide');
  }

  if (isValid) {
    const formData = new FormData();
    formData.append('order_number', orderNumber);
    formData.append('order_invoice', orderInvoice);
    formData.append('_method', 'PUT'); // Laravel requires this for PUT method
    formData.append('_token', '{{ csrf_token() }}');

    $.ajax({
      url: `/shine-product-reviews1/${$('#productId').val()}`,
      type: 'POST', // Use POST for method override
      data: formData,
      contentType: false,
      processData: false,
      success: function(response) {
        Swal.fire({
            title: 'Success',
            text: 'Details updated successfully.',
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
            text: 'Please upload PDF, JPG, or PNG files while updating the details.',
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


function validateForm2(event) {
    event.preventDefault();
    let isValid = true;

    const checkbox = $('#checkbox2').is(':checked');
    const orderScreenshots = $('#orderScreenshots')[0].files[0];
    const feedback_comment = $('#feedback_comment').val();

    // Validate checkbox
    if (!checkbox) {
        $('#checkboxError').removeClass('hide');
        isValid = false;
    } else {
        $('#checkboxError').addClass('hide');
    }

    // Validate orderScreenshots
    if (!orderScreenshots) {
        $('#orderScreenshotsError').removeClass('hide');
        isValid = false;
    } else {
        $('#orderScreenshotsError').addClass('hide');
    }

    // Validate comments
    if (!feedback_comment.trim()) {
        $('#feedback_commentError').removeClass('hide');
        isValid = false;
    } else {
        $('#feedback_commentError').addClass('hide');
    }

    if (isValid) {
        const formData = new FormData();
        formData.append('screenshots', orderScreenshots);
        formData.append('feedback_comment', feedback_comment);
        formData.append('acknowledgment', checkbox ? 1 : 0);
        formData.append('_method', 'PUT'); // Laravel requires this for PUT method
        formData.append('_token', '{{ csrf_token() }}');

        $.ajax({
            url: `/shine-product-reviews3/${$('#productId').val()}`,
            type: 'POST', // Use POST for method override
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
            Swal.fire({
              title: 'Success',
              text: 'Acknowledgment of Shine Completion updated successfully.',
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
              text: 'Please upload valid files (pdf, jpg, png) while updating the details.',
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


///////////////////// Form Submition //////////////////////////////////////////////////////////////////


</script>
@endsection
