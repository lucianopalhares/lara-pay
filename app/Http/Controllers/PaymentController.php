<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\PaymentRequest;
use App\Http\Requests\PaymentCreditCardRequest;

class PaymentController extends Controller
{
    /**
     * Pagina do boleto
     * 
     * @return Response
     */
    public function createBoleto(): Response
    {
        return Inertia::render('Payment/createBoleto');
    }

    /**
     * Pagina do Pix
     * 
     * @return Response
     */
    public function createPix(): Response
    {
        return Inertia::render('Payment/createPix');
    }
    
    /**
     * Pagina do cartão
     * 
     * @return Response
     */
    public function createCreditCard(): Response
    {
        return Inertia::render('Payment/createCreditCard');
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

}
