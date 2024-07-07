@extends('layout')

@section('title', 'Create new sponsor')

@section('content')

<form class="crud-form" method="POST" action="{{ route('sponsors.store') }}" enctype="multipart/form-data">
    @csrf
    <h1>Maak een Sponsor aan</h1>
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
    <br>
    <br>
    <label for="file-upload" class="custom-file-upload">Selecteer Logo*</label>
    <input id="file-upload" class="@error('logo') error-border @enderror" name="logo" type="file" value="{{ old('logo') }}">
    <img id="preview" src="" style="width:80px;margin-top: 10px;">
    @error('logo')
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
                    label.textContent = "Logo is Geselecteerd";
                };
                reader.readAsDataURL(event.target.files[0]);
            } else {
                label.classList.remove('selected');
            }
        });
    </script><br>
    <label>Gesponsord (€)*</label>
    <input type="number" step="any" class="@error('sponsored') error-border @enderror" name="sponsored" value="{{ old('sponsored') }}"></input>
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

    <button class="createBtn" type="submit">Maak Aan</button>
</form>
@endsection
