{{-- se ci sono appartamenti sponsorizzati li stampiamo per primi --}}
@if (count($sponsored_apts))
  <h1>Appartamenti in evidenza</h1>
  @foreach ($sponsored_apts as $sponsored)
    <h2>ID: {{ $sponsored['id'] }}</h2>
    <h2>NAME: {{ $sponsored['name'] }}</h2>
  @endforeach
@endif

{{-- stampiamo il resto degli appartamenti --}}
<h1>Appartamenti per i poveri</h1>
@foreach ($notSponsored_apts as $notSponsored)
  <h2>ID: {{ $notSponsored['id'] }}</h2>
  <h2>NAME: {{ $notSponsored['name'] }}</h2>
@endforeach
