@extends('layouts.dashboard')

@section('content')
    <h1>Piano {{ $sponsor->plan }}</h1>
    @if ($sponsor->id == 1)
        <p class="mt-4 fs-5">
            Un piano base dove il suo appartamento verra visualizzato a monte di tutte le ricerche per 24 ore.
        </p>
    @elseif ($sponsor->id == 2)
        <p class="mt-4 fs-5">
            Un piano intermedio dove il suo appartamento verra visualizzato a monte di tutte le ricerche per 72 ore.
        </p>
    @elseif ($sponsor->id == 3)
        <p class="mt-4 fs-5">
            Un piano avanzato dove il suo appartamento verra visualizzato a monte di tutte le ricerche per 144 ore.
        </p>
    @endif
@endsection
