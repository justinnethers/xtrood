<?php

namespace App\Http\Controllers;

use App\Models\Filament;
use App\Models\FilamentRoll;
use Illuminate\Http\Request;

class FilamentController extends Controller
{
    public function index()
    {
        return inertia('Filament/Index', [
            'filamentRolls' => auth()->user()->filamentRolls()->get(),
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

    public function show(FilamentRoll $filamentRoll)
    {
        return inertia('Filament/Show', [
            'filamentRoll' => $filamentRoll,
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
            'price' => 'numeric'
        ]);

        $filament = Filament::firstOrCreate([
            'brand_id' => $request->brand_id,
            'filament_type_id' => $request->filament_type_id,
            'color_id' => $request->color_id,
        ]);

        auth()->user()->filamentRolls()->create([
            'filament_id' => $filament->id,
            'weight' => $request->weight,
            'diameter' => $request->diameter,
            'price' => $request->price,
        ]);

        return to_route('filament.index');
    }
}
