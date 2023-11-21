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
            "data" => $message,
            'result' => $data
        ];
    }

    public function validationError($validation):array
    {
        return [
            'success' => false,
            'data' => [
                'uz' => $validation->errors()->first(),
                'ru' => $validation->errors()->first(),
                'en' => $validation->errors()->first(),
            ]
        ];
    }

    public static function errorResponse($message,$data = [])
    {
        if (count($data))
            return [
                'status' => false,
                'data' => $message
            ];
        else
            return [
                'status' => false,
                'data' => $message
            ];

    }

    public static function authFailed()
    {
        return [
            'status' => false,
            'data' => [
                'uz' => 'Avtorizatsiyada xatolik!',
                'ru' => "Авторизация не удалась!",
                'en' => "Authorization failed!"
            ]
        ];
    }

    public function errorMethodUndefined($method = '')
    {
        return [
            'status' => false,
            'data' => [
                'uz' => $method.' metodi topilmadi!',
                'ru' => 'Метод '.$method.' не найден!',
                'en' => 'Method '.$method.' not found!',
            ]
        ];
    }

    /**
     * @param array $response
     * @return array|string
     */

    public function validate(array $params, array $rules)
    {
        // Set the desired languages for error messages
        $languages = ['uz','en','ru'];

        $errors = [];

        foreach ($languages as $lang) {
            App::setLocale($lang);
            $validator = Validator::make($params, $rules);
            if ($validator->fails()) {
                $errors[$lang] = $validator->errors()->first();
            }
        }

        if (!empty($errors)) {
            return self::errorResponse($errors);
        }
        return true;
    }
}
