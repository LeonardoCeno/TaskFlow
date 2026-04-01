<?php

namespace App\Http\Controllers;

use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct(private readonly TaskService $taskService)
    {
    }

    public function index(int $id): JsonResponse
    {
        $tasks = $this->taskService->listByProject($id);

        return response()->json([
            'data' => $tasks,
        ]);
    }

    public function store(Request $request, int $id): JsonResponse
    {
        $task = $this->taskService->create($id, $request->all());

        return response()->json([
            'data' => $task,
            'message' => 'Tarefa criada com sucesso.',
        ], 201);
    }

    public function show(int $id, int $taskId): JsonResponse
    {
        $task = $this->taskService->show($id, $taskId);

        return response()->json([
            'data' => $task,
        ]);
    }

    public function update(Request $request, int $id, int $taskId): JsonResponse
    {
        $task = $this->taskService->update($id, $taskId, $request->all());

        return response()->json([
            'data' => $task,
            'message' => 'Tarefa atualizada com sucesso.',
        ]);
    }

    public function destroy(int $id, int $taskId): JsonResponse
    {
        $this->taskService->delete($id, $taskId);

        return response()->json([
            'message' => 'Tarefa removida com sucesso.',
        ]);
    }

    public function updateStatus(Request $request, int $id, int $taskId): JsonResponse
    {
        $task = $this->taskService->updateStatus($id, $taskId, $request->all());

        return response()->json([
            'data' => $task,
            'message' => 'Status da tarefa atualizado com sucesso.',
        ]);
    }
}
