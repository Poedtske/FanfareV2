@extends('layout')

@section('title', 'Belangrijke Documenten')

@section('customstyle', 'belangrijkeDocumenten')

@section('content')

<div class="document-list">
    @foreach($pdfFiles as $file)
    @php
        $filename = $file->getFilename();
        $basename = pathinfo($filename, PATHINFO_FILENAME);
    @endphp
    <a href="{{ asset('pdf/' . $file->getFilename()) }}" download="{{ $file->getFilename() }}" class="document-link">
        <div class="document">
            <!-- PDF Thumbnail -->
            <img src="{{ asset('images/pdf-logo.png') }}" alt="{{ $file->getFilename() }}" class="pdf-thumbnail">

            <!-- PDF Name -->

            <p class="pdf-name">{{ htmlspecialchars($basename) }}</p>
        </div>
    </a>
    @endforeach
</div>





@endsection
