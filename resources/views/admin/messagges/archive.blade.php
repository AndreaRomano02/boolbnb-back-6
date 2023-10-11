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
                </tr>
            </thead>
            <tbody>
                @forelse ($messagges as $messagge)
                    <tr>
                        <th scope="row">{{ $messagge->name }}</th>
                        <td>{{ $messagge->surname }}</td>
                        <td>{{ $messagge->email }}</td>
                        <td>{{ $messagge->content }}</td>

                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="4">
                            <h3>Non ci sono messaggi</h3>
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>
@endsection
