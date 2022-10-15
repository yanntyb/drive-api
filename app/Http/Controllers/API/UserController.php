<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;

class UserController extends Controller
{
    public function login(LoginRequest $request)
    {
        dd($request->email, $request->password);
    }
}
