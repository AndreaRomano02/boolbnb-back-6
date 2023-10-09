@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="row my-4">
                                <div class="col-6 mb-4">
                                    {{-- name --}}
                                    <label for="name" class="form-label text-md-right">{{ __('Name') }} :</label>
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                                <div class="col-6 mb-4">
                                    {{-- surname --}}
                                    <label for="surname" class="form-label text-md-right">Surname :</label>
                                    <input id="surname" type="text"
                                        class="form-control @error('surname') is-invalid @enderror"name="surname"
                                        value="{{ old('surname') }}" autocomplete="surname" autofocus>

                                    @error('surname')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-6 mb-4">
                                    {{-- email --}}
                                    <label for="email" class="form-label text-md-right">{{ __('E-Mail Address') }}*
                                        :</label>
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-6 mb-4">
                                    {{-- date-of-birth --}}
                                    <label for="date" class="form-label text-md-right">Date of Birth :</label>
                                    <input id="date" type="date"
                                        class="form-control @error('date_birth') is-invalid @enderror"name="date_birth"
                                        value="{{ old('date_birth') }}" autocomplete="date_birth" autofocus>

                                    @error('date_birth')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-6 mb-4">
                                    {{-- password --}}
                                    <label for="password"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Password') }}* :</label>
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password" minlength="8">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-6 mb-4">
                                    {{-- confirm-password --}}
                                    <label for="password-confirm"
                                        class="form-label text-md-right">{{ __('Confirm Password') }}*
                                        :</label>
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password" minlength="8">
                                </div>
                                {{-- button --}}
                                <div class="col-1 mb-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
