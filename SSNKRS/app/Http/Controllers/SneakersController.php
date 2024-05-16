<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Carrito;
use App\Models\User;


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
        if ($size == "null") {
            return redirect()->back()->with('message', 'Talla no seleccionada.');
        }

        $client = Client::find($id_cliente);
        $carrito = Carrito::find($client->id_carrito);

        $productos = json_decode($carrito->productos, true);

        $producto_existente = false;
        if ($productos != null) {
            foreach ($productos as $producto) {
                if ($producto['id_producto'] == $id_producto && $producto['size'] == $size) {
                    $producto_existente = true;
                    break;
                }
            }
            if ($producto_existente) {
                return redirect()->back()->with('message', 'El producto ya está en el carrito con la misma talla.');
            }
        }

        $nuevo_producto = array(
            'size' => $size,
            'id_producto' => $id_producto
        );
        $productos[] = $nuevo_producto;

        $productos_json = json_encode($productos);

        $carrito->update(['productos' => $productos_json]);

        return redirect()->back();
    }

    public function carrito_delete($id_carrito, $id_producto, $size)
    {
        $carrito = Carrito::find($id_carrito);

        $productos = json_decode($carrito->productos, true);

        foreach ($productos as $index => $producto) {
            if ($producto['id_producto'] == $id_producto && $producto['size'] == $size) {
                array_splice($productos, $index, 1);
                break;
            }
        }

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
        $users = DB::table('users')->get();

        return Inertia::render('Views/usuarios', ['users' => $users]);
    }
}
