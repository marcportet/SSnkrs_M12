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
    public function catalogo($marca = null)
    {
        if ($marca) {
            switch ($marca) {
                case 'NIKE':
                    return Inertia::render('Views/nike_sneakers');
                    break;
                case 'JORDAN':
                    return Inertia::render('Views/nike_sneakers');
                    break;
                case 'ADIDAS':
                    return Inertia::render('Views/nike_sneakers');
                    break;
                case 'NEW BALANCE':
                    return Inertia::render('Views/adidas_sneakers');
                    break;
                case 'YEEZY':
                    return Inertia::render('Views/nike_sneakers');
                    break;
                default:
                    return Inertia::render('Views/catalogo');
                    break;
            }
        }
        return Inertia::render('Views/catalogo');
    }

    public function detalle($id)
    {
        return Inertia::render('Views/detalle');
    }

    public function contacto()
    {
        return Inertia::render('Views/contacto');
    }
}
