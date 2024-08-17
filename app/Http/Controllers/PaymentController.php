<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\PaymentRequest;
use App\Http\Requests\PaymentCreditCardRequest;
use App\Enums\BillingTypeEnum;
use App\Contracts\PaymentGatewayInterface;

class PaymentController extends Controller
{
    public $gateway = 'ASAAS';
    /**
     * Pagina do boleto
     * 
     * @return Response
     */
    public function createBoleto(): Response
    {
        return Inertia::render('Payment/createBoleto',
            [   
                'billingType' => BillingTypeEnum::BOLETO->name,
                'gateway' => $this->gateway
            ]
        );
    }

    /**
     * Pagina do Pix
     * 
     * @return Response
     */
    public function createPix(): Response
    {
        return Inertia::render('Payment/createPix',
            [   
                'billingType' => BillingTypeEnum::PIX->name,
                'gateway' => $this->gateway
            ]
        );
    }
    
    /**
     * Pagina do cartão
     * 
     * @return Response
     */
    public function createCreditCard(): Response
    {
        return Inertia::render('Payment/createCreditCard',
            [
                'billingType' => BillingTypeEnum::CREDIT_CARD->name,
                'gateway' => $this->gateway
            ]
        );
    }

    /**
     * Pagina validar pagamento
     * 
     * @param PaymentRequest $request
     * @return JsonResponse
     */
    public function validatePayment(PaymentRequest $request): JsonResponse
    {
        return response()->json([]);
    }

    /**
     * Pagina validar pagamento com cartão
     * 
     * @param PaymentCreditCardRequest $request
     * @return JsonResponse
     */
    public function validatePaymentCreditCard(PaymentCreditCardRequest $request): JsonResponse
    {
        return response()->json(['data'=>'validado com sucesso!']);
    }

    /**
     * Metodo para gerar pagamento
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function process(Request $request): JsonResponse
    {
        $gateway = app()->make(PaymentGatewayInterface::class,
            $request->all()
        );

        $processGateway = $gateway->process($request->all());

        return response()->json($processGateway, $processGateway['status']);
    }

}
