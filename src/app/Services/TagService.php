<?php

namespace App\Services;

use App\Models\Tag;
use App\Models\Task;

class TagService extends BaseService
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection<int, Tag>
     */
    public function list(): \Illuminate\Database\Eloquent\Collection
    {
        return Tag::query()->orderBy('name')->get();
    }

    public function create(array $data): Tag
    {
        $validated = $this->validate($data, [
            'name' => ['required', 'string', 'max:255', 'unique:tags,name'],
            'color' => ['nullable', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
        ]);

        return Tag::create($validated);
    }

    public function attachToTask(int $taskId, int $tagId): void
    {
        $task = Task::find($taskId);
        $tag = Tag::find($tagId);

        if (! $task) {
            $this->notFound('Tarefa não encontrada.');
        }

        if (! $tag) {
            $this->notFound('Tag não encontrada.');
        }

        if ($task->tags()->where('tags.id', $tagId)->exists()) {
            $this->conflict('A tag já está associada a esta tarefa.');
        }

        $task->tags()->attach($tagId);
    }

    public function detachFromTask(int $taskId, int $tagId): void
    {
        $task = Task::find($taskId);

        if (! $task) {
            $this->notFound('Tarefa não encontrada.');
        }

        $task->tags()->detach($tagId);
    }
}
