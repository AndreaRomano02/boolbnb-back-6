@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <h1>Visualizza l'appartamento</h1>

                <div class="row my-5">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-10">
                                @if (!$apartment->is_visible)
                                    <h3 class="text-danger">NON PUBBLICATO</h3>
                                @endif
                                <div>
                                    @if (count($apartment->images))
                                        <img class="card-img-top"
                                            src="{{ 'http://127.0.0.1:8000/storage/' . $apartment->images[0]->path }}" />
                                    @endif
                                    <div class="col-6">
                                        <div class=""><strong>Descrizione: </strong>{{ $apartment->description }}
                                        </div>
                                        <div class=""><strong>Indirizzo: </strong>{{ $apartment->address }}</div>
                                        <div class=""><strong>Longitudine: </strong>{{ $apartment->longitude }}</div>
                                        <div class=""><strong>Latitudine: </strong>{{ $apartment->latitude }}</div>
                                        <div class=""><strong>Prezzo: </strong>{{ $apartment->price }} $/a notte</div>
                                        <div class=""><strong>Letti: </strong>{{ $apartment->beds }}</div>
                                        <div class=""><strong>Stanze: </strong>{{ $apartment->rooms }}</div>
                                        <div class=""><strong>Bagni: </strong>{{ $apartment->bathrooms }}</div>
                                        <div class=""><strong>Metri quadrati: </strong>{{ $apartment->square_meters }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="d-flex gap-4 justify-content-center  align-items-center">
            <a href="{{ route('admin.apartments.index') }}" class="btn btn-success">Torna indietro</a>

            {{-- # EDIT --}}
            <a href="{{ route('admin.apartments.edit', $apartment) }}" class="btn btn-warning"><i
                    class="fas fa-pencil"></i> Modifica</a>
            {{-- # DELETE --}}
            @if (!$apartment->trashed())
                <form class="destroy-form" action="{{ route('admin.apartments.destroy', $apartment) }}" method="POST"
                    data-title="{{ $apartment->title }}">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger"><i class="fas fa-trash"></i> Sposta nell'archivio</button>
                </form>
            @else
                <form class="destroy-form" action="{{ route('admin.apartments.restore', $apartment->id) }}" method="POST"
                    data-title="{{ $apartment->title }}">
                    @csrf
                    @method('PATCH')
                    <button class="btn btn-primary"><i class="fas fa-save"></i> Ripristina</button>
                </form>
            @endif
        </div>
    </div>
@endsection
