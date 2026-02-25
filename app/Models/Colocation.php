<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Colocation extends Model
{
    use HasFactory;
    protected $fillable =['nom', 'max_membre'];

    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class, 'memberships', 'colocation_id', 'user_id')->as('membership')->withPivot('role', 'joined_at', 'left_at')->withTimestamps()->using(Membership::class);
    }

    public function owner()
    {
        return $this->users()
            ->wherePivot('role', 'owner');
    }
    public function depenses() : HasMany
    {
        return $this->hasMany(Depense::class);
    }
}
