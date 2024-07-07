@extends('layout')

@section('title', 'Update Event'.$event->title)

@section('content')

<form class="crud-form" method="POST" action="{{ route('events.update',[$event]) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <h1>Pas Evenement {{ $event->title }} aan</h1>
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
    <label for="file-upload" class="custom-file-upload">Selecteer Poster</label>
    <input id="file-upload" class="@error('poster') error-border @enderror" name="poster" type="file" value="{{ old('poster',$event->poster) }}">
    <img id="preview" src="{{asset($event->poster)}}" style="width:80px;margin-top: 10px;">
    @error('poster')
    <div class="error">
        {{ $message }}
    </div>
    @enderror
<br><br>
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
                if(img.src)
                    img.src = "{{ asset($event->poster) }}"; // Revert to original image if no file is selected
            }
        });
    </script>

    <button class="updateBtn" type="submit">Pas Aan</button>
</form>
@endsection
