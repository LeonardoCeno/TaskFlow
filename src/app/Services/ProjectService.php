<?php

namespace App\Services;

use App\Models\Project;

class ProjectService extends BaseService
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection<int, Project>
     */
    public function list(): \Illuminate\Database\Eloquent\Collection
    {
        return Project::query()
            ->with('user:id,name,email')
            ->withCount('tasks')
            ->orderByDesc('id')
            ->get();
    }

    public function create(array $data): Project
    {
        $validated = $this->validate($data, [
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['nullable', 'in:open,in_progress,completed'],
            'deadline' => ['nullable', 'date'],
        ]);

        return Project::create($validated);
    }

    public function show(int $id): Project
    {
        $project = Project::query()
            ->with(['user:id,name,email', 'tasks.tags'])
            ->withCount('tasks')
            ->find($id);

        if (! $project) {
            $this->notFound('Projeto não encontrado.');
        }

        return $project;
    }

    public function update(int $id, array $data): Project
    {
        $project = Project::find($id);

        if (! $project) {
            $this->notFound('Projeto não encontrado.');
        }

        $validated = $this->validate($data, [
            'user_id' => ['sometimes', 'integer', 'exists:users,id'],
            'name' => ['sometimes', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['sometimes', 'in:open,in_progress,completed'],
            'deadline' => ['nullable', 'date'],
        ]);

        $project->update($validated);

        return $project->fresh(['user:id,name,email']);
    }

    public function delete(int $id): void
    {
        $project = Project::find($id);

        if (! $project) {
            $this->notFound('Projeto não encontrado.');
        }

        $project->delete();
    }
}
