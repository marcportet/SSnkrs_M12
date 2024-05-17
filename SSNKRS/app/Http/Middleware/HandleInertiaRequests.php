<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Models\Client;
use App\Models\Carrito;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $sharedData = [
            ...parent::share($request),
            'flash' => [
                'success' => $request->session()->get('success'),
                'error' => $request->session()->get('error'),
            ],
        ];

        if ($request->user()) {
            $clientId = $request->user()->id_client;
            $client = Client::find($clientId);
            $carrito = Carrito::find($client->id_carrito);
            $sharedData['auth'] = [
                'user' => $request->user(),
                'client' => $client,
                'carrito' => $carrito,
            ];
        } else {
            $sharedData['auth'] = [
                'user' => $request->user(),
            ];
        }

        return $sharedData;
    }
}
