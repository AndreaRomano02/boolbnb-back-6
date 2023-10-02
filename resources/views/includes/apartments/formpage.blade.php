<div class="container my-4">

    @if ($apartment->id)
        <form action="{{ route('admin.apartments.update', $apartment->id) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
        @else
            <form action="{{ route('admin.apartments.store') }}" method="POST" enctype="multipart/form-data">
    @endif
    @csrf
    <div class="row">
        {{-- user_id --}}
        <input type="hidden" name="user_id" value="{{ $user->id }}">
        {{-- title --}}
        <div class="col-12 py-2">
            <label for="title" class="form-label">Nome dell' appartamento* :</label>
            <input type="text"
                class="form-control @error('title') is-invalid @elseif(old('title')) is-valid @enderror"
                id="title" placeholder="Es: Villa Flora" name="title"
                value="{{ old('title', $apartment->title ?? '') }}">
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        {{-- description --}}
        <div class="col-12 py-2">
            <label for="description" class="form-label">Descrizione* :</label>
            <textarea class="form-control @error('description') is-invalid @elseif(old('description')) is-valid @enderror"
                id="description" placeholder="Inserisci la descrizione" name="description">{{ old('description', $apartment->description ?? '') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        {{-- address --}}
        <div class="col-6 py-2">
            <label for="address" class="form-label">Indirizzo* :</label>
            <input type="text"
                class="form-control @error('address') is-invalid @elseif(old('address')) is-valid @enderror"
                id="address" placeholder="Es: Via tal de tali 11 00134 Roma" name="address"
                value="{{ old('title', $apartment->address ?? '') }}">
            @error('address')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        {{-- coordinate latitude --}}
        <div class="col-3 py-2 my-4">
            <label for="latitude">Latitudine :</label>
            <input @if ($apartment->latitude) value="{{ $apartment->latitude }}" @endif type="text"
                id="latitude" disabled>
        </div>
        {{-- coordinate longitude --}}
        <div class="col-3 py-2 my-4">
            <label for="longitude">Longitudine</label>
            <input @if ($apartment->longitude) value="{{ $apartment->longitude }}" @endif type="text"
                id="longitude" disabled>
        </div>
        {{-- dropdown --}}
        <div class="dropdown">
            <ul id="dropdown" class="dropdown-menu">
                <li class="dropdown-item"></li>
            </ul>
        </div>
        {{-- image --}}
        <div class="col-9 py-2">
            <label for="image" class="form-label">Immagine dell'appartamento :</label>
            <input type="file"
                class="form-control @error('image') is-invalid @elseif(old('image')) is-valid @enderror"
                id="image" placeholder="Inserisci un logo per il tuo progetto" name="image"
                value="{{ old('image', $apartment->image ?? '') }}">
            @error('image')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        {{-- image-preview --}}
        <div class="col-3 py-2">
            <img src="https://marcolanci.it/utils/placeholder.jpg" alt="preview-apartment" id="image-preview"
                style="width: 150px;">
        </div>
        {{-- beds --}}
        <div class="col-6 py-2">
            <label for="beds" class="form-label">Numero di posti letto* :</label>
            <input type="number"
                class="form-control @error('beds') is-invalid @elseif(old('beds')) is-valid @enderror"
                id="beds" placeholder="Es: 4" name="beds" value="{{ old('beds', $apartment->beds ?? '') }}">
            @error('beds')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        {{-- rooms --}}
        <div class="col-6 py-2">
            <label for="rooms" class="form-label">Numero di letti :</label>
            <input type="number"
                class="form-control @error('rooms') is-invalid @elseif(old('rooms')) is-valid @enderror"
                id="rooms" placeholder="Es: 4" name="rooms" value="{{ old('rooms', $apartment->rooms ?? '') }}">
            @error('rooms')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        {{-- bathrooms --}}
        <div class="col-6 py-2">
            <label for="bathrooms" class="form-label">Stanze da bagno:</label>
            <input type="number"
                class="form-control @error('bathrooms') is-invalid @elseif(old('bathrooms')) is-valid @enderror"
                id="bathrooms" placeholder="Es: 4" name="bathrooms"
                value="{{ old('bathrooms', $apartment->bathrooms ?? '') }}">
            @error('bathrooms')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        {{-- square metres --}}
        <div class="col-6 py-2">
            <label for="square_meters" class="form-label">Metri Quadri :</label>
            <input type="number"
                class="form-control @error('square_meters') is-invalid @elseif(old('square_meters')) is-valid @enderror"
                id="square_meters" placeholder="Es: 4" name="square_meters"
                value="{{ old('square_meters', $apartment->square_meters ?? '') }}">
            @error('square_meters')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        {{-- services --}}
        <div class="col-12 py-2">
            <h5>Servizi* :</h5>
            @foreach ($services as $service)
                <div class="form-check form-check-inline">
                    <label class="form-check-label" for="service-{{ $service->id }}">{{ $service->label }}</label>
                    <input
                        class="form-check-input  @error('services') is-invalid @elseif(old('services')) is-valid @enderror"
                        type="checkbox" @if (in_array($service->id, old('services', $apartment_service_ids ?? []))) checked @endif
                        id="service-{{ $service->id }}" value="{{ $service->id }}" name="services[]">

                </div>
            @endforeach
            @error('services')
                <h6 class="text-start py-2 text-danger">
                    {{ $message }}
                </h6>
            @enderror
        </div>
        <!--Visibility-->
        <div class="col-6 py-2">
            <div class="form-check">
                <label class="form-check-label" for="visibility">Visibilità</label>
                <input
                    class="form-check-input @error('is_visible') is-invalid @elseif(old('is_visible')) is-valid @enderror"
                    type="checkbox" @if (old('is_visible', $apartment->is_visible ?? [])) checked @endif id="visibility"
                    value="{{ old('is_visible', '1') }}" name="is_visible">
            </div>
            @error('is_visible')
                <h6 class="text-start py-2 text-danger">
                    {{ $message }}
                </h6>
            @enderror
        </div>
    </div>
    <button type="submit" class="btn btn-success">
        Save
    </button>
    </form>
</div>

@section('scripts')
    @Vite('resources/js/tomtom.js')
    @Vite('resources/js/image-preview.js')
    @Vite('resources/js/coordinate-preview.js')
@endsection
