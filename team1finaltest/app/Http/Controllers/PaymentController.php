<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use Braintree;
use App\Sponsorship;
use App\Apartment;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
  // FUNZIONE CHE CREA IL TOKEN O LO INVIA ALLA VIEW
  public function pay($id) {
    $apartment = Apartment::findOrFail($id);

    if(Auth::user()->id == $apartment['user_id']) {

      $gateway = new Braintree\Gateway([
        'environment' => 'sandbox',
        'merchantId' => 'rv7zxkpc3tn2p49c',
        'publicKey' => 'nqndd73tpz5wbjvf',
        'privateKey' => 'e55934ed19ac8014a361c6b56b3a3fe4'
      ]);

      $clientToken = $gateway->clientToken()->generate();

      return view('pay', compact('clientToken', 'id'));
    } else {
      return redirect() -> route('home');
    }
  }

  // FUNZIONE CHE CREA E PROCESSA IL PAGAMENTO
  public function checkout(Request $request, $id) {

    if (checkPost($request)) {
      $gateway = new Braintree\Gateway([
        'environment' => 'sandbox',
        'merchantId' => 'rv7zxkpc3tn2p49c',
        'publicKey' => 'nqndd73tpz5wbjvf',
        'privateKey' => 'e55934ed19ac8014a361c6b56b3a3fe4'
      ]);

      // prendo importo e token dalla request
      $amount = $request["amount"];
      $nonce = $request["payment_method_nonce"];

      // creo la transazione
      $result = $gateway->transaction()->sale([
        'amount' => $amount,
        'paymentMethodNonce' => $nonce,
        'options' => [
          'submitForSettlement' => true
        ]
      ]);

      $amount = floatval($amount);

      // controllo l'esito della transazione e restituisco il risultato
      if ($result->success) {
        $transaction = $result->transaction;

        $apartment = Apartment::findOrFail($id);
        $sponsorship = Sponsorship::where('price', '=', $amount)->first();

        $apartment -> sponsorships() -> attach($sponsorship, [
          'transaction_id' => $transaction->id,
          'end_sponsorship' => now()->addHours($sponsorship->duration)
        ]);

        return back() -> with('success', 'La transazione è andata a buon fine. ID TRANSAZIONE: ' . $transaction->id);
      } else {
        $errorString = "";

        foreach($result->errors->deepAll() as $error) {
          $errorString .= 'Error: ' . $error->code . ": " . $error->message . "\n";
        }

        return back() -> withErrors('Qualcosa è andato storto. ERRORE: ' . $result->message);
      }
    }else {
      return redirect() -> route('home');
    }


  }
}

function checkPost($request)
{
  if ($request->method() === 'POST') {
    return true;
  }
}
