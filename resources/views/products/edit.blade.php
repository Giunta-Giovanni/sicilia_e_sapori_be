@extends('layouts.default')

@section('title', "Nuovo Prodotto")

@section('content')
<form action="{{ route('products.update', $product) }}" method="POST" class="container mt-4 p-4 border rounded shadow bg-white">
    @csrf
    @method('PUT')
    


    {{-- @dd($product->type) --}}
    {{-- type --}}
    <input type="hidden" name="type" value="{{ $product->type }}">


    {{-- category --}}
    <div class="mb-3">
        <label for="category" class="form-label">Categoria</label>
        <select name="category_id" id="category" class="form-select"required>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- name --}}
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="name_it" class="form-label">Nome (IT)</label>
            <input type="text" name="name_it" id="name_it" class="form-control" value="{{$product->name_it}}" required>
        </div>
        <div class="col-md-6">
            <label for="name_eng" class="form-label">Nome (EN)</label>
            <input type="text" name="name_eng" id="name_eng" class="form-control" value="{{$product->name_eng}}" required>
        </div>
    </div>

    {{-- description --}}
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="description_it" class="form-label" >Descrizione (IT)</label>
            <textarea name="description_it" id="description_it" class="form-control">{{$product->description_it}}</textarea>
        </div>
        <div class="col-md-6">
            <label for="description_eng" class="form-label">Descrizione (EN)</label>
            <textarea name="description_eng" id="description_eng" class="form-control">{{$product->description_eng}}</textarea>
        </div>
    </div>

    {{-- prices --}}
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="primary_price" class="form-label" >Prezzo principale</label>
            <div class="input-group mb-3">
                <input type="text"name="primary_price" id="primary_price" class="form-control" value='{{$product->primary_price}}' aria-label="inserisci il prezzo" required>
                <span class="input-group-text">€</span>
            </div>
        </div>
        <div class="col-md-6">
            <label for="secondary_price" class="form-label">Prezzo secondario</label>
            <div class="input-group mb-3">
                <input type="text"name="secondary_price" id="secondary_price" class="form-control" value='{{$product->secondary_price?$product->secondary_price:0}}' aria-label="inserisci il prezzo">
                <span class="input-group-text">€</span>
            </div>
        </div>
    </div>
    <hr>

    {{-- food specific fields --}}
    @if ($product->type === 'food')
        <div class="mb-3 row justify-content-center text-center">
            <div class="col-sm-6 col-md-2 my-2">
                <label class="form-label">È piccante?</label><br>
                <div class="form-check form-check-inline">
                    <input type="radio" name="is_spicy" value="1" id="spicy_yes" class="form-check-input">
                    <label for="spicy_yes" class="form-check-label">Sì</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" name="is_spicy" value="0" id="spicy_no" class="form-check-input">
                    <label for="spicy_no" class="form-check-label">No</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-2 my-2">
                <label class="form-label">È vegetariano?</label><br>
                <div class="form-check form-check-inline">
                    <input type="radio" name="is_vegetarian" value="1" id="vegetarian_yes" class="form-check-input">
                    <label for="vegetarian_yes" class="form-check-label">Sì</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" name="is_vegetarian" value="0" id="vegetarian_no" class="form-check-input">
                    <label for="vegetarian_no" class="form-check-label">No</label>
                </div>
            </div>
            

        </div>
    @else
        {{-- drink specific fields --}}
        <div class="row mb-3">
            <div class="col-md-3">
                <label class="form-label">È alcolico?</label><br>
                <div class="form-check form-check-inline">
                    <input type="radio" name="is_alcholic" value="1" id="is_alcholic_yes" class="form-check-input">
                    <label for="alcoholic_yes" class="form-check-label">Sì</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" name="is_alcholic" value="0" id="is_alcholic_no" class="form-check-input">
                    <label for="alcoholic_no" class="form-check-label">No</label>
                </div>
            </div>
            <div class="col-md-3">
                <label for="alcohol_volume" class="form-label">Volume alcolico </label>
                <div class="input-group mb-3">
                    <input type="text"name="alcohol_volume" id="alcohol_volume" class="form-control"  aria-label="inserisci la percentuale alcolica" required>
                    <span class="input-group-text">%</span>
                </div>
            </div>
            <div class="col-md-3">
                <label for="primary_size" class="form-label">Formato principale</label>
                <div class="input-group mb-3">
                    <input type="text"name="primary_size" id="primary_size" class="form-control"  aria-label="inserisci la dimensione" required>
                    <span class="input-group-text">cc</span>
                </div>
            </div>
            <div class="col-md-3">
                <label for="secondary_size" class="form-label">Formato secondario</label>
                <div class="input-group mb-3">
                    <input type="text"name="secondary_size" id="secondary_size" class="form-control"  aria-label="inserisci la dimensione" required>
                    <span class="input-group-text">cc</span>
                </div>
            </div>
        </div>
    @endif

    <hr>

    {{-- allergens --}}
    <h5 class="text-center">Allergeni</h5>
    <div class="mb-3">
        <div class="row">
            @foreach ($allergens as $allergen)
                <div class="col-md-3 col-sm-4">
                    <div class="form-check">
                        <input type="checkbox" name="allergens[]" value="{{ $allergen->id }}" id="allergen-{{ $allergen->id }}" class="form-check-input"
                        {{-- condizione per controllare se è attiva o no la checkbox --}}
                        {{$product->allergens->contains($allergen->id)?'checked':''}}
                        >
                        <label for="allergen-{{ $allergen->id }}" class="form-check-label">
                            {{ $allergen->name }}
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <hr>

    {{-- submit --}}
    <div class="text-center">
        <button type="submit" class="btn btn-primary">
            Salva
        </button>
    </div>
</form>
@endsection