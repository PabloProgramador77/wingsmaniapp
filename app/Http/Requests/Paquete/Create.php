<?php

namespace App\Http\Requests\Paquete;

use Illuminate\Foundation\Http\FormRequest;

class Create extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if( auth()->user()->id ){

            return true;

        }else{

            return false;

        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            
            'nombre' => 'required|string',
            'precio' => 'required|numeric',
            'categoria' => 'required|integer',
            'descripcion' => 'string|nullable',
            'salsas' => 'integer|nullable',
            'bebidas' => 'integer|nullable',

        ];
    }
}
