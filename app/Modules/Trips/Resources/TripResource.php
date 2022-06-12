<?php

namespace App\Modules\Trips\Resources;

use App\Modules\Cars\Http\Resources\CarResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class TripResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return Arr::only(
                $this->resource->attributesToArray(),
                ['id', 'date', 'miles', 'total', 'year']
            ) + [
                'car' => new CarResource($this->whenLoaded('car')),
            ];
    }
}
