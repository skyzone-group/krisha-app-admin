<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResponseMessage extends Controller
{
    const ERROR_OCCURRED = [
        'uz' => "Qandaydur xatolik yuz berdi qayta urinib ko'ring",
        'en' => "Unexpected error occurred!",
        'ru' => "Произошла непредвиденная ошибка",
    ];
}
