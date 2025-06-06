<?php

namespace App\Dtos\Checkout;

use App\Dtos\BaseDto;

class CreditCardDto extends BaseDto
{
    public string $holderName;
    public string $number;
    public string $expiryMonth;
    public string $expiryYear;
    public string $ccv;
}
