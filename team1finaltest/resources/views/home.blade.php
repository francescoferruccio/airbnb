@extends('mainLayout')

@section("content")


  <div class="content">
    @isset($sponsored)
      <div class="sponsoredTitle">
        <h2>Appartamenti in evidenza</h2>
      </div>
      @foreach ($sponsored as $apartment)
        <div class="cardRent" onclick="window.location='{{route('show', $apartment['id'])}}'">
          <div class="cardimg">
            <img src="{{ $apartment['picture'] }}" alt="fdkcrw">
            <div class="star">
              <i class="fas fa-star"></i> <span>Sponsored</span>
            </div>
          </div>
          <div class="cardtext">
            <h2>{{ $apartment['name'] }}</h2>
            <h3>{{$apartment['address']}}</h3>
            <div class="services">
              <ul>
                @foreach ($apartment -> services -> sortBy('id') as $service)
                  <li>
                    <img src="/images/{{$service['name']}}.svg" alt="{{$service['name']}}">
                  </li>
                @endforeach
              </ul>
            </div>
          </div>
        </div>
      @endforeach
    @endisset
  </div>
@endsection
