@extends('layout')


@section('title', 'Bestuur')

@section('customstyle', 'bestuur')


@section('content')
<section>
    <div class="flexbox-container">
      <div class="flexbox-item">
        <img src="{{ asset('images/icoonManBestuur.png') }}" alt="Bart">
        <p>Ruben Fransen</p>
      </div>
      <div class="flexbox-item">
        <img src="{{ asset('images/icoonManBestuur.png') }}" alt="Bart">
        <p>Lance Wauters</p>
      </div>
      <div class="flexbox-item">
        <img src="{{ asset('images/icoonManBestuur.png') }}" alt="Bart">
        <p>Seppe Mariën</p>
      </div>
      <div class="flexbox-item">
        <img src="{{ asset('images/icoonVrouwBestuur.png') }}" alt="Ilse">
        <p>Ilse De Wachter</p>
      </div>
      <div class="flexbox-item">
        <img src="{{ asset('images/icoonVrouwBestuur.png') }}" alt="Jenny">
        <p>Jenny Freeman</p>
      </div>
      <div class="flexbox-item">
        <img src="{{ asset('images/icoonVrouwBestuur.png') }}" alt="Marina">
        <p>Marina Rosic</p>
      </div>
      <div class="flexbox-item">
        <img src="{{ asset('images/icoonVrouwBestuur.png') }}" alt="Pascale">
        <p>Pascale Gysenbergs</p>
      </div>
      <div class="flexbox-item">
        <img src="{{ asset('images/icoonManBestuur.png') }}" alt="Wim">
        <p>Wim Mariën</p>
      </div>
      <div class="flexbox-item">
        <img src="{{ asset('images/icoonManBestuur.png') }}" alt="Chris">
        <p>Chris Selleslagh</p>
      </div>
      <div class="flexbox-item">
        <img src="{{ asset('images/icoonManBestuur.png') }}" alt="Mark">
        <p>Marc De Wael</p>
      </div>
    </div>
    {{-- @auth
    @else
    <br>
    <div class=".container">
        <a class="" href="{{route('contact.create')}}"><button style="background-color: black" class="create flex-item">Contact us</button></a>
    </div>
    @endauth
    <div class=".container">
    <a class="" href="{{route('members')}}"><button style="background-color: black" class="create flex-item">Member List</button></a>
    </div>
  </section> --}}
@endsection
