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

    public static function rules($id = null)
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', Rule::enum(BrandType::class)],
            // This ensures the combination of name and type is unique
            'name' => [
                'required',
                Rule::unique('brands')->where(function ($query) use ($id) {
                    return $query->where('type', request('type'));
                })->ignore($id)
            ],
        ];
    }

    public function filaments()
    {
        return $this->hasMany(Filament::class);
    }
}
