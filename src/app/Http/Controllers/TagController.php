<?php

namespace App\Http\Controllers;

use App\Services\TagService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function __construct(private readonly TagService $tagService)
    {
    }

    public function index(): JsonResponse
    {
        $tags = $this->tagService->list();

        return response()->json([
            'data' => $tags,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $tag = $this->tagService->create($request->all());

        return response()->json([
            'data' => $tag,
            'message' => 'Tag criada com sucesso.',
        ], 201);
    }

    public function attachTag(int $taskId, int $tagId): JsonResponse
    {
        $this->tagService->attachToTask($taskId, $tagId);

        return response()->json([
            'message' => 'Tag associada com sucesso.',
        ]);
    }

    public function detachTag(int $taskId, int $tagId): JsonResponse
    {
        $this->tagService->detachFromTask($taskId, $tagId);

        return response()->json([
            'message' => 'Tag removida da tarefa com sucesso.',
        ]);
    }
}
