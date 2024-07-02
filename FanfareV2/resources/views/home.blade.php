@extends('layout')


@section('title', 'Home')

@section('customstyle', 'home')


@section('content')
<img src="{{ asset('images/banner.jpg') }}" alt="banner" id="banner">
      <section style="background-color: gray;">

        <p>
          Wij zijn een groep enthousiaste amateurmuzikanten bestaande uit momenteel een dertigtal spelende leden waarvan de leeftijden uiteenlopend zijn, gaande van kinderen tot gepensioneerden.
          Jong of oud, het maakt voor ons niet uit !!!
        </p>
        <p>
          Het bestuur bestaat uit gemotiveerde leden, die allen instaan voor de bevordering van onze fanfare.
        </p>
        <p></p>
        <p></p>
        <p></p>
        <p>
          Onze fanfare is altijd op zoek naar nieuwe leden, die interesse hebben in muziek.
          Ben je -18, beginnende muzikanten of een ervaren speler, wees er dan maar zeker van dat je altijd welkom bent om onze rangen te komen bijvullen.
        </p>
        <p>
          Indien je niets of bijna niets van muziek kent, geen nood, dan is er de mogelijkheid om lessen aan te bieden alsook een instrument gratis in bruikleen te krijgen.
        </p>
        <p>
          Het belangrijkste voor onze fanfare is dat deze hobby een unieke kijk op de samenleving geeft, jong en oud die samenspelen en samen plezier hebben met de muziek die ze maken.
        </p>
      </section>

      <section id="activity" style=" background-color: white; color: black;">
        <p id="naam"></p>
        <p id="datum"></p>
        <p id="uur"></p>
        <div>
          <button style="width: 10em;"><a href="kalender/index.html">Kalender</a></button>
        </div>
          <div>
            <button style="width: 2em;" class="prev" id="prev">&#10094;</button>
            <button style="width: 2em;" class="next" id="next">&#10095;</button>
          </div>




      </section>

      <section style="width: 80%; max-width: 600px;">
        <button>
          <a href="https://www.trooper.be/nl/trooperverenigingen/kfdemoedigevrienden" target="_blank"><img class="fotos" src="{{ asset('images/logos/sponsors/trooper_logo.png') }}" alt="Hoofdsponsor" /></a>
        </button>
      </section>
      @auth
      @admin
      @forelse($events as $event)
        <div class="post-item">
            <div class="post-content">
                <h2><a href="{{ route('events.show',[$event]) }}">{{ $event->title }}</a></h2>
                <p>datum: {{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}</p>
                @if ($event->description)
                    <p>beschrijving: {{ $event->description }}</p>
                @endif
                <p>begin: {{ $event->start_time }}</p>
                <p>einde: {{ $event->end_time }}</p>
                <p>locatie: {{ $event->location }}</p>

            </div>
        </div>
        @empty
            <b>Er zijn nog geen evenementen</b>
        @endforelse
      @else
      @forelse($events as $event)
      <div class="post-item">
          <div class="post-content">
              <h2>{{ $event->title }}</h2>
              <p>datum: {{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}</p>
              @if ($event->description)
                  <p>beschrijving: {{ $event->description }}</p>
              @endif
              <p>begin: {{ $event->start_time }}</p>
              <p>einde: {{ $event->end_time }}</p>
              <p>locatie: {{ $event->location }}</p>
          </div>
      </div>
      @empty
          <b>Er zijn nog geen evenementen</b>
      @endforelse
      @endadmin
      @else
      @forelse($events as $event)
      <div class="post-item">
        <div class="post-content">
            <h2>{{ $event->title }}</h2>
            <p>datum: {{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}</p>
            @if ($event->description)
                <p>beschrijving: {{ $event->description }}</p>
            @endif
            <p>begin: {{ $event->start_time }}</p>
            <p>einde: {{ $event->end_time }}</p>
            <p>locatie: {{ $event->location }}</p>
        </div>

      </div>
      @empty
          <b>Er zijn nog geen evenementen</b>
      @endforelse
      @endauth

@endsection
