<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class BaseController extends Controller
{

    /**
     * @param $data
     * @param $message
     * @param int $code
     * @param array $additional
     * @return JsonResponse
     */
    public function returnResponseSuccess($data, $message, $additional = [], $code = 200): JsonResponse
    {
        $responseData = $this->formatResponseData($data, true, $message, $additional);

        return response()->json($responseData, $code);
    }

    /**
     * @param $data
     * @param $message
     * @param int $code
     * @return JsonResponse
     */
    public function returnResponseError($data, $message, $code = 404): JsonResponse
    {
        $responseData = $this->formatResponseData($data, false, $message);

        return response()->json($responseData, $code);
    }

    /**
     * @param $data
     * @param $success
     * @param $message
     * @param array $additional
     * @return array
     */
    private function formatResponseData($data, $success, $message, $additional = []): array
    {
        $return = [
            'data' => $data,
            'success' => $success,
            'message' => $message
        ];
        if ($additional) {
            return array_merge($return, $additional);
        }

        return $return;
    }

    protected function returnResponseSuccessWithPagination($data, $message, $additional = [])
    {
        $responseData = [
            'message' => $message,
            'success' => true
        ];

        $additional = array_merge($additional, $responseData);

        return $data->additional($additional);
    }


    /**
     * @return JsonResponse
     */
    public function returnAccessForbidden(): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => 'Access Forbidden.',
        ];

        return response()->json($response, 403);
    }

    protected function returnNotFoundError(): JsonResponse
    {
        return $this->returnResponseError(null, 'Not found');
    }
}
