<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paiement extends Model
{
    use HasFactory;
    protected $fillable = ['totol'];

    public function payeur() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function receveur() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
