@extends('dashboard.layout.app')

@section('content')
<div class="ek_dashboard">
    <div class="ek_content">
        <div class="card ekcard pa shadow-sm">
            <div class="cardhead">
                <h3 class="cardtitle">Create Sub Admin Account </h3>
                <!-- <a href="" class="btn btnekomn btn-sm"><i class="fas fa-plus fs-12 me-1"></i>Add New Admin</a> -->
            </div>

            <form id="subAdmin">
                <div class="row">
                    <div class="col-md-6">
                        <div class="ek_group">
                            <label class="eklabel req">Name:</label>
                            <div class="ek_f_input">
                                <input type="text" id="name" name="name" class="form-control userico" placeholder="name" />
                                <div id="nameErr" class="invalid-feedback"></div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="ek_group">
                            <label class="eklabel req">Email:</label>
                            <div class="ek_f_input">
                                <input type="text" id="email" name="email" class="form-control userico" placeholder="Email Address" />
                                <div id="emailErr" class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="ek_group">
                            <label class="eklabel req">Password:</label>
                            <div class="ek_f_input">
                                <input type="password" id="password" name="password" class="form-control pwdico" placeholder="Password" />
                                <div id="passwordErr" class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="ek_group">
                            <label class="eklabel req">Re-enter Password:</label>
                            <div class="ek_f_input">
                                <input type="password" id="repassword" name="repassword" class="form-control pwdico" placeholder="Re-enter Password" />
                                <div id="repasswordErr" class="invalid-feedback"></div>
                            </div>
                        </div>

                    </div>
                </div>
                 <div class="form-group">
                    <h3 class="line_h mt-3">Select Permission<span class="line"></span></h3>
                    <div class="row mt-3">
                        @foreach($permissions as $key => $value)
                        <div class="col-md-3">
                            <div class="form-check">
                                <input type="checkbox" id="checkbox-{{$loop->index}}" name="{{ $key }}" class="form-check-input" />
                                <label for="checkbox-{{$loop->index}}" class="form-check-label">{{ $value }}</label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="saveform_footer text-right">
                    <button id="submit" class="btn btn-login btnekomn card_f_btn px-4" type="submit">Submit</button>
                </div>
            </form>
        </div>


    </div>
</div>
@include('dashboard.layout.copyright')
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $('#subAdmin').on('submit', function(e) {
        e.preventDefault();
        var isValid = true;
        var name = $('#name').val();
        var email = $('#email').val();
        var password = $('#password').val();
        var repassword = $('#repassword').val();
        var permissions = [];

        if(name == '') {
            $('#name').addClass('is-invalid');
            $('#nameErr').html('Name is required');
            isValid = false;
        } else {
            $('#name').removeClass('is-invalid');
            $('#nameErr').html('');
        }
        
        if(email == '') {
            $('#email').addClass('is-invalid');
            $('#emailErr').html('Email is required');
            isValid = false;
        } else {
            $('#email').removeClass('is-invalid');
            $('#emailErr').html('');
        }

        if(password == '') {
            $('#password').addClass('is-invalid');
            $('#passwordErr').html('Password is required');
            isValid = false;
        } else {
            $('#password').removeClass('is-invalid');
            $('#passwordErr').html('');
        }   

        if(repassword == '') {
            $('#repassword').addClass('is-invalid');
            $('#repasswordErr').html('Re-enter password is required');
            isValid = false;
        } else if(password != repassword) {
            $('#repassword').addClass('is-invalid');
            $('#repasswordErr').html('Password does not match');
            isValid = false;
        } else {
            $('#repassword').removeClass('is-invalid');
            $('#repasswordErr').html('');
        }

        // if(password != repassword) {
        //     $('#repassword').addClass('is-invalid');
        //     $('#repasswordErr').html('Password does not match');
        //     isValid = false;
        // } else {
        //     $('#repassword').removeClass('is-invalid');
        //     $('#repasswordErr').html('');
        // }


        $('input[type=checkbox]').each(function() {
            if ($(this).is(':checked')) {
                permissions.push($(this).attr('name'));
            }
        });

        if(permissions.length == 0) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please select at least one permission',
            });
            isValid = false;
        }

        let formData = new FormData();
        if(isValid) {
            formData.append('name', name);
            formData.append('email', email);
            formData.append('password', password);
            formData.append('password_confirmation', repassword);
            formData.append('permissions', permissions);
        }

        if(isValid) {
            ApiRequest('sub-admin-store',  'POST', formData)
                .then(response => {
                    if(response.data.statusCode == 200) {
                        Swal.fire({
                                    title: "Good job!",
                                    text: response.data.message,
                                    icon: "success",
                                    didOpen: () => {
                                    // Apply inline CSS to the title
                                    const title = Swal.getTitle();
                                    title.style.color = 'red';
                                    title.style.fontSize = '20px';

                                    // Apply inline CSS to the content
                                    const content = Swal.getHtmlContainer();

                                    // Apply inline CSS to the confirm button
                                    const confirmButton = Swal.getConfirmButton();
                                    confirmButton.style.backgroundColor = '#feca40';
                                    confirmButton.style.color = 'white';
                                    }
                                })
                                .then((value) => {
                                    window.location.href = "{{ route('admin.list') }}";
                                });
                    }
                    
                })
            }
    });
</script>

@endsection