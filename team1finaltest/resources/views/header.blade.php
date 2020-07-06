<div class="header">
  
  <div class="searchBar">
    <form action="{{ route('search') }}" method="post">
        @csrf
        @method('POST')
      <div class="formInterno">
        <div class="inputField primoWrap">
          <input name="address" type="text" placeholder="Dove vuoi andare?">
        </div>
        <div class="inputField secondoWrap">
          <button class="bottoneCerca" type="submit" name="button">CERCA</button>
        </div>
      </div>
    </form>
  </div>

</div>
