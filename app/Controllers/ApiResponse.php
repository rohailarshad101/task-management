<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;

class ApiResponse extends BaseController
{
    public static function success($message = null, $data = [], int $code = 200, ResponseInterface $response)
    {
        $responseBody = [
            'status' => 'success',
            'data' => $data,
            'message' => $message ?: 'Request Successful',
            'code' => $code
        ];
        return $response->setJSON($responseBody)->setStatusCode($code);
    }

    public static function error($error_message, int $code = 400, ResponseInterface $response)
    {
        $responseBody = [
            'status' => 'error',
            'message' => $error_message ?: 'Bad Request',
            'code' => $code
        ];
        return $response->setJSON($responseBody)->setStatusCode($code);
    }
}
