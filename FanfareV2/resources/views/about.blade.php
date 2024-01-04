@extends('layout')

@section('title', 'About us')
@section('customstyle','home')


@section('content')
<h1>About page </h1>
<p>This is the about page.</p>
<section style="background-color: gray;">
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

@endsection
