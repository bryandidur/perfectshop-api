<?php

namespace App\Http\Controllers;

use App\Http\Requests\Checkout\CheckoutRequest;
use App\Http\Resources\CheckoutResource;
use App\Services\CheckoutService;

class CheckoutController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param CheckoutService $checkoutService
     */
    public function __construct(private CheckoutService $checkoutService)
    {
        $this->checkoutService = $checkoutService;
    }

    /**
     * Handle the incoming request to process the checkout.
     *
     * @param CheckoutRequest $request
     * @return CheckoutResource
     */
    public function process(CheckoutRequest $request): CheckoutResource
    {
        return new CheckoutResource($this->checkoutService->process($request->toDto()));
    }
}
