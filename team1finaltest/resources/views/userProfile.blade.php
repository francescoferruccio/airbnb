@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>Benvenuto {{ Auth::user()->firstname }}</p>

                    <a href="{{ route('create') }}">Inserisci un appartamento</a>
                </div>
                <div>
                  @if ($userApartments->count() == 0)
                    <p>Non hai nessun appartamento</p>
                  @endif
                  @foreach ($userApartments as $apartment)
                    <p><a href="{{ route('show', $apartment['id']) }}">{{ $apartment['name'] }}</a>
                    - <a href="{{ route('edit', $apartment['id']) }}">MODIFICA</a>
                    - <a href="{{ route('stats', $apartment['id']) }}">STATISTICHE</a></p>
                  @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
