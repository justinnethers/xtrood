<?php

namespace App\Http\Controllers;

use App\Models\FilamentType;
use Illuminate\Http\Request;

class FilamentTypeController extends Controller
{
    public function store(Request $request)
    {
        FilamentType::create(request()->all());

        return to_route('filament.create');
    }
}
