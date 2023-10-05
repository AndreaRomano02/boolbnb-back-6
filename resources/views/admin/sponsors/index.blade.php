@extends('layouts.dashboard')

@section('content')
    <h1 class="my-5">I nostri Sponsors:</h1>
    <div class="row row-cols-4 g-4 my-5">
        @foreach ($sponsors as $sponsor)
            <div class="col">

                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Piano {{ $sponsor->plan }}</h5>
                        <img src="https://png.pngtree.com/png-clipart/20230915/original/pngtree-cartoon-gift-wrap-or-gift-box-logo-with-a-ribbon-vector-png-image_12227358.png"
                            class="card-img-top img-fluid" alt="sponsor">
                        <div class="card-text mb-3">
                            @if ($sponsor->id == 1)
                                <strong>
                                    Costo per l'attivazione :
                                </strong>
                                Gratuito
                            @else
                                <strong>
                                    Costo per l'attivazione :
                                </strong>
                                {{ $sponsor->price }} $
                            @endif
                        </div>
                        <div class="card-text mb-3">
                            @if ($sponsor->id == 1)
                                <strong>
                                    Durata del piano :
                                </strong>
                                Illimitato
                            @else
                                <strong>
                                    Durata del piano :
                                </strong>
                                {{ $sponsor->duration }} /ore
                            @endif
                        </div>
                        <a href="#" class="btn btn-primary">
                            <div class="d-flex align-items-center justify-content-between">

                                <span class="me-2">
                                    Per Info
                                </span>
                                <span class="material-symbols-outlined">
                                    ads_click
                                </span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
