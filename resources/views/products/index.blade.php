@extends('layouts.default')
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

    <form action="" method="get" class="w-100" style="max-width: 400px;">
        <div class="input-group mb-3">
            <select class="form-select" name="category" id="category" style="border-top-left-radius: 0.375rem; border-bottom-left-radius: 0.375rem;">
                <option value="">Tutte le categorie</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-secondary" style="border-top-right-radius: 0.375rem; border-bottom-right-radius: 0.375rem;">
                Cerca
            </button>
        </div>
    </form>

    <span>Totale prodotti:{{count($products)}}</span>

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
                @foreach ($products as $products)
                    <tr>
                        <td>{{ $products->category->name }}</td>
                        <td>{{ $products->name_it }}</td>
                        <td>{{$products->primary_price}} €</td>
                        <td class="{{!$products->secondary_price?'empty-tab':''}}">{{$products->secondary_price?"$products->secondary_price €":''}}</td>
                        <td class="text-center">
                            <a href="{{ route('products.show', $products->id) }}" class="btn btn-outline-primary btn-sm px-3">
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