<?php

namespace App\Dtos\Checkout;

use App\Dtos\BaseDto;

class CustomerDto extends BaseDto
{
    public string $name;
    public string $email;
    public string $cpf;
    public string $phone;
    public string $postalCode;
    public string $addressNumber;
}
