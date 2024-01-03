@extends('layout')

@section('title', 'Home')

@section('content')

@forelse($posts as $post)
<div class="post-item">
    <div class="post-content">
        <h2><a href="{{ route('posts.show',[$post]) }}">{{ $post->title }}</a></h2>
        <p>{{ $post->description }}</p>
        <small>Posted by <b>{{ $post->user->name }}</b></small>
    </div>
</div>
@empty
    <b>There are no posts yet</b>
@endforelse
<h1>Home page </h1>
<p>This is the home page.</p>
@endsection
