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
                @forelse ($messagges as $messagge)
                    @foreach ($messagge as $m)
                        <tr>
                            <th scope="row">{{ $m->name }}</th>
                            <td>{{ $m->surname }}</td>
                            <td>{{ $m->email }}</td>
                            <td>{{ $m->content }}</td>
                            <td>
                                <div class="d-flex justify-content-end">

                                    <a href="{{ route('admin.messagges.show', $m->id) }}" class="btn btn-primary me-2">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>

                                    <form class="destroy-form-messagge" action="{{ route('admin.messagges.destroy', $m) }}"
                                        method="POST" data-title="{{ $m->email }}" data-bs-toggle="modal"
                                        data-bs-target="#modal">
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
                        <td class="text-center" colspan="5">
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
