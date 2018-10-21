<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    //

    public function checkFields($request, $rules)
    {
        $validator = Validator::make($request, $rules);

        if ($validator->fails()) {
            return ['data' => ['message' => $validator->errors()->first()]];
        } else {
            return 200;
        }
    }
}
