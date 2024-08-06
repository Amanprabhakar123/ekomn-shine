@extends('dashboard.layout.app')

@section('content')
<div class="ek_dashboard">
    <div class="ek_content">
        <div class="card ekcard pa shadow-sm">
            <div class="cardhead">
                <h3 class="cardtitle">Categories by listing</h3>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="ek_f_input">
                        <label for="category">Category</label>
                        <select class="form-select" class="state" id="category">
                            <option value="" selected>Select State</option>
                        </select>
                        <div id="stateErr" class="invalid-feedback"></div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="ek_f_input">
                        <label for="category">Category of Number</label>
                        <select class="form-select" class="number" id="number">
                            <option value="" selected>Select State</option>
                        </select>
                        <div id="stateErr" class="invalid-feedback"></div>
                    </div>
                </div>


                <div class="col-md-4">
                    <div class="ek_f_input">
                        <label for="category">Category by</label>
                        <select class="form-select" class="" id="categoryBy">
                            <option value="" selected>Select State</option>
                        </select>
                        <div id="stateErr" class="invalid-feedback"></div>
                    </div>
                </div>
         
            </div>

            <div class="saveform_footer text-right single-button">
              <button type="button" id="btnSubmit" class="btn btn-login btnekomn card_f_btn" id="generaltab">Submit</button>
            </div>
        </div>
       
    </div>
    @include('dashboard.layout.copyright')
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        ApiRequest('get-category', 'GET')
        .then((res) => {
            if (res.data.statusCode == 200) {
                let data = res.data.data;
                let options = data.map(item => {
                    return {
                        id: item.id,
                        text: item.name
                    };
                });

                // Initialize Select2 with options
                $('#category').select2({
                    data: options,
                    placeholder: 'Select a category',
                    allowClear: true
                });
            }
        })
        .catch((err) => {
            console.log(err);
        });
      

        var numberCategory = [1, 2, 3, 4, 5, 6];
       numberCategory.forEach((item) => {
            $('#number').append(`<option value="${item}">${item}</option>`);
        });
        
        $('#category').on('change', function() {
            var formData = new FormData();

            formData.append('category', $('#category').val());

            ApiRequest('find-category', 'POST', formData)
            .then((res) => {
                if (res.data.statusCode == 200) {
                    let data = res.data.data;
                    console.log(data);
                    let options = data.map(item => {
                        console.log(item);
                        return {
                            id: item.id,
                            text: item.title
                        };
                    });

                    // Initialize Select2 with options
                    $('#categoryBy').select2({
                        data: options,
                        placeholder: 'Select a category',
                        allowClear: true
                    });
                }
            })
            
        });

        $('#btnSubmit').on('click', function() {

            var formData = new FormData();
            var number = $('#number').val();
            var categoryBy = $('#categoryBy').val();
            formData.append('number', number);
            formData.append('categoryBy', categoryBy);

            ApiRequest('find-product', 'POST', formData)
            .then((res) => {
                if (res.data.statusCode == 200) {
                    let data = res.data.data;
                    console.log(data);
                }
            })
        });

    });
    

</script>
@endsection