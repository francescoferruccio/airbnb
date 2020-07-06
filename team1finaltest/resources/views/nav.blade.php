{{-- navbar con register e login --}}

    <div>
      @if (Route::has('login'))
              <div>
                <ul class="nav">
                  <li><a href="#">BoolBnb</a></li>
                @auth
                    <a href="{{ route('user') }}">Home</a>
                  @else
                  <li><a href="{{ route('login') }}">Login</a></li>

                      @if (Route::has('register'))
                  <li><a href="{{ route('register') }}">Register</a></li>
                      @endif
                  @endauth
                  </ul>
              </div>
          @endif
    </div>
