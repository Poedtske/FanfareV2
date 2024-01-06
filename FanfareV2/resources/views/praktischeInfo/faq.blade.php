@extends('layout')

@section('title', 'FAQ')

@section('customstyle', 'home')

@section('content')
@auth
@admin
<br>
<div class=".container">
    <button class="create flex-item"><a class="" href="{{route('categories.create')}}">Create Category</a></button>
    <button class="create flex-item"><a class="" href="{{route('questions.create')}}">Create Question</a></button>
</div>



@endadmin
@endauth
@foreach ($categories as $category)
        <h1 style="scale:150%; margin-top:6rem; z-index:-5; overflow:hidden;">{{ $category->name }}</h1>
        @can('update',$category)
            <button class="update adminFunction"><a href="{{ route('categories.edit',[$category]) }}">Edit category</a></button>
        @endcan
        @can('delete',$category)
            <form method="POST" action="{{ route('categories.destroy',[$category]) }}">
                @csrf
                @method('DELETE')
                <button class="delete adminFunction" type="submit">Delete category</button>
            </form>
        @endcan

            @foreach ($category->questions as $question)
            <section class="item">
                <p style="padding-inline:2em;"><b>title:</b> {{ $question->title }}</p>
                <p><b>question:</b> {{ $question->question }}</p>
                <p><b>answer:</b> {{ $question->anwser }}</p>
            </section>
            @can('update',$question)
            <br>
            <button class="update adminFunction"><a href="{{ route('questions.edit',[$question]) }}">Edit question</a></button>

            @endcan
            @can('delete',$question)
            <form method="POST" action="{{ route('questions.destroy',[$question]) }}">
                @csrf
                @method('DELETE')
                <button class="delete adminFunction" type="submit">Delete question</button>
            </form>
            @endcan
            @endforeach

@endforeach
@endsection
