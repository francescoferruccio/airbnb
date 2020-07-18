@extends('mainLayout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class='userHeader'>
                  <span>{{ __('Profilo Utente') }}</span>
                </div>


                {{-- parte profilo utente e dati con inserisci appartamento --}}
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                  <div class="topProfile">
                    <div class="profile">
                      <img class="profilePic" src="/images/placeholder.jpg" alt="profilepic">
                      <p class="welcomep">Benvenuto {{ Auth::user()->firstname }}</p>
                      <button type="button" name="button"><a href="{{ route('create') }}">Inserisci un appartamento</a></button>
                    </div>
                    <div class="profileInfo">
                      <p>Dati utente:</p>
                      <p> Nome: {{ Auth::user()->firstname }} </p>
                      <p> Cognome: {{ Auth::user()->lastname }} </p>
                      <p> Email: {{ Auth::user()->email }} </p>
                      <p> Data di nascita: {{ Auth::user()->dateofbirth }} </p>
                    </div>
                  </div>
                  <div class="titleAppartamenti">
                    <h2>I tuoi appartamenti</h2>
                  </div>
                  {{-- MESSAGGI ESITO TRANSAZIONE --}}
                  @if (session('success'))
                    <div class="alert alert-success" role="alert">
                      {{ session('success')}}
                    </div>
                  @endif
                  @if (count($errors) > 0)
                    <ul>
                      @foreach ($errors->all() as $error)
                        <div class="alert alert-danger" role="alert">
                          <li>{{ $error }}</li>
                        </div>
                      @endforeach
                    </ul>
                  @endif
                  <div class="appartamenti">
                    @if ($userApartments->count() == 0)
                      <p>Non hai nessun appartamento</p>
                    @endif
                    @foreach ($userApartments as $apartment)
                        <div class="cardProfile">
                          <a href="{{ route('show', $apartment['id']) }}">
                          <div class="cardimg">
                            <img src="{{ $apartment['picture'] }}" alt="fdkcrw">
                          </div>
                          <div class="cardtext">
                            <h2>{{ $apartment['name'] }}</h2>
                            <h3>{{$apartment['address']}}</h3>
                          </div>
                        </a>
                          <div class="services">
                            <span>Modifica: </span>  <a href="{{ route('edit', $apartment['id']) }}"><i class="fas fa-edit"></i></a>
                            <span>Grafico: </span>  <a href="{{ route('stats', $apartment['id']) }}"><i class="fas fa-chart-bar"></i></i></a>
                            <span>Rimuovi: </span><a href="{{ route('delete', $apartment['id']) }}"><i class="fas fa-trash-alt"></i></a>
                            {{-- Controlliamo se l'appartamento è già sponsorizzato e stampiamo un'icona che ce lo indica --}}
                            @if (count($apartment->sponsorships) && $apartment->sponsorships()->orderBy('end_sponsorship', 'desc')->first()->pivot->end_sponsorship > now())
                              <div class="star">
                                <i class="fas fa-star"></i> <span>Sponsored</span>
                              </div>
                            @else
                              {{-- se non è sponsorizzato stampiamo il link alla pagina di sponsorizzazione --}}
                              <div class="sponsorizza">
                                <span>Sponsorizza: </span>  <a href="{{ route('pay', $apartment['id']) }}"><i class="fas fa-euro-sign"></i></a>
                              </div>
                            @endif
                          </div>
                        </div>

                    @endforeach
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
