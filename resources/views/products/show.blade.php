{{-- aut. layout --}}
@extends('layouts.default')

{{-- title --}}
@section('content')


<?php
// salvo gli allergeni del prodotto in una lista
    $allergens =[];
    foreach($product->allergens as $allergen){
        array_push($allergens, $allergen->name );
    }; 
?>

<div class="container">
    <h1 class="text-center my-4">Pagina Prodotto: <strong>{{$product->name_it}}</strong></h1>


    {{-- Lingue --}}
    <div class="row mb-4">
        {{-- ITALIANO --}}
        <div class='col-md-6'>
            <div class="card shadow-sm">
                <div class="card-header text-white bg-primary text-center">🇮🇹 Italiano</div>
                <div class="card-body">
                    <p><strong>Nome:</strong> {{$product->name_it}}</p>
                    <p><strong>Descrizione:</strong> {{$product->description_it}}</p>
                </div>
            </div>
        </div>

        {{-- INGLESE --}}
        <div class='col-md-6'>
            <div class="card shadow-sm">
                <div class="card-header text-white bg-success text-center">🇬🇧 English</div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{$product->name_eng}}</p>
                    <p><strong>Description:</strong> {{$product->description_eng}}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Info principali --}}
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle text-center shadow-sm">
            <thead class="table-dark">
                <tr>
                    <th colspan="2">Informazioni Generali</th>
                </tr>
            </thead>
            <tbody>
                
                {{-- Disponibilità --}}
                <tr>
                    <td><strong>Tipo di Disponibilità</strong></td>
                    <td>{{ $product->availability }}</td>
                </tr>


                {{-- Prezzo primario --}}
                <tr>
                    <td><strong>Prezzo</strong></td>
                    <td>{{ $product->primary_price }} €</td>
                </tr>

                {{-- Prezzo secondario --}}
                @if ($product->secondary_price)
                    <tr>
                        {{-- Condizione Nome prezzo per pizze o bevande --}}
                        <td><strong>{{$product->category->type === 'food'?'Prezzo Maxi / Scrocchiarella': 'Prezzo Secondario'}}</strong></td>
                        <td>{{ $product->secondary_price }} €</td>
                    </tr>
                @endif

                {{-- Categorie --}}
                <tr>
                    <td><strong>Categoria</strong></td>
                    <td>{{ $product->category->name }}</td>
                </tr>


                {{-- Allergeni --}}
                @if($allergens)
                    <tr>
                        <td><strong>Allergeni</strong></td>
                        <td>
                        {{join(', ',$allergens)}}
                        </td>
                    </tr>
                @endif
      
                {{-- Info specifiche per tipo prodotto --}}
                {{-- Se è un cibo  --}}
                @if ($product->category->type === 'food')

                        {{-- Piccante --}}
                        <tr>
                            <td><strong>Piccante?</strong></td>
                            <td class="{{ $product->food->is_spicy ? 'table-success' : 'table-danger'}}">
                                {{ $product->food->is_spicy ? 'SI' : 'NO' }}
                            </td>
                        </tr>
                        
                        {{-- Vegetariano --}}
                        <tr>
                            <td><strong>Vegetariano?</strong></td>
                            <td class="{{ $product->food->is_vegetarian ? 'table-success' : 'table-danger' }}">
                                {{ $product->food->is_vegetarian ? 'SI' : 'NO' }}
                            </td>
                        </tr>

                {{-- Se è una bevanda --}}
                @elseif ($product->category->type === 'drink')
                     {{-- alcolico? --}}
                    <tr>
                        <td><strong>Alcolico?</strong></td>
                        <td class="{{ $product->beverage->is_alcholic ?  'table-success' : 'table-danger'}}">
                            {{ $product->beverage->is_alcholic ? 'SI' : 'NO' }}
                        </td>
                    </tr>
                    {{-- percentuale alcolica --}}
                    <tr>
                        <td><strong>Vol. Alcolico</strong></td>
                        <td>{{ $product->beverage->alcohol_volume }}%</td>
                    </tr>
                    {{-- Formato Standard --}}
                    <tr>
                        <td><strong>Formato Standard</strong></td>
                        <td>{{ $product->beverage->primary_size }} cl</td>
                    </tr>

                    {{-- Formato Secondario --}}
                    @if ($product->beverage->secondary_size)
                        <tr>
                            <td><strong>Formato Grande</strong></td>
                            <td>{{ $product->beverage->secondary_size }} cl</td>
                        </tr>
                    @endif
                @endif
            </tbody>
        </table>
    </div>

    {{-- pulsanti --}}
    <div class="d-flex justify-content-center my-4">
        {{-- Torna indietro --}}
        <a href="{{ route('products.index') }}" class="btn btn-outline-primary mx-4 shadow-sm">
            <i class="bi bi-arrow-left-circle"></i> Torna indietro
        </a>

        {{-- Modifica --}}
        <a href="{{ route('products.edit', $product) }}" class="btn btn-outline-warning mx-4 shadow-sm">
            <i class="bi bi-pencil-square"></i> Modifica
        </a>

        {{-- Elimina --}}
        <button type="button" class="btn btn-outline-danger mx-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
            <i class="bi bi-trash"></i> Elimina
        </button>
    </div>  
</div>
@endsection

{{-- Pop up per confermare l'eliminazione --}}
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Elimina il Prodotto</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Sei sicura di voler eliminare il Prodotto: {{$product->name_it}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                
                {{-- pulsante destroy --}}
                <form action="{{route('products.destroy', $product)}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="submit" class="btn btn-danger" value="Elimina Prodotto">
                </form>
            </div>
        </div>
    </div>
</div>