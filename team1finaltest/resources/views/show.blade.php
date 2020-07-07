@extends('mainLayout')

@section('content')

<div class="showContainer">
  <div class="apartmentDetails" data-address="{{$apartment -> address}}">
    <h3>Nome: {{$apartment -> name}} </h3>
     <p> <strong>Description:</strong> {{$apartment -> description}} </p>

    {{-- @foreach ($apartment -> sponsorships as $sponsorship)
      <p>Transaction ID: {{ $sponsorship->pivot->transaction_id }}</p>
      <p>Sponsorship ID: {{ $sponsorship->pivot->sponsorship_id}}</p>
      <p>CREATED AT: {{ $sponsorship->pivot->created_at}}</p>
    @endforeach --}}
  </div>

<div class="map-title">
<h2>Posizione nella mappa</h2>
</div>
  <div id="map">
    {{-- WARNING:  lasciare vuoto, contenuto mappa dinamico --}}
  </div>

</div>
@endsection

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAP3Uq9YyadYgRoX3N_l4rKUN25UD6Zkgo"
      async defer>
    </script>
