@extends('layout')

@section('title', $sponsor->title)

@section('content')

<div class="post-item">
    <div class="post-content">
        <h1>{{ $sponsor->title }}</h1>
        <br>
        @if ($sponsor->url)
            <a target="blank_" href="{{ $sponsor->url }}"><img src="{{ asset($sponsor->logo) }}" alt="{{ $sponsor->title.'_logo' }}"></a>
        @else
        <img src="{{ asset($sponsor->logo) }}" alt="{{ $sponsor->title.'_logo' }}">
        @endif

        @if ($sponsor->description)
        <br>
        <h2>Beschrijving</h2>
        <p>{{ $sponsor->description }}</p>
        @endif

        <a href="{{ route('sponsors.index') }}"><button class="btn">Sponsors</button></a>

        @can('update',$sponsor)
        <br>
        <a href="{{ route('sponsors.edit',[$sponsor]) }}"><button class="update">Aanpassen</button></a>

        @endcan
        @can('delete',$sponsor)
        <form method="POST" action="{{ route('sponsors.destroy',[$sponsor]) }}">
            @csrf
            @method('DELETE')
            <button class="delete" type="submit">Verwijderen</button>
        </form>
        @endcan
        @auth
        @admin
            <p>Gesponsord: €{{ $sponsor->sponsored }}</p>
            <small>Gemaakt: <b>{{ $sponsor->created_at }}</b></small>
            <br>
            <small>Gemaakt door: <b>{{$sponsor->user->name }}</b></small>

            <br>
            @if ($sponsor->updated_at!=$sponsor->created_at )
            <small>Laatst aangepast: <b>{{ $sponsor->updated_at }}</b></small>
            @endif
        @endadmin
        @endauth
        {{-- <small>Created by <b>{{ $sponsor->user->name }}</b></small> --}}


    </div>
</div>

@endsection
