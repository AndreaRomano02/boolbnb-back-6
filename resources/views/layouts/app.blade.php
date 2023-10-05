<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('includes/layout/head')

<body>
    <div id="app">
        {{-- navbar --}}
        @include('includes/layout/navbar')
        {{-- # Alert  --}}
        @include('includes/layout/alert')


        <main class="@yield('content-class')">
            @yield('content')
        </main>
    </div>


    @yield('scripts')
</body>


</html>
