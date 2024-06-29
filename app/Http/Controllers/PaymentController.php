<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\PaymentRequest;

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
     * Pagina validar pagamento
     * 
     * @param PaymentRequest $request
     * @return JsonResponse
     */
    public function validatePayment(PaymentRequest $request): JsonResponse
    {
        return response()->json([]);
    }
}
