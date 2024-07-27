<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrintedItemController extends Controller
{
    public function index()
    {
        return inertia('Prints/Index', [
            'printedItems' => auth()->user()->printedItems()->get(),
        ]);
    }

    public function create()
    {
        return inertia('Prints/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'required',
        ]);

        auth()->user()->printedItems()->create($request->all());

        return redirect()->route('print.index');
    }

    public function show(PrintedItem $printedItem)
    {
        return inertia('Print/Show', [
            'printedItem' => $printedItem,
        ]);
    }
}
