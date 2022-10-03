<?php

namespace App\Enums;

enum DealTypeEnum : int{
    case SALE = 1;
    case RENT = 2 ;
    case SHORT_RENT = 30;
    case ALL = 40;

    public static function toArray(): array{
        $data = [];
        $i = 0;
        foreach(self::cases() as $case) {
            $data[$i]['id'] = $case->value;
            $data[$i++]['name'] = $case->name;
        }
        return $data;
    }

    public static function toArrayNames(): array{
        $data = [];
        foreach(self::cases() as $case) {
            $data[] = $case->name;
        }
        return $data;
    }


}
