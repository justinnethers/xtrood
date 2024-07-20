<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilamentUsage extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function filamentRoll()
    {
        return $this->belongsTo(FilamentRoll::class);
    }
}
