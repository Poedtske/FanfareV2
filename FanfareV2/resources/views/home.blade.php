@extends('layout')

@section('title', 'Home')

@section('content')

@foreach($posts as $post)
<div class="post-item">
    <div class="post-content">
        <h2>{{ $post->title }}</h2>
        <p>{{ $post->description }}</p>
    </div>
</div>
@endforeach
<h1>Home page </h1>
<p>This is the home page.</p>
@endsection
