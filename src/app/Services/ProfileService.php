<?php

namespace App\Services;

use App\Models\Profile;
use App\Models\User;

class ProfileService extends BaseService
{
    public function showByUser(int $userId): Profile
    {
        $user = User::query()->with('profile')->find($userId);

        if (! $user) {
            $this->notFound('Usuário não encontrado.');
        }

        if (! $user->profile) {
            $this->notFound('Perfil não encontrado.');
        }

        return $user->profile;
    }

    public function upsertByUser(int $userId, array $data): Profile
    {
        $user = User::find($userId);

        if (! $user) {
            $this->notFound('Usuário não encontrado.');
        }

        $validated = $this->validate($data, [
            'bio' => ['nullable', 'string'],
            'phone' => ['nullable', 'string', 'max:50'],
            'avatar_url' => ['nullable', 'url', 'max:2048'],
        ]);

        return Profile::query()->updateOrCreate(
            ['user_id' => $userId],
            $validated
        );
    }
}
