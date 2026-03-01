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
    protected $fillable =['nom', 'max_membres'];

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

    public function categories() : HasMany
    {
        return $this->hasMany(Categorie::class);
    }
    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }

    public function recalculerDepenses()
    {
        $members = $this->users; // members ba9yin
        $count = $members->count();

        if ($count == 0) {
            return;
        }

        foreach ($this->depenses as $depense) {

            $newPart = $depense->montant / $count;

            foreach ($members as $member) {

                $pivot = $depense->users()
                    ->where('user_id', $member->id)
                    ->first();

                if ($pivot) {

                    $depense->users()->updateExistingPivot(
                        $member->id,
                        ['montant_du' => $newPart]
                    );

                } else {

                    // ila kan chi membre jdod w ma kaynach pivot
                    $depense->users()->attach($member->id, [
                        'montant_du' => $newPart,
                        'status' => 'pending'
                    ]);
                }
            }
        }
    }


}
