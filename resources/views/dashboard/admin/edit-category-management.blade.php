@extends('dashboard.layout.app')

@section('content')
    <div class="ek_dashboard">
        <div class="ek_content">
            <div class="card ekcard pa shadow-sm">
                <div class="cardhead">
                    <h3 class="cardtitle">Add Categories Tree listing</h3>
                </div>
                @if($depth == 0)
                <div class="col-md-6 mt-3">
                        <div class="ek_f_input">
                            <label for="category">Category Name</label>
                            <input type="text" class="form-control" value="{{$category->name}}" id="{{salt_encrypt($category->id)}}" placeholder="Enter Category Name">
                            <input type="hidden" id="depth" class="depth" value="{{salt_encrypt($category->id)}}">
                            <div id="categoryNameErr" class="invalid-feedback"></div>
                        </div>
                    </div>
                @endif
                @if($depth == 1)
                    <div class="col-md-6 mt-3">
                        <div class="ek_f_input">
                            <label for="category">Sub Category Name</label>
                            <input type="text" class="form-control" id="{{salt_encrypt($category->id)}}" value="{{$category->name}}" placeholder="Enter Sub Category Name">
                            <input type="hidden" id="depth" class="depth" value="{{salt_encrypt($category->id)}}">
                            <div id="subCategoryErr" class="invalid-feedback"></div>
                        </div>
                    </div>
                @endif
                @if($depth == 2)

                     <div class="col-md-6 mt-3">
                        <div class="ek_f_input">
                            <label for="category">Child Category Name</label>
                            <input type="text" class="form-control" id="{{salt_encrypt($category->id)}}"value="{{$category->name}}" placeholder="Enter Child Category Name">
                            <input type="hidden" id="depth" class="depth" value="{{salt_encrypt($category->id)}}">
                            <div id="childCategoryErr" class="invalid-feedback"></div>
                        </div>
                    </div>
                @endif
                @if($depth == 3)

                      <div class="col-md-6 mt-3">
                        <div class="ek_f_input">
                            <label for="category">Keyword Name</label>
                            <input type="text" class="form-control" id="{{salt_encrypt($category->id)}}" value="{{$category->name}}" placeholder="Enter keyword Name">
                            <input type="hidden" id="depth" class="depth" value="{{salt_encrypt($category->id)}}">
                            <div id="keywordNameErr" class="invalid-feedback"></div>
                        </div>
                    </div>
                @endif

                    <div class="row" id="categories">
                    </div>

                <div class="saveform_footer text-right single-button">
                    <button type="button" id="btnSubmit" class="btn btn-login btnekomn card_f_btn"
                        id="generaltab">Submit</button>
                </div>

            
            </div>

        </div>
        @include('dashboard.layout.copyright')
    </div>
@endsection

@section('scripts')
<!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

      

document.getElementById('btnSubmit').addEventListener('click', function(){
    var isValid = true;
    if(!$('.form-control').val()){
        $('.form-control').addClass('is-invalid');
        $('.invalid-feedback').html('This field is required');
        isValid = false;
    }else{
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').html('');
    }

    if (isValid) {
        var formData = new FormData();
        var category = $('.form-control').val();
        var depth = $('#depth').val();

        formData.append('category', category);
        formData.append('id', depth);

    ApiRequest('update-category', 'POST', formData)
        .then((res) => {
            console.log(res);
            if (res.data.statusCode == 200) {
                Swal.fire({
                                    title: 'Success',
                                    icon: "success",
                                    text: res.data.message,
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
                                }).then(() => {
                                    window.location.href = `{{ route('category.management') }}`;
                                });
            }
        })
        .catch((err) => {
            console.log(err);
        });
    }
});

               
</script>

@endsection