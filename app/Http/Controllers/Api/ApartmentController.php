<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;


class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $apartments = Apartment::with('messages', 'services', 'sponsors', 'visits')->get();

        if (!$apartments) return response(null, 404);
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
                'user_id' => 'required|string|exists:users,id',
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
        if (Arr::exists($data_apartment, 'image')) {
            if ($apartment->image) Storage::delete($apartment->image);
            $img_url = Storage::putFile('apartment_images', $data_apartment['image']);
            $data_apartment['image'] = $img_url;
        }
        // $apartment->user_id = ($data_apartment['user_id']);
        // $apartment->title = ($data_apartment['title']);
        // $apartment->description = ($data_apartment['description']);
        // $apartment->address = ($data_apartment['address']);
        // $apartment->beds = ($data_apartment['beds']);
        // $apartment->is_visible = ($data_apartment['is_visible']);
        $apartment->fill($data_apartment);
        $apartment->save();

        return response()->json($apartment);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $apartments = Apartment::with('messages', 'services', 'sponsors', 'visits')->find($id);
        if (!$apartments) return response(null, 404);
        return response()->json($apartments);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
