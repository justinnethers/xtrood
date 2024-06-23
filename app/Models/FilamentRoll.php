<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilamentRoll extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $with = ['filament'];

    public function filament()
    {
        return $this->belongsTo(Filament::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
