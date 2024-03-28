<?php

namespace  App\Traits;

use Throwable;
use Illuminate\Support\Str;

trait ApiResponse
{
    /**
     * Response for success
     * @param $data,$statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponse($data = null, $statusCode = 200)
    {
        return response()->json([
            'status' => true,
            'data' => $data,
        ], $statusCode);
    }

    /**
     * Response for failure
     * @param  $data, $message, $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorResponse($data = null, $message = "Not Found", $statusCode = 404)
    {
        return response()->json([
            'status' => false,
            'data' => $data,
            'message' => $message
        ], $statusCode);
    }
}
