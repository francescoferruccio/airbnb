@extends('mainLayout')

@section('content')
  {{-- se ci sono appartamenti sponsorizzati li stampiamo per primi --}}
  @if (count($sponsored_apts))
    <h1>Appartamenti in evidenza</h1>
    @foreach ($sponsored_apts as $sponsored)
      <h2>ID: {{ $sponsored['id'] }}</h2>
      <h2>NAME: {{ $sponsored['name'] }}</h2>
      <ul>
        @foreach ($sponsored -> services as $service)
          <li>{{ $service['name'] }}</li>
        @endforeach
      </ul>
    @endforeach
  @endif

  {{-- stampiamo il resto degli appartamenti --}}

    {{-- <div class="titoloappartamententiNormali"> --}}
      {{-- <h1>Appartamenti per i poveri</h1> --}}
      {{-- </div> --}}




  @foreach ($notSponsored_apts as $notSponsored)

  <div class="appartamententiNormali">
    <img src="{{$notSponsored['picture']}}" alt="">
    <h2>ID: {{ $notSponsored['id'] }}</h2>
    <h2>NAME: {{ $notSponsored['name'] }}</h2>
    <ul>
      @foreach ($notSponsored -> services as $service)
        <li>{{ $service['name'] }}</li>
      @endforeach
    </ul>

  </div>
    @endforeach



@endsection
