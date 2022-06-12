<?php

namespace App\Modules\Cars\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int id
 * @property int $user_id
 * @property User $user
 */
class Car extends Model
{
    protected $guarded = [];

    // region relations

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // endregion relations
}
