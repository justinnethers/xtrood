<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function store()
    {
        $brand = Brand::create(request()->all());

        switch(request('type')) {
            case 'printer':
                return to_route('user-printers.create', ['brand_id' => $brand->id]);
            case 'filament':
                return to_route('filament.create');
        }
    }
}
