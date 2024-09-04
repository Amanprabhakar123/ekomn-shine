@extends('dashboard.layout.app')

@section('content')
<div class="ek_dashboard">
    <div class="ek_content">
        <div class="card ekcard pa shadow-sm">
            <div class="cardhead">
                <h3 class="cardtitle">Update Plans</h3>
            </div>
            <section class="sectionspace mt-5">
                
                <div class="row">
                  <div class="col-sm-12 col-md-4">
                    <div class="ek_group">
                      <label class="eklabel req">
                        <span>Name:<span class="req_star">*</span></span>
                      </label>
                      <div class="ek_f_input">
                        <input type="hidden" id="id" value="{{salt_encrypt($plan->id)}}" />
                        <input type="text" class="form-control" id="name" value="{{$plan->name}}" placeholder="Enter Plan Name" />
                        <div id="nameErr" class="invalid-feedback"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4">
                    <div class="ek_group">
                      <label class="eklabel req"><span>Description:</span></label>
                      <div class="ek_f_input">
                        <input type="text" id="description" class="form-control" value="{{$plan->description}}"  placeholder="Description" />
                        <div id="descriptionErr" class="invalid-feedback"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4">
                    <div class="ek_group">
                      <label class="eklabel req">
                        <span>Price:<span class="req_star">*</span></span>
                      </label>
                      <div class="ek_f_input">
                        <input type="text" id="price"  class="form-control" value="{{$plan->price}}"  placeholder="Price" />
                        <div id="priceErr" class="invalid-feedback"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4">
                    <div class="ek_group">
                      <label class="eklabel req">
                        <span>gst:<span class="req_star">*</span></span>
                      </label>
                      <div class="ek_f_input">
                        <input type="text" id="gst"  class="form-control" value="{{$plan->gst}}"  placeholder="Gst" />
                        <div id="gstErr" class="invalid-feedback"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4">
                    <div class="ek_group">
                      <label class="eklabel req">
                        <span>Hsn:<span class="req_star">*</span></span>
                      </label>
                      <div class="ek_f_input">
                        <input type="text" id="hsn"  class="form-control" value="{{$plan->hsn}}"  placeholder="Hsn" />
                        <div id="hsnErr" class="invalid-feedback"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4">
                    <div class="ek_group">
                      <label class="eklabel req">
                        <span>Duration:</span>
                      </label>
                      <div class="ek_f_input">
                        <input type="text" id="duration"  class="form-control" value="{{$plan->duration}}"  placeholder="Duration" />
                        <div id="durationErr" class="invalid-feedback"></div>
                      </div>
                    </div>
                  </div>
                  @foreach(json_decode($plan->features,  true) as $key => $value)
                  <div class="col-sm-12 col-md-4">
                    <div class="ek_group">
                      <label class="eklabel req">
                        <span>{{ucwords(str_replace('_', ' ', $key))}}:<span class="req_star">*</span></span>
                      </label>
                      <div class="ek_f_input">
                        @if(gettype($value) == 'integer')
                        <input type="text" id="{{$key}}"  class="form-control" name = "{{$key}}" value="{{$value}}" />
                        <div id="{{$key}}Err" class="invalid-feedback"></div>
                        @elseif(gettype($value) == 'boolean')
                        <select id="{{$key}}" class="form-select" name="{{$key}}">
                          <option value="1" {{$value ? 'selected' : ''}}>True</option>
                          <option value="0" {{$value ? '' : 'selected'}}>False</option>
                        </select>
                        <div id="{{$key}}Err" class="invalid-feedback"></div>
                        @endif
                      </div>
                    </div>
                  </div>
                @endforeach
                </div>
              </section>
              <div class="saveform_footer text-right">
                    <button id="submit" class="btn btn-login btnekomn card_f_btn px-4" type="submit">Submit</button>
                </div>
        </div>
    </div>
    @include('dashboard.layout.copyright')
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#submit').click(function() {
            var isValid = true;
            var formData = new FormData();
            if ($('#name').val() == '') {
                $('#name').addClass('is-invalid');
                $('#nameErr').html('Please enter plan name');
                isValid = false;
            } else {
                $('#name').removeClass('is-invalid');
                $('#nameErr').html('');
            }

            if ($('#description').val() == '') {
                $('#description').addClass('is-invalid');
                $('#descriptionErr').html('Please enter description');
                isValid = false;
            } else {
                $('#description').removeClass('is-invalid');
                $('#descriptionErr').html('');
            }

            if ($('#price').val() == '') {
                $('#price').addClass('is-invalid');
                $('#priceErr').html('Please enter price');
                isValid = false;
            } else {
                $('#price').removeClass('is-invalid');
                $('#priceErr').html('');
            }

            if ($('#gst').val() == '') {
                $('#gst').addClass('is-invalid');
                $('#gstErr').html('Please enter gst');
                isValid = false;
            } else {
                $('#gst').removeClass('is-invalid');
                $('#gstErr').html('');
            }

            if ($('#hsn').val() == '') {
                $('#hsn').addClass('is-invalid');
                $('#hsnErr').html('Please enter hsn');
                isValid = false;
            } else {
                $('#hsn').removeClass('is-invalid');
                $('#hsnErr').html('');
            }

            if ($('#duration').val() == '') {
                $('#duration').addClass('is-invalid');
                $('#durationErr').html('Please enter duration');
                isValid = false;
            } else {
                $('#duration').removeClass('is-invalid');
                $('#durationErr').html('');
            }

            @foreach(json_decode($plan->features,  true) as $key => $value)
             if ($('#{{$key}}').val() == '') {
                $('#{{$key}}').addClass('is-invalid');
                $('#{{$key}}Err').html("Please enter {{ucwords(str_replace('_', ' ', $key))}}");
                isValid = false;
            } else {
                $('#{{$key}}').removeClass('is-invalid');
                $('#{{$key}}Err').html('');
                formData.append('{{$key}}', $('#{{$key}}').val());
            }
            @endforeach

            if (isValid) {
                formData.append('name', $('#name').val());
                formData.append('description', $('#description').val());
                formData.append('price', $('#price').val());
                formData.append('gst', $('#gst').val());
                formData.append('hsn', $('#hsn').val());
                formData.append('duration', $('#duration').val());
                // formData.append('feature', $('#feature').val());
                formData.append('id', $('#id').val());
                
                ApiRequest('update-plan', 'POST', formData)
                .then(res => {
                    if (res.data.statusCode == '200') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: res.data.message,
                            confirmButtonColor: '#ffb20c',
                          
                        }).then(() => {
                            window.location.href = "{{ route('admin.plan.view') }}";
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: res.message,
                        });
                    }
                });

            }
        });
    }); 
</script>
@endsection