<?php

namespace App\Http\Controllers;

use App\Services\ProjectService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct(private readonly ProjectService $projectService)
    {
    }

    public function index(): JsonResponse
    {
        $projects = $this->projectService->list();

        return response()->json([
            'data' => $projects,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $project = $this->projectService->create($request->all());

        return response()->json([
            'data' => $project,
            'message' => 'Projeto criado com sucesso.',
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $project = $this->projectService->show($id);

        return response()->json([
            'data' => $project,
        ]);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $project = $this->projectService->update($id, $request->all());

        return response()->json([
            'data' => $project,
            'message' => 'Projeto atualizado com sucesso.',
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->projectService->delete($id);

        return response()->json([
            'message' => 'Projeto removido com sucesso.',
        ]);
    }
}
