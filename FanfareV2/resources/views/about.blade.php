@extends('layout')

@section('title', 'About us')
@section('customstyle', 'home')


@section('content')
<h1>About page </h1>
<p>This is the about page.</p>
<section style="background-color: gray; color: white;">


    <h1><a href="https://app.pluralsight.com/library/courses/laravel-9-fundamentals/table-of-contents">Laravel 9 Fundementals</a></h1>
    <br>
    <p class="about">
        Course 1-10 by Mateo Prigl was used to understand the basics
    </p>
</section>
<section style=" background-color: white; color: black;">

    <h1><a href="https://www.kfdemoedigevrienden.be/">K.F DeMoedigeVrienden Borght</a></h1>
    <br>
    <p class="about">
    This website was used by me. This is a website that I made myself while practising for the web advanced exam in August.
    In the 'Jeugd' page you'll find a list of members, the last one is me, Robbe.
    style was designed by Seppe Mariën, student architecture.
    </p>
</section>
<section style=" background-color: black; color: white;">

    <h1><a href="https://www.youtube.com/watch?v=SWVFDe0AThw&t=3s">Image upload with Laravel 6 - User profile image upload</a></h1>
    <br>
    <p class="about">
    Save Image section(14:57-18:17) was used as base to store user avatar and post image.
    </p>
</section>

<section style=" background-color: grey; color: white;">

    <h1><a href="https://stackoverflow.com/questions/21320304/laravel-image-upload-creating-folder-instead-of-file">Laravel image upload creating folder instead of file</a></h1>
    <br>
    <p class="about">
    Took way to long for me to find the issue(+1 hour), this fixed it and deserves its place here
    </p>
</section>

<section style=" background-color: white; color: black;">

    <h1><a href="https://www.appfinz.com/blogs/laravel-middleware-for-auth-admin-users-roles/">Laravel Middleware for Auth Admin Users Roles</a></h1>
    <br>
    <p class="about">
    I followed this as a base to protect routes only admins are allowed to use
    </p>
</section>

<section style=" background-color: black; color: white;">

    <h1><a href="https://dev.to/rebelnii/creating-laravel-blade-directive-4e87">Creating Laravel Blade Directive</a></h1>
    <br>
    <p class="about">
    Was used to make different layout for admins
    </p>
</section>

<section style=" background-color:grey ; color:white ;">

    <h1><a href="https://github.com/Poedtske/FanfareV2">Git Directory</a></h1>
    <br>
    <p class="about">
    This my Git directory
    </p>
</section>

<section style=" background-color:white ; color:black ;">

    <h1><a href="https://chat.openai.com/">chatGPT</a></h1>
    <br>
    <p class="about">
    was used for finding sytaxes or small codes like the factories, the seeders background cover post,...
    </p>
</section>

<section style=" background-color:black ; color:white ;">

    <h1><a href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/time"><input type="time"></a></h1>
    <br>
    <p class="about">
    for form input time
    </p>
</section>

<section style=" background-color:grey ; color:white ;">

    <h1><a href="https://laravel.com/docs/10.x/eloquent-factories">eloquent-factories</a></h1>
    <br>
    <p class="about">
    documentation factories
    </p>
</section>

<section style=" background-color:white ; color:black ;">

    <h1><a href="https://laravel.com/docs/master/eloquent-relationships">eloquent-relationships</a></h1>
    <br>
    <p class="about">
    documentation relationships database
    </p>
</section>

<section style=" background-color:black ; color:white;">

    <h1><a href="https://laravel.com/docs/5.7/validation">validation</a></h1>
    <br>
    <p class="about">
    documentation validation
    </p>
</section>
{{-- <section style=" background-color: ; color: ;">

    <h1><a href=""></a></h1>
    <br>
    <p class="about">

    </p>
</section> --}}





https://laravel.com/docs/5.7/validation
@endsection
