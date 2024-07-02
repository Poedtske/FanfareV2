@extends('layout')

@section('title', $event->title)

@section('content')

<div class="post-item">
    <div class="post-content">
        <h1>{{ $event->title }}</h1>
        <br>
        @if ($event->description)
        <h2>Omschrijving</h2>
        <p>{{ $event->description }}</p>
        <br>
        @endif
        <h2>Datum</h2>
        <p>{{ $event->date }}</p>
        <br>
        <h2>Locatie en Tijd</h2>
        <p>Locatie: {{ $event->location }}</p>
        <p>Begin: {{ substr($event->start_time,0,-3) }}</p>
        <p>Einde: {{ substr($event->end_time,0,-3) }}</p>
        @can('update',$event)
        <br>
        <a href="{{ route('events.edit',[$event]) }}"><button class="update">Aanpassen</button></a>

        @endcan
        @can('delete',$event)
        <form method="POST" action="{{ route('events.destroy',[$event]) }}">
            @csrf
            @method('DELETE')
            <button class="delete" type="submit">Verwijderen</button>
        </form>
        @endcan
        <small>Aangemaakt: <b>{{ $event->created_at }}</b></small>
        @if ($event->updated_at!=$event->created_at )
        <small>Laatst aangepast: <b>{{ $event->updated_at }}</b></small>
        @endif

    </div>
</div>

@endsection
