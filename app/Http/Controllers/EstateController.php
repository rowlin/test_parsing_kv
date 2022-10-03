<?php

namespace App\Http\Controllers;

use App\Services\KvParseService;

class EstateController extends Controller
{

    public function upgrade($deal_type){
        return  (new KvParseService())->run(constant("App\Enums\DealTypeEnum::{$deal_type}"));

    }
}
