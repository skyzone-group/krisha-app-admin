<?php

namespace App\Http\Controllers\Mobile\Auth;

use App\Models\Client;
use App\Models\OTP;
use App\Models\Token;
use App\Services\ResponseController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class LoginController extends ResponseController
{
    public function checkPhone(Request $request): array
    {
        if (!$request->has('phone'))
            return self::errorResponse([
                'uz' => 'Telefon raqam kiritilmagan',
                'ru' => 'Введите номер телефона',
                'en' => 'Input phone number'
            ]);

        // Check Length of phone
        $phone = phone_formatting($request->get('phone'));

        # check user exist or not
        $client = Client::where('phone', $phone)->get()->first();
        if(!is_null($client))
        {
            return self::successResponse([
                'uz' => "Parolni kiriting!",
                'ru' => "Введите пароль!",
                'en' => "Enter password!"
            ]);
        }

        # check blocked or not
        return $this->sendOTP($request, $phone);
    }

    public function register(Request $request): array
    {
        if (!$request->has('phone'))
            return self::errorResponse([
                'uz' => 'Telefon raqam kiritilmagan',
                'ru' => 'Введите номер телефона',
                'en' => 'Input phone number'
            ]);

        if (!$request->has('sms_code') || ($request->has('sms_code') && strlen($request->get('sms_code')) == 0))
            return self::errorResponse([
                'uz' => 'Tasdiqlash kodi kiritilmagan',
                'ru' => 'Заполните код подтверждения',
                'en' => 'Fill in the verification code'
            ]);

        $phone = phone_formatting($request->get('phone'));
        $otp = OTP::where('phone', $phone)->where('status',0)->first();

        if (is_null($otp))
            return self::errorResponse([
                'uz' => 'Sessiya topilmadi',
                'ru' => 'Сессия не найден',
                'en' => 'Session not found'
            ]);

        if (strtotime($otp->expires_at) <  strtotime(Carbon::now()))
        {
            $otp->status = 3;
            $otp->save();
            return self::errorResponse([
                'uz' => 'SMS kodning amal qilish muddati tugagan',
                'ru' => 'Срок действия SMS-кода истек',
                'en' => 'SMS code was expired'
            ]);
        }

        $check = $otp->check($request->sms_code);

        if ($check){
            $client = Client::updateOrCreate(
                [
                    'phone' => $otp->phone,
                ],
                [
                    'fullname' => $request->fullname ?? null,
                    'access_token' => Str::uuid(),
                    'last_login' => Carbon::now()
                ]
            );

            $token = Token::create([
                'client_id' => $client->id,
                'token' => Str::uuid(),
                'token_expires_at' => Carbon::now()->addDays(30)
            ]);
            $otp->used();

            return self::successResponse([
                'id' => $client->id,
                'fullname' => $client->fullname,
                'avatar' => $client->avatar,
                'phone' => $client->phone,
                'type' => $client->type,
                'verified' => $client->verified,
                'token' => $token->token,
                'token_expires_at' => $token->token_expires_at,
            ]);
        }
        return self::errorResponse([
            'uz' => "Noto'g'ri kod kiritildi",
            'ru' => 'Введен неправильный код',
            'en' => 'Wrong code entered'
        ]);
    }

    public function login(Request $request): array
    {
        if (!$request->has('phone'))
            return self::errorResponse([
                'uz' => 'Telefon raqam kiritilmagan',
                'ru' => 'Введите номер телефона',
                'en' => 'Input phone number'
            ]);

        if (!$request->has('password'))
            return self::errorResponse([
                'uz' => 'Parol kiritilmagan',
                'ru' => 'Введите пароль',
                'en' => 'Input password'
            ]);

        $phone = phone_formatting($request->get('phone'));
        $client = Client::where('phone', $phone)->get()->first();

        if ($client && Hash::check($request->get('password'), $client->password)) {

            $token = Token::create([
                'client_id' => $client->id,
                'token' => Str::uuid(),
                'token_expires_at' => Carbon::now()->addDays(30)
            ]);

            return self::successResponse([
                'id' => $client->id,
                'fullname' => $client->fullname,
                'avatar' => $client->avatar,
                'phone' => $client->phone,
                'type' => $client->type,
                'verified' => $client->verified,
                'token' => $token->token,
                'token_expires_at' => $token->token_expires_at,
            ]);
        }
        else {
            return self::errorResponse([
                'uz' => 'Login yoki parol noto\'g\'ri!',
                'ru' => 'Логин или пароль неверный!',
                'en' => 'Login or password is incorrect!'
            ]);
        }

    }

    public function setPassword(Request $request): array
    {

        if (!$request->has('password'))
            return self::errorResponse([
                'uz' => 'Parol kiritilmagan',
                'ru' => 'Введите пароль',
                'en' => 'Input password'
            ]);

        $auth = accessToken()->auth();
        $client = Client::where('id', $auth->id)->get()->first();

        if ($client) {

            $client->password = Hash::make($request->password);
            $client->save();

            return self::successResponse([
                'uz' => 'Parol saqlandi!',
                'ru' => 'Пароль сохранен!',
                'en' => 'Password saved!'
            ]);
        }
        else {
            return self::errorResponse([
                'uz' => 'Kutilmagan xatolik yuz berdi',
                'ru' => 'Произошла непредвиденная ошибка',
                'en' => 'Unexpected error occurred'
            ]);
        }
    }

    public function logout(Request $request): array
    {
        accessToken()->forget($request->bearerToken());

        return self::successResponse([
            'uz' => 'Hisobdan chiqildi',
            'ru' => 'Logged out',
            'en' => 'Logged out'
        ]);
    }

    public function resetPasswordRequest(Request $request): array
    {
        if (!$request->has('phone'))
            return self::errorResponse([
                'uz' => 'Telefon raqam kiritilmagan',
                'ru' => 'Введите номер телефона',
                'en' => 'Input phone number'
            ]);

        // Check Length of phone
        $phone = phone_formatting($request->get('phone'));

        # check user exist or not
        $client = Client::where('phone', $phone)->get()->first();
        if(is_null($client))
        {
            return self::errorResponse([
                'uz' => "Telefon raqam topilmadi",
                'ru' => "Номер телефона не найден",
                'en' => "Phone number not found"
            ]);
        }

        return $this->sendOTP($request, $phone);
    }

    /**
     * @param Request $request
     * @param string $phone
     * @return array
     */
    public function sendOTP(Request $request, string $phone): array
    {
        # check blocked or not
        if (Cache::has('blocked-' . $request->phone)) {
            $wait = 60 - round((Carbon::now()->diffInSeconds(Cache::get('blocked-' . $request->phone))) / 60);
            return self::errorResponse([
                'uz' => "Telefon raqam bloklangan, kutish vaqti $wait minut",
                'ru' => "Номер телефона заблокирован время ожиданий $wait минут ",
                'en' => "Phone number blocked waiting time $wait minutes"
            ]);
        }

        # Check OTP count AND block user
        $count = OTP::get_count($request->phone);
        if ($count > 5) {
            Cache::put("blocked-" . $request->phone, Carbon::now(), 3600);
            return self::errorResponse([
                'uz' => "Urunishlar ko'pligi sabab xavfsizlik yuzasidan sizning raqamingiz 1 soatga bloklandi",
                'ru' => "Много попыток, в рамках безопасностью ваш номер заблокирован на 1 час",
                'en' => "Too many attempts, as part of security, your number is blocked for 1 hour"
            ]);
        }

        if (12 < strlen($phone) || strlen($phone) < 9)
            return self::errorResponse([
                'uz' => "Kiritilgan telefon raqami noto'g'ri formatda",
                'ru' => 'Номер телефона в неправильном формате',
                'en' => 'Phone number is in wrong format'
            ]);

        $last = 'last_resend_' . $phone; //

        if (!Cache::has($last))
            Cache::put($last, Carbon::now(), 10);
        else {
            $wait = 60 - Carbon::now()->diffInSeconds(Cache::get($last));
            return self::errorResponse([
                'uz' => "SMS kod jo'natilgan keyingi urunish $wait soniyadan keyin",
                'ru' => "СМС код отправлена следующая попытка через $wait секунд",
                'en' => "SMS code sent next try in $wait seconds"
            ]);
        }

        # Send OTP and return session_id
        $otp = OTP::where('phone', $phone)->where('status', 0)->first();
        if (!is_null($otp))
            $otp->canceled();

        $session_id = OTP::send($phone, ($request->otp_length ?? 5));
        return self::successResponse([
            'uz' => "SMS kod yuborildi",
            'ru' => "SMS-код успешно отправлен",
            'en' => "SMS code sent successfully"
        ]);
    }
}
