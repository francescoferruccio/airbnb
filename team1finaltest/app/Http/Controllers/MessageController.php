<?php

namespace App\Http\Controllers;

use App\User;
use App\Apartment;
use App\Message;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function message($id)
    {
        $apartment = Apartment::findOrFail($id);

        return view('message', compact('apartment'));
    }

    //funzione di store del messaggio in database
    public function sent(Request $request, $id)
    {
        $validatedData = $request -> validate([
      'email' => 'required|email:rfc,dns',
      'message' => 'required|string'
    ]);

        if (Auth::check()) {
            $mail=  Auth::user()-> email;
            if ($mail == $validatedData['email']) {
                storeMessage($validatedData, $id);
                return redirect() -> route('show', $id)-> with('status', 'Messaggio inviato correttamente');
            } else {
                return redirect() -> route('message', $id)-> withErrors(['Inserisci la tua email di registrazione!']);
            }
        } else {
            storeMessage($validatedData, $id);
            return redirect() -> route('show', $id)-> with('status', 'Messaggio inviato correttamente');
        }
    }

    // funzione che stampa i messaggi ricevuti dall'utente
    public function inbox() {
      $userId = Auth::user() -> id;
      $user = User::findOrFail($userId);

      // se l'utente ha appartamenti lo indirizziamo alla pagina dei messaggi
      if ($user -> apartments() -> count()) {
        $apartments = $user -> apartments() -> get();
        $messages = [];
        foreach ($apartments as $apartment) {
          $messages[] = $apartment -> messages() -> get() -> toArray();
        }
        $allMessages = Arr::collapse($messages);

        return view('inbox', compact('allMessages', 'apartments'));
      } else {
        // altrimenti lo indirizziamo alla pagina di creazione dell'appartamento
        return redirect() -> route('create') -> with('status', 'Inserisci un appartamento per poter ricevere messaggi.');
      }
    }

}

function storeMessage($validatedData, $id) {
    $message = new Message;

    $message['email'] = $validatedData['email'];
    $message['message'] = $validatedData['message'];
    $message['apartment_id'] = $id;

    $message -> save();
}
