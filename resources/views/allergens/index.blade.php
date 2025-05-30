@extends('layouts.default')
@section('title', "Allergeni")

@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0 text-center flex-grow-1">Pagina Prodotti</h2>
        <a href="{{ route('allergens.create') }}" class="btn btn-success ms-auto">
            <i class="bi bi-plus-lg"></i> Aggiungi Allergene
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-sm align-middle">
            <thead class="table-light text-center">
                <tr>
                    <th>Nome allergene</th>
                    <th>Azioni</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($allergens as $allergen)
                    <tr>
                        <td>{{ $allergen->name }}</td>
                        <td class="text-center">
                            <a href="{{ route('allergens.edit', $allergen) }}" class="btn btn-outline-warning m-1 py-1 px-2 shadow-sm">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <button type="button" class="btn btn-outline-danger m-1 py-1 px-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $allergen->id }}">
                                <i class="bi bi-trash"></i>
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="deleteModal-{{ $allergen->id }}" tabindex="-1" aria-labelledby="deleteModalLabel-{{ $allergen->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-6" id="deleteModalLabel-{{ $allergen->id }}">Elimina allergene</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi"></button>
                                        </div>
                                        <div class="modal-body">
                                            Sei sicuro di voler eliminare questo allergene: <strong>{{ $allergen->name }}</strong>?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Annulla</button>
                                            <form action="{{ route('allergens.destroy', $allergen) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <input type="submit" class="btn btn-danger btn-sm" value="Elimina Allergene">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Fine Modal -->
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection