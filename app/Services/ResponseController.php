<?php

namespace App\Services;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;

class ResponseController
{
    public static function successResponse($data, $message = [])
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
            'message' => [
                'uz' => $validation->errors()->first(),
                'ru' => $validation->errors()->first(),
            ],
            'data' => []
        ];
    }

    public static function errorResponse($message = [], $data = [])
    {
        if (count($data))
            return [
                'success' => false,
                'message' => $message,
                'data' => $data
            ];
        else
            return [
                'success' => false,
                'message' => $message,
                'data' => []
            ];

    }

    public static function authFailed()
    {
        return [
            'success' => false,
            'message' => [
                'uz' => 'Avtorizatsiyada xatolik!',
                'ru' => "Авторизация не удалась!",
            ],
            'data' => []
        ];
    }

    public function errorMethodUndefined($method = '')
    {
        return [
            'success' => false,
            'message' => [
                'uz' => $method.' metodi topilmadi!',
                'ru' => 'Метод '.$method.' не найден!',
            ],
            'data' => []
        ];
    }

    /**
     * @param array $response
     * @return array|string
     */

    public function validate(array $params, array $rules)
    {
        // Set the desired languages for error messages
        $languages = ['uz', 'ru'];

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
