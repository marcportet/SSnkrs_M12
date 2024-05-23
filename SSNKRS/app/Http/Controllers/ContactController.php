<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function __invoke(ContactRequest $request)
    {
        // Envía el correo
        Mail::to('ssnkrs.empresa@gmail.com')->send(new ContactMail($request->name,$request->email,$request->text));

        return Inertia::render('Views/contacto');
    }
}
