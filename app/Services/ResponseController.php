<?php

namespace App\Services;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;

class ResponseController
{
    public static function successResponse($data, $message = "")
    {
        return [
            'success' => true,
            'error_code' => -1,
            "message" => $message,
            'data' => $data
        ];
    }

    public function validationError($validation):array
    {
        return [
            'success' => false,
            'error_code' => -1,
            'message' => $validation->errors()->first(),
            'data' => []
        ];
    }

    public static function errorResponse($message = "", $data = [])
    {
        return [
            'success' => false,
            'error_code' => -1,
            'message' => $message,
            'data' => []
        ];
    }

    public static function authFailed()
    {
        return [
            'success' => false,
            'error_code' => -1,
            'message' => __("mobile.auth.authorization_error"),
            'data' => []
        ];
    }

    public function errorMethodUndefined($method = '')
    {
        return [
            'success' => false,
            'error_code' => -1,
            'message' => str_replace("::method::", $method, __("mobile.auth.authorization_error")),
            'data' => []
        ];
    }

    /**
     * @param array $response
     * @return array|string
     */

    public function validate(array $params, array $rules)
    {

        $errors = [];

        $validator = Validator::make($params, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->first();
        }

        if (!empty($errors)) {
            return self::errorResponse($errors);
        }
        return true;
    }
}
