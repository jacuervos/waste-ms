<?php

namespace App\Http\Controllers;

use App\Http\Resources\TypeWasteResource;
use App\Models\TypeWaste;
use Illuminate\Http\JsonResponse;

class TypeWasteChangeStateController extends Controller
{
    public function toggleStatus(TypeWaste $typeWaste): JsonResponse
    {
        $typeWaste->update(['is_active' => !$typeWaste->is_active]);

        $data = [
            'message'   => 'Estado actualizado correctamente',
            'typeWaste' => TypeWasteResource::make($typeWaste),
            'code'      => 200,
        ];

        return response()->json($data);
    }
}
