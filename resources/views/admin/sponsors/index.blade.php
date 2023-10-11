@extends('layouts.dashboard')

@section('content')
    <h1 class="my-5 text-white">I nostri Sponsors:</h1>
    <div class="row row-cols-1 row-cols-md-2  row-cols-lg-2 row-cols-xl-3 g-4 my-5">
        @foreach ($sponsors as $sponsor)
            <div class="col">

                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Piano {{ $sponsor->plan }}</h5>
                        <img src="https://png.pngtree.com/png-clipart/20230915/original/pngtree-cartoon-gift-wrap-or-gift-box-logo-with-a-ribbon-vector-png-image_12227358.png"
                            class="card-img-top img-fluid" alt="sponsor">
                        <div class="card-text mb-3">
                            <strong>
                                Costo per l'attivazione :
                            </strong>
                            {{ $sponsor->price }} $
                        </div>
                        <div class="card-text mb-3">
                            <strong>
                                Durata del piano :
                            </strong>
                            {{ $sponsor->duration }} ore
                        </div>
                        <a href="{{ route('admin.sponsors.show', $sponsor->id) }}" class="btn btn-primary">
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
