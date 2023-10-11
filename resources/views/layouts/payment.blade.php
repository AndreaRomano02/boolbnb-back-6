<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('includes/layout/head')

<body>
    <div id="app">
        {{-- navbar --}}
        @include('includes/layout/navbar')
        {{-- # Alert  --}}
        @include('includes/layout/alert')


        <div class="container">
            @yield('content')
        </div>
    </div>

    {{-- modal --}}
    @include('includes/layout/modal')

    </div>
</body>

@yield('scripts')

</html>
