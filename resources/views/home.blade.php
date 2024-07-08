@extends('layout')
@section('title', 'Home')

@section('customstyle', 'home')


@section('content')
<img src="{{ asset('images/banner.jpg') }}" alt="banner" id="banner">

    @if (!$events->Empty())
        <?php
            $first=$events[0]
        ?>
        @if ($first->poster)
            <section style="background-color:black;">
                <a style="margin-inline: auto;" href="{{ route('events.show',[$first]) }}"><img id="poster" src="{{ asset("$first->poster") }}" alt="{{ $first->title.'_poster' }}"></a>
            </section>
        @endif
    @endif

    <section style="background-color:black;">
        <video width="100%" src="{{ asset('videos/demo.mkv') }}" controls></video>
    </section>


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
    <p id="locatie"></p>
    <a style="display: flex; justify-content: center; align-items: center; width: 2.2em; height: 2.2em; margin-left: auto; margin-right: auto; border-radius: 50%; background-color: transparent; border: solid black 2px;" id="eventLink" href="#">
        <i class="fa-solid fa-info" style="font-size: 1.2em; color: black;"></i>
    </a>



    <div>
        <button style="width: 10em;"><a href="{{ route('kalender') }}">Kalender</a></button>
    </div>
    <div>
        <button style="width: 2em;" class="prev" id="prev">&#10094;</button>
        <button style="width: 2em;" class="next" id="next">&#10095;</button>
    </div>
    <script>
        let activityList=@json($events)

        let currentImageIndex=0;
        let hasBeenClicked=false;
        let slideInterval;

        function formatDate(dateString) {
            const [year, month, day] = dateString.split('-');
            return `${day}/${month}/${year}`;
        }

        let sponsorShowUrl = "{{ route('events.show', ['event' => ':id']) }}";

        let assignValues=()=>{
        document.getElementById("naam").innerHTML= activityList[currentImageIndex].title;
        document.getElementById("datum").innerHTML= formatDate(activityList[currentImageIndex].date);
        document.getElementById("uur").innerHTML=activityList[currentImageIndex].start_time.slice(0,-3);
        document.getElementById("locatie").innerHTML=activityList[currentImageIndex].location;
        let showUrl = sponsorShowUrl.replace(':id', activityList[currentImageIndex].id);
        document.getElementById("eventLink").href=showUrl;
        }

        // let getValues=()=>{
        //   console.log(activityList[currentImageIndex].naam);
        //   console.log(activityList[currentImageIndex].datum);
        //   console.log(activityList[currentImageIndex].uur);
        // }
        assignValues();
        let nextActivity= () => {
            console.log("next");
            if(currentImageIndex==activityList.length-1){
                currentImageIndex=0;
            }
            else{
                currentImageIndex++
            }
            //getValues();
            assignValues();
        }

        let prevActivity= () => {
            console.log("prev");
            if(currentImageIndex==0){
                currentImageIndex=activityList.length-1;
            }
            else{
                currentImageIndex--;
            }
            //getValues();
            assignValues();

        }

        let clicked=()=>{
            hasBeenClicked=true;
            console.log("clicked");
            clearInterval(slideInterval);
        }

        const next=document.getElementById("next");
        const prev=document.getElementById("prev");
        console.log(next);

        slideInterval=setInterval(nextActivity, 5000);
        next.addEventListener("click", nextActivity, clicked);
        next.addEventListener("click", clicked);
        prev.addEventListener("click", prevActivity, clicked);
        prev.addEventListener("click", clicked);

        //Slider
        // let images= [];
        // for (let i=0;i<29;i++){
        // images.push(`WA1/photos/photo${i}.jpg`);
        // }

        // images.push('WA1/photos/photo29.PNG');
        // images.push('WA1/photos/photo30.PNG');

        // let currentImageIndex=0;
        // const slider = document.getElementById("slider");
        // slider.src=images[currentImageIndex];


        // let nextPhoto= () => {
        //   console.log("next");


        //   if(currentImageIndex==images.length-1){
        //     currentImageIndex=0;
        //   }
        //   else{
        //     currentImageIndex++
        //   }
        //   console.log(slider.src);
        //   slider.src = images[currentImageIndex];
        // }
        // let prevPhoto= () => {
        //   console.log("prev");


        //   if(currentImageIndex==0){
        //     currentImageIndex=images.length-1;
        //   }
        //   else{
        //     currentImageIndex--;
        //   }
        //   console.log(slider.src);
        //   slider.src = images[currentImageIndex];

        // }

        // const next=document.getElementById("next");
        // const prev=document.getElementById("prev");
        // console.log(next);
        // next.addEventListener("click", nextPhoto);
        // prev.addEventListener("click", prevPhoto);



        // setInterval(nextPhoto, 5000);
    </script>
    </section>

    <section style="width: 80%; max-width: 600px;">
    <button>
        <a href="https://www.trooper.be/nl/trooperverenigingen/kfdemoedigevrienden" target="_blank"><img class="fotos" src="{{ asset('images/logos/sponsors/trooper_logo.png') }}" alt="Hoofdsponsor" /></a>
    </button>
    </section>
    {{-- @auth
    @admin
    @forelse($events as $event)
    <div class="post-item">
        <div class="post-content">
            <h2><a href="{{ route('events.show',[$event]) }}">{{ $event->title }}</a></h2>
            <p>datum: {{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}</p>
            @if ($event->description)
                <p>beschrijving: {{ $event->description }}</p>
            @endif
            <p>begin: {{ substr($event->start_time,0,-3) }}</p>
            <p>einde: {{ substr($event->end_time,0,-3) }}</p>
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
            <p>begin: {{ substr($event->start_time,0,-3) }}</p>
            <p>einde: {{ substr($event->end_time,0,-3) }}</p>
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
        <p>begin: {{ substr($event->start_time,0,-3) }}</p>
        <p>einde: {{ substr($event->end_time,0,-3) }}</p>
        <p>locatie: {{ $event->location }}</p>
    </div>

    </div>
    @empty
        <b>Er zijn nog geen evenementen</b>
    @endforelse
    @endauth --}}

@endsection
