<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Visit;
use Illuminate\Http\Request;

class VisitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'apartment_id' => 'required|exists:apartments,id',
                'date' => 'required|date_format:Y-m-d H:i:s',
                'IP_address' => 'required'
            ],
            [
                'apartment_id.required' => 'Dati dell\' appartamento inesistenti',
                'apartment_id.exists' => 'Il messaggio non può essere inviato all\'appartamento selezionato',
                'date.required' => 'La data è obbligatoria',
                'IP_address.required' => 'l\'ip è obbligatorio'
            ]

        );

        $data_visit = $request->all();
        $visit = new Visit();

        $visit->apartment_id =  $data_visit['apartment_id'];
        $visit->IP_address =  $data_visit['IP_address'];
        $visit->date =  $data_visit['date'];


        $visit->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
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
