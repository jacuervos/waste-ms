<?php

namespace App\Http\Controllers;

use App\Models\OrderTypeWaste;
use Illuminate\Http\Request;

class OrderTypeWasteController extends Controller {
    public function index() {
        return response()->json(OrderTypeWaste::all());
    }

    public function store(Request $request) {
        $request->validate([
            'type_waste_id' => 'required|exists:type_wastes,id',
            'order_id' => 'required|integer',
            'weight' => 'required|numeric|min:0',
            'points' => 'required|integer|min:0',
        ]);

        return response()->json(OrderTypeWaste::create($request->all()), 201);
    }

    public function show(OrderTypeWaste $orderTypeWaste) {
        return response()->json($orderTypeWaste);
    }

    public function update(Request $request, OrderTypeWaste $orderTypeWaste) {
        $request->validate([
            'type_waste_id' => 'required|exists:type_wastes,id',
            'order_id' => 'required|integer',
            'weight' => 'required|numeric|min:0',
            'points' => 'required|integer|min:0',
        ]);

        $orderTypeWaste->update($request->all());
        return response()->json($orderTypeWaste);
    }

    public function destroy(OrderTypeWaste $orderTypeWaste) {
        $orderTypeWaste->delete();
        return response()->json(null, 204);
    }
}
