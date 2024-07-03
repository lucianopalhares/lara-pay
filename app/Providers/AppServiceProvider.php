<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\PaymentGatewayInterface;
use App\Enums\BillingTypeEnum;
use App\Services\GatewayServices\Asaas\AsaasBoletoGatewayService;
use App\Services\GatewayServices\Asaas\AsaasCreditCardGatewayService;
use App\Services\GatewayServices\Asaas\AsaasPixGatewayService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PaymentGatewayInterface::class, function($app, $params) {
            $gateway = empty($params['gateway']) === false ? $params['gateway'] : false;
            $billingType = empty($params['billingType']) === false ? $params['billingType'] : false;

            if ($gateway === false || $billingType === false) {
                throw new \Exception('Erro para chamar o metodo');
            }

            $classes = [
                'ASAAS' => [
                    BillingTypeEnum::BOLETO->value => AsaasBoletoGatewayService::class,
                    BillingTypeEnum::CREDIT_CARD->value => AsaasCreditCardGatewayService::class,
                    BillingTypeEnum::PIX->value => AsaasPixGatewayService::class,
                ]
            ];

            return new $classes[$gateway][$billingType]();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
