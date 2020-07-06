@extends('mainLayout')

@section("content")
  @foreach ($sponsored as $apartment)
    <div>
      APARTMENT ID: {{ $apartment['id'] }} <br>
      NAME: {{ $apartment['name'] }} <br>
      {{-- CICLO TUTTE LE SPONSORIZZAZIONI --}}
      @foreach ($apartment->sponsorships as $sponsorship)
        {{-- STAMPO SOLO I DATI DELLA SPONSORIZZAZIONE ATTIVA --}}
        @if ($sponsorship->pivot->end_sponsorship > now())
          SPONSONRSHIP TYPE: {{ $sponsorship->pivot->sponsorship_id }} <br>
          START SPONSORSHIP: {{ $sponsorship->pivot->created_at }} <br>
          END SPONSORSHIP: {{ $sponsorship->pivot->end_sponsorship }} <br>
        @endif
      @endforeach
      <img src="{{ $apartment['picture'] }}" alt="">
    </div>
  @endforeach
@endsection
