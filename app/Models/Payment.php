<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;
    
    // table name explicit because migration creates `table_payments`
    protected $table = 'table_payments';
    
    protected $fillable = [
        'user_id',
        'amount',
        'currency',
        'method',
        'status',
        'activity',
        'paid_at',
        'remains'
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
