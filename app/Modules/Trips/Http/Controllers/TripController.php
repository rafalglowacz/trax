<?php

namespace App\Modules\Trips\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Trips\Http\Requests\TripRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Response as ResponseFacade;

class TripController extends Controller
{
    public function store(TripRequest $request): Response
    {
        $request->user()->trips()->create($request->validated());

        return ResponseFacade::make();
    }
}
