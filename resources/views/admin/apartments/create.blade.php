@extends('layouts.app')

@section('content-class', 'container')
@section('content')

    <div class="container my-4">
        <h2 class="text-white">Aggiungi un nuovo Appartamento : </h2>
        @include('includes.apartments.formpage')
    </div>
@endsection
