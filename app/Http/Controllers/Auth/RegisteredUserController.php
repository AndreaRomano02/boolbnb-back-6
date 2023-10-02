<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // dd($request);
        $request->validate([
            'name' => ['string', 'max:20', 'min:3'],
            'surname' => ['string', 'nullable'],
            'date_birth' => ['date', 'nullable'],
            'email' => ['required', 'string', 'email', 'min:10', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'name.string' => 'L\' Elemento inserito non è testo',
            'name.max' => 'Il Testo inserito è troppo lungo massimo 20 caratteri',
            'name.min' => 'Il Testo inserito è troppo corto minimo 3 caratteri',
            'surname.string' => 'L\' Elemento inserito non è testo',
            'date_birth.date' => 'L\' Elemento inserito non è una data',
            'email.required' => 'L\' Email è obbligatoria',
            'email.email' => 'L\' Elemento inserito non è un\' Email',
            'email.max' => 'L\' Email inserita è troppo lungo massimo 255 caratteri',
            'email.min' => 'L\' Email inserita è troppo corta massimo 10 caratteri',
            'email.unique' => 'L\'Email esiste già',
            'password.required' => 'La password è obbligatoria',
            'password.min' => 'La password deve essere di minimo 8 caratteri',
            'password.confirmed' => 'Le password deveno essere identiche',

        ]);

        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'date_birth' => $request->date_birth,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
