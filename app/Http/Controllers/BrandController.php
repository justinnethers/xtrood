<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function store()
    {
        Brand::create(request()->all());

        return to_route('filament.create');
    }
}
