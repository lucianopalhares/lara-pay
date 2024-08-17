<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class AsaasPaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'customer' => $this->customer,
            'paymentId' => $this->id,
            'creditCardBrand' => $this->creditCardBrand,
            'creditCardNumber' => $this->creditCardNumber,
            'invoiceNumber' => $this->invoiceNumber,
            'invoiceUrl' => $this->invoiceUrl,
            'externalReference' => $this->externalReference,
            'status' => $this->status,
            'billingType' => $this->billingType,            
            'value' => $this->value,
            'dueDate' => Carbon::createFromFormat('Y-m-d', $this->dueDate)->format('d/m/Y'),
            'canBePaidAfterDueDate' => $this->canBePaidAfterDueDate,
            'description' => $this->description,
            'encodedImage' => $this->encodedImage,
            'payload' => $this->payload
        ];
    }
}
