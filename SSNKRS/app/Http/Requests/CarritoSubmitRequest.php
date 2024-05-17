<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CarritoSubmitRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'poblacion' => ['required', 'string', 'max:255'],
            'calle' => ['required', 'string', 'max:255'],
            'cpostal' => ['required', 'numeric'],
            'info_adicional' => ['string', 'max:255'],
        ];
    }
}
