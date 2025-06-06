<?php

namespace App\Dtos\Checkout;

use App\Enums\BillingTypeEnum;
use App\Dtos\BaseDto;

class CheckoutDto extends BaseDto
{
    public CustomerDto $customer;
    public BillingTypeEnum $billingType;
    public float $value;
    public ?CreditCardDto $creditCard = null;
}
