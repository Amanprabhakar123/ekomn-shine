@extends('dashboard.layout.app')

@section('content')
<div class="ek_dashboard">
    <div class="ek_content">
        <div class="card ekcard pa shadow-sm">
            <div class="cardhead">
                <h3 class="cardtitle">Courier List</h3>
            </div>
            <div class="table-responsive tres_border">

                <table class="normalTable tableSorting whitespace">
                    <thead>
                        <tr>
                            <th>Sr. No.</th>
                            <th>Courier Name</th>
                            <th>Tracking URL</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($courierDetails as $courier)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $courier->courier_name }}</td>
                            <td><div  class="w_500_f wordbreak">
                            {{ $courier->tracking_url }}
                            </div></td>
                            <td>
                                <a href="{{ route('edit.courier', salt_encrypt($courier->id)) }}">Edit</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('dashboard.layout.copyright')
</div>
@endsection