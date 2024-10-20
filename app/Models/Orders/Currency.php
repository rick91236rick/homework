<?php

namespace App\Models\Orders;

enum Currency: string
{
    case TWD = 'TWD';

    case USD = 'USD';

    case JPY = 'JPY';

    case RMB = 'RMB';

    case MYR = 'MYR';
}
