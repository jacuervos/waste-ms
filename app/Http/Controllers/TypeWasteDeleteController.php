<?php

namespace App\Http\Controllers;

use App\Models\TypeWaste;
use Illuminate\Http\JsonResponse;

class TypeWasteDeleteController extends Controller
{
    public function delete(TypeWaste $typeWaste): JsonResponse
    {
        $typeWaste->delete();

        $data = [
            'message' => 'Tipo de residuo eliminado correctamente',
            'id'      => $typeWaste->id,
            'code'    => 200,
        ];

        return response()->json($data);
    }
}
