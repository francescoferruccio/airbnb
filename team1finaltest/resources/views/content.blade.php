@extends('mainLayout')

@section("content")


  <div class="content">
    <div class="cardRent"onclick="window.location='{{route('create')}}'">
      <div class="cardimg">
          <img src="images/carduno.jpg" alt="fdkcrw">
      </div>
      <div class="cardtext">
        <h1>Nome Residenza</h1>
        <p>Vieni a trascorrere una meravigliosa vacanza nella nostra fantasmagorica dimora</p>
      </div>
    </div>
    <div class="cardRent"onclick="window.location='http://google.com';">
      <div class="cardimg">
          <img src="images/carduno.jpg" alt="fdkcrw">
      </div>
      <div class="cardtext">
        <h1>Nome Residenza</h1>
        <p>Vieni a trascorrere una meravigliosa vacanza nella nostra fantasmagorica dimora</p>
      </div>
    </div>

  </div>



@endsection
