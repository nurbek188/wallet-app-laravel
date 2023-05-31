<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;
use LogicException;

class FailedTransaction extends LogicException
{
    public function render($request): JsonResponse
    {
        return response()->json(
            [
                'message' => 'Transaction failed! Please try again!'
            ],
            500
        );
    }
}
