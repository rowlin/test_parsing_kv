<?php

namespace App\Models;

use App\Enums\DealTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estate extends Model
{
    use HasFactory;

    protected $fillable = [
                         'title',
                         'address',
                         'type',
                         'url',
                         'image',
                         'float',
                         'float_total',
                         'total_area',
                         'description',
                         'description_full',
                         'year',
                         'price',
                         'price_per_m',
                         'published',
                    ];


}

