@extends('layouts.dashboard')

@section('content')
    <h1 class="my-4 ms-3 text-white">Messaggi</h1>

    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Cognome</th>
                    <th scope="col">Email</th>
                    <th scope="col">Contenuto</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($apartments as $apartment)
                    @foreach ($apartment->messages as $messagge)
                        <tr>
                            <th scope="row">{{ $messagge->name }}</th>
                            <td>{{ $messagge->surname }}</td>
                            <td>{{ $messagge->email }}</td>
                            <td>{{ $messagge->content }}</td>
                            <td>
                                <div class="d-flex justify-content-end">

                                    <a href="{{ route('admin.messagges.show', $messagge->id) }}"
                                        class="btn btn-primary me-2">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>

                                    <form class="destroy-form-messagge"
                                        action="{{ route('admin.messagges.destroy', $messagge) }}" method="POST"
                                        data-title="{{ $messagge->email }}" data-bs-toggle="modal" data-bs-target="#modal">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                @empty
                    <tr>
                        <td class="text-center text-white" colspan="5">
                            <h3>Non ci sono messaggi</h3>
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    @Vite('resources/js/delete-messagge.js')
@endsection
