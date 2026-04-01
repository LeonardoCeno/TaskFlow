<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::factory(10)->create();

        $users->each(function (User $user): void {
            Project::factory(2)->create(['user_id' => $user->id])
                ->each(function (Project $project): void {
                    Task::factory(3)->create(['project_id' => $project->id]);
                });
        });

        $tags = Tag::factory(8)->create();

        Task::query()->get()->each(function (Task $task) use ($tags): void {
            $amount = fake()->numberBetween(0, 3);

            if ($amount === 0) {
                return;
            }

            $tagIds = $tags->random($amount)->pluck('id')->all();

            $task->tags()->syncWithoutDetaching($tagIds);
        });
    }
}