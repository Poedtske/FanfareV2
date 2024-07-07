@extends('layout')

@section('title', 'Create new event')

@section('content')

<form class="crud-form" method="POST" action="{{ route('events.store') }}" enctype="multipart/form-data">
    @csrf
    <h1>Maak een Evenement aan</h1>
    <label>Titel*</label>
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

    <label>Begin*</label>
    <input class="@error('start_time') error-border @enderror" name="start_time" type="time" value="{{ old('start_time') }}">
    @error('start_time')
    <div class="error">
        {{ $message }}
    </div>
    @enderror
    <br>
    <label>Einde*</label>
    <input class="@error('end_time') error-border @enderror" name="end_time" type="time" value="{{ old('end_time') }}">
    @error('end_time')
    <div class="error">
        {{ $message }}
    </div>
    @enderror
    <br>
    <label>Datum*</label>
    <input class="@error('date') error-border @enderror" name="date" type="date" value="{{ old('date') }}">
    @error('date')
    <div class="error">
        {{ $message }}
    </div>
    @enderror
    <br>
    <label>Locatie*</label>
    <textarea class="@error('location') error-border @enderror" name="location">{{ old('location') }}</textarea>
    @error('location')
    <div class="error">
        {{ $message }}
    </div>
    @enderror

    <br><br>
    <label for="file-upload" class="custom-file-upload">Selecteer Poster</label>
    <input id="file-upload" class="@error('poster') error-border @enderror" name="poster" type="file" value="{{ old('poster') }}">
    <img id="preview" src="" style="width:80px;margin-top: 10px;">
    @error('poster')
    <div class="error">
        {{ $message }}
    </div>
    @enderror

    <script>
        document.getElementById('file-upload').addEventListener('change', function(event) {
            const label = document.querySelector('.custom-file-upload');
            const img = document.getElementById('preview');

            if (event.target.files.length > 0) {
                label.classList.add('selected');

                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                    label.textContent = "Poster is Geselecteerd";
                };
                reader.readAsDataURL(event.target.files[0]);
            } else {
                label.classList.remove('selected');
            }
        });
    </script>


    <button class="createBtn" type="submit">Maak Aan</button>
</form>
@endsection
