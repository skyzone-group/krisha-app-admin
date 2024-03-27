<?php

namespace App\Http\Controllers\Mobile;

use App\Services\ResponseController;
use Illuminate\Http\Request;
use App\Models\TempImage;

class FileController extends ResponseController
{
    public function upload(Request $request)
    {
        $v = $this->validate($request->all(),[
            'file' => 'required'
        ]);
        if ($v !== true) return $v;

        if ($request->hasFile('file'))
        {
            $file = $request->file;
            $name = (microtime(true)*10000).'.'.$file->extension();
            $file->move(public_file_path(), $name);

            TempImage::create([
                'name' => $name
            ]);
            return self::successResponse($name);
        }

        return self::errorResponse(__("mobile.global.error_occurred"));
    }
}
