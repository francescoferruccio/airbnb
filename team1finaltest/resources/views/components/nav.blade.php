<div class="mynav">
    <div class="nav-logo">
      <a class="noeffect" href="{{ url('/') }}">
        <img src="/images/logobnb.png" alt="logo bnb">
        <span class="logoTitle">BoolBnB</span>
      </a>
    </div>

    @if ( (\Route::current()->getName() === 'home') || (\Route::current()->getName() === 'show') || (\Route::current()->getName() === 'search') || (\Route::current()->getName() === 'nav') )

      {{-- searchbar a comparsa --}}
      <div class="navSearch">
        <div class="apriSearch">
          @include('searchNav')
          <div class="closeSearch">
          </div>
        </div>
        <button id="stileNavSearch" type="button" name="button">Scegli dove andare</button>
      </div>
    @endif

    <div class="burger">
      <div class="burger-box">
        <ul class="noeffect burger-list">
          @guest
            <li class="">
              <a class="noeffect burger-link" href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
            @if (Route::has('register'))
              <li class="">
                <a class="noeffect burger-link" href="{{ route('register') }}">{{ __('Register') }}</a>
              </li>
            @endif
          @else
            <li>
              <a class="noeffect burger-link" href="{{ route('user') }}">
                {{ __('Il mio profilo') }}
              </a>
              <a class="noeffect burger-link" href="{{ route('inbox') }}">
                {{ __('I tuoi messaggi') }}
              </a>

              <a class="noeffect burger-link" href="{{ route('logout') }}" onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">
              {{ __('Logout') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
          </li>
        @endguest
        </ul>
      </div>
    </div>

      <div class="mynav-menu">
        <ul class="noeffect">
          <!-- Authentication Links -->
          @guest
            <li class="cmd">
              <a class="noeffect" href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
            @if (Route::has('register'))
              <li class="cmd">
                <a class="noeffect" href="{{ route('register') }}">{{ __('Register') }}</a>
              </li>
            @endif
          @else
            <li class="nav-drop">

              {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}
              <span class="caret"></span>

              <div class="drop-menu">
                <div class="drop-sub-menu">
                  <a class="noeffect drop-link" href="{{ route('user') }}">
                    {{ __('Il mio profilo') }}
                  </a>
                  <a class="noeffect droplink" href="{{ route('inbox') }}">
                    {{ __('I tuoi messaggi') }}
                  </a>

                  <a class="noeffect drop-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">
                  {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
                </form>

              </div>
            </div>
          </li>
        @endguest
      </ul>
    </div>


</div>
