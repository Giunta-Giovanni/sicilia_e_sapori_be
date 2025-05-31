@extends('layouts.default')

@section('title', "Nuovo Prodotto")

@section('content')

<form action="{{ route('products.store') }}" method="POST" class="container mt-4 p-4 border rounded shadow-sm bg-light">
    {{-- token di protezione che identifica che la chiamata post avvenga tramite un form del sito stesso --}}
    @csrf

    {{-- identifichiamo il metodo put --}}
    @method('PUT')

    {{-- type - radio --}}
    <div class="mb-3">
        <p>Inserisci il tipo di prodotto che vuoi inserire</p>
        {{-- food --}}
        <input type="radio" name="type" value="food" id="is_food">
        <label for="type" class="form-label">food</label>
        {{-- beverage --}}
        <input type="radio" name="type" value="drink" id="is_drink">
        <label for="type" class="form-label">beverage</label>
    </div>
    {{-- categoria --}}
    <div class="mb-3">
        <label for="category" class="form-label">Categoria</label>
        <select name="category" id="category" class="form-select" required>
            @foreach ($categories as $category)
            <option value="{{$category->id}}">{{$category->name}}</option>
            @endforeach
        </select>
    </div>
    {{-- nome in italiano --}}
    <div class="mb-3">
        <label for="name_it" class="form-label">Nome in italiano</label>
        <input type="text" name="name_it" id="name_it" required>
    </div>
    {{-- nome in inglese --}}
    <div class="mb-3">
        <label for="name_eng" class="form-label">Nome in inglese</label>
        <input type="text" name="name_it" id="name_eng" required>
    {{-- descrizione in italiano --}}
    <div class="mb-3">
        <label for="description_it" class="form-label">Descrizione in italiano</label>
        <textarea name="description_it" id="description_it"></textarea>
    </div>
    {{-- descrizione in inglese --}}
    <div class="mb-3">
        <label for="description_eng" class="form-label">Descrizione in inglese</label>
        <textarea name="description_eng" id="description_eng"></textarea>
    </div>
    {{-- prezzo primario --}}
    <div class="mb-3">
        <label for="primary_price" class="form-label">Prezzo standard</label>
        <input type="text" name="primary_price" id="primary_price" required>
        <span>€</span>
    </div>
    {{-- prezzo secondario --}}
    <div class="mb-3">
        <label for="secondary_price" class="form-label">Prezzo standard</label>
        <input type="text" name="secondary_price" id="secondary_price">
        <span>€</span>
    </div>
    


    {{-- se è un prodotto food --}}
    <div class="mb-3">
        <p>Il prodotto contiene piccante?</p>
        {{-- true --}}
        <input type="radio" name="is_spicy" value="1">
        <label for="is_spicy" class="form-label">Si</label>
        {{-- false --}}
        <input type="radio" name="is_spicy" value="0">
        <label for="is_spicy" class="form-label">No</label>
    </div>
    <div class="mb-3">
        <p>è un prodotto vegetariano?</p>
        {{-- true --}}
        <input type="radio" name="is_vegetarian" value="1">
        <label for="is_vegetarian" class="form-label">Si</label>
        {{-- false --}}
        <input type="radio" name="is_vegetarian" value="0">
        <label for="is_vegetarian" class="form-label">No</label>
    </div>

        {{-- se è un prodotto beverage --}}
    <div class="mb-3">
        <p>è una bevanda alcolica?</p>
        {{-- true --}}
        <input type="radio" name="is_alcholic" value="1">
        <label for="is_alcholic" class="form-label">Si</label>
        {{-- false --}}
        <input type="radio" name="is_alcholic" value="0">
        <label for="is_alcholic" class="form-label">No</label>
    </div>
    <div class="mb-3">
        <label for="alcohol_volume" class="form-label">Percentuale alcolica</label>
        <input type="text" name="alcohol_volume" id="alcohol_volume">
        <span>%</span>
    </div>
    <div class="mb-3">
        <label for="primary_size" class="form-label">Dimensioni normali</label>
        <input type="text" name="primary_size" id="primary_size">
        <span>cc</span>
    </div>
        <div class="mb-3">
        <label for="primary_size" class="form-label">Dimensioni grandi</label>
        <input type="text" name="primary_size" id="primary_size">
        <span>cc</span>
    </div>





    {{-- allergeni --}}
    <div>
        @foreach ($allergens as $allergen)
        <input 
            type="checkbox"
            name="allergens[]"
            value="{{$allergen->id}}"
            id="allergen-{{$allergen->id}}"
            class="form-check-input"
        >
        <label
            for="allergen-{{$allergen->id}}"
            class="form-check-label"
        >
        {{$allergen->name}}
        </label>
        @endforeach
        
    </div>
        
</form>

@endsection