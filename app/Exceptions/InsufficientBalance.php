<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;
use LogicException;

class InsufficientBalance extends LogicException
{
    public function render($request): JsonResponse
    {
        return response()->json(
            [
                'message' => 'Insufficient balance in wallet!'
            ],
            400
        );
    }
}
