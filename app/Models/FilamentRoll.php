<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class FilamentRoll extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $with = ['filament', 'usages'];

    public function filament()
    {
        return $this->belongsTo(Filament::class);
    }

    public function usages()
    {
        return $this->hasMany(FilamentUsage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hasBeenUsed()
    {
        return $this->weight < 1000 || $this->usages->isNotEmpty();
    }


    public function userPrinters(): BelongsToMany
    {
        return $this->belongsToMany(UserPrinter::class)->withTimestamps();
    }
}
