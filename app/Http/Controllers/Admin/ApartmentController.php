<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Image;
use App\Models\Service;
use App\Models\Sponsor;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $apartments = Apartment::where('user_id', $user->id)->get();
        return view('admin.apartments.index', compact('apartments', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $apartment = new Apartment();
        $services = Service::all();
        $sponsors = Sponsor::all();
        return view('admin.apartments.create', compact('user', 'apartment', 'services', 'sponsors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data_apartment = $request->all();
        // dd($data_apartment);
        $request->validate(
            [
                'user_id' => 'required|exists:users,id',
                'title' => 'required|unique:apartments|string',
                'description' => 'required|string',
                'address' => 'required|string',
                'longitude' => 'nullable|string',
                'latitude' => 'nullable|string',
                'image' => 'nullable',
                'beds' => 'required|integer',
                'rooms' => 'nullable|integer',
                'bathrooms' => 'nullable|integer',
                'square_meters' => 'nullable|integer',
                'is_visible' => 'required|boolean',
                'sponsor' => 'required|integer|exists:sponsors,id',
                'services' => 'required|exists:services,id',
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
                'sponsor.require' => 'Lo sponsor è obbligatorio',
                'services.require' => 'Almeno un servizio di è obbligatorio',
                'sponsor.exists' => 'Lo sponsor scelto non esiste',
                'services.exists' => 'Il servizio scelto non esiste',
            ]
        );
        $apartment = new Apartment();
        $image = new Image();

        $address_info = str_replace(' ', '%20', $data_apartment['address']);
        $key = 'key=PWX9HGsOx1sGv84PlpxzgXIbaElOjVMF';
        $query = "https://api.tomtom.com/search/2/geocode/$address_info.json?storeResult=false&lat=37.337&lon=-121.89&view=Unified&$key";

        $client = new Client(['verify' => false]);
        $response = $client->get($query);
        $data = json_decode($response->getBody(), true);

        $apartment->user_id = ($data_apartment['user_id']);
        $apartment->title = ($data_apartment['title']);
        $apartment->description = ($data_apartment['description']);
        $apartment->address = ($data_apartment['address']);
        $apartment->latitude = $data['results'][0]['position']['lat'];
        $apartment->longitude = $data['results'][0]['position']['lon'];
        $apartment->rooms = ($data_apartment['rooms']);
        $apartment->beds = ($data_apartment['beds']);
        $apartment->bathrooms = ($data_apartment['bathrooms']);
        $apartment->square_meters = ($data_apartment['square_meters']);
        $apartment->is_visible = ($data_apartment['is_visible']);


        $apartment->save();


        $folder = 'apartments_image';
        $image = $request->file('image');
        $imageName =  time() . '.' . $image->extension();

        $image_path = "$folder/$imageName";

        $image->storeAs($folder, $imageName);
        $imageModel = new Image();
        $imageModel->apartment_id = $apartment->id;
        $imageModel->path =  $image_path;
        $imageModel->save();

        if (array_key_exists('services', $data_apartment)) {
            $apartment->services()->attach($data_apartment['services']);
        }

        if (array_key_exists('sponsor', $data_apartment)) {
            $apartment->sponsors()->attach($data_apartment['sponsor']);
        }

        return to_route('admin.apartments.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(String $id)
    {
        $user = Auth::user();
        $apartment = Apartment::where('user_id', $user->id)->withTrashed()->findOrFail($id);
        return view('admin.apartments.show', compact('apartment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
    public function destroy(Apartment $apartment)
    {
        $apartment->delete();
        return to_route('admin.apartments.index')->with('type', 'success')->with('message', 'Il progetto è stato spostato nel cestino!');
    }

    public function trash()
    {
        $apartments = Apartment::onlyTrashed()->get();
        return view('admin.apartments.trash', compact('apartments'));
    }

    public function restore(String $id)
    {
        $apartment = Apartment::onlyTrashed()->findOrFail($id);
        $apartment->restore();
        return to_route('admin.apartments.trash')->with('type', 'success')->with('message', 'Il progetto è stato ripristinato!');
    }

    public function drop(String $id)
    {
        $apartment = Apartment::onlyTrashed()->findOrFail($id);
        if ($apartment->image) Storage::delete($apartment->image);
        $apartment->forceDelete();
        return to_route('admin.apartments.trash')->with('type', 'success')->with('message', 'Il progetto è stato eliminato definitivamente!');
    }

    public function dropAll()
    {
        Apartment::onlyTrashed()->forceDelete();
        return to_route('admin.apartments.trash')->with('type', 'success')->with('message', 'Il tuo cestino è stato svuotato correttamente!');
    }
}
