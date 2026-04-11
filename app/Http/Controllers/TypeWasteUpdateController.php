<?php

namespace App\Http\Controllers;

use App\Http\Requests\TypeWasteUpdateRequest;
use App\Http\Resources\TypeWasteResource;
use App\Models\TypeWaste;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class TypeWasteUpdateController extends Controller
{
    public function update(TypeWasteUpdateRequest $request, TypeWaste $typeWaste): JsonResponse
    {
        DB::beginTransaction();
        try {
            $typeWaste->update($request->validated());
            DB::commit();

            $data = [
                'message'   => 'Tipo de residuo actualizado correctamente',
                'typeWaste' => TypeWasteResource::make($typeWaste),
                'code'      => 200,
            ];

            return response()->json($data);
        } catch (\Exception $exception) {
            DB::rollBack();

            return response()->json([
                'message' => $exception->getMessage(),
                'code'    => 400,
            ], 400);
        }
    }
}
