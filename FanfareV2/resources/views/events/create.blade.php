@extends('layout')

@section('title', 'Create new event')

@section('content')

<form class="crud-form" method="POST" action="{{ route('events.store') }}" enctype="multipart/form-data">
    @csrf
    <h1>Maak een Evenement aan</h1>
    <label>Titel</label>
    <input class="@error('title') error-border @enderror" type="text" name="title" value="{{ old('title') }}">
    @error('title')
    <div class="error">
        {{ $message }}
    </div>
    @enderror

    <label>Beschrijving</label>
    <textarea class="@error('description') error-border @enderror" name="description">{{ old('description') }}</textarea>
    @error('description')
    <div class="error">
        {{ $message }}
    </div>
    @enderror

    <label>Begin</label>
    <input class="@error('start_time') error-border @enderror" name="start_time" type="time" value="{{ old('start_time') }}">
    @error('start_time')
    <div class="error">
        {{ $message }}
    </div>
    @enderror
    <br>
    <label>Einde</label>
    <input class="@error('end_time') error-border @enderror" name="end_time" type="time" value="{{ old('end_time') }}">
    @error('end_time')
    <div class="error">
        {{ $message }}
    </div>
    @enderror
    <br>
    <label>Datum</label>
    <input class="@error('date') error-border @enderror" name="date" type="date" value="{{ old('date') }}">
    @error('date')
    <div class="error">
        {{ $message }}
    </div>
    @enderror
    <br>
    <label>Locatie</label>
    <textarea class="@error('location') error-border @enderror" name="location">{{ old('location') }}</textarea>
    @error('location')
    <div class="error">
        {{ $message }}
    </div>
    @enderror


    <button class="createBtn" type="submit">Maak Aan</button>
</form>
@endsection
