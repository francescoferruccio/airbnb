@extends('mainLayout')

@section('content')
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

@endsection
