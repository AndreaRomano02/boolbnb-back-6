<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\Request;

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
        //
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
