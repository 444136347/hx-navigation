<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class TestController extends BaseController
{
    public function index(Request $request)
    {
        return response()->json([
            'message'           => 'hello world',
        ],200);
    }
}
