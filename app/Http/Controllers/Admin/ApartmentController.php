<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\Request;
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
