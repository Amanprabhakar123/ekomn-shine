@extends('dashboard.layout.app')

@section('content')
<div class="ek_dashboard">
    <div class="ek_content">
        <div class="card ekcard pa shadow-sm">
            <div class="cardhead">
                <h3 class="cardtitle">Admin List</h3>
                <a href="{{route('admin.add')}}" class="btn btnekomn btn-sm"><i class="fas fa-plus fs-12 me-1"></i>Add New Admin</a>
            </div>
            <div class="tableTop">
                <input type="text" class="form-control w_350_f searchicon"  id="searchQuery" placeholder="Search with Product Title, SKU, Product ID">
             
            </div>
            <div class="table-responsive tres_border">
                <table class="normalTable tableSorting whitespace">
                    <thead>
                        <tr>
                            <th data-sort-field="order_number">Name</th>
                            </th>
                            <th data-sort-field="courier_name">Email</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="dataContainer">
                        <!-- Data will be displayed here -->
                    </tbody>
                </table>
            </div>
            <div class="ek_pagination">
                <span class="row_select rowcount" id="rowInfo"></span>
                <div class="pager_box">
                    <button id="prevPage" class="pager_btn"><i class="fas fa-chevron-left"></i></button>
                    <ul class="pager_" id="pagination"></ul>
                    <button id="nextPage" class="pager_btn"><i class="fas fa-chevron-right"></i></button>
                </div>
                <div class="row_select jumper">Go to
                    <select id="rowsPerPage">
                        <option value="5">5</option>
                        <option selected value="10">10</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="200">200</option>
                    </select>
                </div>
            </div>
            <!-- end pegination -->
        </div>
    </div>
    @include('dashboard.layout.copyright')
</div>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $('docyment').ready(function() {
        ApiRequest('admin-list-get', 'GET')
        .then(res => {
            console.log(res.data);
            if(res.data.statusCode == 200) {
                let data = res.data.data;
                let html = '';
                data.forEach((item, index) => {
                    html += `
                        <tr>
            <td>
                 <div class="productTitle_t">
                   ${item.name}
                </div>
            </td>
             <td>
                <div class="productTitle_t">
                   ${item.email}

                </div>
            </td>
            
        </tr>
                    `;
                });
                $('#dataContainer').html(html);
            }
        });
    });
</script>

@endsection