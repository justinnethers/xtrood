<?php

namespace App\Http\Controllers;

use App\Models\Filament;
use App\Models\FilamentRoll;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FilamentController extends Controller
{
    public function index()
    {
        return inertia('Filament/Index', [
            'filamentRolls' => auth()->user()->filamentRolls()
                ->with(['usages' => function ($query) {
                    $query->latest();
                }])
                ->get()
                ->sortByDesc(function ($filamentRoll) {
                    return $filamentRoll->usages->first()->created_at ?? Carbon::createFromTimestamp(0);
                })
                ->values(),
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
            'price' => 'numeric',
            'number_of_rolls' => 'integer'
        ]);

        $filament = Filament::firstOrCreate([
            'brand_id' => $request->brand_id,
            'filament_type_id' => $request->filament_type_id,
            'color_id' => $request->color_id,
        ]);

        collect(range(1, $request->number_of_rolls))->each(function () use ($request, $filament) {
            auth()->user()->filamentRolls()->create([
                'filament_id' => $filament->id,
                'weight' => $request->weight,
                'diameter' => $request->diameter,
                'price' => $request->price,
            ]);
        });

        return to_route('filament.index');
    }
}
