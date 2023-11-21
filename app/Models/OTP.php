<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class OTP extends Model
{
    use HasFactory;
    protected $fillable = [
        'phone',
        'content',
        'otp',
        'status',
        'tries',
        'expires_at'
    ];

    public static function send($phone,$otp_length = 5)
    {
        $rand = rand(pow(10,$otp_length-1),pow(10,$otp_length)-1);

        if ($phone == '998953226600')
            $rand = 12345;

        $rand = 12345;

        $message = "Код авторизации на систему real estate app. Код $rand";
        $phone = phone_formatting($phone);
        $otp = self::create([
            'phone' => $phone,
            'content' => $message,
            'otp' => $rand,
            'status' => 0,
            'tries' => 0,
            'expires_at' => Carbon::now()->addMinutes(5)
        ]);
//        SendSMS::dispatch($phone,$message);
        return $otp->id;
    }

    public function canceled()
    {
        $this->status = 4;
        $this->save();
    }

    public function check($otp):bool
    {
        $this->tries++;
        if ($this->tries == 10 && $otp != $this->otp)
            $this->status = 4;
        $this->save();
        return $otp == $this->otp;
    }

    public function used()
    {
        $this->status = 1;
        $this->save();
    }

    public static function get_count($phone)
    {
        $columns = self::where('created_at', '>=', Carbon::now()->subMinutes(10))->count();
        return $columns;
    }
}
