@extends('layouts.default')
<?php
session_start();
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
    <span>Totale prodotti:{{count($products)}}</span>

    <div class="table-responsive">
        <table class="table table-bordered table-sm align-middle">
            <thead class="table-light text-center">
                <tr>
                    <th>Categoria</th>
                    <th>Nome Prodotto</th>
                    <th>Azioni</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->category->name }}</td>
                        <td>{{ $product->name_it }}</td>
                        <td class="text-center">
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-primary btn-sm px-3">
                                Visualizza
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection