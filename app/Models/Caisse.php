<?php

// app/Models/Caisse.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caisse extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'lieu',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function sessions()
    {
        return $this->hasMany(SessionCaisse::class);
    }

    public function currentSession()
    {
        return $this->hasOne(SessionCaisse::class)->where('status', 'ouvert');
    }
}
