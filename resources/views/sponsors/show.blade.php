@extends('layout')

@section('title', $sponsor->title)

@section('content')

<div class="post-item">
    <div class="post-content">
        <h1>{{ $sponsor->title }}</h1>
        <br>
        @if ($sponsor->url)
        <a target="blank_" href="{{ $sponsor->url }}">
            <button style="border: none; padding: 0; border-radius: 10px; overflow: hidden;">
                <img src="{{ asset($sponsor->logo) }}" alt="{{ $sponsor->title.'_logo' }}" style="border-radius: 10px;">
            </button>
        </a>

        @else
        <img src="{{ asset($sponsor->logo) }}" alt="{{ $sponsor->title.'_logo' }}">
        @endif

        @if ($sponsor->description)
        <br>
        <h2>Beschrijving</h2>
        <p>{{ $sponsor->description }}</p>
        @endif
        <br>
        <a href="{{ route('sponsors.index') }}"><button class="btn">Sponsors</button></a>

        @can('update',$sponsor)
        <br>
        <a href="{{ route('sponsors.edit',[$sponsor]) }}"><button class="update">Aanpassen</button></a>

        @if ($sponsor->active)
            <form action="{{ route('sponsors.changeState',[$sponsor]) }}" method="post">
                @csrf
                <button class="changeState" type="submit" name="id" value="{{ $sponsor->id }}" style="background-color: white;color:black;">Actief</button>
            </form>
        @else
            <form action="{{ route('sponsors.changeState',[$sponsor]) }}" method="post">
                @csrf
                <button class="changeState" type="submit" name="id" value="{{ $sponsor->id }}" style="background-color: black;color:white">Niet Actief</button>
            </form>
        @endif


        @endcan
        @can('delete',$sponsor)
        <form method="POST" action="{{ route('sponsors.destroy', [$sponsor]) }}" onsubmit="return confirmDelete()">
            @csrf
            @method('DELETE')
            <button class="delete" type="submit">Verwijderen</button>
        </form>
        <script>
            function confirmDelete() {
                return confirm("Ben je zeker dat je deze sponsor wilt verwijderen?");
            }
        </script>
        @endcan
        @auth
        @admin
            <p>Gesponsord: €{{ $sponsor->sponsored }}</p>
            <small>Gemaakt: <b>{{ $sponsor->created_at }}</b></small>
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
