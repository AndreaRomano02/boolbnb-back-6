<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use GuzzleHttp\client;
use Symfony\Component\Finder\Glob;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $request->all();
        $request->validate(
            [
                'city' => 'nullable|string',
                'range' => 'nullable|integer',
                'beds' => 'nullable|integer',
                'rooms' => 'nullable|integer',
                'services' => 'nullable|exists:services,id',
            ],
            [
                'city.string' => 'Elemento inserito non conforme',
                'range.integer' => 'L\'e lemento inserito non è un numero',
                'beds.integer' => 'L\'e lemento inserito non è un numero',
                'rooms.integer' => 'L\'e lemento inserito non è un numero',
                'services.exists' => 'Il servizio non esiste',
            ]
        );
        $city = $data['city'] ?? null;
        $range = $data['range'] ?? 20;
        $beds = $data['beds'] ?? null;
        $rooms = $data['rooms'] ?? null;
        $services = $data['services'] ?? null;
        $userlongitude = null;
        $userlatitude = null;
        $key = 'key=PWX9HGsOx1sGv84PlpxzgXIbaElOjVMF';

        $apartments = Apartment::with('messages', 'services', 'sponsors', 'visits', 'images');

        if (strlen($beds)) {
            $apartments->where('beds', '>=', $beds);
        }

        if (strlen($rooms)) {
            $apartments->where('rooms', '>=', $rooms);
        }

        if (!empty($services)) {

            $apartments->whereHas('services', function ($query) use ($services) {
                $query->whereIn('services.id', $services);
            });
        }

        if (strlen($city)) {
            $apartments = $apartments->get();

            $query = 'https://api.tomtom.com/search/2/search/' . $city . '.json?' . $key;

            $client = new Client(['verify' => false]);
            $response = $client->get($query);
            $new_data = json_decode($response->getBody(), true);
            $apartments_filtered = [];

            $userlatitude = $new_data['results'][0]['position']['lat'];
            $userlongitude = $new_data['results'][0]['position']['lon'];
            foreach ($apartments as $apartment) {

                $distancequery = 'https://api.tomtom.com/routing/1/calculateRoute/' . $userlatitude . '%2C' . $userlongitude . '%3A' . $apartment->latitude . '%2C' . $apartment->longitude . '/json?key=PWX9HGsOx1sGv84PlpxzgXIbaElOjVMF';
                $client = new Client(['verify' => false]);
                $response = $client->get($distancequery);
                $distance_data = json_decode($response->getBody(), true);

                $distance = $distance_data['routes'][0]['summary']['lengthInMeters'] / 1000;
                $distance_rounded = round($distance, 1);

                if ($distance_rounded <= $range) {
                    $apartment['distance_center'] = $distance_rounded;
                    $apartments_filtered[] = $apartment;
                }
            }

            return response()->json($apartments_filtered);
        }

        if (isset($data['all'])) $apartments =  $apartments->get();
        else $apartments =  $apartments->paginate(10);

        return response()->json($apartments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data_apartment = $request->all();
        $request->validate(
            [
                'user_id' => 'required|exists:users,id',
                'title' => 'required|unique:apartments|string',
                'description' => 'required|string',
                'address' => 'required|string',
                'longitude' => 'nullable|string',
                'latitude' => 'nullable|string',
                'image' => 'nullable|image',
                'beds' => 'required|integer',
                'rooms' => 'nullable|integer',
                'bathrooms' => 'nullable|integer',
                'square_meters' => 'nullable|integer',
                'is_visible' => 'required|boolean',
            ],
            [
                'user_id.required' => 'E\' necessario possedere un\' account per la registrazione',
                'user_id.exists' => 'l\' utente non esiste',
                'title.required' => 'Il titolo è obbligatorio',
                'title.unique' => 'Il titolo inserito esiste già',
                'description.required' => 'La descrizione è obbligatoria',
                'address.required' => 'L\' indirizzo è obbligatorio',
                'image.image' => 'Il file inserito non è un immagine',
                'beds.require' => 'Il numero di posti letto è obbligatorio',
                'beds.integer' => 'Valore inserito non numerico',
                'rooms.integer' => 'Valore inserito non numerico',
                'bathrooms.integer' => 'Valore inserito non numerico',
                'square_meters.integer' => 'Valore inserito non numerico',
                'is_visible.required' => 'La disponibilità è obbligatoria',
                'is_visible.boolean' => 'Valore inserito non valido',


            ]
        );
        $apartment = new Apartment();

        $address_info = str_replace(' ', '%20', $data_apartment['address']);
        $key = 'key=PWX9HGsOx1sGv84PlpxzgXIbaElOjVMF';
        $query = "https://api.tomtom.com/search/2/geocode/$address_info.json?storeResult=false&lat=37.337&lon=-121.89&view=Unified&$key";

        $client = new Client(['verify' => false]);
        $response = $client->get($query);
        $data = json_decode($response->getBody(), true);

        if (Arr::exists($data_apartment, 'image')) {
            if ($apartment->image) Storage::delete($apartment->image);
            $img_url = Storage::putFile('apartment_images', $data_apartment['image']);
            $data_apartment['image'] = $img_url;
        }

        // $apartment->fill($data_apartment);

        $apartment->user_id = ($data_apartment['user_id']);
        $apartment->title = ($data_apartment['title']);
        $apartment->description = ($data_apartment['description']);
        $apartment->address = ($data_apartment['address']);
        $apartment->beds = ($data_apartment['beds']);
        $apartment->is_visible = ($data_apartment['is_visible']);

        $apartment->latitude = $data['results'][0]['position']['lat'];
        $apartment->longitude = $data['results'][0]['position']['lon'];

        $apartment->save();

        if (array_key_exists('services', $data_apartment)) {
            $apartment->services()->attach($data_apartment['services']);
        }

        return response()->json($apartment);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $apartments = Apartment::with('messages', 'services', 'sponsors', 'visits', 'images')->find($id);
        if (!$apartments) return response(null, 404);
        return response()->json($apartments);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data_apartment = $request->all();

        $request->validate(
            [
                'user_id' => 'required|exists:users,id',
                'title' => ['required', 'string', Rule::unique('apartments')->ignore($data_apartment['title'], 'title')],
                'description' => 'required|string',
                'address' => 'required|string',
                'longitude' => 'nullable|string',
                'latitude' => 'nullable|string',
                'image' => 'nullable|image',
                'beds' => 'required|integer',
                'rooms' => 'nullable|integer',
                'bathrooms' => 'nullable|integer',
                'square_meters' => 'nullable|integer',
                'is_visible' => 'required|boolean',
            ],
            [
                'user_id.required' => 'E\' necessario possedere un\' account per la registrazione',
                'user_id.exists' => 'l\' utente non esiste',
                'title.required' => 'Il titolo è obbligatorio',
                'description.required' => 'La descrizione è obbligatoria',
                'address.required' => 'L\' indirizzo è obbligatorio',
                'image.image' => 'Il file inserito non è un immagine',
                'beds.require' => 'Il numero di posti letto è obbligatorio',
                'beds.integer' => 'Valore inserito non numerico',
                'rooms.integer' => 'Valore inserito non numerico',
                'bathrooms.integer' => 'Valore inserito non numerico',
                'square_meters.integer' => 'Valore inserito non numerico',
                'is_visible.required' => 'La disponibilità è obbligatoria',
                'is_visible.boolean' => 'Valore inserito non valido',
            ]
        );
        $apartment = Apartment::find($id);
        $address_info = str_replace(' ', '%20', $data_apartment['address']);
        $key = 'key=PWX9HGsOx1sGv84PlpxzgXIbaElOjVMF';
        $query = "https://api.tomtom.com/search/2/geocode/$address_info.json?storeResult=false&lat=37.337&lon=-121.89&view=Unified&$key";
        $client = new Client(['verify' => false]);
        $response = $client->get($query);
        $data = json_decode($response->getBody(), true);

        if (Arr::exists($data_apartment, 'image')) {
            if ($apartment->image) Storage::delete($apartment->image);
            $img_url = Storage::putFile('apartment_images', $data_apartment['image']);
            $data_apartment['image'] = $img_url;
        }

        $apartment->user_id = ($data_apartment['user_id']);
        $apartment->title = ($data_apartment['title']);
        $apartment->description = ($data_apartment['description']);
        $apartment->address = ($data_apartment['address']);
        $apartment->beds = ($data_apartment['beds']);
        $apartment->is_visible = ($data_apartment['is_visible']);

        $apartment->latitude = $data['results'][0]['position']['lat'];
        $apartment->longitude = $data['results'][0]['position']['lon'];

        $apartment->update($data_apartment);

        if (!Arr::exists($data_apartment, 'services') && count($apartment->services))  $apartment->services()->detach();
        elseif (Arr::exists($data_apartment, 'services'))  $apartment->technologys()->sync($data_apartment['services']);

        return response()->json($apartment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $apartment = Apartment::where('id', $id)->firstOrFail();
        $apartment->delete();

        return response()->json($apartment);
    }
}
