<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Carrito;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class SneakersController extends Controller
{
    public function catalogo()
    {
        return Inertia::render('Views/catalogo');
    }

    public function detalle()
    {
        return Inertia::render('Views/detalle');
    }

    public function contacto()
    {
        return Inertia::render('Views/contacto');
    }

    public function carrito($id_carrito)
    {
        $carrito = DB::table('carritos')
            ->where('id', $id_carrito)
            ->first();
        return Inertia::render('Views/carrito', ['carrito' => $carrito]);
    }

    public function carrito_add($id_producto, $id_cliente, $size)
    {
        $client = Client::find($id_cliente);
        $carrito = Carrito::find($client->id_carrito);

        $productos = json_decode($carrito->productos, true);
        $nuevo_producto = array(
            'size' => $size,
            'id_producto' => $id_producto
        );
        $productos[] = $nuevo_producto;

        $productos_json = json_encode($productos);

        $carrito->update(['productos' => $productos_json]);

        return redirect()->back();
    }

    public function fqs()
    {
        return Inertia::render('Views/fqs');
    }
    public function stock()
    {
        return Inertia::render('Views/stock');
    }
    public function usuarios()
    {
        return Inertia::render('Views/usuarios');
    }
}
