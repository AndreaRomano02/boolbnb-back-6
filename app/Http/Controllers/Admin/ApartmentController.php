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
use Illuminate\Validation\Rule;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $apartments = Apartment::where('user_id', $user->id)->with('images')->get();
        // $apartment_images = Image::where('apartment_id',  $apartments->id)->get();
        // dd($apartment_images);
        return view('admin.apartments.index', compact('apartments', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $apartment_service_ids = [];
        $apartment_sponsor_ids = [];
        $apartment = new Apartment();
        $services = Service::all();
        $sponsors = Sponsor::all();
        return view('admin.apartments.create', compact('user', 'apartment', 'services', 'sponsors', 'apartment_service_ids', 'apartment_sponsor_ids'));
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
                'image' => 'nullable|image|mimes:jpeg,jpg,png,gif,svg',
                'price' => 'nullable|integer',
                'beds' => 'required|integer',
                'rooms' => 'nullable|integer',
                'bathrooms' => 'nullable|integer',
                'square_meters' => 'nullable|integer',
                'is_visible' => 'nullable|boolean',
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
                'beds.required' => 'Il numero di posti letto è obbligatorio',
                'beds.integer' => 'Valore inserito non numerico',
                'rooms.integer' => 'Valore inserito non numerico',
                'price.integer' => 'Valore inserito non numerico',
                'bathrooms.integer' => 'Valore inserito non numerico',
                'square_meters.integer' => 'Valore inserito non numerico',
                'is_visible.boolean' => 'Valore inserito non valido',
                'services.required' => 'Almeno un servizio è obbligatorio',
                'services.exists' => 'Il servizio scelto non esiste',
            ]
        );
        $apartment = new Apartment();

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
        $apartment->price = ($data_apartment['price']);
        $apartment->square_meters = ($data_apartment['square_meters']);
        if (isset($apartment->is_visible)) $apartment->is_visible = ($data_apartment['is_visible']);
        else $apartment->is_visible = false;

        $apartment->save();

        if (Arr::exists($data_apartment, 'image')) {
            $folder = 'apartments_image';
            $image = $request->file('image');
            $imageName =  time() . '.' . $image->extension();

            $image_path = "$folder/$imageName";

            $image->storeAs($folder, $imageName);
            $imageModel = new Image();
            $imageModel->apartment_id = $apartment->id;
            $imageModel->path =  $image_path;
            $imageModel->save();
        }

        if (array_key_exists('services', $data_apartment)) {
            $apartment->services()->attach($data_apartment['services']);
        }

        // if (array_key_exists('sponsor', $data_apartment)) {
        //     $apartment->sponsors()->attach($data_apartment['sponsor']);
        // }

        return to_route('admin.apartments.show', compact('apartment'));
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
        $user = Auth::user();
        $apartment = Apartment::where('user_id', $user->id)->withTrashed()->findOrFail($id);
        $services = Service::all();
        $sponsors = Sponsor::all();
        $apartment_service_ids = $apartment->services->pluck('id')->toArray();
        $apartment_sponsor_ids = $apartment->sponsors->pluck('id')->toArray();
        return view('admin.apartments.edit', compact('apartment', 'user', 'services', 'sponsors', 'apartment_service_ids', 'apartment_sponsor_ids'));
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
                'image' => 'nullable|image|mimes:jpeg,jpg,png,gif,svg',
                'price' => 'nullable|integer',

                'beds' => 'required|integer',
                'rooms' => 'nullable|integer',
                'bathrooms' => 'nullable|integer',
                'square_meters' => 'nullable|integer',
                'is_visible' => 'nullable|boolean',
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
                'price.integer' => 'Valore inserito non numerico',

                'square_meters.integer' => 'Valore inserito non numerico',
                'is_visible.boolean' => 'Valore inserito non valido',
                'services.require' => 'Almeno un servizio di è obbligatorio',
                'services.exists' => 'Il servizio scelto non esiste',
            ]
        );
        $user = Auth::user();
        $apartment = Apartment::where('user_id', $user->id)->withTrashed()->findOrFail($id);
        $image_old = Image::where('apartment_id', $apartment->id)->first();
        $address_info = str_replace(' ', '%20', $data_apartment['address']);
        $key = 'key=PWX9HGsOx1sGv84PlpxzgXIbaElOjVMF';
        $query = "https://api.tomtom.com/search/2/geocode/$address_info.json?storeResult=false&lat=37.337&lon=-121.89&view=Unified&$key";
        $client = new Client(['verify' => false]);
        $response = $client->get($query);
        $data = json_decode($response->getBody(), true);
        $apartment->latitude = $data['results'][0]['position']['lat'];
        $apartment->longitude = $data['results'][0]['position']['lon'];
        if (isset($data_apartment['is_visible'])) $apartment->is_visible = ($data_apartment['is_visible']);
        else $apartment->is_visible = false;

        $apartment->update($data_apartment);

        if (!Arr::exists($data_apartment, 'services') && count($apartment->services)) $apartment->services()->detach();
        elseif (Arr::exists($data_apartment, 'services')) $apartment->services()->sync($data_apartment['services']);


        // if (!Arr::exists($data_apartment, 'sponsor') && count($apartment->sponsors)) $apartment->sponsors()->detach();
        // elseif (Arr::exists($data_apartment, 'sponsor')) $apartment->sponsors()->sync($data_apartment['sponsor']);

        if (Arr::exists($data_apartment, 'image')) {

            $imageModel = new Image();
            $imageModel->apartment_id = $apartment->id;

            if (Arr::exists($data_apartment, 'image')) {
                foreach ($apartment->images as $image) {
                    Storage::delete($image->path);
                    $image_old->forceDelete();
                }
                $img_url = Storage::putFile('apartments_image', $data_apartment['image']);
                $data_apartment['image'] = $img_url;
            }

            $imageModel->path =  $img_url;

            $imageModel->save();
        }

        return to_route('admin.apartments.show', compact('apartment'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Apartment $apartment)
    {
        $apartment->delete();
        return to_route('admin.apartments.index')->with('type', 'success')->with('message', 'Il progetto è stato spostato nell\'arhcivio con successo!');
    }

    public function archive()
    {
        $apartments = Apartment::onlyTrashed()->get();
        return view('admin.apartments.archive', compact('apartments'));
    }

    public function restore(String $id)
    {
        $apartment = Apartment::onlyTrashed()->findOrFail($id);
        $apartment->restore();
        return to_route('admin.apartments.archive')->with('type', 'success')->with('message', 'Il progetto è stato ripristinato!');
    }
}
