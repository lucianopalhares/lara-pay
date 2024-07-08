<?php 

namespace App\Services\GatewayServices\Asaas;

use App\Contracts\PaymentGatewayInterface;
use App\Services\GatewayServices\Asaas\AsaasHttpGatewayService;
use App\Enums\HttpMethodEnum;
use App\Enums\HttpStatusEnum;
use Carbon\Carbon;

class AsaasBoletoGatewayService extends AsaasHttpGatewayService implements PaymentGatewayInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Metodo para gerar pagamento
     * 
     * @param Array $data 
     * @return Array
     */
    public function process(array $data): array 
    {
        try {
        
            $this->setCustomer($data);      

            $carbon = Carbon::now();
            $date = $carbon->addDays(15);

            $data['dueDate'] = $date;

            $this->setUrl('/payments');
            $this->send($data, HttpMethodEnum::POST);

            $this->message = 'Boleto gerado com sucesso. Clique no link abaixo para realizar o pagamento.';
              //code...
        } catch (\Exception $e) {
            $this->status = HttpStatusEnum::SERVER_ERROR->value;
            $this->data = (string) $e->getMessage();
            $this->message = 'Estamos com instabilidade no sistema. Tente novamente mais tarde.';
        }

        return $this->response();
    }
}