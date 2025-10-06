<?php

// app/Models/SessionCaisse.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SessionCaisse extends Model
{
    use HasFactory;

    protected $fillable = [
        'caisse_id',
        'user_id',
        'solde_ouverture',
        'solde_fermeture',
        'solde_attendu',
        'difference',
        'ouverture_at',
        'fermeture_at',
        'status',
        'notes'
    ];

    protected $casts = [
        'solde_ouverture' => 'decimal:2',
        'solde_fermeture' => 'decimal:2',
        'solde_attendu' => 'decimal:2',
        'difference' => 'decimal:2',
        'ouverture_at' => 'datetime',
        'fermeture_at' => 'datetime',
    ];

    public function caisse()
    {
        return $this->belongsTo(Caisse::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function movements()
    {
        return $this->hasMany(MouvementCaisse::class);
    }

    public function sales()
    {
        return $this->hasMany(Order::class);
    }

    public function calculateSoldeAttendu()
    {
        $totalIn = $this->movements()->where('type', 'entree')->sum('montant');
        $totalOut = $this->movements()->where('type', 'sortie')->sum('montant');
        $salesCash = $this->sales()->where('methode_paiement', 'cash')->sum('total');
        $salesMobileMoney = $this->sales()->where('methode_paiement', 'mobile_money')->sum('total');

        return $this->solde_ouverture + $totalIn - $totalOut + $salesCash + $salesMobileMoney;
    }

    public function getTotalSalesAttribute()
    {
        return $this->sales()->sum('total');
    }

    public function getTotalCashSalesAttribute()
    {
        return $this->sales()->where('methode_paiement', 'cash')->sum('total');
    }

    public function getTotalMobileMoneySalesAttribute()
    {
        return $this->sales()->where('methode_paiement', 'mobile_money')->sum('total');
    }
}

