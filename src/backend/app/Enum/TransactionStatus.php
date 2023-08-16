<?php

namespace App\Enum;

enum TransactionStatus: string
{
    case Authorized = 'authorized';
    case Decline = 'decline';
    case Refunded = 'refunded';
}
