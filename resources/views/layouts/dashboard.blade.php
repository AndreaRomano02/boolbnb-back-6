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
            <div class="d-none d-sm-none col-md-3 d-md-inline-block columns-sx">

                {{-- dashboard --}}
                <div class="container left-col">

                    <div class="my-4">
                        {{-- # Account Name --}}

                        <a class="dropdown-item" href="{{ url('profile') }}">
                            <div class="d-flex align-items-start">
                                <span class="material-symbols-outlined dash-icon text-white">
                                    account_circle
                                </span>
                                <h3 class="fs-4 text-white">
                                    {{ Auth::user()->name }}
                                </h3>
                            </div>
                        </a>
                    </div>

                    <div class="my-4">

                        {{-- # Aggiungi un appartamento --}}
                        <a href="{{ route('admin.apartments.create') }}" class="btn btn-info">
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

                    <div class="my-4">

                        {{-- # Vai ai tui Appartamenti --}}
                        <a class="btn btn-info" href="{{ route('admin.apartments.index') }}">
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

                    <div class="my-4">
                        {{-- # Vai all'archivio --}}

                        <a href="{{ route('admin.apartments.archive') }}" class="btn btn-info">
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

                    <div class="my-4">

                        {{-- # Vai nei sponsor --}}
                        <a href="{{ route('admin.sponsors.index') }}" class="btn btn-info">
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

                    <div class="my-4">

                        {{-- # Vai nei messaggi --}}
                        <a href="{{ route('admin.messagges.index') }}" class="btn btn-info">
                            <div class="d-flex align-items-cente justify-content-start">

                                <span class="material-symbols-outlined me-2">
                                    mail
                                </span>
                                <h6 class="mt-1 mb-0">
                                    I tuoi messaggi
                                </h6>
                            </div>
                        </a>
                    </div>

                    <div class="my-4">

                        {{-- # Vai all'archivio --}}
                        <a href="{{ route('admin.messagges.archive') }}" class="btn btn-info">
                            <div class="d-flex align-items-cente justify-content-start">
                                <span class="material-symbols-outlined me-2">
                                    inventory_2
                                </span>
                                <h6 class="pt-1 mb-0">
                                    Vai all'archivio dei messaggi
                                </h6>
                            </div>
                        </a>
                    </div>

                </div>

            </div>

            {{-- # Content --}}
            <div class="col-xs-12 col-sm-12 col-md-9 columns-dx">
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
