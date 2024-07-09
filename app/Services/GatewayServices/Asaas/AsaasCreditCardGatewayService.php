<?php 

namespace App\Services\GatewayServices\Asaas;

use App\Contracts\PaymentGatewayInterface;
use App\Services\GatewayServices\Asaas\AsaasHttpGatewayService;
use App\Enums\HttpMethodEnum;
use App\Enums\HttpStatusEnum;
use App\Enums\BillingTypeEnum;
use Carbon\Carbon;

class AsaasCreditCardGatewayService extends AsaasHttpGatewayService implements PaymentGatewayInterface
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

            $data['billingType'] = BillingTypeEnum::UNDEFINED->value;

            $this->setUrl('/payments');
            $this->send($data, HttpMethodEnum::POST);

            $response = $this->response();

            $paymentCreated = $response['success'] === true;

            if ($paymentCreated === true) {
                $hasPaymentId = empty($response['data']['id']) === false;

                if ($hasPaymentId === true) {
                    $paymentId = $response['data']['id'];

                    $data['id'] = $paymentId;

                    $data['billingType'] = BillingTypeEnum::CREDIT_CARD->value;

                    $data['creditCard'] = array(
                        'holderName' => $data['holderName'],
                        'number' => $data['number'],
                        'expiryMonth' => $data['expiryMonth'],
                        'expiryYear' => $data['expiryYear'],
                        'ccv' => $data['ccv']
                    );

                    $data['creditCardHolderInfo'] = array(
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'cpfCnpj' => $data['cpfCnpj'],
                        'postalCode' => $data['postalCode'],
                        'addressNumber' => $data['addressNumber'],
                        'addressComplement' => $data['addressComplement'],
                        'phone' => $data['phone']
                    );

                    $this->setUrl("/payments/$paymentId/payWithCreditCard");
                    $this->send($data, HttpMethodEnum::POST);
        
                    $response = $this->response();

                    if ($response['success'] === true) {
                        if ($response['data']['status'] == 'CONFIRMED') {
                            $this->message = 'Pagamento com cartão efetuado com sucesso';
                        } else {
                            $this->message = 'Pagamento processado. Aguarde enquanto a operadora do cartão valida o pagamento.';
                        }
                    } else {
                        $this->message = 'Erro inesperado';
                    }
                }
            }

        } catch (\Exception $e) {
            $this->status = HttpStatusEnum::SERVER_ERROR;
            $this->data = (string) $e->getMessage();
            $this->message = 'Estamos com instabilidade no sistema. Tente novamente mais tarde.';
        }

        return $this->response();
    }
}