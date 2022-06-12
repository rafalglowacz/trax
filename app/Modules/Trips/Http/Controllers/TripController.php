<?php

namespace App\Modules\Trips\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Trips\Http\Requests\TripRequest;
use App\Modules\Trips\Resources\TripResource as TripResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response as ResponseFacade;

class TripController extends Controller
{
    public function index(Request $request): ResourceCollection
    {
        return TripResource::collection($request->user()->trips->load('car'));
    }

    public function store(TripRequest $request): Response
    {
        DB::transaction(function () use ($request) {
            $user = $request->user();

            $previousTrip = $user->trips()->where('date', '<=', $request->validated()['date'])->first();

            $data = $request->validated() + [
                    'total' => ($previousTrip->total ?? 0) + $request->validated()['miles'],
                ];

            $newTrip = $user->trips()->create($data);

            $user->trips()->where('date', '>', $newTrip->date)->update([
                // MySQL will automatically overwrite this column with current timestamp if we don't specify it.
                // It can be prevented in MySQL configuration, but I forgot how and couldn't find the solution quickly
                // so this is a workaround.
                'date' => DB::raw('date'),

                'total' => DB::raw('total + ' . intval($newTrip->miles)),
            ]);
        });

        return ResponseFacade::make();
    }
}
