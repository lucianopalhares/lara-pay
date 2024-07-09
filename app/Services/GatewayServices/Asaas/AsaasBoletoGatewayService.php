<?php 

namespace App\Services\GatewayServices\Asaas;

use App\Contracts\PaymentGatewayInterface;
use App\Services\GatewayServices\Asaas\AsaasHttpGatewayService;
use App\Enums\HttpMethodEnum;
use App\Enums\HttpStatusEnum;
use App\Enums\BillingTypeEnum;
use Carbon\Carbon;
use App\Http\Resources\AsaasPaymentResource;

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

            $response = $this->response();

            if ($response['success'] === true) {
                $data = $response['data'];

                $data->creditCardBrand = null;
                $data->creditCardNumber = null;  
                $data->encodedImage = null;
                $data->payload = null;
                $data->billingType = BillingTypeEnum::tryFromName($data->billingType)->value;
                
                $this->data = new AsaasPaymentResource((object) $data);
            }

            $this->message = 'Boleto gerado com sucesso. Clique no link abaixo para realizar o pagamento.';
              //code...
        } catch (\Exception $e) {
            $this->status = HttpStatusEnum::SERVER_ERROR;
            $this->error = (string) $e->getMessage();
            $this->message = 'Estamos com instabilidade no sistema. Tente novamente mais tarde.';
        }

        return $this->response();
    }
}