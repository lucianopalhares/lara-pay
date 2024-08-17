<?php 

namespace App\Services\GatewayServices\Asaas;

use App\Contracts\PaymentGatewayInterface;
use App\Services\GatewayServices\Asaas\AsaasHttpGatewayService;
use App\Enums\HttpMethodEnum;
use App\Enums\HttpStatusEnum;
use App\Enums\BillingTypeEnum;
use Carbon\Carbon;
use App\Http\Resources\AsaasPaymentResource;

class AsaasPixGatewayService extends AsaasHttpGatewayService implements PaymentGatewayInterface
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

            $data['billingType'] = BillingTypeEnum::PIX->value;

            $this->setUrl('/payments');
            $this->send($data, HttpMethodEnum::POST);

            $response = $this->response();

            $paymentCreated = $response['success'] === true;

            if ($paymentCreated === true) {
                $responseData = $response['data'];

                $responseData->creditCardBrand = null;
                $responseData->creditCardNumber = null;
                $responseData->canBePaidAfterDueDate = false;

                $hasPaymentId = empty($response['data']->id) === false;

                if ($hasPaymentId === true) {
                    $paymentId = $response['data']->id;

                    $data['id'] = $paymentId;

                    $this->setUrl("/payments/$paymentId/pixQrCode");
                    $this->send($data, HttpMethodEnum::GET);
        
                    $response = $this->response();

                    if ($response['success'] === true) {
                        $responseData->encodedImage = $response['data']->encodedImage;
                        $responseData->payload = $response['data']->payload;
                        $responseData->billingType = BillingTypeEnum::tryFromName($responseData->billingType)->value;

                        $this->data = new AsaasPaymentResource((object) $responseData);

                        $this->message = 'Aponte a câmera do celular para realizar o pagamento com QRCode.';
                    } else {
                        $this->message = 'Erro inesperado';
                    }
                }
            }

        } catch (\Exception $e) {
            $this->status = HttpStatusEnum::SERVER_ERROR;
            $this->error = (string) $e->getMessage();
            $this->message = 'Estamos com instabilidade no sistema. Tente novamente mais tarde.';
        }

        return $this->response();
    }
}