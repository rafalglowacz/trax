<?php

namespace App\Modules\Trips\Models;

use App\Modules\Cars\Models\Car;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Trip extends Model
{
    protected $casts = ['date' => 'datetime'];

    protected $guarded = [];

    // region relations

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    // endregion relations
}