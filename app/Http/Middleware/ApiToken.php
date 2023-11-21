<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Api\TokenController;
use App\Models\Token;
use App\Services\LogWriter;
use App\Services\ResponseController;
use Closure;
use Illuminate\Http\Request;

class ApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $start_time = microtime(true);
        $validate = false;

        if(strlen($request->bearerToken()))
            $validate = Token::check($request->bearerToken());

        if ($validate)
        {
            try {
                $result = $next($request);
            }
            catch (\Exception $exception)
            {
                $result = response()->json([
                    'success' => false,
                    "message" => "",
                    "error_code" => -1,
                    'data' => [
                        'uz' => $exception->getMessage(),
                        'ru' => $exception->getMessage(),
                        'en' => $exception->getMessage(),
                    ]
                ],500);
            }
        }
        else
            $result = response()->json(ResponseController::authFailed(),401);

        // Calculate script execution time
//        $execution_time = round((microtime(true) - $start_time) * 1000);

//        LogWriter::requests($request,json_decode($result->content(),true),$execution_time);

        return $result;
    }
}
