@extends('mainLayout')

@section('content')

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class='userHeader'>
            <span>Messaggi Ricevuti</span>
          </div>

          <div class="table-users">


            <table cellspacing="0">
               <tr>
                  <th>Mittente</th>
                  <th>Messaggio</th>
                  <th>Appartamento</th>
                  <th></th>

               </tr>
               @foreach ($allMessages as $message)
                <tr>
                 <td>{{$message["email"]}}</td>
                 <td>{{$message["message"]}}</td>
                 @foreach ($apartments as $apartment)
                   @if ($apartment['id'] == $message['apartment_id'])
                     <td>
                       <a href="{{ route('show', $apartment['id']) }}">{{ $apartment['name'] }}</a>
                     </td>
                     <td>
                       <img class="tdimg" src="{{$apartment['picture']}}" alt="img">
                     </td>
                   @endif
                 @endforeach
                </tr>
               @endforeach
           </table>
          </div>
        </div>
      </div>
    </div>

  </div>








@endsection
