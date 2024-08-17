<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Rule;

class RuleCreditCard implements Rule
{

    /**
     * Passes validation
     * 
     * @param $attribute
     * @param $value
     * 
     * @return mixed
     */
    public function passes($attribute, $value) 
    {
        return $this->validateCreditCard($value);
    }

    /**
     * Message validation
     *  
     * @return String
     */
    public function message(): String
    {
        return 'Numero do cartão de crédito inválido';
    }

    protected function validateCreditCard($number): bool
    {
        $number = preg_replace('/\D/','',$number);

        if (strlen($number) !== 16) {
            return false;
        }

        return true;
    }
}
