<?php 

namespace App\Enums;

enum BillingTypeEnum: string 
{
    case BOLETO = 'BOLETO';
    case CREDIT_CARD = 'CREDIT_CARD';
    case PIX = 'PIX';
    case UNDEFINED = 'UNDEFINED';
}