<?php 

namespace App\Services\GatewayServices\Asaas;

use App\Contracts\PaymentGatewayInterface;

class AsaasCreditCardGatewayService implements PaymentGatewayInterface
{
    public function __construct()
    {
        
    }

    /**
     * Metodo para gerar pagamento
     * 
     * @param Array $data 
     * @return Array
     */
    public function process(array $data): array 
    {
        return ['credit card chamado'];
    }
}