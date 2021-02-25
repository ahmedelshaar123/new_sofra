<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Client\RegisterRequest;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\NewPasswordRequest;
use App\Http\Requests\Api\ResetPasswordRequest;
use App\Mail\ResetPassword;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(RegisterRequest $request) {
        $request->merge(['password' => bcrypt($request->password)]);
        $client = Client::create($request->all());
        $client->api_token = Str::random(60);
        $client->save();
        return response()->json($client->load('region', 'region.city'), 200);
    }

    public function login(LoginRequest $request) {
        $client = Client::where('email', $request->email)->first();
        if($client){
            if(Hash::check($request->password, $client->password)) {
                if ($client->is_active == 0) {
                    return response()->json("تم حظر حسابك", 400);
                } else {
                    return response()->json($client->load('region', 'region.city'), 200);
                }
            } else {
                return response()->json("بيانات الدخول غير صحيحة", 400);
            }
        }else{
            return response()->json("بيانات الدخول غير صحيحة", 400);
        }
    }

    public function resetPassword(ResetPasswordRequest $request) {
        $client = Client::where('email', $request->email)->first();
        if($client){
            $code = Str::random(6);
            $client->update(['pin_code' => $code]);
            Mail::to($client->email)
                ->send(new ResetPassword($client->pin_code));
            return response()->json("برجاء فحص بريدك", 200);
        }else{
            return response()->json("البيانات غير صحيحة", 400);
        }
    }

    public function newPassword(NewPasswordRequest $request) {
        $client = Client::where('pin_code', $request->pin_code)->where('pin_code', '!=', null)->first();
        if($client) {
            $client->password = bcrypt($request->password);
            $client->pin_code = null;
            $client->save();
            return response()->json('تم تغيير كلمة السر بنجاح', 200);
        }else{
            return response()->json('البيانات غير صحيحة', 400);
        }
    }

}
