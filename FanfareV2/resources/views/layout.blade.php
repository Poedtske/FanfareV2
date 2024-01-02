<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @yield('title','Blog')
    </title>
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
</head>
<body>

<ul class="nav">
    <li><a class="{{ request()->routeIs('home2') ? 'active' : '' }}" href="{{ route('home2') }}">Home</a></li>
    <li><a class="{{request()->routeIs('about') ? 'active' : ''}}" href="{{route('about')}}">About</a></li>
    <li><a class="{{request()->routeIs('posts.create') ? 'active' : ''}}" href="{{route('posts.create')}}">Create Post</a></li>
</ul>

@includeWhen($errors->any(),'_errors')


@if (session('success'))
<div class="flash-success">
    {{session('success')}}
</div>
@endif

<div class="main">
    @yield('content')
</div>



</body>
</html>
