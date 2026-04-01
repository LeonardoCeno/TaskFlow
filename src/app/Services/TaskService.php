<?php

namespace App\Services;

use App\Models\Project;
use App\Models\Task;

class TaskService extends BaseService
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection<int, Task>
     */
    public function listByProject(int $projectId): \Illuminate\Database\Eloquent\Collection
    {
        $project = Project::find($projectId);

        if (! $project) {
            $this->notFound('Projeto não encontrado.');
        }

        return Task::query()
            ->where('project_id', $projectId)
            ->with('tags')
            ->orderByDesc('id')
            ->get();
    }

    public function create(int $projectId, array $data): Task
    {
        $project = Project::find($projectId);

        if (! $project) {
            $this->notFound('Projeto não encontrado.');
        }

        $validated = $this->validate($data, [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['nullable', 'in:pending,in_progress,done'],
            'priority' => ['nullable', 'in:low,medium,high'],
            'due_date' => ['nullable', 'date'],
        ]);

        $validated['project_id'] = $projectId;

        return Task::create($validated)->fresh('tags');
    }

    public function show(int $projectId, int $taskId): Task
    {
        $task = Task::query()
            ->where('project_id', $projectId)
            ->where('id', $taskId)
            ->with('tags')
            ->first();

        if (! $task) {
            $this->notFound('Tarefa não encontrada.');
        }

        return $task;
    }

    public function update(int $projectId, int $taskId, array $data): Task
    {
        $task = Task::query()
            ->where('project_id', $projectId)
            ->where('id', $taskId)
            ->first();

        if (! $task) {
            $this->notFound('Tarefa não encontrada.');
        }

        $validated = $this->validate($data, [
            'title' => ['sometimes', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['sometimes', 'in:pending,in_progress,done'],
            'priority' => ['sometimes', 'in:low,medium,high'],
            'due_date' => ['nullable', 'date'],
        ]);

        $task->update($validated);

        return $task->fresh('tags');
    }

    public function updateStatus(int $projectId, int $taskId, array $data): Task
    {
        $task = Task::query()
            ->where('project_id', $projectId)
            ->where('id', $taskId)
            ->first();

        if (! $task) {
            $this->notFound('Tarefa não encontrada.');
        }

        $validated = $this->validate($data, [
            'status' => ['required', 'in:pending,in_progress,done'],
        ]);

        $task->update(['status' => $validated['status']]);

        return $task->fresh('tags');
    }

    public function delete(int $projectId, int $taskId): void
    {
        $task = Task::query()
            ->where('project_id', $projectId)
            ->where('id', $taskId)
            ->first();

        if (! $task) {
            $this->notFound('Tarefa não encontrada.');
        }

        $task->delete();
    }
}
