<?php

namespace App\Services;

use App\Contracts\GatewayService;
use App\Dtos\Checkout\CheckoutDto;
use App\Http\Resources\CheckoutResource;

class CheckoutService
{
    /**
     * Create a new controller instance.
     *
     * @param GatewayService $gatewayService
     */
    public function __construct(private GatewayService $gatewayService)
    {
        $this->gatewayService = $gatewayService;
    }

    /**
     * Process the checkout.
     *
     * @param CheckoutDto $dto
     * @return array
     */
    public function process(CheckoutDto $dto): array
    {
        return $this->gatewayService->checkout($dto);
    }
}
