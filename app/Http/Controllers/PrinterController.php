<?php

namespace App\Http\Controllers;

use App\Models\Printer;
use Illuminate\Http\Request;

class PrinterController extends Controller
{
    public function index()
    {
        $printers = Printer::all();
        return inertia('Printers/Index', ['printers' => $printers]);
    }

    public function create()
    {
        return inertia('Printers/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand_id' => 'required|string|max:255',
            'bed_size_x' => 'required|numeric',
            'bed_size_y' => 'required|numeric',
            'bed_size_z' => 'required|numeric',
        ]);

        $printer = Printer::create($validated);

        return to_route('user-printers.create', [
            'brand_id' => $validated['brand_id'],
            'printer_id' => $printer->id
        ]);

//        return redirect()->route('printers.index')->with('success', 'Printer added successfully.');
    }

    public function edit(Printer $printer)
    {
        return inertia('Printers/Edit', ['printer' => $printer]);
    }

    public function update(Request $request, Printer $printer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'bed_size_x' => 'required|numeric',
            'bed_size_y' => 'required|numeric',
            'bed_size_z' => 'required|numeric',
        ]);

        $printer->update($validated);

        return redirect()->route('printers.index')->with('success', 'Printer updated successfully.');
    }

    public function destroy(Printer $printer)
    {
        $printer->delete();
        return redirect()->route('printers.index')->with('success', 'Printer deleted successfully.');
    }
}
