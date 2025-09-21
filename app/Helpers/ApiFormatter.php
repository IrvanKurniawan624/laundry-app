<?php

namespace App\Helpers;

class ApiFormatter
{
    /**
     * Success Response
     */
    public static function success(int $code, string $message, $data = null, ?string $redirect = null)
    {
        if (!in_array($code, [200, 201, 202, 203, 204, 206])) {
            return response()->json([
                'code' => 400,
                'message' => 'Wrong status code'
            ], 400);
        }

        if ($code === 201) {
            return response()->json([
                'code'     => 201,
                'message'  => $message,
                'redirect' => $redirect,
            ], 201);
        }

        if ($code === 204) {
            return response()->noContent();
        }

        return response()->json([
            'code'    => $code,
            'data'    => $data,
            'message' => $message,
        ], $code);
    }

    /**
     * Error Response
     */
    public static function error(int $code, string $message, array $errors = [])
    {
        if (in_array($code, [200, 201])) {
            return response()->json([
                'code' => 400,
                'message' => 'Wrong status code'
            ], 400);
        }

        return response()->json([
            'code'    => $code,
            'errors'  => $errors,
            'message' => $message,
        ], $code);
    }

    /**
     * Validation Error Response
     */
    public static function validate($errors)
    {
        $errors = json_decode($errors, true);
        $array = [];

        foreach ($errors as $field => $messages) {
            foreach ($messages as $msg) {
                $array[] = [
                    'field'   => $field,
                    'message' => $msg,
                ];
            }
        }

        return response()->json([
            'code'    => 400,
            'errors'  => $array,
            'message' => 'Input validation error'
        ], 400);
    }

    /**
     * Pagination Response
     */
    public static function pagination(string $message, $data)
    {
        return response()->json([
            'code'       => 200,
            'message'    => $message,
            'data'       => $data->items(),
            'pagination' => [
                'total'        => $data->total(),
                'per_page'     => $data->perPage(),
                'current_page' => $data->currentPage(),
                'last_page'    => $data->lastPage(),
            ]
        ], 200);
    }
}
