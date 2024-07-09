@extends('layout')

@section('title', 'Sponsors')

@section('customstyle', 'sponsors')
@section('customscript', '')

@section('content')
    @auth
        @admin
        <style>
            main{
                grid-template-columns:1fr;
                justify-items: right;
            }
        </style>
        <div>
            <a href="{{ route('sponsors.create') }}"><button class="createBtn">Aanmaken</button></a>
        </div>

        @if ($sponsors)
        <script>
            let currentSortColumn = null;
            let currentSortDirection = 'asc';

            function sortTable(columnIndex) {
                const table = document.getElementById("sponsors-table");
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
                    } else if (columnIndex === 8) {
                        // Handle sorting for the 'status' column (active or not active)
                        return currentSortDirection === 'asc'
                            ? (cellA === 'Actief' ? 1 : -1) - (cellB === 'Actief' ? 1 : -1)
                            : (cellB === 'Actief' ? 1 : -1) - (cellA === 'Actief' ? 1 : -1);
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
                return confirm("Ben je zeker dat je deze sponsor wilt verwijderen?");
            }
        </script>

        <style>
            main {
                gap:0;
            }
        </style>

        <table id="sponsors-table">
            <thead>
                <tr>
                    <th>logoFoto</th>
                    <th><a class="filter" href="#" onclick="sortTable(1)">id</a></th>
                    <th><a class="filter" href="#" onclick="sortTable(2)">naam</a></th>
                    <th><a class="filter" href="#" onclick="sortTable(3)">beschrijving</a></th>
                    <th><a class="filter" href="#" onclick="sortTable(4)">logoLink</a></th>
                    <th><a class="filter" href="#" onclick="sortTable(5)">rang</a></th>
                    <th><a class="filter" href="#" onclick="sortTable(6)">sponserd</a></th>
                    <th><a class="filter" href="#" onclick="sortTable(7)">url</a></th>
                    <th><a class="filter" href="#" onclick="sortTable(8)">status</a></th>
                    <th>aanpassen</th>
                    <th>verwijderen</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sponsors as $sponsor)
                    <tr>
                        <td><a href="{{ route('sponsors.show',[$sponsor]) }}"><button><img src="{{ asset($sponsor->logo) }}" alt="{{ $sponsor->title.'_logo' }}"></button></a></td>
                        <td>{{ $sponsor->id }}</td>
                        <td>{{ $sponsor->title }}</td>
                        <td>{{ $sponsor->description ? "ja":"nee"; }}</td>
                        <td>{{ $sponsor->logo }}</td>
                        <td>{{ $sponsor->rank }}</td>
                        <td>{{ $sponsor->sponsored }}</td>
                        <td>{{ $sponsor->url }}</td>
                        @if ($sponsor->active)
                        <td>
                            <form action="{{ route('sponsors.changeState',[$sponsor]) }}" method="post">
                                @csrf
                                <button class="changeStateBtn" type="submit" name="id" value="{{ $sponsor->id }}" style="background-color: white;color:black;">Actief</button>
                            </form>
                        </td>
                        @else
                        <td>
                            <form action="{{ route('sponsors.changeState',[$sponsor]) }}" method="post">
                                @csrf
                                <button class="changeStateBtn" type="submit" name="id" value="{{ $sponsor->id }}" style="background-color: black;color:white">Niet Actief</button>
                            </form>
                        </td>
                        @endif
                        <td><a href="{{ route('sponsors.edit',[$sponsor]) }}"><button class="updateBtn">aanpassen</button></a></td>
                        <td>
                            <form method="POST" action="{{ route('sponsors.destroy', [$sponsor]) }}" onsubmit="return confirmDelete()">
                                @csrf
                                @method('DELETE')
                                <button class="deleteBtn" type="submit">Verwijderen</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <b>Er zijn nog geen sponsors</b>
    @endif

        @elseauth
            @if ($sponsors)
            <script>
                let main = document.querySelector("body main");
                const shuffle = (array) => {
                    for (let i = array.length - 1; i > 0; i--) {
                        const j = Math.floor(Math.random() * (i + 1));
                        [array[i], array[j]] = [array[j], array[i]];
                    }
                };

                async function asyncCall() {
                    try {
                        let sponsors = @json($sponsors);

                        // Initialize an empty array to hold the transformed sponsors
                        let transformedSponsors = [];

                        // Loop through each sponsor and transform the data
                        for (let sponsor of sponsors) {
                            let item = {
                                "naam": sponsor.title,
                                "link": sponsor.url,
                                "logo": sponsor.logo, // Assuming there is a logo field
                                "rang": sponsor.rank,
                                "geld": sponsor.sponsored,
                                "description":sponsor.description,
                                "id":sponsor.id
                            };
                            transformedSponsors.push(item);
                        }

                        sponsors = transformedSponsors;

                        let sponsorsLength = sponsors.length;

                        const ranking = (array, rang) => {
                            for (let i = 0; i < sponsors.length; i++) {
                                if (sponsors[i].rang == rang) {
                                    array.push(sponsors[i]);
                                    sponsors.splice(i, 1);
                                    i--;
                                }
                            }
                        };

                        let rang2 = [];
                        let rang3 = [];
                        let rang4 = [];

                        ranking(rang2, 2);
                        ranking(rang3, 3);
                        ranking(rang4, 4);

                        shuffle(rang2);
                        shuffle(rang3);
                        shuffle(rang4);

                        sponsors = [...sponsors, ...rang2, ...rang3, ...rang4];
                        sponsors.length = sponsorsLength;

                        const placingImage = (sponsor) => {
                            if (sponsor.naam == null || sponsor.logo == null || sponsor.rang == null) {
                                throw new Error('Incomplete sponsor data');
                            }

                            let width = 200;

                            if (sponsor.rang == 1) {
                                width = 290;
                            } else if (sponsor.rang == 2) {
                                width = 250;
                            } else if (sponsor.rang == 3) {
                                width = 220;
                            }
                            let sponsorShowUrl = "{{ route('sponsors.show', ['sponsor' => ':id']) }}";

                            let linkElement;
                            let sponsorId=sponsor.id;
                            if (sponsor.description!=null) {
                                let showUrl = sponsorShowUrl.replace(':id', sponsor.id);
                                linkElement = `<button style="width: ${width}px;">
                                    <a href="${showUrl}" target="_blank">
                                        <img src="${sponsor.logo}" alt="${sponsor.naam}" style="width: ${width}px;">
                                    </a>
                                </button>`;
                            } else if(sponsor.link==null){
                                linkElement=`<button class="no_website" style="width: ${width}px;">
                                    <img src="${sponsor.logo}" alt="${sponsor.naam}" style="width: ${width}px;">
                                </button>`;
                            }else{
                                linkElement=`<button style="width: ${width}px;">
                                    <a href="${sponsor.link}" target="_blank">
                                        <img src="${sponsor.logo}" alt="${sponsor.naam}" style="width: ${width}px;">
                                    </a>
                                </button>`;
                            }

                            return `<section>${linkElement}</section>`;
                        };

                        const sponsorElements = sponsors.map(placingImage).join('');
                        main.innerHTML = sponsorElements;
                    } catch (error) {
                        console.error('Error:', error);
                    }
                }

                asyncCall();
            </script>
            @else
                <b>Er zijn nog geen sponsors</b>
            @endif
        @endadmin
    @endauth
    @guest
        @if ($sponsors)
        <script>
            let main = document.querySelector("body main");
            const shuffle = (array) => {
                for (let i = array.length - 1; i > 0; i--) {
                    const j = Math.floor(Math.random() * (i + 1));
                    [array[i], array[j]] = [array[j], array[i]];
                }
            };

            async function asyncCall() {
                try {
                    let sponsors = @json($sponsors);

                    // Initialize an empty array to hold the transformed sponsors
                    let transformedSponsors = [];

                    // Loop through each sponsor and transform the data
                    for (let sponsor of sponsors) {
                        let item = {
                            "naam": sponsor.title,
                            "link": sponsor.url,
                            "logo": sponsor.logo, // Assuming there is a logo field
                            "rang": sponsor.rank,
                            "geld": sponsor.sponsored,
                            "description":sponsor.description,
                            "id":sponsor.id
                        };
                        transformedSponsors.push(item);
                    }

                    sponsors = transformedSponsors;

                    let sponsorsLength = sponsors.length;

                    const ranking = (array, rang) => {
                        for (let i = 0; i < sponsors.length; i++) {
                            if (sponsors[i].rang == rang) {
                                array.push(sponsors[i]);
                                sponsors.splice(i, 1);
                                i--;
                            }
                        }
                    };

                    let rang2 = [];
                    let rang3 = [];
                    let rang4 = [];

                    ranking(rang2, 2);
                    ranking(rang3, 3);
                    ranking(rang4, 4);

                    shuffle(rang2);
                    shuffle(rang3);
                    shuffle(rang4);

                    sponsors = [...sponsors, ...rang2, ...rang3, ...rang4];
                    sponsors.length = sponsorsLength;

                    const placingImage = (sponsor) => {
                        if (sponsor.naam == null || sponsor.logo == null || sponsor.rang == null) {
                            throw new Error('Incomplete sponsor data');
                        }

                        let width = 200;

                        if (sponsor.rang == 1) {
                            width = 290;
                        } else if (sponsor.rang == 2) {
                            width = 250;
                        } else if (sponsor.rang == 3) {
                            width = 220;
                        }
                        let sponsorShowUrl = "{{ route('sponsors.show', ['sponsor' => ':id']) }}";

                        let linkElement;
                        let sponsorId=sponsor.id;
                        if (sponsor.description!=null) {
                                let showUrl = sponsorShowUrl.replace(':id', sponsor.id);
                                linkElement = `<button style="width: ${width}px;">
                                    <a href="${showUrl}" target="_blank">
                                        <img src="${sponsor.logo}" alt="${sponsor.naam}" style="width: ${width}px;">
                                    </a>
                                </button>`;
                            } else if(sponsor.link==null){
                                linkElement=`<button class="no_website" style="width: ${width}px;">
                                    <img src="${sponsor.logo}" alt="${sponsor.naam}" style="width: ${width}px;">
                                </button>`;
                            }else{
                                linkElement=`<button style="width: ${width}px;">
                                    <a href="${sponsor.link}" target="_blank">
                                        <img src="${sponsor.logo}" alt="${sponsor.naam}" style="width: ${width}px;">
                                    </a>
                                </button>`;
                            }

                        return `<section>${linkElement}</section>`;
                    };

                    const sponsorElements = sponsors.map(placingImage).join('');
                    main.innerHTML = sponsorElements;
                } catch (error) {
                    console.error('Error:', error);
                }
            }

            asyncCall();
        </script>
        @else
            <b>Er zijn nog geen sponsors</b>
        @endif
    @endguest
@endsection
