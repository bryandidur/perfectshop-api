<?php

namespace App\Services;

use Exception;
use App\Contracts\GatewayService as GatewayServiceContract;
use App\Dtos\Checkout\CheckoutDto;
use App\Enums\BillingTypeEnum;
use Illuminate\Http\Client\{
    ConnectionException,
    PendingRequest,
    RequestException,
};
use Illuminate\Support\Facades\{
    Http,
    Log,
};

class AsaasGatewayService implements GatewayServiceContract
{
    /**
     * The HTTP client for making requests to the Asaas gateway.
     *
     * @var PendingRequest
     */
    private PendingRequest $httpClient;

    /**
     * Create a new service instance.
     */
    public function __construct()
    {
        $this->setHttpClient();
    }

    /**
     * @inheritDoc
     */
    public function checkout(CheckoutDto $dto): array
    {
        $payment = $this->createPayment($dto);

        if ($dto->billingType === BillingTypeEnum::PIX) {
            $payment['pixQrCode'] = $this->getPixQrCode($payment['id']);
        }

        return $payment;
    }

    /**
     * Create a customer in the gateway.
     *
     * @param CheckoutDto $dto
     * @return string
     * @throws RequestException
     */
    private function createCustomer(CheckoutDto $dto): string
    {
        try {
            $customer = $this->httpClient->post('/v3/customers', [
                'name' => $dto->customer->name,
                'cpfCnpj' => $dto->customer->cpf,
            ])->json();

            return $customer['id'];
        } catch (Exception $e) {
            Log::error('Error creating customer in Asaas: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Create a payment in the gateway.
     *
     * @param CheckoutDto $dto
     * @return array
     * @throws RequestException
     */
    private function createPayment(CheckoutDto $dto): array
    {
        try {
            $payment = $this->httpClient->post('/v3/lean/payments', $this->makePaymentPayload($dto))->json();

            return $payment;
        } catch (Exception $e) {
            Log::error('Error creating payment in Asaas: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get the QR code for a Pix payment.
     *
     * @param string $paymentId
     * @return string
     * @throws RequestException
     */
    private function getPixQrCode(string $paymentId): string
    {
        try {
            $qrCode = $this->httpClient->get("/v3/payments/{$paymentId}/pixQrCode")->json();

            return $qrCode['encodedImage'];
        } catch (Exception $e) {
            Log::error('Error getting pix qrcode in Asaas: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Create the payment payload data.
     *
     * @param CheckoutDto $dto
     * @return array
     */
    private function makePaymentPayload(CheckoutDto $dto): array
    {
        $data = [
            'customer' => $this->createCustomer($dto),
            'billingType' => $dto->billingType->value,
            'value' => $dto->value,
            'dueDate' => now()->addDays(3)->format('Y-m-d'),
        ];

        if ($dto->billingType === BillingTypeEnum::CREDIT_CARD) {
            $data += [
                'creditCard' => [
                    'holderName' => $dto->creditCard->holderName,
                    'number' => $dto->creditCard->number,
                    'expiryMonth' => $dto->creditCard->expiryMonth,
                    'expiryYear' => $dto->creditCard->expiryYear,
                    'ccv' => $dto->creditCard->ccv,
                ],
                'creditCardHolderInfo' => [
                    'name' => $dto->customer->name,
                    'email' => $dto->customer->email,
                    'cpfCnpj' => $dto->customer->cpf,
                    'postalCode' => $dto->customer->postalCode,
                    'addressNumber' => $dto->customer->addressNumber,
                    'phone' => $dto->customer->phone,
                ],
            ];
        }

        return $data;
    }

    /**
     * Make the HTTP client for the Asaas gateway.
     *
     * @return void
     */
    private function setHttpClient(): void
    {
        $this->httpClient = Http::withOptions([
            'verify' => false,
            'base_uri' => config('gateways.asaas.base_url'),
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'User-Agent' => 'PerfectShop',
                'access_token' => config('gateways.asaas.api_key'),
            ],
        ])->retry(2, 100, function ($exception) {
            return $exception instanceof ConnectionException;
        })->throw();
    }
}
