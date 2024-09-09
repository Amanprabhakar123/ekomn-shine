@extends('dashboard.layout.app')

@section('content')
<div class="ek_dashboard">
    <div class="ek_content">
        <div class="card ekcard pa shadow-sm">
            <div class="cardhead">
                <h3 class="cardtitle">Admin plans</h3>
            </div>
                <div class="table-responsive tres_border mt-3">

                <table class="normalTable tableSorting whitespace">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>GST</th>
                            <th>HSN</th>
                            <th>Razorpay Plan Id</th>
                            <th>Duration</th>
                            {{--<th>Features</th>
                            <th>Status</th>--}}
                            <th>Action</th>
                        </tr>
                    </thead>
                    @foreach($plans as $item)
                    <tr>
                        <td>{{$item->name}}</td>
                        <td>{{$item->description}}</td>
                        <td>{{$item->price}}</td>
                        <td>{{$item->gst}}</td>
                        <td>{{$item->hsn}}</td>
                        <td>{{ $item->razorpay_plan_id ?? 'N/A' }}</td>
                        <td>{{$item->duration}}</td>
                        {{--
                                    <td>
                                    <div class="productTitle_t" title="{{$item->features}}">{{$item->features}}
            </div>
            </td>

            <td><select class="changeStatus_t form-select" onchange="handleInput('{{$item->id}}', 2, this)" disabled>
                    <option value="1" {{$item->status == "1" ? "selected" : ""}}>Active</option>
                    <option value="0" {{$item->status == "0" ? "selected" : ""}}>In Active</option>
                </select>
            </td>
            --}}
            <td>
                <a href="{{ route('edit.plan', salt_encrypt($item->id)) }}">Edit</a>
            </td>
            </tr>
            @endforeach
            <tbody>
                <!--  Data display here Dynamic -->
            </tbody>
            </table>
        </div>
    </div>

</div>
@include('dashboard.layout.copyright')
</div>
@endsection