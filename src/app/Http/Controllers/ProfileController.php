<?php

namespace App\Http\Controllers;

use App\Services\ProfileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct(private readonly ProfileService $profileService)
    {
    }

    public function show(int $id): JsonResponse
    {
        $profile = $this->profileService->showByUser($id);

        return response()->json([
            'data' => $profile,
        ]);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $profile = $this->profileService->upsertByUser($id, $request->all());

        return response()->json([
            'data' => $profile,
            'message' => 'Perfil salvo com sucesso.',
        ]);
    }
}
