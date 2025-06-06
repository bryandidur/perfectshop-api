<?php

namespace App\Contracts;

use App\Dtos\Checkout\CheckoutDto;

interface GatewayService
{
    /**
     * Process the checkout.
     *
     * @param CheckoutDto $dto
     */
    public function checkout(CheckoutDto $dto): array;
}
