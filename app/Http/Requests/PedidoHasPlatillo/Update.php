<?php

namespace App\Http\Requests\PedidoHasPlatillo;

use Illuminate\Foundation\Http\FormRequest;

class Update extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if( auth()->user()->id && session()->get('idPedido') ){

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
            
            'id' => 'required|integer',
            'salsas' => 'array|nullable',
            'salsas.*' => 'string|nullable',
            'preparaciones' => 'array|nullable',
            'preparaciones.*' => 'string|nullable'
        ];
    }
}
