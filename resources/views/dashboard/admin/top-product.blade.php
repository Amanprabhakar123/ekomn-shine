@extends('dashboard.layout.app')

@section('content')
<div class="ek_dashboard">
    <div class="ek_content">
        <div class="card ekcard pa shadow-sm">
            <div class="cardhead">
                <h3 class="cardtitle">Product by type</h3>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="ek_f_input">
                        <label for="category">Prodcut title</label>
                        <select class="form-select" class="state" id="product-title">
                            <option value="" selected>Select State</option>
                        </select>
                        <div id="stateErr" class="invalid-feedback"></div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="ek_f_input">
                        <label for="category">Product type</label>
                        <select class="form-select" class="number" id="product-type">
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
        ApiRequest('get-top-product', 'GET')
        .then((res) => {
            if (res.data.statusCode == 200) {
                let data = res.data.data;
                let typePorduct = res.data.typeProduct;
                let entries = Object.entries(typePorduct);
                let options = data.map(item => {
                    return {
                        id: item.id,
                        text: item.title
                    };
                });
                
                // Initialize Select2 with options
                $('#product-title').select2({
                    data: options,
                    placeholder: 'Select a category',
                    allowClear: true
                });

               
                let keyValue = entries.map(([key, value]) => {
                    console.log(key, value);
                    return {
                        id: key,
                        text: value
                    };
                });
                

                 // Initialize Select2 with options
                 $('#product-type').select2({
                    data: keyValue,
                    placeholder: 'Select a category',
                    allowClear: true
                });
            }
        })
        .catch((err) => {
            console.log(err);
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