<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class BaseController extends Controller
{
    /**
     * Common Success Response
     */
    protected function successResponse(
        string $message = 'Success',
        mixed $data = null,
        int $code = 200,
        array $extra = []
    ): JsonResponse {
        return response()->json(array_merge([
            'status'  => true,
            'code'    => $code,
            'message' => $message,
            'data'    => $data ?? [],
        ], $extra), $code);
    }

    /**
     * Common Error Response
     */
    protected function errorResponse(
        string $message = 'Something went wrong.',
        mixed $errors = null,
        int $code = 400
    ): JsonResponse {
        return response()->json([
            'status'  => false,
            'code'    => $code,
            'message' => $message,
            'errors'  => $errors ?? (object) [],
        ], $code);
    }

    /**
     * Common Paginated Response with Meta
     */
    protected function paginatedResponse(
        $paginatedData,
        string $successMessage = 'Data fetched successfully.',
        string $emptyMessage = 'No data found.',
        int $code = 200
    ): JsonResponse {

        $meta = [
            'current_page' => $paginatedData->currentPage(),
            'per_page'     => $paginatedData->perPage(),
            'last_page'    => $paginatedData->lastPage(),
            'total'        => $paginatedData->total(),
        ];

        if ($paginatedData->isEmpty()) {
            return $this->successResponse(
                $emptyMessage,
                [],
                $code,
                ['meta' => $meta]
            );
        }

        return $this->successResponse(
            $successMessage,
            $paginatedData->items(),
            $code,
            ['meta' => $meta]
        );
    }
}
