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

class AuthController extends ResponseController
{
    public function checkPhone(Request $request): array
    {
        if (!$request->has('phone'))
            return self::errorResponse(__("mobile.auth.phone_not_entered"));

        // Check Length of phone
        $phone = phone_formatting($request->get('phone'));

        # check user exist or not
        $client = Client::where('phone', $phone)->get()->first();
        if(is_null($client) || is_null($client->password))
        {
            return $this->sendOTP($request, $phone, true);
        }

        # show user login
        return self::successResponse(['is_new_user' => false], __("mobile.auth.enter_password"));
    }

    public function register(Request $request): array
    {
        if (!$request->has('phone'))
            return self::errorResponse(__("mobile.auth.phone_not_entered"));

        if (!$request->has('sms_code') || ($request->has('sms_code') && strlen($request->get('sms_code')) == 0))
            return self::errorResponse(__("mobile.auth.phone_not_entered"));

        $phone = phone_formatting($request->get('phone'));
        $otp = OTP::where('phone', $phone)->where('status',0)->first();

        if (is_null($otp))
            return self::errorResponse(__("mobile.auth.session_not_found"));

        if (strtotime($otp->expires_at) <  strtotime(Carbon::now()))
        {
            $otp->status = 3;
            $otp->save();
            return self::errorResponse(__("mobile.auth.sms_code_expired"));
        }

        $check = $otp->check($request->sms_code);

        if ($check){

            $client = Client::where('phone', $otp->phone)->first();

            if ($client) {
                $client->update([
                    'access_token' => Str::uuid(),
                    'last_login' => Carbon::now()
                ]);
            }
            else {
                $client = Client::create([
                    'phone' => $otp->phone,
                    'fullname' => $request->fullname ?? null,
                    'access_token' => Str::uuid(),
                    'last_login' => Carbon::now()
                ]);
            }

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
        return self::errorResponse(__("mobile.auth.wrong_code_entered"));
    }

    public function login(Request $request): array
    {
        if (!$request->has('phone'))
            return self::errorResponse(__("mobile.auth.phone_not_entered"));

        if (!$request->has('password'))
            return self::errorResponse(__("mobile.auth.password_not_entered"));

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
            return self::errorResponse(__("mobile.auth.login_or_password_incorrect"));
        }

    }

    public function setPassword(Request $request): array
    {

        if (!$request->has('password'))
            return self::errorResponse(__("mobile.auth.password_not_entered"));

        $auth = accessToken()->auth();
        $client = Client::where('id', $auth->id)->get()->first();

        if ($client) {
            $client->password = Hash::make($request->password);
            $client->save();
            return self::successResponse([],__("mobile.auth.password_saved"));
        }
        else {
            return self::errorResponse(__("mobile.auth.unexpected_error"));
        }
    }

    public function logout(Request $request): array
    {
        accessToken()->forget($request->bearerToken());
        return self::successResponse([],__("mobile.auth.logged_out"));
    }

    public function resetPasswordRequest(Request $request): array
    {
        if (!$request->has('phone'))
            return self::errorResponse(__("mobile.auth.phone_not_entered"));

        // Check Length of phone
        $phone = phone_formatting($request->get('phone'));

        # check user exist or not
        $client = Client::where('phone', $phone)->get()->first();
        if(is_null($client))
        {
            return self::errorResponse(__("mobile.auth.phone_not_found"));
        }

        return $this->sendOTP($request, $phone);
    }

    /**
     * @param Request $request
     * @param string $phone
     * @return array
     */
    public function sendOTP(Request $request, string $phone, bool $status = false): array
    {
        # check blocked or not
        if (Cache::has('blocked-' . $request->phone)) {
            $wait = 60 - round((Carbon::now()->diffInSeconds(Cache::get('blocked-' . $request->phone))) / 60);
            return self::errorResponse(str_replace("::minut::", $wait, __("mobile.auth.phone_number_blocked_for_minutes")));
        }

        # Check OTP count AND block user
        $count = OTP::get_count($request->phone);
        if ($count > 10000) {
            Cache::put("blocked-" . $request->phone, Carbon::now(), 3600);
            return self::errorResponse(__("mobile.auth.too_many_request_block"));
        }

        if (12 < strlen($phone) || strlen($phone) < 9)
            return self::errorResponse(__("mobile.auth.phone_format_incorrect"));

        $last = 'last_resend_' . $phone; //

        if (!Cache::has($last))
            Cache::put($last, Carbon::now(), 1);
        else {
            $wait = 60 - Carbon::now()->diffInSeconds(Cache::get($last));
            return self::errorResponse(str_replace("::minut::", $wait, __("mobile.auth.sms_code_already_sent_error")));
        }

        # Send OTP and return session_id
        $otp = OTP::where('phone', $phone)->where('status', 0)->first();
        if (!is_null($otp))
            $otp->canceled();

        $session_id = OTP::send($phone, ($request->otp_length ?? 4));
        return self::successResponse(['is_new_user' => $status],__("mobile.auth.sms_code_sent"));
    }
}
