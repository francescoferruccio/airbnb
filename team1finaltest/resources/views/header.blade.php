
@if (\Request::is('/'))

<div class="header">
  <div class="searchBar">
    <form action="{{ route('search') }}" method="post">
        @csrf
        @method('POST')
      {{-- <div class="formInterno"> --}}
        <div class="inputField">
          <input name="address" type="search" id="address-input" placeholder="Dove vuoi andare?" required>
        {{-- <div class="inputField secondoWrap"> --}}
          <button class="bottoneCerca" type="submit" name="button">CERCA</button>
        </div>
        {{-- </div> --}}
      {{-- </div> --}}
      {{-- range slider km --}}
      <div class="slidecontainer">
          <div class="textValues">
            <p>0 km</p>
            <p>50 km</p>
            <p>100 km</p>
          </div>
          <input type="range" name="radius" min="1" max="100" value="50" class="slider" id="myRange">
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
          <input type="checkbox" name="services[]" value="1">
          <label for="services[]">Wifi</label>
          <input type="checkbox" name="services[]" value="2">
          <label for="services[]">Posto macchina</label>
          <input type="checkbox" name="services[]" value="3">
          <label for="services[]">Piscina</label>
          <input type="checkbox" name="services[]" value="4">
          <label for="services[]">Portineria</label>
          <input type="checkbox" name="services[]" value="5">
          <label for="services[]">Sauna</label>
          <input type="checkbox" name="services[]" value="6">
          <label for="services[]">Vista mare</label>
        </div>
      </div>
      @if($errors->any())
        <p>{{$errors->first()}}</p>
      @endif
    </form>
  </div>
</div>

@endif
