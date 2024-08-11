<?php

namespace App\Models;

use App\Enums\BrandType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'type' => BrandType::class,
    ];

    public function filaments()
    {
        return $this->hasMany(Filament::class);
    }
}
