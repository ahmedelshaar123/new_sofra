<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RegisterTokenRequest;
use App\Http\Requests\Api\RemoveTokenRequest;
use App\Models\Token;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function registerToken(RegisterTokenRequest $request) {
        $token = $request->user()->tokens()->create($request->all());
        return response()->json($token->load('client'), 200);
    }

    public function removeToken(RemoveTokenRequest $request) {
        Token::where('token', $request->token)->delete();
        return response()->json('تم الحذف بنجاح', 200);
    }
}
