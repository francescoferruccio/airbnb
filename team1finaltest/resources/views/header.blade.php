
@if (\Request::is('/'))

<div class="header">

  <div class="searchBar">
    <form action="{{ route('search') }}" method="post">
      <h2>
        @if (Auth::check() && Auth::user() -> firstname )
          Ciao {{ Auth::user() -> firstname }}, quale sarà la tua prossima meta?
        @else
          Quale sarà la tua prossima meta?
        @endif
      </h2>

        @csrf
        @method('POST')
        <div class="inputField">
          <input name="address" type="search" id="address-input" placeholder="Dove vuoi andare?" required>
          <button class="bottoneCerca" type="submit" name="button">CERCA</button>
        </div>

        {{-- bottone ricerca avanzata --}}
      <div class="filter">
        <button id="ricercaAvanzata" type="button" name="button">Ricerca Avanzata</button>
      </div>
      {{-- range slider km --}}
    <div id="containerRicercaAvanzata">
      <div class="slidecontainer">
          <div class="textValues">
            <p>0 km</p>
            <p>50 km</p>
            <p>100 km</p>
          </div>
          <input type="range" name="radius" min="1" max="100" value="20" class="slider" id="myRange">
          <p class="range">Raggio:&nbsp;<span id="demo"></span></p>
      </div>
      <div class="numbersService">
        <div class="rooms">
        <p>Stanze:</p>
          <input type="number" name="rooms" min="1" max="5" value="1" required>
        </div>
        <div class="beds">
          <p>Letti:</p>
          <input type="number" name="beds" min="1" max="5" value="1" required>
        </div>
        <div class="service">
          <p>Servizi:</p>
          <label class="containerCheckbox">
            <p class="serviceText">Wifi</p>
            <input type="checkbox" name="services[]" value="1">
            <span class="checkmark"></span>
          </label>
          <label class="containerCheckbox">
            <p class="serviceText">Parcheggio</p>
            <input type="checkbox" name="services[]" value="2">
            <span class="checkmark"></span>
          </label>
          <label class="containerCheckbox">
            <p class="serviceText">Piscina</p>
            <input type="checkbox" name="services[]" value="3">
            <span class="checkmark"></span>
          </label>
          <label class="containerCheckbox">
            <p class="serviceText">Portineria</p>
            <input type="checkbox" name="services[]" value="4">
            <span class="checkmark"></span>
          </label>
          <label class="containerCheckbox">
            <p class="serviceText">Sauna</p>
            <input type="checkbox" name="services[]" value="5">
            <span class="checkmark"></span>
          </label>
          <label class="containerCheckbox">
            <p class="serviceText">Vista mare</p>
            <input type="checkbox" name="services[]" value="6">
            <span class="checkmark"></span>
          </label>
        </div>
      </div>
    </div>
      @if($errors->any())
        <p>{{$errors->first()}}</p>
      @endif
    </form>
  </div>
</div>

@endif
