<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use Braintree;

class PaymentController extends Controller
{
  // FUNZIONE CHE CREA IL TOKEN O LO INVIA ALLA VIEW
  public function pay() {
    $gateway = new Braintree\Gateway([
      'environment' => 'sandbox',
      'merchantId' => 'rv7zxkpc3tn2p49c',
      'publicKey' => 'nqndd73tpz5wbjvf',
      'privateKey' => 'e55934ed19ac8014a361c6b56b3a3fe4'
    ]);

    $clientToken = $gateway->clientToken()->generate();

    return view('pay', compact('clientToken'));
  }

  // FUNZIONE CHE CREA E PROCESSA IL PAGAMENTO
  public function checkout(Request $request) {

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

    // controllo l'esito della transazione e restituisco il risultato
    if ($result->success) {
        $transaction = $result->transaction;
        return back() -> with('success', 'La transazione è andata a buon fine. ID TRANSAZIONE: ' . $transaction->id);
    } else {
        $errorString = "";

        foreach($result->errors->deepAll() as $error) {
            $errorString .= 'Error: ' . $error->code . ": " . $error->message . "\n";
        }

        return back() -> withErrors('Qualcosa è andato storto. ERRORE: ' . $result->message);
    }
  }
}