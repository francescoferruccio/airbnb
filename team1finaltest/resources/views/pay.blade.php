@extends('mainLayout')


@section('content')
  <div class="pay">
    <h2>Scegli il tuo piano</h2>
    {{-- FORM PAGAMENTO BRAINTREE --}}
    <form method="post" id="payment-form" action="{{ route('checkout', $id) }}">
      @csrf
      @method('POST')
      <section>
        <div class="subscription">
          <div class="inputGroup">
            <input type="radio" id="basic" name="amount" value="2.99" checked>
            <label for="basic">2.99€ - Basic - 24h</label>
          </div>
          <div class="inputGroup">
            <input type="radio" id="medium" name="amount" value="5.99">
            <label for="medium">5.99€ - Medium - 3 days</label>
          </div>
          <div class="inputGroup">
            <input type="radio" id="pro" name="amount" value="9.99">
            <label for="pro">9.99€ - Pro - 6 days</label>
          </div>
        </div>
        </label>

        <div class="bt-drop-in-wrapper">
          <div id="bt-dropin"></div>
        </div>
      </section>
      <input id="nonce" name="payment_method_nonce" type="hidden" />
      <div class="paga">
        <button id="form-button" class="button" type="submit"><span>Sponsorizza ora</span></button>
      </div>
    </form>
  </div>

  {{-- SCRIPT BRAINTREE --}}
  <script src="https://js.braintreegateway.com/web/dropin/1.23.0/js/dropin.min.js"></script>
  <script>
  var form = document.querySelector('#payment-form');
  var client_token = {!! json_encode($clientToken) !!};

  braintree.dropin.create({
    authorization: client_token,
    selector: '#bt-dropin'
  }, function (createErr, instance) {
    if (createErr) {
      console.log('Create Error', createErr);
      return;
    }
    form.addEventListener('submit', function (event) {
      event.preventDefault();

      instance.requestPaymentMethod(function (err, payload) {
        if (err) {
          console.log('Request Payment Method Error', err);
          return;
        }

        // Add the nonce to the form and submit
        document.querySelector('#nonce').value = payload.nonce;
        // hide the button
        $("#form-button").hide();
        form.submit();
      });
    });
  });
  </script>
@endsection
