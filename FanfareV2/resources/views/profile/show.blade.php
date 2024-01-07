@extends('layout')

@section('title', 'Home')

@section('customstyle', 'home')


@section('content')
@if ($user->role=="admin")
<section style="justify-content: center; background-color:rgb(164,55,65);color: white;">
    {{ $user->name }}
    @if ($user->birthday!=null)
    <br>
    Birthday:
    {{ $user->getBirthday() }}
    @endif
</section>
@else
<section style="justify-content: center; background-color:grey;color: white;">
    {{ $user->name }}
    @if ($user->birthday!=null)
    <br>
    Birthday:
    {{ $user->getBirthday() }}
    @endif
</section>
@endif

<section style="justify-content: center; background-color:white;color: black;">
    <img style=" width:50%; border-radius:30%" src=" {{ $user->avatar }}" alt="user avatar">
</section>

<section style="justify-content: center; background-color:black;color: white;">
    {{ $user->aboutme }}
</section>


@endsection
