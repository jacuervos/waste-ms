<?php

namespace App\Http\Controllers;

use App\Models\TypeWaste;
use Illuminate\Http\Request;

class TypeWasteController extends Controller {
    public function index() {
        return response()->json(TypeWaste::all());
    }

    public function store(Request $request) {
        $request->validate(['name' => 'required|string|unique:type_wastes']);
        return response()->json(TypeWaste::create($request->all()), 201);
    }

    public function show(TypeWaste $typeWaste) {
        return response()->json($typeWaste);
    }

    public function update(Request $request, TypeWaste $typeWaste) {
        $request->validate(['name' => 'required|string|unique:type_wastes,name,' . $typeWaste->id]);
        $typeWaste->update($request->all());
        return response()->json($typeWaste);
    }

    public function destroy(TypeWaste $typeWaste) {
        $typeWaste->delete();
        return response()->json(null, 204);
    }
}
