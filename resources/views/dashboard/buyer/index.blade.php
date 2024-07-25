@extends('dashboard.layout.app')

@section('content')
<div class="ek_dashboard">
@include('dashboard.layout.copyright')
  Distance : {{$distance['distance']}} <br>
  Zone : {{$distance['zone']}}
</div>
@endsection