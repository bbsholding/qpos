<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashRegister extends Model
{
    use HasFactory;

    protected $table = 'cash_registers';

    protected $fillable = [
        'user_id',
        'opening_amount',
        'closing_amount',
        'status',
        'opened_at',
        'closed_at',
    ];

    protected $dates = [
        'opened_at',
        'closed_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
