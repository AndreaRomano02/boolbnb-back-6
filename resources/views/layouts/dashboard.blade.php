<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('includes/layout/head')

<body>
    <div id="app">
        {{-- navbar --}}
        @include('includes/layout/navbar')
        {{-- # Alert  --}}
        @include('includes/layout/alert')

        <div class="row g-0">
            <div class="col-3 columns-sx">

                {{-- # Account Name --}}
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

                    {{-- # Aggiungi un appartamento --}}
                    <div class="card my-3">
                        <div class="card-body">
                            <a href="{{ route('admin.apartments.create') }}" class="btn btn-success">
                                <div class="d-flex align-items-cente justify-content-start">

                                    <span class="material-symbols-outlined me-2">
                                        add
                                    </span>
                                    <h6 class="pt-1 mb-0">
                                        Aggiungi un appartamento
                                    </h6>
                                </div>
                            </a>
                        </div>
                    </div>

                    {{-- # Vai ai tui Appartamenti --}}
                    <div class="card my-3">
                        <div class="card-body">
                            <a class="btn btn-outline-primary" href="{{ route('admin.apartments.index') }}">
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

                    {{-- # Vai all'archivio --}}
                    <div class="card my-3">
                        <div class="card-body">
                            <a href="{{ route('admin.apartments.archive') }}" class="btn btn-secondary">
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

                    {{-- # Vai nei sponsor --}}
                    <div class="card my-3">
                        <div class="card-body">
                            <a href="{{ route('admin.sponsors.index') }}" class="btn btn-warning">
                                <div class="d-flex align-items-cente justify-content-start">

                                    <span class="material-symbols-outlined me-2">
                                        star
                                    </span>
                                    <h6 class="mt-1 mb-0">
                                        Sponsors
                                    </h6>
                                </div>
                            </a>
                        </div>
                    </div>

                </div>
            </div>

            {{-- # Content --}}
            <div class="col-9 columns-dx">
                <div class="right-col">
                    <div class="container">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>

        {{-- modal --}}
        @include('includes/layout/modal')

    </div>
</body>

@yield('scripts')

</html>

{{-- @section('content')
  
@endsection --}}
