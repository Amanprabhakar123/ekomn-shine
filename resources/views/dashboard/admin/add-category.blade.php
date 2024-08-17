@extends('dashboard.layout.app')

@section('content')
    <div class="ek_dashboard">
        <div class="ek_content">
            <div class="card ekcard pa shadow-sm">
                <div class="cardhead">
                    <h3 class="cardtitle">Add Categories Tree listing</h3>
                </div>

                <div class="row" id="">
                    <div class="col-md-6">
                        <div class="ek_f_input">
                            <label for="category">Category Tree</label>
                            <select class="form-select" id="categoryTree">
                                <option value="" selected>Select Category</option>
                                <option value="0">Parent Category</option>
                                <option value="1"> Sub Category</option>
                                <option value="2"> Child Category</option>
                                <option value="3"> Keyword</option>
                            </select>
                            <div id="categoryErr" class="invalid-feedback">dsfdsa</div>
                        </div>
                    </div>
                </div>

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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>


document.getElementById('categoryTree').addEventListener('change', function(){
    document.getElementById('categories').innerHTML = "";
    var html = '';
    if($('#categoryTree').val()==''){
        document.getElementById('categories').innerHTML = "";
    }else if($('#categoryTree').val() == 0){
        html +=` 
       <div class="col-md-6 mt-3">
                        <div class="ek_f_input">
                            <label for="category">Category Name</label>
                            <input type="text" class="form-control" id="categoryName" placeholder="Enter Category Name">
                            <div id="categoryNameErr" class="invalid-feedback"></div>
                        </div>
                    </div>
    <div class="col-md-6 mt-3">
                        <div class="ek_f_input">
                            <label for="category">Sub Category Name</label>
                            <input type="text" class="form-control" id="subCategory" placeholder="Enter Sub Category Name">
                            <div id="subCategoryErr" class="invalid-feedback"></div>
                        </div>
                    </div>

                     <div class="col-md-6 mt-3">
                        <div class="ek_f_input">
                            <label for="category">Child Category Name</label>
                            <input type="text" class="form-control" id="childCategory" placeholder="Enter Child Category Name">
                            <div id="childCategoryErr" class="invalid-feedback"></div>
                        </div>
                    </div>

                      <div class="col-md-6 mt-3">
                        <div class="ek_f_input">
                            <label for="category">Keyword Name</label>
                            <input type="text" class="form-control" id="keywordName" placeholder="Enter keyword Name">
                            <div id="keywordNameErr" class="invalid-feedback"></div>
                        </div>
                    </div>
    `;
        $('#categories').append(html);
    }else if($('#categoryTree').val()==1){
        html +=` 
        <div class="col-md-6 mt-3">
                        <div class="ek_f_input">
                            <label for="category">Category Name</label>
                            <select class="form-select" id="categoryName">
                                <option value="" selected>Select Category Name</option>
                            </select>
                            <div id="categoryNameErr" class="invalid-feedback"></div>
                        </div>
                    </div>
    <div class="col-md-6 mt-3">
                        <div class="ek_f_input">
                            <label for="category">Sub Category Name</label>
                            <input type="text" class="form-control" id="subCategory" placeholder="Enter Sub Category Name">
                            <div id="subCategoryErr" class="invalid-feedback"></div>
                        </div>
                    </div>

                     <div class="col-md-6 mt-3">
                        <div class="ek_f_input">
                            <label for="category">Child Category Name</label>
                            <input type="text" class="form-control" id="childCategory" placeholder="Enter Child Category Name">
                            <div id="childCategoryErr" class="invalid-feedback"></div>
                        </div>
                    </div>

                      <div class="col-md-6 mt-3">
                        <div class="ek_f_input">
                            <label for="category">Keyword Name</label>
                            <input type="text" class="form-control" id="keywordName" placeholder="Enter keyword Name">
                            <div id="keywordNameErr" class="invalid-feedback"></div>
                        </div>
                    </div>
    `;
                $('#categories').append(html);
                ApiRequest('get-category?type=banner', 'GET')
                            .then((res) => {
                                if (res.data.statusCode == 200) {
                                    let data = res.data.data;
                                    let options = data.map(item => {
                                    return {
                                        id: item.id,
                                        text: item.name
                                    };
                                });

                                $('#categoryName').select2({
                                    data: options,
                                    placeholder: 'Select a category',
                                    allowClear: true
                                });
                                    
                                }
                            })
                            .catch((err) => {
                                console.log(err);
                            });
    }else if($('#categoryTree').val()==2){
        html +=` 
        <div class="col-md-6 mt-3">
                        <div class="ek_f_input">
                            <label for="category">Category name</label>
                            <select class="form-select" id="categoryName">
                                <option value="" selected>Select Category</option>
                            </select>
                            <div id="categoryNameErr" class="invalid-feedback"></div>
                        </div>
                    </div>
    
  <div class="col-md-6 mt-3">
                        <div class="ek_f_input">
                            <label for="category">Sub Category name</label>
                            <select class="form-select" id="subCategory">
                                <option value="" selected>Select Category</option>
                            </select>
                            <div id="subCategoryErr" class="invalid-feedback"></div>
                        </div>
                    </div>
                  
                   
                       <div class="col-md-6 mt-3">
                        <div class="ek_f_input">
                            <label for="category">Child Category Name</label>
                            <input type="text" class="form-control" id="childCategory" placeholder="Enter Child Category Name">
                            <div id="childCategoryErr" class="invalid-feedback"></div>
                        </div>
                    </div>

                      <div class="col-md-6 mt-3">
                        <div class="ek_f_input">
                            <label for="category">Keyword Name</label>
                            <input type="text" class="form-control" id="keywordName" placeholder="Enter keyword Name">
                            <div id="keywordNameErr" class="invalid-feedback"></div>
                        </div>
                    </div>
    `;
        $('#categories').append(html);
        ApiRequest('get-category?type=banner', 'GET')
                            .then((res) => {
                                if (res.data.statusCode == 200) {
                                    let data = res.data.data;
                                    $.each(data, function(index, category) {
                                        var options = [
                                            { id: category.id, text: category.name }
                                        ];
                                        
                                        $('#categoryName').select2({
                                            data: options,
                                            placeholder: 'Select a category',
                                            allowClear: true
                                        });

                            });
                                }
                            })
                            .catch((err) => {
                                console.log(err);
                            });

                            $('#categoryName').on('change', function() {
                                var categoryId = $(this).val();
                                $('#subCategory').empty();
                                ApiRequest('get-category?type=sub-category&category_id=' + categoryId, 'GET')
                                    .then((res) => {
                                        if (res.data.statusCode == 200) {
                                            let data = res.data.data;
                                            // console.log(data);
                                            let options = data.map(item => {
                                                return {
                                                    id: item.id,
                                                    text: item.name
                                                };
                                            });

                                            $('#subCategory').select2({
                                                data: options,
                                                placeholder: 'Select a category',
                                                allowClear: true
                                            });
                                        }
                                    })
                                    .catch((err) => {
                                        console.log(err);
                                    });
                            });


                           
    }else if($('#categoryTree').val()==3){

        html +=` 
        <div class="col-md-6 mt-3">
                        <div class="ek_f_input">
                            <label for="category">Category name</label>
                            <select class="form-select" id="categoryName">
                                <option value="" selected>Select Category</option>
                                
                            </select>
                            <div id="categoryNameErr" class="invalid-feedback"></div>
                        </div>
                    </div>
    

                   <div class="col-md-6 mt-3">
                        <div class="ek_f_input">
                            <label for="category">Sub Category name</label>
                            <select class="form-select" id="subCategory">
                            </select>
                            <div id="subCategoryErr" class="invalid-feedback"></div>
                        </div>
                    </div>
                   
                   <div class="col-md-6 mt-3">
                        <div class="ek_f_input">
                            <label for="category">Child Category</label>
                            <select class="form-select" id="childCategory">
                            </select>
                            <div id="childCategoryErr" class="invalid-feedback"></div>
                        </div>
                    </div>
 
                      <div class="col-md-6 mt-3">
                        <div class="ek_f_input">
                            <label for="category">Keyword Name</label>
                            <input type="text" class="form-control" id="keywordName" placeholder="Enter keyword Name">
                            <div id="keywordNameErr" class="invalid-feedback"></div>
                        </div>
                    </div>
    `;
        $('#categories').append(html);
        
        ApiRequest('get-category?type=banner', 'GET')
                            .then((res) => {
                                if (res.data.statusCode == 200) {
                                    let data = res.data.data;
                                    $.each(data, function(index, category) {
                                        var options = [
                                            { id: category.id, text: category.name }
                                        ];
                                        
                                        $('#categoryName').select2({
                                            data: options,
                                            placeholder: 'Select a category',
                                            allowClear: true
                                        });

                            });
                                }
                            })
                            .catch((err) => {
                                console.log(err);
                            });

                            $('#categoryName').on('change', function() {
                                var categoryId = $(this).val();
                                $('#subCategory').empty();
                                $('#childCategory').empty();
                                ApiRequest('get-category?type=sub-category&category_id=' + categoryId, 'GET')
                                    .then((res) => {
                                        if (res.data.statusCode == 200) {
                                            let data = res.data.data;
                                            let options = data.map(item => {
                                                console.log(item);
                                                return {
                                                    id: item.id,
                                                    text: item.name
                                                };
                                            });

                                            $('#subCategory').select2({
                                                data: options,
                                                placeholder: 'Select a category',
                                                allowClear: true
                                            });
                                        }
                                    })
                                    .catch((err) => {
                                        console.log(err);
                                    });
                            });

                            $('#subCategory').on('change', function() {
                                var categoryId = $(this).val();
                                $('#childCategory').empty();
                                ApiRequest('get-category?type=child-category&category_id=' + categoryId, 'GET')
                                    .then((res) => {
                                        if (res.data.statusCode == 200) {
                                            let data = res.data.data;
                                            let options = data.map(item => {
                                                return {
                                                    id: item.id,
                                                    text: item.name
                                                };
                                            });

                                            $('#childCategory').select2({
                                                data: options,
                                                placeholder: 'Select a category',
                                                allowClear: true
                                            });
                                        }
                                    })
                                    .catch((err) => {
                                        console.log(err);
                                    });
                            });
                           
    }

    
})

document.getElementById('btnSubmit').addEventListener('click', function(){
    var isValid = true;

    if (!$('#categoryTree').val()) {
        $('#categoryTree').addClass('is-invalid');
        $('#categoryErr').text('Category Tree is required');
        isValid = false;
    } else {
        $('#categoryTree').removeClass('is-invalid');
        $('#categoryErr').html('');
    }

    if ($('#categoryName').val() == '') {
        $('#categoryName').addClass('is-invalid');
        $('#categoryNameErr').text('Category Name is required');
        isValid = false;
    } else {
        $('#categoryName').removeClass('is-invalid');
        $('#categoryNameErr').text('');
    }

    if ($('#subCategory').val() == '') {
        $('#subCategory').addClass('is-invalid');
        $('#subCategoryErr').text('Sub Category is required');
        isValid = false;
    } else {
        $('#subCategory').removeClass('is-invalid');
        $('#subCategoryErr').text('');
    }

    if ($('#childCategory').val() == '') {
        $('#childCategory').addClass('is-invalid');
        $('#childCategoryErr').text('Child Category is required');
        isValid = false;
    } else {
        $('#childCategory').removeClass('is-invalid');
        $('#childCategoryErr').text('');
    }

    if ($('#keywordName').val() == '') {
        $('#keywordName').addClass('is-invalid');
        $('#keywordNameErr').text('Keyword Name is required');
        isValid = false;
    } else {
        $('#keywordName').removeClass('is-invalid');
        $('#keywordNameErr').text('');
    }

    if (isValid) {
    
    var categoryTree = $('#categoryTree').val();
    var categoryName = $('#categoryName').val();
    var subCategory = $('#subCategory').val();
    var childCategory = $('#childCategory').val();
    var keywordName = $('#keywordName').val();

    
    var data = {
        categoryTree: categoryTree,
        categoryName: categoryName,
        keywordName: keywordName,
        subCategory: subCategory,
        childCategory: childCategory
    }
    ApiRequest('add-categories', 'POST', data)
        .then((res) => {
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