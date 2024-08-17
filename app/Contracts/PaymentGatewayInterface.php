<?php 

namespace App\Contracts;

interface PaymentGatewayInterface
{
    /*
    * Metodo para gerar pagamento
    *
    * @param Array $data
    * @return Array
    */
    public function process(array $data);
}