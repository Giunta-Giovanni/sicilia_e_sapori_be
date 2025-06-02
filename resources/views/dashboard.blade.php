@extends('layouts.default')

@section('content')
<div class="container">
    <h2 class="text-center my-4">
        {{ __('Zona di amministrazione di Sicilia e sapori') }}
    </h2>
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">{{ __('User Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    {{ __('Benvenuta, sei online') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
