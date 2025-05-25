<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $exception)
    {
        // Log pengecualian untuk memastikan penanganan exception
        if ($exception instanceof ModelNotFoundException) {
            Log::error('ModelNotFoundException: ' . $exception->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Data yang dicari tidak ada'
            ], Response::HTTP_NOT_FOUND);
        }

        return parent::render($request, $exception);
    }
}
