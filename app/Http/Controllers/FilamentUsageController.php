<?php

namespace App\Http\Controllers;

use App\Models\FilamentUsage;
use Illuminate\Http\Request;

class FilamentUsageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'filament_roll_id' => 'required',
            'weight' => 'required',
        ]);

        $filament = FilamentUsage::create($request->all());

//        dump($filament);

        return to_route('filament.index');
    }
}
