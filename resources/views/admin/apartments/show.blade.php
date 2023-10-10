@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <h1 class="my-5 text-white text-center">Visualizza l'appartamento</h1>
        <div id="card-show" class="card my-5">

            <div class="row row-cols-1 row-cols-md-1 row-cols-lg-2">
                <div class="col">
                    <div class="container">

                        @if (!$apartment->is_visible)
                            <h3 class="text-danger">NON PUBBLICATO</h3>
                        @endif
                        <h2>{{ $apartment->title }}</h2>
                        @if (count($apartment->images))
                            <img id="image-show" class="card-img-top"
                                src="{{ 'http://127.0.0.1:8000/storage/' . $apartment->images[0]->path }}" />
                        @endif
                    </div>
                </div>
                <div class="col">
                    <div class="container">

                        <div class="">
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
                                            La tua sponsorizzazione è scaduta... RINNOVALA ORA!
                                        @else
                                            <strong>Sponsor: </strong>
                                            {{ $last_sponsor->plan }} e scadrà il
                                            {{ str_replace('-', '/', $last_sponsor['pivot']->end_date) }}
                                        @endif
                                    @else
                                        <strong>Sponsor: </strong>
                                        Non hai nessun sponsor Attivo
                                    @endif

                                </div>

                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="d-flex gap-4 justify-content-center  align-items-center my-4">
            <a href="{{ route('admin.apartments.index') }}" class="btn btn-success">Home</a>

            {{-- # EDIT --}}
            <a href="{{ route('admin.apartments.edit', $apartment) }}" class="btn btn-warning"><i
                    class="fas fa-pencil me-2"></i>Modifica</a>
            {{-- # DELETE --}}
            @if (!$apartment->trashed())
                <form class="destroy-form" action="{{ route('admin.apartments.destroy', $apartment) }}" method="POST"
                    data-title="{{ $apartment->title }}" data-bs-toggle="modal" data-bs-target="#modal">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger"><i class="fas fa-trash me-2"></i>Archivia</button>
                </form>
            @else
                <form class="destroy-form" action="{{ route('admin.apartments.restore', $apartment->id) }}" method="POST"
                    data-title="{{ $apartment->title }}">
                    @csrf
                    @method('PATCH')
                    <button class="btn btn-primary"><i class="fas fa-save me-2"></i>
                        Ripristina</button>
                </form>
            @endif
            <a href="{{ route('admin.sponsors.edit', $apartment->id) }}" class="btn btn-secondary">Sponsorizza</a>
        </div>

    </div>
@endsection

@section('scripts')
    @Vite('resources/js/delete-confirmation.js')
@endsection
