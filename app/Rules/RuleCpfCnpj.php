<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Rule;

class RuleCpfCnpj implements Rule
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
        return $this->validateCpfCnpj($value);
    }

    /**
     * Message validation
     *  
     * @return String
     */
    public function message(): String
    {
        return 'Numero o CPF ou CNPJ corretamente';
    }

    protected function validateCpfCnpj($number): bool
    {
        $number = preg_replace('/[^0-9]/','',$number);

        if (strlen($number) !== 11 && strlen($number) !== 14) {
            return false;
        }

        return true;
    }
}
