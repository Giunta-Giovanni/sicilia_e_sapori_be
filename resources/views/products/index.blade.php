@extends('layouts.default')
<?php
session_start();
?>
<?php
// i prodotti devono essere filtrati

//noi i prodotti
$filteredProducts = $products;

// se il filtro è attivo 
if (isset($_GET['category'])) {

    //abbiamo un filtro 
    $filter = $_GET['category'];

    //se il filtro è food
    if ($filter === 'food') {
        $filteredProducts = $foodProducts;
    }
    // se il filtro è beverage
    elseif($filter === 'drink')
    {
    $filteredProducts = $beverageProducts;
    }
};
// se il filtro è attivo allora 
    
?>
@section('title','Prodotti')
@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Pagina Prodotti</h2>

        <div>
            <a href="{{ route('products.create', ['type'=>'food'] )}}" class="btn btn-success btn-sm ms-auto">
                <i class="bi bi-plus-lg"></i> Nuovo cibo
            </a>
            <a href="{{ route('products.create', ['type'=>'drink']) }}" class="btn btn-success btn-sm ms-auto">
                <i class="bi bi-plus-lg"></i> Nuovo bevanda
            </a>
        </div>

    </div>
    <form action="" class="w-100" style="max-width: 400px;">
        <div class="input-group mb-3">
            <select class="form-select" name="category" id="category" style="border-top-left-radius: 0.375rem; border-bottom-left-radius: 0.375rem;">
            <option value="all">Tutti i prodotti</option>
            <option value="food">Cibi</option>
            <option value="drink">Bevande</option>
            </select>
            <button type="submit" class="btn btn-secondary" style="border-top-right-radius: 0.375rem; border-bottom-right-radius: 0.375rem;">
            Cerca
            </button>
        </div>
    </form>

    <span>Totale prodotti:{{count($filteredProducts)}}</span>


    <div class="table-responsive">
        <table class="table table-bordered table-sm align-middle">
            <thead class="table-light text-center">
                <tr>
                    <th>Categorie</th>
                    <th>Nome Prodotto</th>
                    <th>prezzo</th>
                    <th>prezzo 2</th>
                    <th>Azioni</th>
                </tr>
            </thead>
            <tbody>
  
                @foreach ($filteredProducts as $filteredProducts)
                    <tr>
                        <td>{{ $filteredProducts->category->name }}</td>
                        <td>{{ $filteredProducts->name_it }}</td>
                        <td>{{$filteredProducts->primary_price}}</td>
                        <td>{{$filteredProducts->secondary_price}}</td>
                        <td class="text-center">
                            <a href="{{ route('products.show', $filteredProducts->id) }}" class="btn btn-outline-primary btn-sm px-3">
                                Visualizza
                            </a>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
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