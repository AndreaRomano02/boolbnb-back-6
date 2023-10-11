@extends('layouts.dashboard')

@section('title', 'Archive')

@section('content')
    <div class="d-flex justify-content-between  my-4">
        <h1 class="text-white">Archivio</h1>
        <a class="btn btn-secondary text-white mb-0 pb-0" href="{{ route('admin.apartments.index') }}">Torna all'elenco</a>
    </div>
    <section class="row row-cols-1 row-cols-md-2 row-cols-sm-1 row-cols-lg-3">
        @if (count($apartments))
            @foreach ($apartments as $apartment)
                <div class="col">
                    <div class="card m-2">
                        <div class="card-body">
                            @if (count($apartment->images))
                                <img class="card-img-top"
                                    src="{{ 'http://127.0.0.1:8000/storage/' . $apartment->images[0]->path }}" />
                            @endif
                            <h5 class=" my-3 card-title">{{ $apartment->title }}</h5>
                            <div class="d-flex gap-3 align-items-center ">
                                {{-- # SHOW --}}
                                <a href="{{ route('admin.apartments.show', $apartment->id) }}"
                                    class="btn btn-sm btn-info d-flex align-items-center"><i class="fas fa-eye me-1"></i>
                                    Vedi</a>

                                {{-- # RIPRISTINA --}}
                                <form method="POST" action="{{ route('admin.apartments.restore', $apartment->id) }}">
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
            <div class="container text-center text-white my-5">
                <h1>Archivio Vuoto</h1>
            </div>
        @endif
    </section>
@endsection
