@extends('mainLayout')

@section('content')

<div class="showContainer">

  <div class="apartmentDetails" data-address="{{$apartment -> address}}">
    <div class="photoApartmentName">
      <img src="../images/carduno.jpg" alt="">
      <h3>Nome: {{$apartment -> name}} </h3>
    </div>
    <div class="contaninerMap">
      <h2>Posizione nella mappa</h2>
      <div id="map">
        {{-- WARNING:  lasciare vuoto, contenuto mappa dinamico --}}
      </div>
    </div>

    </div>
    <div class="provashow">
      <p> <strong>Description:</strong> {{$apartment -> description}} </p>
      <ul>
        <li><i class="fa fa-wifi" aria-hidden="true"></i>ssss</li>
        <li>gggg</li>
        <li>gggg</li>
        <li>gggg</li>
        <li>ggggg</li>
      </ul>
    </div>


    {{-- @foreach ($apartment -> sponsorships as $sponsorship)
      <p>Transaction ID: {{ $sponsorship->pivot->transaction_id }}</p>
      <p>Sponsorship ID: {{ $sponsorship->pivot->sponsorship_id}}</p>
      <p>CREATED AT: {{ $sponsorship->pivot->created_at}}</p>
    @endforeach --}}

  <div class="containerTotPropr">

    <div class="messageContainer">

    <div class="formContainer">

      <form  action="{{route('sent', $apartment -> id)}}" method="post">
        @csrf
        @method ('POST')

        @if($errors->any())
            <h2>{{$errors->first()}}</h2>
          @endif

        <input type="email" name="email" placeholder="ex. mario@rossi@gmail.com" value=@auth
          "{{Auth::user() -> email}}" readonly
        @endauth >
        <textarea name="message" rows="8" cols="80" placeholder="Inserisci la domanda per il proprietario dell'appartamento..."></textarea>
        <input type="submit" name="submit" value="Invia">
      </form>
    </div>
    </div>
  </div>

</div>

@endsection

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAP3Uq9YyadYgRoX3N_l4rKUN25UD6Zkgo"
      async defer>
    </script>
