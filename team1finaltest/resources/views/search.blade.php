@extends('mainLayout')

@section('content')
  <div class="search-content">
    {{-- se ci sono appartamenti sponsorizzati li stampiamo per primi --}}

    @if (count($sponsored_apts))
      <div class="sponsorApartments">
        <div class="titleSponsored">
          <h2>Le nostre scelte top</h2>
        </div>
        @foreach ($sponsored_apts as $sponsored)
          <div class="apartmentContainer sponsored" onclick="window.location='{{route('show', $sponsored['id'])}}'">
            <div class="imgApartment">
              <img src="{{$sponsored['picture']}}" alt="">
            </div>
            <div class="textApartment">
              <div class="titleApartment">
                <h2>{{ $sponsored['name'] }}</h2>
                <h4>{{ $sponsored['address'] }}</h4>
              </div>
              <div class="descriptionApartment">
                <p>{{Str::limit($sponsored['description'], 100)}}</p>
              </div>

            </div>
            <div class="serviceApartment">
              <div class="specifiche">
                <ul class="iconList">
                  <li><i class="fas fa-door-open"></i>  {{ $sponsored['rooms'] }}</li>
                  <li><i class="fas fa-bed"></i>  {{ $sponsored['beds'] }}</li>
                  <li><i class="fas fa-toilet"></i>  {{ $sponsored['bathrooms'] }}</li>
                  <li><i class="fas fa-square"></i>  {{ $sponsored['size'] }} m<sup>2</sup></li>
                </ul>
              </div>
              <div class="service">

                <ul>
                  @foreach ($sponsored -> services as $service)
                      <li><img src="/images/{{$service['name']}}.svg" alt="">
                  @endforeach
                </ul>
              </div>
          </div>
          <div class="ribbon-wrapper">
        		<div class="ribbon-front">
        			<i class="fas fa-star"></i> <span>Sponsored</span>
        		</div>
        		<div class="ribbon-edge-topleft"></div>
        		<div class="ribbon-edge-topright"></div>
        		<div class="ribbon-edge-bottomleft"></div>
        		<div class="ribbon-edge-bottomright"></div>
        		<div class="ribbon-back-left"></div>
        		<div class="ribbon-back-right"></div>
        	</div>
          </div>
        @endforeach
      @endif
      </div>

    {{-- stampiamo il resto degli appartamenti --}}

    {{-- <div class="titoloappartamententiNormali"> --}}
    {{-- <h1>Appartamenti per i poveri</h1> --}}
    {{-- </div> --}}



    <div class="notContainer">
      @foreach ($notSponsored_apts as $notSponsored)
          <div class="apartmentContainer notSponsored" onclick="window.location='{{route('show', $notSponsored['id'])}}'">
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
                <p>{{Str::limit($notSponsored['description'], 100)}}</p>
              </div>

            </div>
            <div class="serviceApartment">
              <div class="specifiche">
                <ul class="iconList">
                  <li><i class="fas fa-door-open"></i>  {{ $notSponsored['rooms'] }}</li>
                  <li><i class="fas fa-bed"></i>  {{ $notSponsored['beds'] }}</li>
                  <li><i class="fas fa-toilet"></i>  {{ $notSponsored['bathrooms'] }}</li>
                  <li><i class="fas fa-square"></i>  {{ $notSponsored['size'] }} m<sup>2</sup></li>
                </ul>
              </div>
              <div class="service">

                <ul>
                  @foreach ($notSponsored -> services as $service)
                    <li><img src="/images/{{$service['name']}}.svg" alt="">
                    @endforeach
                  </ul>
                </div>
              </div>
            </div>

        @endforeach
    </div>


  </div>

@endsection
