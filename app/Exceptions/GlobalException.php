<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GlobalException extends Exception
{
    /**
     * Render the exception as an HTTP response.
     */
    protected $code = 400;
    public function render(Request $request): JsonResponse
    {
        return response()->json([
            'message' => $this->getMessage()
        ], $this->getCode());
    }
}
