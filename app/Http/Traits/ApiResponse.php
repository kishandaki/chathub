<?php

namespace App\Http\Traits;

trait ApiResponse
{
    public function success($data = null, string $message = 'OK', int $status = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    public function error(string $message = 'Error', int $status = 400, $errors = null)
    {
        $payload = [
            'success' => false,
            'message' => $message,
        ];

        if ($errors !== null) {
            $payload['errors'] = $errors;
        }

        return response()->json($payload, $status);
    }

    public function validationError($errors, string $message = 'Validation failed')
    {
        return $this->error($message, 422, $errors);
    }

    public function unauthorized(string $message = 'Unauthorized')
    {
        return $this->error($message, 401);
    }

    public function forbidden(string $message = 'Forbidden')
    {
        return $this->error($message, 403);
    }

    public function notFound(string $message = 'Not found')
    {
        return $this->error($message, 404);
    }

    public function serverError(string $message = 'Server error', \Throwable $exception = null)
    {
        return $this->error($message, 500);
    }
}