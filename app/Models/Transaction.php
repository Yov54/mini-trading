<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    // fillable column
    protected $fillable = [
        'user_id',
        'asset_symbol',
        'type',
        'volume',
        'price',
        'total_cost',
    ];

    /**
     * Relationship: One Transaction belongs to one User(BelongsTo)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
