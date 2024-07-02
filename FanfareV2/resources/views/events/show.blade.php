@extends('layout')

@section('title', $event->title)

@section('content')

<div class="event-item">
    <div class="event-content">
        <h2>{{ $event->title }}</h2>
        <p>{{ $event->description }}</p>
        <p>{{ $event->date }}</p>
        <p>{{ $event->location }}</p>
        <p>{{ $event->start_time }}</p>
        <p>{{ $event->end_time }}</p>
        @can('update',$event)
        <br>
        <a href="{{ route('events.edit',[$event]) }}"><button class="update">Edit event</button></a>

        @endcan
        @can('delete',$event)
        <form method="POST" action="{{ route('events.destroy',[$event]) }}">
            @csrf
            @method('DELETE')
            <button class="delete" type="submit">Delete event</button>
        </form>
        @endcan
        <small>Created: <b>{{ $event->created_at }}</b></small>
        @if ($event->updated_at!=$event->created_at )
        <small>Updated: <b>{{ $event->updated_at }}</b></small>
        @endif

    </div>
</div>

@endsection
