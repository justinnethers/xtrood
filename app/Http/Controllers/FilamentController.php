<?php

namespace App\Http\Controllers;

use App\Models\Filament;
use Illuminate\Http\Request;

class FilamentController extends Controller
{
    public function index()
    {
        return inertia('Filament/Index', [
            'filamentRolls' => auth()->user()->filamentRolls,
        ]);
    }

    public function create()
    {
        return inertia('Filament/Create', [
            'brands' => \App\Models\Brand::all(),
            'filamentTypes' => \App\Models\FilamentType::all(),
            'colors' => \App\Models\Color::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'brand_id' => 'required',
            'filament_type_id' => 'required',
            'color_id' => 'required',
            'weight' => 'required',
            'diameter' => 'required',
        ]);

        $filament = Filament::create([
            'brand_id' => $request->brand_id,
            'filament_type_id' => $request->filament_type_id,
            'color_id' => $request->color_id,
        ]);

        auth()->user()->filamentRolls()->create([
            'filament_id' => $filament->id,
            'weight' => $request->weight,
            'diameter' => $request->diameter,
        ]);

        return to_route('filament.index');
    }
}
