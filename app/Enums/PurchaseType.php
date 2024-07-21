<?php

namespace App\Enums;

enum PurchaseType: string
{
    case RENT = 'rent';
    case BUY = 'buy';
    case BOTH = 'rent,buy';
}
