@extends('layouts.dashboard')

@section('content')
    <h1 class="my-4 ms-3">Messaggi</h1>

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
                    <tr>
                        <th scope="row">{{ $messagge->name }}</th>
                        <td>{{ $messagge->surname }}</td>
                        <td>{{ $messagge->email }}</td>
                        <td>{{ $messagge->content }}</td>
                        <td>
                            <div class="d-flex justify-content-end">

                                <a href="{{ route('admin.messagges.show', $messagge->id) }}" class="btn btn-primary me-2">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="#" class="btn btn-warning me-2">
                                    <i class="fa-solid fa-pen-nib"></i>
                                </a>
                                <form action="#" method="POST">
                                    @method('delete')
                                    @csrf
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
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
