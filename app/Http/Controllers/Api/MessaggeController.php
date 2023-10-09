<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessaggeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data_messagge = $request->all();
        $request->validate(
            [
                'apartment_id' => 'required|exists:apartments,id',
                'name' => 'required|string',
                'surname' => 'required|string',
                'email' => 'required|string',
                'content' => 'required|string',
            ],
            [
                'apartment_id.required' => 'Dati dell\' appartamento inesistenti',
                'apartment_id.exists' => 'Il messaggio non può essere inviato all\'appartamento selezionato',
                'name.required' => 'Il Nome è obbligatorio',
                'surname.required' => 'Il cognome è obbligatorio',
                'email.required' => 'L\' Email è obbligatoria',
                'content.required' => 'Il Contenuto dell\'messaggio è obbligatorio',
            ]
        );

        $messagge = new Message();

        $messagge->apartment_id =  $data_messagge['apartment_id'];
        $messagge->name =  $data_messagge['name'];
        $messagge->surname =  $data_messagge['surname'];
        $messagge->email =  $data_messagge['email'];
        $messagge->content =  $data_messagge['content'];

        $messagge->save();
        // dd($messagge);
        // return response()->json($messagge);
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
