{{-- aut. layout --}}
@extends('layouts.default')

{{-- title --}}
@section('title','Prodotti')

{{-- body --}}
@section('content')

<div class="container my-5">

    <div class="text-center d-sm-flex justify-content-between align-items-center mb-3 ">
        <h2 class="mb-0">Pagina Prodotti</h2>
        {{-- Pulsanti di aggiunta prodotto --}}
        <div class="my-3 ">
            {{-- nuovo cibo --}}
            <a href="{{ route('products.create', ['type'=>'food'] )}}" class="btn btn-success btn-sm ms-auto">
                <i class="bi bi-plus-lg"></i> Nuovo cibo
            </a>
            {{-- nuova bevanda --}}
            <a href="{{ route('products.create', ['type'=>'drink']) }}" class="btn btn-success btn-sm ms-auto">
                <i class="bi bi-plus-lg"></i> Nuovo bevanda
            </a>
        </div>
    </div>

    {{-- form di richiesta per filtrare il menu --}}
    <form action="" method="get" class="w-100" style="max-width: 400px;">
        <div class="input-group mb-3">
            {{-- selezione categorie --}}
            <select class="form-select" name="category" id="category" style="border-top-left-radius: 0.375rem; border-bottom-left-radius: 0.375rem;">
                <option value="">Tutte le categorie</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            {{-- pulsante di invio richiesta --}}
            <button type="submit" class="btn search_btn" style="border-top-right-radius: 0.375rem; border-bottom-right-radius: 0.375rem;">
                Cerca
            </button>
        </div>
    </form>

    {{-- Totale prodotti caricati --}}
    <span>Totale prodotti:{{count($products)}}</span>

    <div class="table-responsive">
        <table class="table ses-table table-sm align-middle">
            <thead class="table-light text-center ">
            {{-- titoli colonne --}}
                <tr>
                    {{-- categorie --}}
                    <th class="d-none d-sm-table-cell">Categorie</th>
                    {{-- Disponibilità --}}
                    <th class="d-none d-sm-table-cell">Disponibilita</th>
                    {{-- nome --}}
                    <th>Nome Prodotto</th>
                    {{-- descrizione --}}
                    <th class="d-none d-md-table-cell">Descrizione</th>
                    {{-- allergeni --}}
                    <th class="d-none d-sm-table-cell">Allergeni</th>
                    {{-- action --}}
                    <th>Azioni</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)

                <?php
                    $allergens =[];
                    foreach($product->allergens as $allergen){
                        array_push($allergens, $allergen->name );
                    }; 
                ?>
                    <tr>
                        {{-- categorie --}}
                        <td class="d-none d-sm-table-cell cat{{$product->category->id}}">{{ $product->category->name }}</td>
                        {{-- nome con e senza stile --}}
                        <td class="d-none d-sm-table-cell cat">{{$product->availability}}</td>

                        <td class="d-none d-sm-table-cell cat">{{ $product->name_it }}</td>
                        <td class="d-sm-none cat{{$product->category->id}}">{{ $product->name_it }}</td>
                        {{-- descrizione --}}
                        <td class="d-none d-md-table-cell {{!$product->description_it? "empty-tab":null }} ">{{$product->description_it?$product->description_it:'Nessuna Descrizione' }}</td>
                        {{-- allergeni --}}
                        <td class="d-none d-sm-table-cell {{!count($allergens)? "empty-tab":null }}">{{ count($allergens) ? implode(', ', $allergens) : '//' }}</td>
                        {{-- action --}}
                        <td class="text-center show_btn">
                            <a href="{{ route('products.show', $product->id) }}">
                                <img src="{{ asset('img/lens.svg') }}" alt="">
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- pop up eliminazione --}}
    @if (session('success'))
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div class="toast align-items-center text-bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
        <div class="toast-body">
            {{ session('success') }}
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
    </div>
    @endif
</div>
@endsection