@extends('layouts.dashboard')

@section('content')
    <div class="row row-cols-1 row-cols-md-2 row-cols-sm-1 row-cols-lg-3 g-4 my-5">
        @foreach ($apartments as $apartment)
            <div class="col">
                <div class="card mb-3">
                    <div class="card-header">
                        @if (!$apartment->is_visible)
                            <h6 class="text-danger">NON PUBBLICATO</h6>
                        @else
                            <h6 class="text-success">PUBBLICATO</h6>
                        @endif
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $apartment->title }}</h5>
                        <figure class="me-3">
                            @if (count($apartment->images))
                                <img class="card-img-top"
                                    src="{{ 'http://127.0.0.1:8000/storage/' . $apartment->images[0]->path }}" />
                            @endif
                        </figure>
                        <p class="card-text">{{ $apartment->description }}</p>
                        <p><strong>Visualizzazioni: </strong> {{ count($apartment->visits) }}</p>

                        <div class="d-flex justify-content-start align-items-center gap-2">
                            {{-- # SHOW --}}
                            <a href="{{ route('admin.apartments.show', $apartment) }}" class="btn btn-info"><i
                                    class="fas fa-eye"></i></a>

                            {{-- # EDIT --}}
                            <a href="{{ route('admin.apartments.edit', $apartment) }}" class="btn btn-warning"><i
                                    class="fas fa-pencil"></i></a>

                            {{-- # DELETE --}}
                            <form class="destroy-form" action="{{ route('admin.apartments.destroy', $apartment) }}"
                                method="POST" data-title="{{ $apartment->title }}" data-bs-toggle="modal"
                                data-bs-target="#modal">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('scripts')
    @Vite('resources/js/delete-confirmation.js')
@endsection
