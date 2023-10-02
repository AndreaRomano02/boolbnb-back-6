@extends('layouts.dashboard')

@section('title', 'Archive')

@section('content')
    <h1>Archivio</h1>
    <div class="d-flex justify-content-between  my-4">
        <a class="btn btn-outline-secondary" href="{{ route('admin.apartments.index') }}">Torna all'elenco</a>
    </div>
    <section class="row row-cols-3">
        @if (count($apartments))
            @foreach ($apartments as $apartment)
                <div class="col">
                    <div class="card m-2">
                        <div class="card-body">
                            <img v-if="apartment.images.length" class="card-img-top"
                                src="{{ 'http://127.0.0.1:8000/storage/' . $apartment->images[0]->path }}" />
                            <h5 class=" my-3 card-title">{{ $apartment->title }}</h5>
                            <div class="d-flex gap-3 align-items-center ">
                                {{-- # SHOW --}}
                                <a href="{{ route('admin.apartments.show', $apartment->id) }}"
                                    class="btn btn-sm btn-info d-flex align-items-center"><i class="fas fa-eye me-1"></i>
                                    Vedi</a>

                                {{-- # RIPRISTINA --}}
                                <form method="POST" action="{{ route('admin.apartments.restore', $apartment) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-sm btn-success">Ripristina</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="container text-center my-5">
                <h1>Archivio Vuoto</h1>
            </div>
        @endif
    </section>
@endsection