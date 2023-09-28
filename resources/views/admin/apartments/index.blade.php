@extends('layouts.app')

@section('content-class', 'container')
@section('content')
    <header class="d-flex justify-content-between  my-5">
        <a href="{{ route('admin.apartments.trash') }}" class="btn btn-secondary">vai al cestino</a>
        <a href="{{ route('admin.apartments.create') }}" class="btn btn-success">Aggiungi un appartamento</a>
    </header>
    <div class="row row-cols-4 g-4 my-5">
        @foreach ($apartments as $apartment)
            <div class="col">

                <div class="card">
                    {{-- <img src="..." class="card-img-top" alt="..."> --}}
                    <div class="card-body">
                        <h5 class="card-title">{{ $apartment->title }}</h5>
                        <p class="card-text">{{ $apartment->description }}</p>

                        {{-- # DELETE --}}
                        <form class="destroy-form" action="{{ route('admin.apartments.destroy', $apartment) }}"
                            method="POST" data-title="{{ $apartment->title }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">Elimina <i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
