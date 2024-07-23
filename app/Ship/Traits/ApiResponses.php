<?php

namespace App\Ship\Traits;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Illuminate\Validation\ValidationException as ValidationException;

trait ApiResponses
{
    /**
     * return success json response with data and message
     *
     * @param mixed     $data
     * @param string    $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successResponse($data = null, string $message = null, int $status = 200)
    {
        return Response::json([
            'status' => 'success',
            'message' => $message ?? __('message.default.api_success'),
            'data' => $data,
        ], $status)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }

    /**
     * return fail json response with data and message
     *
     * @param mixed     $data
     * @param string    $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorResponse(Exception $error = null, string $message = null)
    {
        $code = $error->getCode();

        if ($code < 100 || $code > 599 || !is_numeric($code)) {
            $code = 500;
        }

        return Response::json([
            'status'  => 'fail',
            'message' => $message ?? __('message.default.api_failed'),
            'data'    => json_decode($error->getMessage()),
        ], $code)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }

    /**
     * Return an empty json response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function emptyResponse()
    {
        return Response::json(null, SymfonyResponse::HTTP_NO_CONTENT)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }

    /**
     * return client error response
     *
     * @param string  $errorMessage
     * @param integer $status
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function clientErrorResponse(string $errorMessage = null, $status = 400)
    {
        Log::warning("Client issue: {$errorMessage}", request()->toArray());

        return Response::json([
            'status' => 'fail',
            'message' => $errorMessage ?? __('message.default.api_failed')
        ], $status)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }

    /**
     * return system error response
     *
     * @param Exception     $errorMessage
     * @param integer       $status
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function systemErrorResponse(Exception $error = null, $status = 500)
    {
        $message = $error->getMessage();

        if ($error instanceof ValidationException) {
            $errors = $error->validator->getMessageBag();
        }

        if (method_exists($error, 'getCode') && $error->getCode() !== 0) {
            $status = $error->getCode();
        }

        if (($status < 100 || $status > 599) || !is_numeric($status)) {
            $status = 500;
        }

        if ($status >= 500) {
            Log::error("BUG: {$error->getMessage()} in {$error->getFile()}:{$error->getLine()}", request()->toArray());
        }

        $response = [
            'status'  => 'error',
            'message' => $message ?? __('message.default.api_system_error'),
            'errors'  => $errors ?? null
        ];

        if ($error->getPrevious()) {
            $response['data'] = json_decode($error->getPrevious()->getMessage());
        }

        return Response::json($response, $status)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $message = null)
    {
        return Response::json([
            'status' => 'success',
            'message' => $message ?? __('message.default.api_success'),
            'data' => [
                'access_token' => $token,
                'token_type'   => 'bearer',
                'expires_in'   => config('jwt.ttl') * 60,
                'refresh_ttl'  => config('jwt.refresh_ttl') * 60,
            ]
        ])->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }
}
