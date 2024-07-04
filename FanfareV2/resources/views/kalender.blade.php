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
        <div style="margin-left:auto; margin-right:2em;">
            <a href="{{ route('events.create') }}"><button class="createBtn">Aanmaken</button></a>
        </div>
        <style>

        </style>
        <script>
            let currentSortColumn = null;
            let currentSortDirection = 'asc';

            function sortTable(columnIndex) {
                const table = document.getElementById("events-table");
                const rows = Array.from(table.rows).slice(1); // Exclude the header row

                // Reverse the sorting direction if the same column is clicked
                if (currentSortColumn === columnIndex) {
                    currentSortDirection = currentSortDirection === 'asc' ? 'desc' : 'asc';
                } else {
                    currentSortDirection = 'asc';
                }
                currentSortColumn = columnIndex;

                rows.sort((rowA, rowB) => {
                    let cellA = rowA.cells[columnIndex].textContent.trim();
                    let cellB = rowB.cells[columnIndex].textContent.trim();

                    // Convert numeric values to compare as numbers
                    if (!isNaN(cellA) && !isNaN(cellB)) {
                        return currentSortDirection === 'asc'
                            ? parseInt(cellA) - parseInt(cellB)
                            : parseInt(cellB) - parseInt(cellA);
                    } else {
                        return currentSortDirection === 'asc'
                            ? cellA.localeCompare(cellB)
                            : cellB.localeCompare(cellA);
                    }
                });

                // Clear the existing table rows
                while (table.rows.length > 1) {
                    table.deleteRow(1);
                }

                // Re-append sorted rows
                rows.forEach(row => {
                    table.appendChild(row);
                });
            }
            function confirmDelete() {
                return confirm("Ben je zeker dat je dit evenement wilt verwijderen?");
            }
        </script>
        <style>
            main {
                gap:0;
            }
        </style>
        <section>
            <table id="events-table">
                <thead>
                    <tr>
                        <th><a class="filter" href="#" onclick="sortTable(0)">id</a></th>
                        <th><a class="filter" href="#" onclick="sortTable(1)">titel</a></th>
                        <th><a class="filter" href="#" onclick="sortTable(2)">beschrijving</a></th>
                        <th><a class="filter" href="#" onclick="sortTable(3)">datum</a></th>
                        <th><a class="filter" href="#" onclick="sortTable(4)">begin</a></th>
                        <th><a class="filter" href="#" onclick="sortTable(5)">einde</a></th>
                        <th><a class="filter" href="#" onclick="sortTable(6)">locatie</a></th>
                        <th>aanpassen</th>
                        <th>verwijderen</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($events as $event)
                        <tr>
                            <td><a class="filter" href="{{ route('events.show',[$event]) }}">{{ $event->id }}</a></td>
                            <td>{{ $event->title }}</td>
                            <td>{{ $event->description ? "ja":"nee"; }}</td>
                            <td>{{ $event->date }}</td>
                            <td>{{ substr($event->start_time,0,-3) }}</td>
                            <td>{{ substr($event->end_time,0,-3) }}</td>
                            <td>{{ $event->location }}</td>
                            <td><a href="{{ route('events.edit',[$event]) }}"><button class="updateBtn">aanpassen</button></a></td>
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

        <section>
            <iframe src="https://embed.styledcalendar.com/#UyOpSAaIMWF0AU2Tddv3" title="Styled Calendar" class="styled-calendar-container" style="width: 100%; border: none;" data-cy="calendar-embed-iframe"></iframe>
            <script async type="module" src="https://embed.styledcalendar.com/assets/parent-window.js"></script>
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
            <iframe src="https://embed.styledcalendar.com/#UyOpSAaIMWF0AU2Tddv3" title="Styled Calendar" class="styled-calendar-container" style="width: 100%; border: none;" data-cy="calendar-embed-iframe"></iframe>
            <script async type="module" src="https://embed.styledcalendar.com/assets/parent-window.js"></script>
        </section>
    @endguest

@endsection


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
