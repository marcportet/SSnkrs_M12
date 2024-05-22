<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use App\Models\Carrito;
use App\Models\Comanda;
use GuzzleHttp\Client as HttpClient;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\CarritoSubmitRequest;
use Inertia\Inertia;

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
            return redirect()->back()->with('error', 'Talla no seleccionada.');
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
                return redirect()->back()->with('error', 'El producto ya está en el carrito con la misma talla.');
            }
        }

        $nuevo_producto = array(
            'size' => $size,
            'id_producto' => $id_producto
        );
        $productos[] = $nuevo_producto;

        $productos_json = json_encode($productos);

        $carrito->update(['productos' => $productos_json]);

        return redirect()->back()->with('success', 'Producto añadido correctamente.');
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

    public function carrito_submit(CarritoSubmitRequest $request)
    {
        $user = $request->user();
        $client = Client::find($user->id_client);
        $carrito = Carrito::find($client->id_carrito);
        $productos = $carrito->productos;
        $productos_arr = json_decode($carrito->productos, true);

        $httpClient = new HttpClient();

        foreach ($productos_arr as $key => $value) {
            $idProducto = $value['id_producto'];
            $sizeproducto = $value['size'];
            try {
                $response = $httpClient->put("http://localhost:3000/api/sneakers_sizes/delstock/$idProducto", [
                    'json' => [
                        'size' => $sizeproducto
                    ]
                ]);
                if ($response->getStatusCode() !== 200) {
                    // Manejo del caso donde la respuesta no sea exitosa
                    throw new \Exception("Error actualizando stock para el producto $idProducto");
                }
            } catch (\Exception $e) {
                // Manejo del error
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }

        $calle = $request->input('calle');
        $poblacion = $request->input('poblacion');
        $cpostal = $request->input('cpostal');
        $info_adicional = $request->input('info_adicional');

        $direccion = "$calle, $poblacion, $cpostal, $info_adicional";

        $comanda = Comanda::create([
            'productos' => $productos,
            'dir_envio' => $direccion,
            'fecha_compra' => now()->toDateString(),
            'id_client' => $client->id,
        ]);

        $carrito->productos = json_encode([]);
        $carrito->save();

        return Inertia::render('Views/comanda', ['comanda' => $comanda]);
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

    public function comanda($id_comanda)
    {
        $comanda = DB::table('comandas')
            ->where('id', $id_comanda)
            ->first();
        return Inertia::render('Views/comanda', ['comanda' => $comanda]);
    }

    public function historial($id_client)
    {
        $comandes = DB::table('comandas')
            ->where('id_client', $id_client)
            ->get();
        return Inertia::render('Views/historial', ['comandes' => $comandes]);
    }

    public function modstock($id)
{
    // Crear una nueva instancia del cliente HTTP
    $httpClient = new HttpClient();

    try {
        // Obtener la información del sneaker
        $response = $httpClient->request('GET', "http://localhost:3000/api/sneakers/$id");
        if ($response->getStatusCode() !== 200) {
            throw new \Exception("Error obteniendo información del producto $id");
        }
        $sneaker = json_decode($response->getBody()->getContents(), true);

        // Obtener la información de los sizes
        $response = $httpClient->request('GET', "http://localhost:3000/api/sizes");
        if ($response->getStatusCode() !== 200) {
            throw new \Exception("Error obteniendo tamaños para el producto $id");
        }
        $sizes = json_decode($response->getBody()->getContents(), true);

        // Suponiendo que 'sneaker' tiene propiedades 'sizes' y 'stock' que son cadenas de texto
        $sizesArray = explode(',', $sneaker[0]['sizes']);
        $stockArray = explode(',', $sneaker[0]['stock']);

        // Verificar si los arrays se dividieron correctamente
        if (count($sizesArray) !== count($stockArray)) {
            throw new \Exception("La cantidad de tamaños y stock no coincide");
        }

        // Construir el nuevo array $size_stock
        $size_stock = [];
        for ($i = 0; $i < count($sizesArray); $i++) {
            $size_stock[] = [
                'size' => $sizesArray[$i],
                'stock' => $stockArray[$i]
            ];
        }

        // Añadir el array combinado como una nueva propiedad del sneaker
        $sneaker[0]['size_stock'] = $size_stock;

        // Renderizar la vista con Inertia, pasando los datos del sneaker
        return Inertia::render('Views/modstock', [
            'sneaker' => $sneaker,
            'sizes' => $sizes,
        ]);
    } catch (\Exception $e) {
        return redirect()->back()->withErrors(['message' => $e->getMessage()]);
    }
}



}
