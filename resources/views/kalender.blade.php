@extends('layout')

@section('title', 'Kalender')

@auth
@admin
@section('customstyle', 'kalender')
@endadmin
@elseauth
@section('customstyle', 'main')
@endauth
@section('customstyle', 'main')

@section('content')

  @auth
    @admin
        @if ($events)
            <style>
                main section {
                    width: min(90vw, 70rem);
                }
            </style>
        <section>
            <div style="margin-left:auto;">
                <a href="{{ route('events.create') }}"><button class="createBtn">Aanmaken</button></a>
            </div>
        </section>

        <section>
            <table id="events-table">
                <thead>
                    <tr>
                        <th><a class="filter" href="#" onclick="sortTable(0)">Poster</a></th>
                        <th><a class="filter" href="#" onclick="sortTable(1)">ID</a></th>
                        <th><a class="filter" href="#" onclick="sortTable(2)">Titel</a></th>
                        <th><a class="filter" href="#" onclick="sortTable(3)">Beschrijving</a></th>
                        <th><a class="filter" href="#" onclick="sortTable(4)">Spond</a></th>
                        <th><a class="filter" href="#" onclick="sortTable(5)">Datum</a></th>
                        <th><a class="filter" href="#" onclick="sortTable(6)">Begin</a></th>
                        <th><a class="filter" href="#" onclick="sortTable(7)">Einde</a></th>
                        <th><a class="filter" href="#" onclick="sortTable(8)">Locatie</a></th>
                        <th>Aanpassen</th>
                        <th>Verwijderen</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($events as $event)
                        <tr>
                            <td>
                                <div class="date-container">
                                    <div class="date-day">{{ \Carbon\Carbon::parse($event->date)->format('d') }}</div>
                                    <div class="date-month">{{ \Carbon\Carbon::parse($event->date)->format('M') }}</div>
                                </div>
                            </td>
                            <td>{{ $event->id }}</td>
                            <td>{{ $event->title }}</td>
                            <td>{{ $event->description ? "Ja" : "Nee" }}</td>
                            <td>{{ $event->spond_id ? "Ja" : "Nee" }}</td>
                            <td>{{ $event->date }}</td>
                            <td>{{ substr($event->start_time, 0, -3) }}</td>
                            <td>{{ substr($event->end_time, 0, -3) }}</td>
                            <td>{{ $event->location }}</td>
                            <td><a href="{{ route('events.edit', [$event]) }}"><button class="updateBtn">Aanpassen</button></a></td>
                            <td>
                                <form method="POST" action="{{ route('events.destroy', [$event]) }}" onsubmit="return confirmDelete()">
                                    @csrf
                                    @method('DELETE')
                                    <button class="deleteBtn" type="submit">Verwijderen</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>

    @else
        <b>Er zijn nog geen events</b>
    @endif

  @elseauth
    <section>
        <iframe src="https://embed.styledcalendar.com/#UyOpSAaIMWF0AU2Tddv3" title="Styled Calendar" class="styled-calendar-container" style="width: 100%; border: none;" data-cy="calendar-embed-iframe"></iframe>
        <script async type="module" src="https://embed.styledcalendar.com/assets/parent-window.js"></script>
    </section>
  @endadmin
@endauth

@guest
    <section>
        <style>
            .event-list {
                width: 80%;
                max-width: 1200px;
                margin: 20px auto;
                list-style-type: none;
                padding: 0;
            }
            .event-container {
                display: flex;
                flex-direction: column;
                gap: 20px;
            }
            .event {
                display: flex;
                align-items: center;
                padding: 20px;
                background-color: #000000;
                border-radius: 10px;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                transition: transform 0.3s, box-shadow 0.3s;
                text-decoration: none;
                color: inherit;
                position: relative;
                overflow: hidden;
            }
            .event:hover {
                transform: scale(1.03);
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            }
            .date-container {
                width: 10%;
                min-width: 40px;
                height: 70px;
                background-color: #333;
                color: white;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                border-radius: 10%;
                margin-right: 20px;
            }
            .date-day {
                font-size: 24px;
                font-weight: bold;
            }
            .date-month {
                font-size: 14px;
                text-transform: uppercase;
            }
            .event-title {
                font-size: 24px;
                font-weight: bold;
                margin: 0;
            }
            .event-date {
                font-size: 18px;
                color: #555;
                margin-top: 5px;
            }
        </style>
        <div class="event-list">
            <div class="event-container">
                @foreach ($events as $event)
                    <a href="{{ route('events.show', [$event]) }}" class="event">
                        <div class="date-container">
                            <div class="date-day">{{ \Carbon\Carbon::parse($event->date)->format('d') }}</div>
                            <div class="date-month">{{ \Carbon\Carbon::parse($event->date)->format('M') }}</div>
                        </div>
                        <div class="event-details">
                            <div class="event-title">{{ $event->title }}</div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endguest

@endsection
