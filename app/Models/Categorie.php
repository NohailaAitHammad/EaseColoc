<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categorie extends Model
{
    use HasFactory;
    protected $fillable = ['nom', 'user_id'];

    public function depenses() : HasMany
    {
        return $this->hasMany(Depense::class);
    }
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);

    }
}
