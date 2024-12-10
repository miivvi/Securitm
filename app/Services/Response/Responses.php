<?php
declare(strict_types=1);

namespace App\Services\Response;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class Responses
{
    /**
     * @param mixed $data
     * @param string $message
     * @param int $status
     * @param array $headers
     * @return JsonResponse
     */
    public static function success(
        mixed $data,
        string $message = Messages::SUCCESS,
        int $status = ResponseAlias::HTTP_OK,
        array $headers = []
    ): JsonResponse {
        return self::response($message, $data, [], $status, $headers);
    }

    /**
     * @param mixed $errors
     * @param string $message
     * @param int $status
     * @param array $headers
     * @return JsonResponse
     */
    public static function error(
        mixed $errors,
        string $message = Messages::UNPROCESSABLE_ACTION,
        int $status = ResponseAlias::HTTP_UNPROCESSABLE_ENTITY,
        array $headers = []
    ): JsonResponse {
        return self::response($message, [], Arr::wrap($errors), $status, $headers);
    }

    /**
     * @param string $message
     * @param int $status
     * @param array $headers
     * @return JsonResponse
     */
    public static function empty(
        string $message = Messages::SUCCESS,
        int $status = ResponseAlias::HTTP_OK,
        array $headers = []
    ): JsonResponse {
        return self::response($message, [], [], $status, $headers);
    }

    /**
     * @param string $message
     * @param int $status
     * @param array $headers
     * @return JsonResponse
     */
    public static function noContent(
        string $message = Messages::SUCCESS,
        int $status = ResponseAlias::HTTP_NO_CONTENT,
        array $headers = []
    ): JsonResponse {
        return self::response($message, [], [], $status, $headers);
    }

    /**
     * @param string $message
     * @param mixed $data
     * @param mixed $errors
     * @param int $status
     * @param array $headers
     * @return JsonResponse
     */
    private static function response(
        string $message,
        mixed $data,
        mixed $errors,
        int $status = ResponseAlias::HTTP_OK,
        array $headers = []
    ): JsonResponse {
        $response = [
            'message' => $message,
        ];

        if (!empty($data)) {
            $response['data'] = $data;
        }

        if (!empty($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $status, $headers);
    }
}
