<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Sponsor;
use Carbon\Carbon;
use DateTime;
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
        $data = $request->all();
        // dd($data['sponsor_id']);
        $sponsor = Sponsor::where('id', $data['sponsor_id'])->withTrashed()->find($data['sponsor_id']);
        $mytime = Carbon::now()->timezone('Europe/Stockholm');
        // $mytime->toDateTimeString();
        $carbon_date = Carbon::parse($mytime);
        $carbon_date->addHours($sponsor->duration);

        // dd($start, $end);
        $apartment = Apartment::where('id', $data['apartment_id'])->withTrashed()->find($id);
        // dd($sponsor->duration);
        if (array_key_exists('sponsor_id', $data) && array_key_exists('apartment_id', $data)) {
            $apartment->sponsors()->attach($data['sponsor_id'], ['start_date' =>   $mytime, 'end_date' => $carbon_date]);
        }

        return view('admin.apartments.show', compact('apartment'))->with('type', 'success')->with('message', 'Sponsor inserito con successo');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function payment()
    {
    }
}
