<?php

namespace App\Modules\Cars\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\Car;
use App\Modules\Cars\Http\Requests\CarRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Response as ResponseFacade;

class CarController extends Controller
{
    public function index(Request $request): ResourceCollection
    {
        return Car::collection($request->user()->cars);
    }

    public function store(CarRequest $request): Response
    {
        $request->user()->cars()->create($request->validated());

        return ResponseFacade::make();
    }
}
