<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class depense_user extends Pivot
{
    public function depense() : BelongsTo
    {
        return $this->belongsTo(Depense::class, 'depense_id');
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
