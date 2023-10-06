<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SponsorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sponsors = Sponsor::all();

        return view('admin.sponsors.index', compact('sponsors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
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
        $sponsor = Sponsor::where('id', $id)->withTrashed()->find($id);
        if (!Sponsor::withTrashed()->find($id)) abort(404);
        return view('admin.sponsors.show', compact('sponsor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = Auth::user();
        $sponsors = Sponsor::all();
        $apartment = Apartment::where('user_id', $user->id)->withTrashed()->find($id);
        if (!Apartment::find($id)) abort(404);
        else if (!Auth::user() || !$apartment) abort(403);

        return view('admin.sponsors.edit', compact('sponsors', 'user', 'apartment'));
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
