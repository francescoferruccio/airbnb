@extends('mainLayout')

@section("content")


  <div class="content">
    @isset($sponsored)

      @foreach ($sponsored as $apartment)
        <div class="cardRent"onclick="window.location='{{route('show', $apartment['id'])}}'">
          <div class="cardimg">
            <img src="{{ $apartment['picture'] }}" alt="fdkcrw">
          </div>
          <div class="cardtext">
            <h1>NAME: {{ $apartment['name'] }}</h1>
            <p>{{ $apartment['description'] }}</p>
          </div>
        </div>
      @endforeach
    @endisset
  </div>
@endsection
