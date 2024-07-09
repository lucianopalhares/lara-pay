<?php 

namespace App\Enums;

enum BillingTypeEnum: string 
{
    case BOLETO = 'BOLETO';
    case CREDIT_CARD = 'CARTÃO DE CRÉDITO';
    case PIX = 'PIX';
    case UNDEFINED = 'UNDEFINED';

    public static function tryFromName(string $name): ?self
    {
        foreach (self::cases() as $case) {
            if ($case->name === $name) {
                return $case;
            }
        }

        return null;
    }
}