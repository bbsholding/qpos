<?php



// app/Models/MouvementCaisse.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MouvementCaisse extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_caisse_id',
        'user_id',
        'type',
        'montant',
        'montant_a_paye_mobile_money',
        'montant_recu',
        'monnaie_rendue',
        'methode_paiement',
        'reference',
        'description'
    ];

    protected $casts = [
        'montant' => 'decimal:2',
        'montant_a_paye_mobile_money' => 'decimal:2',
        'montant_recu' => 'decimal:2',
        'monnaie_rendue' => 'decimal:2',
    ];

    public function session()
    {
        return $this->belongsTo(SessionCaisse::class, 'session_caisse_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
