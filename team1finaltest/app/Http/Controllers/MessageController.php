<?php

namespace App\Http\Controllers;
use App\User;
use App\Apartment;
use App\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MessageController extends Controller
{
  public function message($id){
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
        return redirect() -> route('show', $id)-> with('status','Messaggio inviato correttamente');
      } else{
        return redirect() -> route('message', $id)-> withErrors(['Inserisci la tua email di registrazione!']);
      }
    }else {
      storeMessage($validatedData, $id);
      return redirect() -> route('show', $id)-> with('status','Messaggio inviato correttamente');
    }
  }
}

function storeMessage($validatedData, $id)
{
  $message = new Message;

  $message['email'] = $validatedData['email'];
  $message['message'] = $validatedData['message'];
  $message['apartment_id'] = $id;

  $message -> save();

}
