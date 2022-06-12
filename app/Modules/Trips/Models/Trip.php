<?php

namespace App\Modules\Trips\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Trip extends Model
{
    protected $casts = ['date' => 'datetime'];

    protected $guarded = [];

    // region relations

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // endregion relations
}
