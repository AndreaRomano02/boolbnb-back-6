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
                        <img v-if="apartment.images.length" class="card-img-top"
                            src="{{ 'http://127.0.0.1:8000/storage/' . $apartment->images[0]->path }}" />
                        <h5 class="card-title">{{ $apartment->title }}
                        </h5>
                        <p class="card-text">{{ $apartment->description }}</p>

                        <div class="d-flex justify-content-end gap-2">
                            {{-- # SHOW --}}
                            <a href="{{ route('admin.apartments.show', $apartment) }}" class="btn btn-info"><i
                                    class="fas fa-eye"></i></a>

                            {{-- # EDIT --}}
                            <a href="{{ route('admin.apartments.edit', $apartment) }}" class="btn btn-warning"><i
                                    class="fas fa-pencil"></i></a>

                            {{-- # DELETE --}}
                            <form class="destroy-form" action="{{ route('admin.apartments.destroy', $apartment) }}"
                                method="POST" data-title="{{ $apartment->title }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
