<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

use App\Models\User;
use App\Models\Client;
use App\Models\Marketing;
use App\Models\Admin;
use App\Models\Carrito;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $clientId = $request->user()->id_client;
        $client = Client::find($clientId);

        $client->fill($request->validated());

        $client->save();

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
            $user->save();
        }

        return Redirect::route('profile.edit');
    }


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Delete cuenta por id
     */
    public function destroy_id($id): RedirectResponse
    {
        $user = User::find($id);

        $user->delete();

        if($user->id_client){
            $id_client = $user->id_client;
            $client = Client::find($id_client);
            $carrito = Carrito::find($client->id_carrito);

            $client->delete();
            $carrito->delete();
        }
        if($user->id_admin){
            $id_admin = $user->id_admin;
            $admin = Admin::find($id_admin);
            $admin->delete();
        }
        if($user->id_marketing){
            $id_marketing = $user->id_marketing;
            $marketing = Marketing::find($id_marketing);
            $marketing->delete();
        }

        return Redirect::to('/usuarios');
    }

      /**
     * Añadir rol de Marketing a un $id
     */
    public function add_marketing($id): RedirectResponse
    {
        $user = User::find($id);

        $marketing = Marketing::create([]);

        $user->id_marketing = $marketing->id;

        $user->save();

        return Redirect::to('/usuarios');
    }

   /**
     * Quitar rol de Marketing a un $id
     */
    public function remove_marketing($id): RedirectResponse
    {
        $user = User::find($id);

        $user->id_marketing = null;

        $user->save();

        return Redirect::to('/usuarios');
    }


    /**
     * Añadir rol de Admin a un $id
     */
    public function add_admin($id): RedirectResponse
    {
        $user = User::find($id);

        $admin = Admin::create([]);

        $user->id_admin = $admin->id;

        $user->save();

        return Redirect::to('/usuarios');
    }

   /**
     * Quitar rol de Admin a un $id
     */
    public function remove_admin($id): RedirectResponse
    {
        $user = User::find($id);

        $user->id_admin = null;

        $user->save();

        return Redirect::to('/usuarios');
    }

    public function google_destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = $request->user();

        if ($request->input('email') !== $user->email) {
            return redirect()->back()->withErrors(['email' => 'El correo electrónico proporcionado no coincide con el correo electrónico de la cuenta.']);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
