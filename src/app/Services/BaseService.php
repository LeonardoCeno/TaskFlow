<?php

namespace App\Services;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;

abstract class BaseService
{
    /**
     * @param array<string, mixed> $data
     * @param array<string, mixed> $rules
     * @return array<string, mixed>
     */
    protected function validate(array $data, array $rules): array
    {
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new HttpResponseException(response()->json([
                'message' => 'Dados inválidos.',
                'errors' => $validator->errors(),
            ], 422));
        }

        return $validator->validated();
    }

    protected function notFound(string $message): void
    {
        throw new HttpResponseException(response()->json([
            'message' => $message,
            'status' => 404,
        ], 404));
    }

    protected function conflict(string $message): void
    {
        throw new HttpResponseException(response()->json([
            'message' => $message,
            'status' => 409,
        ], 409));
    }
}
