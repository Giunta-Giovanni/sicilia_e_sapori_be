@extends('layouts.default')
@section('title', "Categorie prodotti")

@section('content')
<div class="container my-5">
    <div class="table-responsive d-flex justify-content-center">
        <table class="table table-sm table-bordered  align-middle text-center">
            <thead class="table-light">
                <tr>
                    <th class="p-3">CATEGORIE</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr >
                        <td class="p-"><small>{{ $category->name }}</small></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection