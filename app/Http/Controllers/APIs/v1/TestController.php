<?php

namespace App\Http\Controllers\APIs\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index () 
    {
        return response([
            'message' => 'ok'
        ], 200);
    }

    public function repay () 
    {
        return response([
            'message' => 'ok'
        ], 200);
    }
}
