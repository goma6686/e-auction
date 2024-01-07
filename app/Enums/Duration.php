<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum Duration: int
{
    use EnumToArray;
    
    case THREE_DAYS = 3;
    case FIVE_DAYS = 5;
    case EIGHT_DAYS = 8;
    case TEN_DAYS = 10;
    case FOURTEEN_DAYS = 14;
}