@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <h1 class="my-5">Visualizza l'appartamento</h1>

                <div class="row my-5">
                    <div class="col-6">
                        @if (!$apartment->is_visible)
                            <h3 class="text-danger">NON PUBBLICATO</h3>
                        @endif
                        <h2>{{ $apartment->title }}</h2>
                        @if (count($apartment->images))
                            <img class="card-img-top img-fluid"
                                src="{{ 'http://127.0.0.1:8000/storage/' . $apartment->images[0]->path }}" />
                        @endif
                    </div>
                    <div class="col-6">
                        <div class="h-100 d-flex flex-column justify-content-between align-items-start">
                            <div>
                                <p>
                                    <strong>Descrizione: </strong>
                                    {{ $apartment->description }}
                                </p>

                                <div class="row">

                                    <address class="col-12">
                                        <strong>Indirizzo: </strong>
                                        {{ $apartment->address }}
                                    </address>

                                    <div class="col-4 mb-2">
                                        <strong>Longitudine: </strong>
                                        {{ $apartment->longitude }}
                                    </div>

                                    <div class="col-4 mb-2">
                                        <strong>Latitudine: </strong>
                                        {{ $apartment->latitude }}
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <strong>Prezzo: </strong>
                                    {{ $apartment->price }}
                                    $/a notte
                                </div>
                                <div class="mb-2">
                                    <strong>Letti: </strong>
                                    {{ $apartment->beds }}
                                </div>
                                <div class="mb-2">
                                    <strong>Stanze: </strong>
                                    {{ $apartment->rooms }}
                                </div>
                                <div class="mb-2">
                                    <strong>Bagni: </strong>
                                    {{ $apartment->bathrooms }}
                                </div>
                                <div class="mb-2">
                                    <strong>Metri quadrati: </strong>
                                    {{ $apartment->square_meters }}mq
                                </div>

                                <div class="mb-2">

                                    @if ($last_sponsor)
                                        @if ($last_sponsor['pivot']->end_date < $current_date)
                                            <strong>Sponsor: </strong>
                                            Non hai nessun sponsor Attivo
                                        @else
                                            <strong>Sponsor: </strong>
                                            {{ $last_sponsor->plan }}
                                        @endif
                                    @else
                                        <strong>Sponsor: </strong>
                                        Non hai nessun sponsor Attivo
                                    @endif

                                </div>

                            </div>
                            <div>

                                <div class="d-flex gap-4 justify-content-center  align-items-center">
                                    <a href="{{ route('admin.apartments.index') }}" class="btn btn-success">Torna
                                        indietro</a>

                                    {{-- # EDIT --}}
                                    <a href="{{ route('admin.apartments.edit', $apartment) }}" class="btn btn-warning"><i
                                            class="fas fa-pencil"></i> Modifica</a>
                                    {{-- # DELETE --}}
                                    @if (!$apartment->trashed())
                                        <form class="destroy-form"
                                            action="{{ route('admin.apartments.destroy', $apartment) }}" method="POST"
                                            data-title="{{ $apartment->title }}" data-bs-toggle="modal"
                                            data-bs-target="#modal">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger"><i class="fas fa-trash"></i> Sposta
                                                nell'archivio</button>
                                        </form>
                                    @else
                                        <form class="destroy-form"
                                            action="{{ route('admin.apartments.restore', $apartment->id) }}" method="POST"
                                            data-title="{{ $apartment->title }}">
                                            @csrf
                                            @method('PATCH')
                                            <button class="btn btn-primary"><i class="fas fa-save"></i> Ripristina</button>
                                        </form>
                                    @endif
                                    <a href="{{ route('admin.sponsors.edit', $apartment->id) }}"
                                        class="btn btn-secondary">Sponsorizza</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    @Vite('resources/js/delete-confirmation.js')
@endsection
