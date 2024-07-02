@extends('layout')

@section('title', 'Create new sponsor')

@section('content')
<h1>Create a Sponsor</h1>
<form method="POST" action="{{ route('sponsors.store') }}" enctype="multipart/form-data">
    @csrf

    <label>Naam*</label>
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

    <label>Logo*</label>
    <input class="@error('logo') error-border @enderror" name="logo" type="file">
    @error('logo')
    <div class="error">
        {{ $message }}
    </div>
    @enderror

    <label>Gesponsord (€)*</label>
    <input type="number" step="any" class="@error('sponsored') error-border @enderror" name="sponsored">{{ old('sponsored') }}</input>
    @error('sponsored')
    <div class="error">
        {{ $message }}
    </div>
    @enderror
    <br>

    <label>Url</label>
    <textarea class="@error('url') error-border @enderror" name="url">{{ old('url') }}</textarea>
    @error('url')
    <div class="error">
        {{ $message }}
    </div>
    @enderror

    <button type="submit">Submit</button>
</form>
@endsection
