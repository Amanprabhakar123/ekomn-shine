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
                                <option value="3"> Keyowrd</option>
                            </select>
                            <div id="categoryErr" class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>

                    <div class="row" id="categories">

                    <!-- <div class="col-md-6">
                        <div class="ek_f_input">
                            <label for="category">Category Name</label>
                            <input type="text" class="form-control" id="categoryName" placeholder="Enter Category Name">
                            <div id="priorityErr" class="invalid-feedback"></div>
                        </div>
                    </div>

                    <div class="col-md-6 mt-3">
                        <div class="ek_f_input">
                            <label for="category">Sub Category</label>
                            <select class="form-select" id="subCategory">
                                <option value="" selected>Select Category</option>
                                <option value="1"> Sub Category</option>
                            </select>
                            <div id="categoryErr" class="invalid-feedback"></div>
                        </div>
                    </div>

                    <div class="col-md-6 mt-3">
                        <div class="ek_f_input">
                            <label for="category">Sub Category Name</label>
                            <input type="text" class="form-control" id="subCategoryName" placeholder="Enter Sub Category Name">
                            <div id="priorityErr" class="invalid-feedback"></div>
                        </div>
                    </div>

                    <div class="col-md-6 mt-3">
                        <div class="ek_f_input">
                            <label for="category">Child Category</label>
                            <select class="form-select" id="childCategory">
                                <option value="" selected>Select Category</option>
                                <option value="2"> Child Category</option>
                            </select>
                            <div id="categoryErr" class="invalid-feedback"></div>
                        </div>
                    </div>

                    <div class="col-md-6 mt-3">
                        <div class="ek_f_input">
                            <label for="category">Child Category Name</label>
                            <input type="text" class="form-control" id="childCategoryName" placeholder="Enter Child Category Name">
                            <div id="priorityErr" class="invalid-feedback"></div>
                        </div>
                    </div>

                    <div class="col-md-6 mt-3">
                        <div class="ek_f_input">
                            <label for="category">Keyword</label>
                            <select class="form-select" id="keyword">
                                <option value="" selected>Select Keyword</option>
                                <option value="3"> Keyowrd</option>
                            </select>
                            <div id="categoryErr" class="invalid-feedback"></div>
                        </div>
                    </div>

                    <div class="col-md-6 mt-3">
                        <div class="ek_f_input">
                            <label for="category">Keyword Name</label>
                            <input type="text" class="form-control" id="keywordName" placeholder="Enter keyword Name">
                            <div id="priorityErr" class="invalid-feedback"></div>
                        </div>
                    </div> -->

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

<script>
document.getElementById('categoryTree').addEventListener('change', function(){
    document.getElementById('categories').innerHTML = "";
    var html = '';
    
    if($('#categoryTree').val() == 0){
        html +=` 
       <div class="col-md-6 mt-3">
                        <div class="ek_f_input">
                            <label for="category">Category Name</label>
                            <input type="text" class="form-control" id="categoryName" placeholder="Enter Category Name">
                            <div id="priorityErr" class="invalid-feedback"></div>
                        </div>
                    </div>
    <div class="col-md-6 mt-3">
                        <div class="ek_f_input">
                            <label for="category">Sub Category Name</label>
                            <input type="text" class="form-control" id="subCategoryName" placeholder="Enter Sub Category Name">
                            <div id="priorityErr" class="invalid-feedback"></div>
                        </div>
                    </div>

                     <div class="col-md-6 mt-3">
                        <div class="ek_f_input">
                            <label for="category">Child Category Name</label>
                            <input type="text" class="form-control" id="childCategoryName" placeholder="Enter Child Category Name">
                            <div id="priorityErr" class="invalid-feedback"></div>
                        </div>
                    </div>

                      <div class="col-md-6 mt-3">
                        <div class="ek_f_input">
                            <label for="category">Keyword Name</label>
                            <input type="text" class="form-control" id="keywordName" placeholder="Enter keyword Name">
                            <div id="priorityErr" class="invalid-feedback"></div>
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
                                <option value="1"> Sub Category</option>
                            </select>
                            <div id="categoryErr" class="invalid-feedback"></div>
                        </div>
                    </div>
    <div class="col-md-6 mt-3">
                        <div class="ek_f_input">
                            <label for="category">Sub Category Name</label>
                            <input type="text" class="form-control" id="subCategoryName" placeholder="Enter Sub Category Name">
                            <div id="priorityErr" class="invalid-feedback"></div>
                        </div>
                    </div>

                     <div class="col-md-6 mt-3">
                        <div class="ek_f_input">
                            <label for="category">Child Category Name</label>
                            <input type="text" class="form-control" id="childCategoryName" placeholder="Enter Child Category Name">
                            <div id="priorityErr" class="invalid-feedback"></div>
                        </div>
                    </div>

                      <div class="col-md-6 mt-3">
                        <div class="ek_f_input">
                            <label for="category">Keyword Name</label>
                            <input type="text" class="form-control" id="keywordName" placeholder="Enter keyword Name">
                            <div id="priorityErr" class="invalid-feedback"></div>
                        </div>
                    </div>
    `;
        $('#categories').append(html);
    }else if($('#categoryTree').val()==2){
        html +=` 
        <div class="col-md-6 mt-3">
                        <div class="ek_f_input">
                            <label for="category">Category name</label>
                            <select class="form-select" id="category">
                                <option value="" selected>Select Category</option>
                                <option value="1"> Sub Category</option>
                            </select>
                            <div id="categoryErr" class="invalid-feedback"></div>
                        </div>
                    </div>
    
  <div class="col-md-6 mt-3">
                        <div class="ek_f_input">
                            <label for="category">Sub Category name</label>
                            <select class="form-select" id="subCategory">
                                <option value="" selected>Select Category</option>
                                <option value="1"> Sub Category</option>
                            </select>
                            <div id="categoryErr" class="invalid-feedback"></div>
                        </div>
                    </div>
                  
                   
                       <div class="col-md-6 mt-3">
                        <div class="ek_f_input">
                            <label for="category">Child Category Name</label>
                            <input type="text" class="form-control" id="childCategoryName" placeholder="Enter Child Category Name">
                            <div id="priorityErr" class="invalid-feedback"></div>
                        </div>
                    </div>

                      <div class="col-md-6 mt-3">
                        <div class="ek_f_input">
                            <label for="category">Keyword Name</label>
                            <input type="text" class="form-control" id="keywordName" placeholder="Enter keyword Name">
                            <div id="priorityErr" class="invalid-feedback"></div>
                        </div>
                    </div>
    `;
        $('#categories').append(html);
    }else if($('#categoryTree').val()==3){

        html +=` 
        <div class="col-md-6 mt-3">
                        <div class="ek_f_input">
                            <label for="category">Category name</label>
                            <select class="form-select" id="category">
                                <option value="" selected>Select Category</option>
                                <option value="1"> Sub Category</option>
                            </select>
                            <div id="categoryErr" class="invalid-feedback"></div>
                        </div>
                    </div>
    

                   <div class="col-md-6 mt-3">
                        <div class="ek_f_input">
                            <label for="category">Sub Category name</label>
                            <select class="form-select" id="subCategory">
                                <option value="" selected>Select Category</option>
                                <option value="1"> Sub Category</option>
                            </select>
                            <div id="categoryErr" class="invalid-feedback"></div>
                        </div>
                    </div>
                   
                   <div class="col-md-6 mt-3">
                        <div class="ek_f_input">
                            <label for="category">Child Category</label>
                            <select class="form-select" id="childCategory">
                                <option value="" selected>Select Category</option>
                                <option value="2"> Child Category</option>
                            </select>
                            <div id="categoryErr" class="invalid-feedback"></div>
                        </div>
                    </div>
 
                      <div class="col-md-6 mt-3">
                        <div class="ek_f_input">
                            <label for="category">Keyword Name</label>
                            <input type="text" class="form-control" id="keywordName" placeholder="Enter keyword Name">
                            <div id="priorityErr" class="invalid-feedback"></div>
                        </div>
                    </div>
    `;
        $('#categories').append(html);
    }

    
})
</script>

@endsection