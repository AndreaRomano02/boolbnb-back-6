@extends('layouts.app')

@section('content-class', 'container')
@section('content')

    <div class="container">
        <h2>Aggiungi un nuovo Appartamento : </h2>
        @include('includes.apartments.formpage')
    </div>
@endsection
