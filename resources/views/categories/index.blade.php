@extends('layouts.default')

@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Pagina Categorie</h2>
        <a href="{{ route('categories.create') }}" class="btn btn-success">
            <i class="bi bi-plus-lg"></i> Aggiungi Categoria
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-sm align-middle">
            <thead class="table-light text-center">
                <tr>
                    <th>Nome della Categoria</th>
                    <th>Azioni</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td class="text-center">
                            <a href="{{ route('categories.edit', $category) }}" class="btn btn-outline-warning m-1 py-1 px-2 shadow-sm">
                                <i class="bi bi-pencil-square"></i> 
                            </a>
                            <button type="button" class="btn btn-outline-danger m-1 py-1 px-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#exampleModal-{{ $category->id }}">
                                <i class="bi bi-trash"></i>
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal-{{ $category->id }}" tabindex="-1" aria-labelledby="exampleModalLabel-{{ $category->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-6" id="exampleModalLabel-{{ $category->id }}">Elimina Categoria</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi"></button>
                                        </div>
                                        <div class="modal-body">
                                            Sei sicuro di voler eliminare la categoria: <strong>{{ $category->name }}</strong>?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Annulla</button>
                                            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <input type="submit" class="btn btn-danger btn-sm" value="Elimina Categoria">
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