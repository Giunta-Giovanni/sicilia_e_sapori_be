{{-- no aut. layout --}}
@extends('layouts.app')

{{-- title --}}
@section('title', "Home")

{{-- body --}}
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center text-center">
        <div class="col-md-8">
            <h1 class="mb-4">Benvenuto nella pagina di amministrazione di Sicilia e Sapori</h1>
            <img src="{{ asset('img/logo.svg') }}" alt="Sicilia e Sapori" class="logo-home" />
            
            {{-- login button --}}
            <p class="mb-4 ">
                <a class="login-btn" href="{{ route('login') }}">Accedi per continuare</a>
            </p>
        </div>
    </div>
</div>
@endsection