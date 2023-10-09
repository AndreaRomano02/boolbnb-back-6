@extends('layouts.dashboard')

@section('content')
    <div class="row row-cols-3 g-4 my-5">
        @foreach ($apartments as $apartment)
            <div class="col">

                <div class="card h-100">
                    @if (!$apartment->is_visible)
                        <div class="card-header">
                            <h3 class="text-danger">NON PUBBLICATO</h3>
                        </div>
                    @endif
                    <div class="card-body">
                        <h3 class="card-title mb-3">{{ $apartment->title }}</h3>
                        <div class="d-flex justify-content-between">

                            <figure class="me-3">
                                @if (count($apartment->images))
                                    <img class="card-img-top"
                                        src="{{ 'http://127.0.0.1:8000/storage/' . $apartment->images[0]->path }}" />
                                @endif
                            </figure>

                            <div class="d-flex flex-column justify-content-start align-items-center gap-2">
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
                        <p class="card-text">{{ $apartment->description }}</p>
                        <p><strong>Visualizzazioni: </strong> {{ count($apartment->visits) }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('scripts')
    @Vite('resources/js/delete-confirmation.js')
@endsection
