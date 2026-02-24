<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Depense extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['montant', 'titre', 'categorie_id'];

    public function categorie() : BelongsTo
    {
        return $this->belongsTo(Categorie::class);
    }

    public function payeur() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function colocation() : BelongsTo
    {
        return $this->belongsTo(Colocation::class);
    }
}
