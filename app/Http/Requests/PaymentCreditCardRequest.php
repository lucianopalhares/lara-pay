<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\RuleCreditCard;
use App\Rules\RuleCpfCnpj;

class PaymentCreditCardRequest extends FormRequest
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
            'number' => ['required', new RuleCreditCard],
            'holderName' => 'required',
            'expiryMonth' => 'required',
            'expiryYear' => 'required|digits:4',
            'ccv' => 'required|digits:3',
            'email' => 'required',
            'postalCode' => 'required',
            'addressNumber' => 'required',
            'addressComplement' => 'required',
            'phone' => 'required', 
            'remoteIp' => 'required',
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
            'holderName.required' => 'Digite o nome do titular do cartão',
            'expiryMonth.required' => 'Digite o mẽs de vencimento do cartão',
            'expiryYear.required' => 'Digite o ano de vencimento do cartão',
            'ccv.required' => 'Digite o ccv do cartão',
            'email.required' => 'Digite o email',
            'postalCode.required' => 'Digite o CEP',
            'addressNumber.required' => 'Digite o numero do endereço',
            'addressComplement.required' => 'Digite o endereço',
            'number.required' => 'Digite o numero do cartão',
            'number.digits' => 'Digite o numero do cartão corretamente',
            'userId.required' => 'Cliente nao encontrado',
            'externalReference.required' => 'Digite o numero do pedido',
        ];
    }
}
