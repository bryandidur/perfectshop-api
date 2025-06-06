<?php

namespace App\Enums;

enum BillingTypeEnum: string
{
    case CREDIT_CARD = 'CREDIT_CARD';
    case BOLETO = 'BOLETO';
    case PIX = 'PIX';

    public static function toArray(): array
    {
        return [
            self::CREDIT_CARD->value,
            self::BOLETO->value,
            self::PIX->value,
        ];
    }
}
