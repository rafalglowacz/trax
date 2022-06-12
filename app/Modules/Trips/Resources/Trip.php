<?php

namespace App\Modules\Trips\Resources;

use App\Http\Resources\Car;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class Trip extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return Arr::only(
                $this->resource->attributesToArray(),
                ['id', 'date', 'miles', 'year']
            ) + [
                'car' => new Car($this->whenLoaded('car')),
            ];
    }
}
