<?php

namespace App\Modules\Trips\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Trips\Http\Requests\TripRequest;
use App\Modules\Trips\Resources\Trip as TripResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Response as ResponseFacade;

class TripController extends Controller
{
    public function index(Request $request): ResourceCollection
    {
        return TripResource::collection($request->user()->trips->load('car'));
    }

    public function store(TripRequest $request): Response
    {
        $request->user()->trips()->create($request->validated());

        return ResponseFacade::make();
    }
}
