<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\UserPrinter;
use App\Models\Printer;
use Illuminate\Http\Request;

class UserPrinterController extends Controller
{
    public function index()
    {
        $userPrinters = auth()->user()
            ->userPrinters()
            ->with('printer.brand', 'filamentRolls')
            ->get();

        return inertia('UserPrinters/Index', ['userPrinters' => $userPrinters]);
    }

    public function create()
    {
        return inertia('UserPrinters/Create', [
            'printers' => Printer::all(),
            'brands' => Brand::where('type', 'printer')->orderBy('name')->get()->pluck('name', 'id'),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'printer_id' => 'required|exists:printers,id',
            'nickname' => 'nullable|string|max:255',
            'purchase_date' => 'nullable|date',
            'purchase_price' => 'nullable|numeric',
        ]);

        $userPrinter = auth()->user()->userPrinters()->create($validated);

        return to_route('user-printers.show', $userPrinter)->with('success', 'Printer added to your collection.');
    }

    public function show(UserPrinter $userPrinter)
    {
        $userPrinter->load('printer', 'filamentRolls');
        return inertia('UserPrinters/Show', ['userPrinter' => $userPrinter]);
    }

    public function edit(UserPrinter $userPrinter)
    {
        $printers = Printer::all();
        return inertia('UserPrinters/Edit', ['userPrinter' => $userPrinter, 'printers' => $printers]);
    }

    public function update(Request $request, UserPrinter $userPrinter)
    {
        $validated = $request->validate([
            'printer_id' => 'required|exists:printers,id',
            'nickname' => 'nullable|string|max:255',
            'purchase_date' => 'nullable|date',
            'purchase_price' => 'nullable|numeric',
        ]);

        $userPrinter->update($validated);

        return redirect()->route('user-printers.show', $userPrinter)->with('success', 'Printer information updated successfully.');
    }

    public function destroy(UserPrinter $userPrinter)
    {
        $userPrinter->delete();
        return redirect()->route('user-printers.index')->with('success', 'Printer removed from your collection.');
    }

    public function assignFilament(Request $request, UserPrinter $userPrinter)
    {
        $validated = $request->validate([
            'filament_roll_id' => 'required|exists:filament_rolls,id',
        ]);

        $filamentRoll = \App\Models\FilamentRoll::findOrFail($validated['filament_roll_id']);
        $filamentRoll->update(['user_printer_id' => $userPrinter->id]);

        return back()->with('success', 'Filament assigned successfully.');
    }
}
