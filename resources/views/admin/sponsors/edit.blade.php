@extends('layouts.dashboard')

@section('content')
    <h1>Sponsorizza il tuo Appartamente</h1>
    <div class="row my-5">
        <div class="col-5">
            <h3>{{ $apartment->title }}</h3>
            @if (count($apartment->images))
                <img class="card-img-top img-fluid"
                    src="{{ 'http://127.0.0.1:8000/storage/' . $apartment->images[0]->path }}" />
            @endif
        </div>
        <div class="col-6">
            <form action="{{ route('admin.sponsors.update', $apartment->id) }}" method="POST">
                @method('PUT')
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                <input type="hidden" name="apartment_id" value="{{ $apartment->id }}">


                @foreach ($sponsors as $sponsor)
                    <div class="form-check form-check-inline">
                        <label class="form-check-label" for="sponsor-{{ $sponsor->id }}">{{ $sponsor->plan }}</label>
                        <input
                            class="form-check-input  @error('sponsor_id') is-invalid @elseif(old('sponsor_id')) is-valid @enderror"
                            type="radio" @if (old('sponsor_id') ?? $sponsor->id == 1) checked @endif id="sponsor-{{ $sponsor->id }}"
                            value="{{ $sponsor->id }}" name="sponsor_id">

                    </div>
                @endforeach
                <button type="submit" class="btn btn-success">
                    Save
                </button>
            </form>
        </div>

    </div>
@endsection
