<div class="header">
<div class="search">
  <form class="" action="{{ route('search') }}" method="post">
    @csrf
    @method('POST')
    <input type="search" name="address" value=""><button type="submit" name="button">SEARCH</button>
  </form>
</div>
