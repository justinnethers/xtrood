<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserPrinter extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'purchase_date' => 'date',
        'purchase_price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function printer()
    {
        return $this->belongsTo(Printer::class);
    }

    public function filamentRolls(): BelongsToMany
    {
        return $this->belongsToMany(FilamentRoll::class)->withTimestamps();
    }

    public function filamentUsages()
    {
        return $this->hasMany(FilamentUsage::class);
    }
}
