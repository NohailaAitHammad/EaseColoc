<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'firstName',
        'lastName',
        'email',
        'reputation_score',
        'password',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function colocations() : BelongsToMany
    {
        return $this->belongsToMany(Colocation::class, 'memberships', 'user_id', 'colocation_id')->as('membership')->withPivot('role', 'joined_at', 'left_at')->withTimestamps()->using(Membership::class);
    }
    public function depenses_a_paye() : BelongsToMany
    {
       return $this->belongsToMany(Depense::class, 'depense_user', 'User_id', 'depense_id')
       ->withTimestamps()
           ->withPivot('montant_du', 'montant_paye')
           ->using(depense_user::class);

    }

    public function invitations() : HasMany
    {
        return $this->hasMany(Invitation::class);
    }

    public function paiements() : HasMany
    {
        return $this->hasMany(Paiement::class);
    }

    public function role() : BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function depenses() : HasMany
    {
        return $this->hasMany(Depense::class);
    }

}
