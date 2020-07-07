<div class="header">

  <div class="searchBar">
    <form action="{{ route('search') }}" method="post">
        @csrf
        @method('POST')
      <div class="formInterno">
        <div class="inputField primoWrap">
          <input name="address" type="search" id="address-input" placeholder="Dove vuoi andare?">
        </div>
        <div class="inputField secondoWrap">
          <button class="bottoneCerca" type="submit" name="button">CERCA</button>
        </div>
      </div>
      {{-- range slider km --}}
      <div class="slidecontainer">
          <div class="textValues">
            <p>0 km</p>
            <p>50 km</p>
            <p>100 km</p>
          </div>
          <input type="range" min="1" max="100" value="50" class="slider" id="myRange">
          <p class="range">Raggio:&nbsp;<span id="demo"></span></p>
      </div>
      <div class="numbersService">
        <div class="rooms">
        <p>Stanze:</p>
          <input type="number" name="quantity" min="1" max="5">
        </div>
        <div class="beds">
          <p>Letti:</p>
          <input type="number" name="quantity" min="1" max="5">
        </div>
        <div class="service">
          <p>Servizi:</p>
          <input type="checkbox" name="" value="">
          <label for="">Wifi</label>
          <input type="checkbox" name="" value="">
          <label for="">Posto macchina</label>
          <input type="checkbox" name="" value="">
          <label for="">Piscina</label>
          <input type="checkbox" name="" value="">
          <label for="">Portineria</label>
          <input type="checkbox" name="" value="">
          <label for="">Sauna</label>
          <input type="checkbox" name="" value="">
          <label for="">Vista mare</label>
        </div>
      </div>
      @if($errors->any())
        <p>{{$errors->first()}}</p>
      @endif
    </form>
  </div>

</div>
