@extends('layouts.app')

@section('content')
  {{-- <div class="inbox">
    <table>
      <thead>
        <tr>
          <th>Mittente</th>
          <th>Messaggio</th>
          <th>Appartamento</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($allMessages as $message)
          <tr>
            <td>{{ $message['email'] }}</td>
            <td>{{ $message['message'] }}</td>
            <td>
              @foreach ($apartments as $apartment)
                @if ($apartment['id'] == $message['apartment_id'])
                  <a href="{{ route('show', $apartment['id']) }}">{{ $apartment['name'] }}</a>
                @endif
              @endforeach
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div> --}}
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class='userHeader'>
            <span>{{ __('Messaggi Ricevuti') }}</span>
          </div>
          <div class="msgcontainer">
            <div class="msgsubcontainer">
              @foreach ($allMessages as $message)
                <div class="msgcard">
                  <div><b>Email mittente:</b> {{$message["email"]}}</div>
                  <div><b>Messaggio:</b> {{$message["message"]}}</div>


                  @foreach ($apartments as $apartment)
                    @if ($apartment['id'] == $message['apartment_id'])
                      <div>
                        <b>Nome appartamento:</b> <a href="{{ route('show', $apartment['id']) }}">{{ $apartment['name'] }}</a>

                      </div>
                    @endif
                  @endforeach

                </div>

              @endforeach

            </div>

          </div>



        </div>
      </div>
    </div>

  </div>

@endsection
