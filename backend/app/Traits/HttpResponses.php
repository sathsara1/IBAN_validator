<?php

    namespace App\Traits;

    use Illuminate\Http\JsonResponse;

    trait HttpResponses{
        protected function success($data, $message = null , $code = 200): JsonResponse
        {
            return response()->json(
                [
                    'status' => $code,
                    'message' => $message,
                    'data' => $data
                ], $code
            );
        }

        protected function error($message = null ,$code): JsonResponse
        {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => $message,
                ], $code
            );
        }
    }
