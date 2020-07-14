{{-- navbar con register e login --}}
<nav id="customNav" class="navbar fixed-top navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container-fluid" id="customContainer">
        <a class="navbar-brand" href="{{ url('/') }}">
          <img src="/images/logobnb.png" alt="logo bnb">
          <span class="logoTitle">BoolBnB</span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>

            @if ( (\Route::current()->getName() === 'home') || (\Route::current()->getName() === 'show') || (\Route::current()->getName() === 'search') )

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

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
                @endif
                @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->firstname }} {{ Auth::user()->lastname }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('user') }}">
                            {{ __('Il mio profilo') }}
                        </a>
                        <a class="dropdown-item" href="{{ route('inbox') }}">
                            {{ __('I tuoi messaggi') }}
                        </a>

                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
