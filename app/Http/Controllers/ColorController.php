<?php

namespace App\Http\Controllers;

use App\Models\Color;

class ColorController extends Controller
{
    public function store()
    {
        Color::create(request()->all());

        return to_route('filament.create');
    }
}
