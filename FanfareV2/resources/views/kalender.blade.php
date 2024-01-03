@extends('layout')


@section('title', 'Kalender')

@section('customstyle', 'kalender')


@section('content')
<section>
    <iframe src="https://calendar.google.com/calendar/embed?height=600&wkst=2&bgcolor=%23ffffff&ctz=Europe%2FBrussels&src=ay5mLmRlbW9lZGlnZXZyaWVuZGVuQGdtYWlsLmNvbQ&src=bmwuYmUjaG9saWRheUBncm91cC52LmNhbGVuZGFyLmdvb2dsZS5jb20&color=%23039BE5&color=%230B8043" style="border:solid 1px #777" width="100%" height="400" frameborder="0" scrolling="no"  id="calendar"></iframe>
  </section>

@endsection
