<?php 

namespace App\Services\GatewayServices\Asaas;

use \GuzzleHttp\Client;
use \GuzzleHttp\Exception\ClientException;
use App\Enums\HttpMethodEnum;
use App\Enums\HttpStatusEnum;

class AsaasHttpGatewayService 
{
    private string $token;
    private string $url = 'https://sandbox.asaas.com/api/v3';
    private string $endpoint = '';
    private $http;

    private string $customer;

    protected int $status;
    protected string $message = '';
    protected string $data = '';

    public function __construct()
    {
        $this->http = new Client();
        $this->token = ENV('TOKEN_ASAAS');
    }

    /**
     * Setar o customer
     * 
     * @param array $data
     * @return void
     */
    protected function setCustomer(array $data): void 
    {
        $this->customer = (string) $data['customer'];

        if (empty($this->customer) === true) {
            
            try {
           
                $this->setUrl('/customers');
                $this->send($data, HttpMethodEnum::POST);

                $response = $this->response();

                if ($response['success'] === true) {
                    $this->customer = (string) $response['data']['id'];

                    $user = \App\Models\User::find($data['userId']);
                    $user->customer = $this->customer;
                    $user->save();
                }
                 //code...
            } catch (\Exception $e) {
                throw new \Exception($response['data']);
            }
        }
    }

    /**
     * Pega customer
     * 
     * @return string
     */
    private function getCustomer(): string 
    {
        return $this->customer;
    }

    /**
     * Setar url
     * 
     * @param string $endpoint
     * @return void
     */
    protected function setUrl(string $endpoint): void 
    {
        $this->endpoint = $endpoint;
    }

    /**
     * Pegar url
     * 
     * @param string $endpoint
     * @return void
     */
    protected function getUrl(): string 
    {
        if (empty($this->endpoint) === true)
            throw new \Exception('Url nao informada');

        return $this->url . $this->endpoint;
    }

    /**
     * Metodo para gerar pagamento
     * 
     * @param Array $data 
     * @param HttpMethodEnum $method
     * @return Array
     */
    public function send(array $data, HttpMethodEnum $method): void 
    {
        try {

            $url = $this->getUrl();
            $this->setUrl('');

            $request = [
                'headers' => [
                    'accept' => 'application/json',
                    'access_token' => $this->token,
                    'content-type' => 'application/json',
                ],
            ];

            $data['customer'] = $this->getCustomer();

            if ($method === HttpMethodEnum::POST) {
                $request['body'] = json_encode($data);
            }

            $client = $this->http;
            $response = $client->request(
                $method->value,
                $url, 
                $request
            );
            
            $this->data = (string) $response->getBody();
            $this->status = (int) $response->getStatusCode();
           
        } catch (ClientException $e) {
            $this->data = (string) $e->getMessage();
            $this->status = (int) $e->getCode();
        }
    }

    protected function response(): array 
    {
        $array = [
            'status' => $this->status,
            'data' => $this->data, 
            'message' => $this->message,
            'success' => $this->status === HttpStatusEnum::SUCCESS->value
        ];

        if ($array['success'] === true) {
            $array['data'] = json_decode($array['data'], true);
        }

        return $array;
    }

    
}