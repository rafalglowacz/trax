<?php

namespace App\Modules\Trips\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TripRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'date' => ['required', 'date'], // ISO 8601 string
            'car_id' => ['required', 'integer', Rule::exists('cars', 'id')->where('user_id', $this->user()->id)],
            'miles' => ['required', 'numeric'],
        ];
    }
}
