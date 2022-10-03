<?php

namespace App\Http\Controllers;

use App\Http\Requests\EstateRequest;
use App\Services\EstateService;
use Illuminate\Http\Request;

class IndexController extends Controller
{

    public function __construct(private EstateService $estateService){}

    public function index(Request $request)
    {
        return view('index' );
    }

    public function getAll(EstateRequest $request){
        return $this->estateService->getAll($request);
    }


}
