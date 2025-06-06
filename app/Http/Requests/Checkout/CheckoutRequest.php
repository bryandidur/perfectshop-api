<?php

namespace App\Http\Requests\Checkout;

use App\Dtos\Checkout\{
    CheckoutDto,
    CreditCardDto,
    CustomerDto,
};
use App\Enums\BillingTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CheckoutRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $creditCardRequired = Rule::requiredIf(fn () => $this->billingType === BillingTypeEnum::CREDIT_CARD->value);

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email'],
            'cpf' => ['required', 'string', 'digits:11'],
            'phone' => ['required', 'string', 'regex:/^\d{10,11}$/'],
            'postalCode' => ['required', 'string', 'digits:8'],
            'addressNumber' => ['required', 'numeric'],
            'billingType' => ['required', 'string', Rule::in(BillingTypeEnum::toArray())],
            'value' => ['required', 'numeric', 'min:0.01'],
            'creditCard' => [
                $creditCardRequired,
                'array:holderName,number,expiryMonth,expiryYear,ccv'
            ],
            'creditCard.holderName' => [$creditCardRequired, 'string', 'max:255'],
            'creditCard.number' => [$creditCardRequired, 'string', 'regex:/^\d{16}$/'],
            'creditCard.expiryMonth' => [$creditCardRequired, 'string', 'digits:2'],
            'creditCard.expiryYear' => [$creditCardRequired, 'string', 'digits:4'],
            'creditCard.ccv' => [$creditCardRequired, 'string', 'regex:/^\d{3,4}$/'],
        ];
    }

    /**
     * Create a DTO from the request data.
     *
     * @return CheckoutDto
     */
    public function toDto(): CheckoutDto
    {
        return new CheckoutDto([
            'customer' => new CustomerDto([
                'name' => $this->input('name'),
                'email' => $this->input('email'),
                'cpf' => $this->input('cpf'),
                'phone' => $this->input('phone'),
                'postalCode' => $this->input('postalCode'),
                'addressNumber' => $this->input('addressNumber'),
            ]),
            'billingType' => BillingTypeEnum::from($this->input('billingType')),
            'value' => (float) $this->input('value'),
            'creditCard' => $this->has('creditCard') ? new CreditCardDto($this->input('creditCard')) : null,
        ]);
    }
}
