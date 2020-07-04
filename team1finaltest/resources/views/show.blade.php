<p>Apartment ID: {{ $apartment['id'] }}</p>
@foreach ($apartment -> sponsorships as $sponsorship)
  <p>Transaction ID: {{ $sponsorship->pivot->transaction_id }}</p>
  <p>Sponsorship ID: {{ $sponsorship->pivot->sponsorship_id}}</p>
  <p>CREATED AT: {{ $sponsorship->pivot->created_at}}</p>
@endforeach
