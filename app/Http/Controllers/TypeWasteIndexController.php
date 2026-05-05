<?php

namespace App\Http\Controllers;

use App\Http\Resources\TypeWasteResource;
use App\Models\TypeWaste;

class TypeWasteIndexController extends Controller
{
    public function index()
    {
        $typeWastes = TypeWaste::orderBy('id', 'DESC')->get();

        return TypeWasteResource::collection($typeWastes);
    }

    public function active()
    {
        $typeWastes = TypeWaste::where('is_active', true)->orderBy('id', 'DESC')->get();
        return TypeWasteResource::collection($typeWastes);
    }
}
