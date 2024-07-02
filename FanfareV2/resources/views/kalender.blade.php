@extends('layout')


@section('title', 'Kalender')

@section('customstyle', 'main')


@section('content')
{{-- <section>

  </section> --}}
  <iframe src="https://embed.styledcalendar.com/#UyOpSAaIMWF0AU2Tddv3" title="Styled Calendar" class="styled-calendar-container" style="width: 100%; border: none;" data-cy="calendar-embed-iframe"></iframe>
<script async type="module" src="https://embed.styledcalendar.com/assets/parent-window.js"></script>

  {{-- @foreach ($posts as $post)
    <div class="post-item" style="background-image: url('{{ asset($post->cover) }}');background-size: cover;">
        <div class="post-content">
            <h2>{{ $post->title }}</h2>
            <p>{{ $post->description }}</p>
            <p>Date: {{ $post->date }}</p>
            <p>Time: {{ $post->getTime() }}</p>
            @can('update',$post)
            <br>
            <button class="update"><a href="{{ route('posts.edit',[$post]) }}">Edit post</a></button>

            @endcan
            @can('delete',$post)
            <form method="POST" action="{{ route('posts.destroy',[$post]) }}">
                @csrf
                @method('DELETE')
                <button class="delete" type="submit">Delete post</button>
            </form>
            @endcan
            <small>Posted by <b>{{ $post->user->name }}</b></small>
            <small>Created: <b>{{ $post->created_at }}</b></small>
            @if ($post->updated_at!=$post->created_at )
            <small>Updated: <b>{{ $post->updated_at }}</b></small>
            @endif

        </div>
    </div>

  @endforeach --}}

@endsection
