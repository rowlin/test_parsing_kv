<?php

namespace App\Helper;

use App\Enums\DealTypeEnum;

class Helper
{
    public static function getDealTypes() : string{
        return json_encode(DealTypeEnum::toArray());
    }

}
