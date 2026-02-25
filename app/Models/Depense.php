<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Depense extends Model
{
    use HasFactory;
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

    public function depenses_a_paye() : BelongsToMany
    {
        return $this->belongsToMany(User::class, 'depense_user',  'depense_id','User_id')
            ->withTimestamps()
            ->withPivot('montant_du', 'montant_paye')
            ->using(depense_user::class);

    }
}
