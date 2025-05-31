@extends('layouts.default')

@section('title', "Modifica Allergene")

@section('content')

<form action="{{ route('allergens.update', $allergen) }}" method="POST" class="container mt-4 p-4 border rounded shadow-sm bg-light">
    {{-- token di protezione che identifica che la chiamata post avvenga tramite un form del sito stesso --}}
    @csrf

    {{-- identifichiamo il metodo put --}}
    @method('PUT')

    {{-- titolo --}}
    <div class="mb-3">
        <label for="title" class="form-label">Titolo</label>
        <input type="text" name="title" id="title" class="form-control" value={{$project->title}}   required>
    </div>




</form>

@endsection