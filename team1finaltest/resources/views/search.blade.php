@extends('mainLayout')

@section('content')
  <div class="search-content">
    {{-- se ci sono appartamenti sponsorizzati li stampiamo per primi --}}
    @if (count($sponsored_apts))
      <h1>Appartamenti in evidenza</h1>
      @foreach ($sponsored_apts as $sponsored)
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
        <div class="imgApartment">
          <img src="{{$notSponsored['picture']}}" alt="">
        </div>
        {{-- <h2>ID: {{ $notSponsored['id'] }}</h2> --}}
        <div class="textApartment">
          <div class="titleApartment">
            <h2>{{ $notSponsored['name'] }}</h2>
            <h4>{{ $notSponsored['address'] }}</h4>
          </div>
          <div class="descriptionApartment">
            <p>{{ $notSponsored['description'] }}</p>
          </div>

        </div>
        <div class="serviceApartment">
          <div class="specifiche">
            <ul class="iconList">
              <li><i class="fas fa-toilet"></i>  {{ $notSponsored['rooms'] }}</li>
              <li><i class="fas fa-bed"></i>  {{ $notSponsored['beds'] }}</li>
              <li><i class="fas fa-toilet"></i>  {{ $notSponsored['bathrooms'] }}</li>
              <li><i class="fas fa-square"></i>  {{ $notSponsored['size'] }}</li>
            </ul>
          </div>
          <div class="service">

            <ul>
              @foreach ($notSponsored -> services as $service)
                  <li><img src="/images/{{$service['name']}}.svg" alt="">
                @php
                if (strpos($service -> name, '_')) {
                      $service -> name = str_replace("_", " ", $service -> name);
                    }
                @endphp
                  {{$service['name']}}</li>
              @endforeach
            </ul>
          </div>
      </div>
      </div>
    @endforeach

  </div>

@endsection
