<?php

namespace App\Modules\Cars\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\Car as CarResource;
use App\Modules\Cars\Http\Requests\CarRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Response as ResponseFacade;

class CarController extends Controller
{
    public function index(Request $request): ResourceCollection
    {
        return CarResource::collection($request->user()->cars);
    }

    public function store(CarRequest $request): Response
    {
        $request->user()->cars()->create($request->validated());

        return ResponseFacade::make();
    }

    public function show(int $id, Request $request): JsonResource
    {
        return new CarResource($request->user()->cars()->where('id', $id)->firstOrFail());
    }
}
