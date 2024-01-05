@extends('layout')

@section('title', 'About us')
@section('customstyle', 'home')


@section('content')
<h1>About page </h1>
<p>This is the about page.</p>
<section style="background-color: gray; color: white;">
    <p>
        <a href="https://app.pluralsight.com/library/courses/laravel-9-fundamentals/table-of-contents" style="font-size: 100%; text-decoration: underline;">Laravel 9 Fundementals</a>
        <br>
        Course 1-10 by Mateo Prigl was used to understand the basics
    </p>
</section>
<section style=" background-color: white; color: black;">
    <p>
        <a href="https://www.kfdemoedigevrienden.be/" style="font-size: 100%; text-decoration: underline;">K.F DeMoedigeVrienden Borght</a>
    <br>
    This website was used by me. This is a website that I made myself while practising for the web advanced exam in August.
    In the 'Jeugd' page you'll find a list of members, the last one is me, Robbe.
    </p>
</section>
<section style=" background-color: black; color: white;">
    <p>
        <a href="https://www.youtube.com/watch?v=SWVFDe0AThw&t=3s" style="font-size: 100%; text-decoration: underline;">Image upload with Laravel 6 - User profile image upload</a>
    <br>
    Save Image section(14:57-18:17) was used as base to store user avatar and post image.
    </p>
</section>

<section style=" background-color: grey; color: white;">
    <p>
        <a href="https://stackoverflow.com/questions/21320304/laravel-image-upload-creating-folder-instead-of-file" style="font-size: 100%; text-decoration: underline;">Laravel image upload creating folder instead of file</a>
    <br>
    Took way to long for me to find the issue(+1 hour), this fixed it and deserves its place here
    </p>
</section>



@endsection
