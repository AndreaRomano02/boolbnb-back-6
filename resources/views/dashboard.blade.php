@extends('layouts.app')

@section('content')
    <div class="row g-0">
        <div class="col-3 columns-sx">
            <div class="container left-col">
                <a class="dropdown-item my-4" href="{{ url('profile') }}">
                    <div class="d-flex align-items-start">

                        <span class="material-symbols-outlined dash-icon">
                            account_circle
                        </span>
                        <h3 class="fs-4 text-secondary">
                            {{ Auth::user()->name }}
                        </h3>
                    </div>
                </a>

                <div class="card my-3">

                    <div class="card-body">

                        <a class="btn btn-outline-secondary" href="{{ route('admin.apartments.index') }}">
                            <div class="d-flex align-items-cente justify-content-start">
                                <span class="material-symbols-outlined me-2">
                                    apartment
                                </span>

                                <h6 class="pt-1 mb-0">
                                    Vai ai tui Appartamenti
                                </h6>
                            </div>
                        </a>

                    </div>
                </div>
                <div class="card my-3">
                    <div class="card-body">
                        <a href="{{ route('admin.apartments.create') }}" class="btn btn-success">
                            <div class="d-flex align-items-cente justify-content-start">

                                <span class="material-symbols-outlined me-2">
                                    add
                                </span>
                                <h6 class="pt-1 mb-0">
                                    Aggiungi un'appartamento
                                </h6>
                            </div>
                        </a>
                    </div>

                </div>
                <div class="card my-3">

                    <div class="card-body">
                        <a href="{{ route('admin.apartments.trash') }}" class="btn btn-secondary">
                            <div class="d-flex align-items-cente justify-content-start">

                                <span class="material-symbols-outlined me-2">
                                    archive
                                </span>
                                <h6 class="pt-1 mb-0">
                                    Vai all'archivio
                                </h6>
                            </div>
                        </a>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-9 columns-dx">
            <div class="right-col">
                <div class="container py-4">

                    <h1>titolo</h1>

                </div>
            </div>
        </div>
    </div>
@endsection
