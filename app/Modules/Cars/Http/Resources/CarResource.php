<?php

namespace App\Modules\Cars\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class CarResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return Arr::only($this->resource->attributesToArray(), ['id', 'make', 'model', 'year']);
    }
}
