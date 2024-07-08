<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\RuleCpfCnpj;

class PaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'value' => 'required',
            'name' => 'required', 
            'cpfCnpj' => ['required', new RuleCpfCnpj],
            'customer'=> 'nullable', 
            'userId'=> 'required', 
            'externalReference'=> 'required', 
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function messages(): array
    {
        return [
            'value.required' => 'Digite o valor',
            'name.required' => 'Digite o nome', 
            'cpfCnpj.required' => 'Digite o cpf ou cnpj',
            'userId.required' => 'Cliente nao encontrado',
            'externalReference.required' => 'Digite o numero do pedido',
        ];
    }
}
