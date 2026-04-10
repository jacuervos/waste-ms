<?php

namespace App\Http\Controllers;

use App\Models\TypeWaste;
use Illuminate\Http\Request;

class TypeWasteController extends Controller
{
    public function index()
    {
        return response()->json(TypeWaste::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'   => 'required|string|max:100|unique:type_wastes,name',
            'points' => 'sometimes|integer|min:0',
        ]);

        $typeWaste = TypeWaste::create($validated);

        return response()->json($typeWaste, 201);
    }

    public function show(TypeWaste $typeWaste)
    {
        return response()->json($typeWaste);
    }

    public function update(Request $request, TypeWaste $typeWaste)
    {
        $validated = $request->validate([
            'name'   => 'sometimes|required|string|max:100|unique:type_wastes,name,' . $typeWaste->id,
            'points' => 'sometimes|integer|min:0',
        ]);

        $typeWaste->update($validated);

        return response()->json($typeWaste);
    }

    public function toggleStatus(TypeWaste $typeWaste)
    {
        $typeWaste->update(['is_active' => !$typeWaste->is_active]);

        return response()->json([
            'message'   => 'Estado actualizado correctamente.',
            'is_active' => $typeWaste->is_active,
            'typeWaste' => $typeWaste,
        ]);
    }

    public function destroy(TypeWaste $typeWaste)
    {
        $typeWaste->delete();

        return response()->json(null, 204);
    }
}
