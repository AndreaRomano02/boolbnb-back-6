<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Sponsor;
use Carbon\Carbon;
use \Braintree\Gateway;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\Cast\Object_;

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

        //# Prendiamo tutto il necessario
        if ($request) {
            $data = $request->all();
            $sponsor = Sponsor::where('id', $data['sponsor_id'])->withTrashed()->find($data['sponsor_id']);
            $apartment = Apartment::with('sponsors')->where('id', $data['apartment_id'])->withTrashed()->find($id);

            $mytime = Carbon::now()->timezone('Europe/Stockholm');
            $carbon_date = Carbon::parse($mytime);
            $carbon_date->addHours($sponsor->duration);
        }

        //# Diamo l'autorizzazione a Braintree
        $gateway = new Gateway([
            'environment' => 'sandbox',
            'merchantId' => 'zkvj7pnw8fkt9cv8',
            'publicKey' => 'tk7g4jvv9bdbfkxx',
            'privateKey' => '583e36e45a30bcd00c4293a1e69a7286'
        ]);

        $result = $gateway->transaction()->sale([
            'paymentMethodNonce' => $request->payment_method_nonce,
            'amount' => $sponsor->price,
        ]);

        //# Se il pagamento è stato effetutato con successo
        if ($result->success) {

            //# Si fa l'attach degli sponsor nella tabella di mezzo apartment_sponsor
            if (array_key_exists('sponsor_id', $data) && array_key_exists('apartment_id', $data)) {
                $apartment->sponsors()->attach($data['sponsor_id'], ['start_date' =>   $mytime, 'end_date' => $carbon_date]);
            }

            return to_route('admin.apartments.show', compact('apartment'))->with('type', 'success')->with('message', 'Sponsor inserito con successo');
        } else {
            return to_route('admin.apartments.show', compact('apartment'))->with('type', 'danger')->with('message', 'Il pagamento NON è andato a buon fine');
        }
    }

    public function checkout(Request $request, Apartment $apartment)
    {
        $current_date =  Carbon::now()->timezone('Europe/Stockholm');


        //# Controllo se ha gia una sponsorizzazione in corso
        if (count($apartment->sponsors)) {
            $last_sponsor = $apartment->sponsors[count($apartment->sponsors) - 1]['pivot'];

            if (strtotime($last_sponsor->end_date) > strtotime($current_date)) {
                $end_date =   Carbon::parse($last_sponsor->end_date)->format('d-m-Y H:m:s');

                return to_route('admin.apartments.show', compact('apartment'))
                    ->with('type', 'danger')
                    ->with('message', "Hai gia una sponsorizzazione in corso valida fino al $end_date");
            }
        }
        return view('admin.sponsors.payment', compact('request'));
    }
}
