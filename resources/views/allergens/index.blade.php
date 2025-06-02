@extends('layouts.default')
@section('title', "Allergeni")

@section('content')
<div class="container my-5">
    <div class="table-responsive d-flex justify-content-center">
        <table class="table table-sm table-bordered  align-middle text-center">
            <thead class="table-light">
                <tr>
                    <th class="p-3">ALLERGENI</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($allergens as $allergen)
                    <tr >
                        <td class="p-"><small>{{ $allergen->name }}</small></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection