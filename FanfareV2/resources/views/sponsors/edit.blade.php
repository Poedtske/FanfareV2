@extends('layout')

@section('title', 'Update Sponsor'.$sponsor->title)

@section('content')
<form class="crud-form" method="POST" action="{{ route('sponsors.update',[$sponsor]) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <h1>Pas Sponsor {{ $sponsor->title }} aan</h1>
    <label>Naam*</label>
    <input class="@error('title') error-border @enderror" type="text" name="title" value="{{ old('title',$sponsor->title) }}">
    @error('title')
    <div class="error">
        {{ $message }}
    </div>
    @enderror
    <br>
    <label>Beschrijving</label>
    <textarea class="@error('description') error-border @enderror" name="description">{{ old('description',$sponsor->description) }}</textarea>
    @error('description')
    <div class="error">
        {{ $message }}
    </div>
    @enderror
    <br>
    <br>
    <label for="file-upload" class="custom-file-upload">Selecteer Logo*</label>
    <input id="file-upload" class="@error('logo') error-border @enderror" name="logo" type="file" value="{{ old('logo',$sponsor->logo) }}">
    <img src="{{asset($sponsor->logo)}}" style="width:80px;margin-top: 10px;">
    @error('logo')
    <div class="error">
        {{ $message }}
    </div>
    @enderror
    <br>
    <label>Gesponsord (€)*</label>
    <input type="number" step="any" class="@error('sponsored') error-border @enderror" name="sponsored" value="{{ old('sponsored',$sponsor->sponsored) }}"></input>
    @error('sponsored')
    <div class="error">
        {{ $message }}
    </div>
    @enderror
    <br>

    <label>Url</label>
    <textarea class="@error('url') error-border @enderror" name="url">{{ old('url',$sponsor->url) }}</textarea>
    @error('url')
    <div class="error">
        {{ $message }}
    </div>
    @enderror

    <label>Rang</label><br><br>
    <button style="padding:1em; border-radius:10px; background-color:transparent; border:solid; color:white; font-size:1.5em; cursor:auto;">{{ $sponsor->rank }}</button>
    <br><br>
    <button class="updateBtn" type="submit">Pas Aan</button>
</form>
@endsection
