@extends('layout')

@section('title', 'Update Post'.$post->title)

@section('content')
<h1>Update Post {{ $post->title }}</h1>
<form method="POST" action="{{ route('posts.update',[$post]) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <label>Title</label>
    <input class="@error('title') error-border @enderror" type="text" name="title" value="{{ old('title',$post->title) }}">
    @error('title')
    <div class="error">
        {{ $message }}
    </div>
    @enderror

    <label>Description</label>
    <textarea class="@error('description') error-border @enderror" name="description">{{ old('description',$post->description) }}</textarea>
    @error('description')
    <div class="error">
        {{ $message }}
    </div>
    @enderror

    <div>
        <x-input-label for="cover" :value="__('cover')" />
        <x-text-input id="cover" name="cover" type="file" class="block w-full mt-1" autofocus autocomplete="cover" />
        @if($post->cover!=null)
        <img src="{{$post->cover}}" style="width:80px;margin-top: 10px;">
        @endif

        <x-input-error class="mt-2" :messages="$errors->get('cover')" />
    </div>

    <button type="submit">Update</button>
</form>
@endsection
