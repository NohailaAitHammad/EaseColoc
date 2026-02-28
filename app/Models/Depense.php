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
    protected $fillable = ['montant', 'title', 'categorie_id', 'colocation_id', 'payeur_id'];

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

    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class, 'depense_user',  'depense_id','user_id')
            ->withTimestamps()
            ->withPivot('montant_du', 'montant_paye', 'status')
            ->using(depense_user::class);

    }

    public function calculDpenses(){

            $memebres = $this->colocation->users;
            foreach ($memebres as $memebre) {
                if ($memebre->id !== $this->payeur->id) {
                    if($this->wasRecentlyCreated) {
                        $this->users()->attach($memebre->id, [
                            'montant_du' => $this->montant / $memebres->count(),
                            'montant_paye' => 0,
                            'status' => 'pending',
                        ]);
                    } else if(!$this->users()->wherePivot('status', '=', 'pending')) {
                        $this->users()->updateExistingPivot($memebre->id, [
                            'montant_du' => $this->montant / $memebres->count(),
                        ]);
                        }else{
                        abort(403, 'Depense en cours de paiement ');
                    }
//                $depense_user = new depense_user();
//                $depense_user->user_id = $memebre->user_id;
//                $depense_user->status = 'pending';
//                $depense_user->depense_id = $this->id;
//                $depense_user->save();
//                $d = $depense_user;
                }
            }

    }
}
