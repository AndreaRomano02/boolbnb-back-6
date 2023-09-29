<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('includes/layout/head')

<body>
    <div id="app">
        @include('includes/layout/navbar')

        {{-- # Alert  --}}

        @if (session('message'))
            <div class="container mt-5">
                <div class="alert alert-{{ session('type') ? session('type') : 'info' }} alert-dismissible fade show"
                    role="alert">
                    <p>{{ session('message') }}</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        <main class="@yield('content-class')">
            @yield('content')
        </main>
    </div>
</body>

@yield('scripts')

</html>
