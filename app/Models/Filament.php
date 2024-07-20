<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Filament extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $with = ['filamentType', 'color', 'brand'];

    public function filamentType()
    {
        return $this->belongsTo(FilamentType::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function filamentRolls()
    {
        return $this->hasMany(FilamentRoll::class);
    }
}
