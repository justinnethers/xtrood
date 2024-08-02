<?php

namespace App\Http\Controllers;

use App\Models\Filament;
use App\Models\FilamentRoll;
use Illuminate\Http\Request;

class FilamentColorController extends Controller
{
    public function show(Request $request)
    {
        $colorId = $request->query('color');
        $brandId = $request->query('brand');
        $filamentTypeId = $request->query('filament_type');

        $filament = Filament::where([
            'color_id' => $colorId,
            'brand_id' => $brandId,
            'filament_type_id' => $filamentTypeId,
        ])->firstOrFail();

        $filamentRolls = FilamentRoll::where('filament_id', $filament->id)->with('usages')->get();

        $filamentRolls = $filamentRolls->filter(function ($filamentRoll) {
            return !$filamentRoll->hasBeenUsed();
        });

        return inertia('Filament/ShowColor', [
            'brand' => \App\Models\Brand::find($brandId),
            'color' => \App\Models\Color::find($colorId),
            'filamentType' => \App\Models\FilamentType::find($filamentTypeId),
            'filamentRolls' => $filamentRolls
        ]);
    }
}
