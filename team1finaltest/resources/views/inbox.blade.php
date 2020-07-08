@extends('layouts.app')

@section('content')
  <div class="inbox">
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
  </div>

@endsection
