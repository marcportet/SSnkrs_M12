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
    public function carrito()
    {
        return Inertia::render('Views/carrito');
    }

    public function fqs()
    {
        return Inertia::render('Views/fqs');
    }
    public function stock()
    {
        return Inertia::render('Views/stock');
    }
}
