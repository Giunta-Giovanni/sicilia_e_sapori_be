{{-- aut. layout --}}
@extends('layouts.default')

{{-- title --}}
@section('title', "Nuovo Prodotto")

{{-- body --}}
@section('content')

<?php

    // save food categorie
    $foodCategories =[];

    // save beverages categories
    $beverageCategories = [];
    foreach($categories as $category){
    if($category->type === 'food'){
        $foodCategories[] = $category;
    } else{
        $beverageCategories[] = $category;
    }
    }
?>
{{-- @dd($foodCategories) --}}
<form action="{{ route('products.store') }}" method="POST" class="container mt-4 p-4 border rounded shadow bg-white">
    
    {{--Token CSRF per protezione contro attacchi cross-site request forgery.--}}
    @csrf
    
    <input type="hidden" name="type" value="{{ $type }}">

    {{-- category --}}
    <div class="mb-3">
        <label for="category" class="form-label">Categoria*</label>
        <select name="category_id" id="category" class="form-select"required>
            @if($type === 'food')
                @foreach ($foodCategories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id?'selected':''}}>{{ $category->name }}</option>
                @endforeach
            @else
                @foreach ($beverageCategories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id?'selected':''}}>{{ $category->name }}</option>
                @endforeach
            @endif
        </select>
    </div>

      {{-- availability --}}
    <div class="mb-3">
        <label for="availability" class="form-label">Tipo di Disponibilità*</label>
        <select name="availability" id="availability" class="form-select"required>
            <option value='both' {{ old('availability') == 'both'?'selected':''}}>both</option>
            <option value='dinein' {{ old('availability') == 'dinein'?'selected':''}}>dinein</option>
            <option value='takeaway' {{ old('availability') == 'takeaway'?'selected':''}}>takeaway</option>
        </select>
    </div>

    {{-- name --}}
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="name_it" class="form-label">Nome (IT)*</label>
            <input 
                type="text" 
                name="name_it" 
                value="{{old('name_it')}}"
                id="name_it" 
                class="form-control" 
                required>
        @error('name_it')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
        </div>
        <div class="col-md-6">
            <label for="name_eng" class="form-label">Nome (EN)</label>
            <input 
                type="text" 
                name="name_eng" 
                value="{{old('name_eng')}}"
                id="name_eng" 
                class="form-control" >
            @error('name_eng')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- description --}}
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="description_it" class="form-label">Descrizione (IT)</label>
            <textarea name="description_it" id="description_it" class="form-control">{{old('description_it')}}</textarea>
            @error('description_it')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <label for="description_eng" class="form-label">Descrizione (EN)</label>
            <textarea name="description_eng" id="description_eng" class="form-control">{{old('description_eng')}}</textarea>
            
            @error('description_eng')
            <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- prices --}}
    <div class="row mb-3">
        {{-- primary price --}}
        <div class="col-md-6">
            <label for="primary_price" class="form-label">Prezzo principale*</label>
            <div class="input-group mb-3">
                <input 
                    type="number" 
                    step="0.01" 
                    min="0"
                    name="primary_price"
                    id="primary_price"
                    class="form-control price"
                    value="{{ old('primary_price') }}"
                    required>
                <span class="input-group-text">€</span>
                @error('primary_price')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- secondary price --}}
        <div class="col-md-6">
            <label for="secondary_price" class="form-label">Prezzo secondario</label>
            <div class="input-group mb-3">
                <input 
                    type="number" 
                    step="0.01" 
                    min="0"
                    name="secondary_price"
                    id="secondary_price"
                    class="form-control price"
                    value="{{ old('secondary_price') }}">
                <span class="input-group-text">€</span>
                @error('secondary_price')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <hr>

    {{-- food specific fields --}}
    @if ($type === 'food')
        <div class="mb-3 row justify-content-center text-center">
            {{-- is spicy? --}}
            <div class="col-sm-6 col-md-2 my-2">
                <label class="form-label">È piccante?*</label><br>
                <div class="form-check form-check-inline">
                    <input 
                        type="radio"
                        name="is_spicy" 
                        value="1" 
                        {{old('is_spicy') === '1'?'checked':''}}
                        id="spicy_yes" 
                        class="form-check-input">
                    <label for="spicy_yes" class="form-check-label">Sì</label>
                </div>
                <div class="form-check form-check-inline">
                    <input 
                        type="radio" 
                        name="is_spicy" 
                        value="0" 
                        {{old('is_spicy') === '0'?'checked':''}}
                        id="spicy_no" 
                        class="form-check-input"
                        required>
                    <label for="spicy_no" class="form-check-label">No</label>
                </div>
                @error('is_spicy')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            {{-- is vegetarian? --}}
            <div class="col-sm-6 col-md-2 my-2">
                <label class="form-label">È vegetariano?*</label><br>
                <div class="form-check form-check-inline">
                    <input 
                        type="radio" 
                        name="is_vegetarian" 
                        value="1" 
                        {{old('is_vegetarian') === '1'?'checked':''}}
                        id="vegetarian_yes" 
                        class="form-check-input"
                        required>
                    
                    <label for="vegetarian_yes" class="form-check-label">Sì</label>
                </div>
                <div class="form-check form-check-inline">
                    <input 
                        type="radio" 
                        name="is_vegetarian" 
                        value="0" 
                        {{old('is_vegetarian') === '0'?'checked':''}}
                        id="vegetarian_no" 
                        class="form-check-input">
                    <label for="vegetarian_no" class="form-check-label">No</label>
                </div>
                @error('is_vegetarian')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>
    @else {{-- drink specific fields --}}
        <div class="row mb-3">
            {{-- is alcholic --}}
            <div class="col-md-3">
                <label class="form-label">È alcolico?</label><br>
                <div class="form-check form-check-inline">
                    <input 
                        type="radio" 
                        name="is_alcholic"
                        value="1" 
                        {{old('is_alcholic') === '1'?'checked':''}}
                        id="is_alcholic_yes" 
                        class="form-check-input"
                        required>
                    <label for="alcoholic_yes" class="form-check-label">Sì</label>
                </div>
                <div class="form-check form-check-inline">
                    <input 
                        type="radio" 
                        name="is_alcholic"
                        value="0" 
                        {{old('is_alcholic') === 0?'checked':''}}
                        id="is_alcholic_no" 
                        class="form-check-input">
                    <label for="alcoholic_no" class="form-check-label">No</label>
                </div>
                @error('is_alcholic')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-3">
                <label for="alcohol_volume" class="form-label">Volume alcolico </label>
                <div class="input-group mb-3">
                    <input 
                        type="number" 
                        step="0.1" 
                        min="0"
                        name="alcohol_volume"
                        id="alcohol_volume"
                        value="{{ old('alcohol_volume') }}"
                        class="form-control input-number "
                        {{ old('is_alcoholic') === '1' ? 'required' : '' }}>
                    <span class="input-group-text">%</span>
                    @error('alcohol_volume')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

            </div>
            <div class="col-md-3">
                <label for="primary_size" class="form-label">Formato principale</label>
                <div class="input-group mb-3">
                    <input
                        type="number" 
                        step="1" 
                        min="0"
                        name="primary_size" 
                        value="{{old('primary_size')}}"
                        id="primary_size" 
                        class="form-control input-number "
                        required>
                    <span class="input-group-text">cc</span>
                    @error('primary_size')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-3">
                <label for="secondary_size" class="form-label">Formato secondario</label>
                <div class="input-group mb-3">
                    <input 
                        type="number" 
                        step="1" 
                        min="0"
                        name="secondary_size" 
                        value="{{old('secondary_size')}}"
                        id="secondary_size"
                        class="form-control input-number ">
                    <span class="input-group-text">cc</span>
                    @error('secondary_size')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    @endif

    <hr>

    {{-- allergens --}}
    <div class="mb-3">
     <h5 class="text-center">Allergeni</h5>
        <div class="row">
            @foreach ($allergens as $allergen)
                <div class="col-md-3 col-sm-4">
                    <div class="form-check">
                        <input 
                            type="checkbox" 
                            name="allergens[]" 
                            value="{{ $allergen->id }}" 
                            {{-- condizione per controllare se è attiva o no la checkbox --}}
                            {{ in_array($allergen->id, old('allergens', [])) ? 'checked' : '' }}
                            id="allergen-{{ $allergen->id }}" 
                            class="form-check-input">
                        <label for="allergen-{{ $allergen->id }}" class="form-check-label">
                            {{ $allergen->name }}
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
        @error('allergens')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <hr>

        {{-- pulsanti --}}
    <div class="d-flex justify-content-between align-items-center my-4 w-100">
        {{-- Torna indietro --}}
        <a href="{{ route('products.index') }}" class="btn btn-outline-primary shadow-sm">
            <i class="bi bi-arrow-left-circle"></i> Torna indietro
        </a>

        {{-- Submit --}}
        <button type="submit" class="btn btn-success">
            Salva
        </button>
    </div>
</form>
@endsection