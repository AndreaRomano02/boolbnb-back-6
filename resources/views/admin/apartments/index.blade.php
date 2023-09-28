@extends('layouts.app')

@section('content-class', 'container')
@section('content')
    <div class="row row-cols-4 g-4 my-5">
        @foreach ($apartments as $apartment)
            <div class="col">

                <div class="card">
                    {{-- <img src="..." class="card-img-top" alt="..."> --}}
                    <div class="card-body">
                        <h5 class="card-title">{{ $apartment->title }}</h5>
                        <p class="card-text">{{ $apartment->description }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
