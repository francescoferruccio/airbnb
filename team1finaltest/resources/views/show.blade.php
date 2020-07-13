@extends('mainLayout')

@section('content')

<div class="showContainer">

  <div class="apartmentDetails" data-address="{{$apartment -> address}}">
    <div class="photoApartmentName">
      <div class="housename">
        <h3>Nome: {{$apartment -> name}} </h3>
      </div>
      <div class="houseimg">
        <img src="{{ $apartment->picture }}" alt="">
      </div>
    </div>
    <div class="contaninerMap">
      <div class="maptitle">
        <h3>Posizione nella mappa</h3>
      </div>
      <div id="map">
        {{-- WARNING:  lasciare vuoto, contenuto mappa dinamico --}}
      </div>
    </div>

    </div>
    <div class="provashow">
      <p> <strong>Description:</strong> {{$apartment -> description}} </p>
      <ul>
        @foreach ($apartment -> services -> sortBy('id') as $service)
          <li>
            <img src="/images/{{$service['name']}}.svg" alt="{{$service['name']}}"> {{$service['name']}}
          </li>
        @endforeach
      </ul>
    </div>

  <div class="containerTotPropr">

    <div class="messageContainer">

    <div class="formContainer">
        @if ($user_id && $apartment -> user_id == $user_id)
          <div>
            <a href="{{ route('stats', $apartment->id) }}">STATISTICHE</a>
            @if (!$active)
              <a href="{{ route('pay', $apartment->id) }}">SPONSORIZZA</a>
            @else
              <span>Il tuo appartamento è già sponsorizzato</span>
            @endif
          </div>
        @elseif($user_id == null || $apartment -> user_id != $user_id)
          <form  action="{{route('sent', $apartment -> id)}}" method="post">
            @csrf
            @method ('POST')

            @if($errors->any())
              <h2>{{$errors->first()}}</h2>
            @endif

            <input class="email" type="email" name="email" placeholder="ex. mario@rossi@gmail.com" value=@auth
              "{{Auth::user() -> email}}" readonly
            @endauth >
            <textarea name="message" rows="8" cols="60" placeholder="Inserisci la domanda per il proprietario dell'appartamento..."></textarea>
            <input type="submit" name="submit" value="Invia">
          </form>
        @endif

    </div>
    </div>
  </div>

</div>

@endsection

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAP3Uq9YyadYgRoX3N_l4rKUN25UD6Zkgo"
      async defer>
    </script>
