@extends('layout')

@section('title', $post->title)

@section('content')

<div class="post-item">
    <div class="post-content">
        <h2>{{ $post->title }}</h2>
        <p>{{ $post->description }}</p>
        <a href="{{ route('posts.edit',[$post]) }}">Edit post</a>
        <form method="POST" action="{{ route('posts.destroy',[$post]) }}">
            @csrf
            @method('DELETE')
            <button class="delete" type="submit">Delete post</button>
        </form>
        <small>Posted by <b>{{ $post->user->name }}</b></small>
        <small>Created: <b>{{ $post->created_at }}</b></small>
        @if ($post->updated_at!=$post->created_at )
        <small>Updated: <b>{{ $post->updated_at }}</b></small>
        @endif

    </div>
</div>

@endsection
