@extends('layouts.dashboard')

@section('content')
    <h1 class="my-4 ms-3">Messaggio</h1>

    <div class="container">

        <div class="card mb-3">
            <div class="row g-0">
                <div class="col-md-4">
                    @if (count($apartment->images))
                        <img src="{{ ' http://127.0.0.1:8000/storage/' . $apartment->images[0]->path }}"
                            class="img-fluid rounded-start h-50" alt="{{ $apartment->title }}">
                    @endif
                    <div class="m-3 p-2">

                        <h3 class="mb-2">{{ $apartment->title }}</h3>
                        <h4>{{ $apartment->address }}</h4>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">Messaggio inviato da : {{ $messagge->email }}</h5>
                        <p class="card-text">Nome Mittente : {{ $messagge->name . ' ' . $messagge->surname }}</p>
                        <p class="card-text">Testo del messaggio : {{ $messagge->content }}</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
