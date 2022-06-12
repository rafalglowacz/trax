<?php

namespace App\Modules\Cars\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Cars\Http\Requests\CarRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Response as ResponseFacade;

class CarController extends Controller
{
    public function store(CarRequest $request): Response
    {
        $request->user()->cars()->create($request->validated());

        return ResponseFacade::make();
    }
}
