@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <h1>Visualizza l'appartamento</h1>

                <div class="row my-5">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-10">
                                <div>
                                    <div class="col-6">
                                        <div class=""><strong>Descrizione: </strong>{{ $apartment->description }}
                                        </div>
                                        <div class=""><strong>Indirizzo: </strong>{{ $apartment->address }}</div>
                                        <div class=""><strong>Longitudine: </strong>{{ $apartment->longitude }}</div>
                                        <div class=""><strong>Latitudine: </strong>{{ $apartment->latitude }}</div>
                                        <div class=""><strong>Immagine: </strong>{{ $apartment->image }}</div>
                                        <div class=""><strong>Letti: </strong>{{ $apartment->beds }}</div>
                                        <div class=""><strong>Stanze: </strong>{{ $apartment->room }}</div>
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

        <div class="row">
            <div class="col-5"></div>
            <div class="col-2 align-self-center">
                <a href="{{ route('admin.apartments.index') }}" class="button">Torna indietro</a>
            </div>
            <div class="col-4"></div>
        </div>
    </div>
@endsection
