<?php

namespace App\Http\Controllers;

use App\Http\Requests\TypeWasteStoreRequest;
use App\Http\Resources\TypeWasteResource;
use App\Models\TypeWaste;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class TypeWasteStoreController extends Controller
{
    public function create(TypeWasteStoreRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $typeWaste = TypeWaste::create($request->validated());
            $typeWaste->refresh();
            DB::commit();

            $data = [
                'message'   => 'Tipo de residuo creado correctamente',
                'typeWaste' => TypeWasteResource::make($typeWaste),
                'code'      => 201,
            ];

            return response()->json($data, 201);
        } catch (\Exception $exception) {
            DB::rollBack();

            return response()->json([
                'message' => $exception->getMessage(),
                'code'    => 400,
            ], 400);
        }
    }
}
