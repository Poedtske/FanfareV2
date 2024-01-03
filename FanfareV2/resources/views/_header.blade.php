<header>
    <button class="hamburger" aria-expanded="false" aria-controls="main-nav">
      <div class="bar"></div>
    </button>
    <a href="#" class="logo">
      <img class="" src="{{ asset('images/logoFanfare.png') }}" />
    </a>
    <nav id="main-nav" aria-expanded="false">
      <a href="/" aria-current="true">Home</a>
      <div class="dropdown" aria-expanded="false">
        <button class="btn2 dropbtn" >Fanfare</button>
        <div class="dropdown-content">
          <a href="fanfare/instrumenten/index.html">Instrumenten</a>
          <a href="fanfare/geschiedenis/index.html">Geschiedenis</a>
          <a href="fanfare/bestuur/index.html">Bestuur</a>
          <a href="fanfare/dirigent/index.html">Dirigent</a>
        </div>
      </div>
      <a href="jeugd/index.html">Jeugd</a>
      <div class="dropdown">
        <button class="dropbtn">Praktische Info</button>
        <div class="dropdown-content">
          <a href="praktische_info/belangrijkedocumenten/index.html">Belangrijke Documenten</a>
          <a href="praktische_info/privacyverklaring/index.html">Privacyverklaring</a>
        </div>
      </div>
      <a href="sponsors/index.html">Sponsors</a>
      <a href="kalender/index.html">Kalender</a>
    </nav>
  </header>














































  {{-- <ul class="nav">
    <li><a class="{{ request()->routeIs('home2') ? 'active' : '' }}" href="{{ route('home2') }}">Home</a></li>
    <li><a class="{{request()->routeIs('about') ? 'active' : ''}}" href="{{route('about')}}">About</a></li>
    <li class="dropdown" aria-expanded="false">
        <button class="btn2 dropbtn">Fanfare</button>
            <div class="dropdown-content">
              <a href="fanfare/instrumenten/index.html">Instrumenten</a>
              <a href="fanfare/geschiedenis/index.html">Geschiedenis</a>
              <a href="fanfare/bestuur/index.html">Bestuur</a>
              <a href="fanfare/dirigent/index.html">Dirigent</a>
            </div>
    </li>
    @auth
    <li><a class="{{request()->routeIs('posts.create') ? 'active' : ''}}" href="{{route('posts.create')}}">Create Post</a></li>
    <li><a class="{{request()->routeIs('logout') ? 'active' : ''}}" href="{{route('logout')}}">Logout</a></li>
    <li class="username"><p>Logged in as <b>{{ Auth::user()->name }}</b></p></li>
    @else
    <li><a class="{{request()->routeIs('register') ? 'active' : ''}}" href="{{route('register')}}">Register</a></li>
    <li><a class="{{request()->routeIs('login') ? 'active' : ''}}" href="{{route('login')}}">Login</a></li>
    @endauth
</ul> --}}

{{-- <header>
    <button class="hamburger" aria-expanded="false" aria-controls="main-nav">
      <div class="bar"></div>
    </button>
    <a href="#" class="logo">
      <img src="../logos/Screenshot 2023-07-06 162548.png" alt="logo" />
    </a>
    <nav id="main-nav" aria-expanded="false">
      <a class="{{ request()->routeIs('home2') ? 'active' : '' }}" href="{{ route('home2') }}" aria-current="true">Home</a>
      <div class="dropdown" aria-expanded="false">
        <button class="btn2 dropbtn" >Fanfare</button>
        <div class="dropdown-content">
          <a class="{{ request()->routeIs('instrumenten') ? 'active' : '' }}" href="{{ route('instrumenten') }}">Instrumenten</a>
          <a class="{{ request()->routeIs('geschiedenis') ? 'active' : '' }}" href="{{ route('geschiedenis') }}">Geschiedenis</a>
          <a class="{{ request()->routeIs('bestuur') ? 'active' : '' }}" href="{{ route('bestuur') }}">Bestuur</a>
          <a class="{{ request()->routeIs('dirigent') ? 'active' : '' }}" href="{{ route('dirigent') }}">Dirigent</a>
        </div>
      </div>
      <a class="{{ request()->routeIs('jeugd') ? 'active' : '' }}" href="{{ route('jeugd') }}">Jeugd</a>
      <div class="dropdown">
        <button class="dropbtn">Praktische Info</button>
        <div class="dropdown-content">
          <a class="{{ request()->routeIs('belangrijkeDocumenten') ? 'active' : '' }}" href="{{ route('belangrijkeDocumenten') }}">Belangrijke Documenten</a>
          <a class="{{ request()->routeIs('privacyverklaring') ? 'active' : '' }}" href="{{ route('privacyverklaring') }}">Privacyverklaring</a>
        </div>
      </div>
      <a class="{{ request()->routeIs('sponsors') ? 'active' : '' }}" href="{{ route('sponsors') }}">Sponsors</a>
      <a class="{{ request()->routeIs('kalender') ? 'active' : '' }}" href="{{ route('kalender') }}">Kalender</a>
      <a class="{{ request()->routeIs('home2') ? 'active' : '' }}" href="{{ route('home2') }}">Home</a>

        <a class="{{request()->routeIs('about') ? 'active' : ''}}" href="{{route('about')}}">About</a>
        @auth
        <a class="{{request()->routeIs('posts.create') ? 'active' : ''}}" href="{{route('posts.create')}}">Create Post</a>
        <a class="{{request()->routeIs('logout') ? 'active' : ''}}" href="{{route('logout')}}">Logout</a>
         class="username"><p>Logged in as <b>{{ Auth::user()->name }}</b></p>
        @else
        <a class="{{request()->routeIs('register') ? 'active' : ''}}" href="{{route('register')}}">Register</a>
        <a class="{{request()->routeIs('login') ? 'active' : ''}}" href="{{route('login')}}">Login</a>
        @endauth
    </nav>
  </header> --}}
