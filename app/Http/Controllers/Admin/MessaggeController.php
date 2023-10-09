<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessaggeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $apartments = Apartment::where('user_id', $user->id)->get();
        $messagges = [];
        foreach ($apartments as $apartment) {
            $messagges = Message::where('apartment_id', $apartment->id)->get();
        }

        return view('admin.messagges.index', compact('apartment', 'user', 'messagges'));
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

        $user = Auth::user();
        $messagge = Message::where('id', $id)->find($id);
        $apartment = Apartment::with('images')->where('id', $messagge->apartment_id)->get();
        if (!Apartment::withTrashed()->find($messagge->apartment_id)) abort(404);
        else if (!Auth::user() || !$apartment) abort(403);
        return view('admin.messagges.show', compact('apartment', 'user', 'messagge'));
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
    public function destroy(string $id)
    {
        //
    }
}
