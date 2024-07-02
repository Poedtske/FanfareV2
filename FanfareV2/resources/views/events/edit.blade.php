@extends('layout')

@section('title', 'Update Event'.$event->title)

@section('content')
<h1>Pas Evenement {{ $event->title }} aan</h1>
<form method="POST" action="{{ route('events.update',[$event]) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <label>Titel</label>
    <input class="@error('title') error-border @enderror" type="text" name="title" value="{{ old('title',$event->title) }}">
    @error('title')
    <div class="error">
        {{ $message }}
    </div>
    @enderror

    <label>Beschrijving</label>
    <textarea class="@error('description') error-border @enderror" name="description">{{ old('description',$event->description) }}</textarea>
    @error('description')
    <div class="error">
        {{ $message }}
    </div>
    @enderror

    <label>Begin</label>
    <input class="@error('start_time') error-border @enderror" name="start_time" type="time" value="{{ old('start_time',$event->start_time) }}">
    @error('start_time')
    <div class="error">
        {{ $message }}
    </div>
    @enderror
    <br>
    <label>Einde</label>
    <input class="@error('end_time') error-border @enderror" name="end_time" type="time" value="{{ old('end_time',$event->end_time) }}">
    @error('end_time')
    <div class="error">
        {{ $message }}
    </div>
    @enderror
    <br>
    <label>Datum</label>
    <input class="@error('date') error-border @enderror" name="date" type="date" value="{{ old('date',$event->date) }}">
    @error('date')
    <div class="error">
        {{ $message }}
    </div>
    @enderror
    <br>
    <label>Locatie</label>
    <textarea class="@error('location') error-border @enderror" name="location">{{ old('location',$event->location) }}</textarea>
    @error('location')
    <div class="error">
        {{ $message }}
    </div>
    @enderror

    <button class="updateBtn" type="submit">Update</button>
</form>
@endsection
