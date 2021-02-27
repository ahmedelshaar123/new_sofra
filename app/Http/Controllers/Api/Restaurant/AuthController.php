<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\NewPasswordRequest;
use App\Http\Requests\Api\ResetPasswordRequest;
use App\Http\Requests\Api\Restaurant\RegisterRequest;
use App\Mail\ResetPassword;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(RegisterRequest $request) {
        $request->merge(['password' => bcrypt($request->password)]);
        $restaurant = Restaurant::create($request->all());
        $restaurant->api_token = Str::random(60);
        $restaurant->save();
        $path = public_path();
        $destinationPath = $path . '/uploads/restaurants'; // upload path
        $image = $request->file('path');
        $extension = $image->getClientOriginalExtension(); // getting image extension
        $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
        $image->move($destinationPath, $name); // uploading file to given path
        $restaurant->photo()->create(['path' => 'uploads/restaurants/' . $name, 'photoable_id' => $restaurant->id,
                'photoable_type' => 'App\Models\Restaurant']);
        return response()->json($restaurant->load('region', 'region.city', 'photo'), 200);
    }

    public function login(LoginRequest $request) {
        $restaurant = Restaurant::where('email', $request->email)->first();
        if($restaurant){
            if(Hash::check($request->password, $restaurant->password)) {
                if ($restaurant->is_active == 0) {
                    return response()->json("تم حظر حسابك", 400);
                } else {
                    return response()->json($restaurant->load('region', 'region.city'), 200);
                }
            } else {
                return response()->json("بيانات الدخول غير صحيحة", 400);
            }
        }else{
            return response()->json("بيانات الدخول غير صحيحة", 400);
        }
    }

    public function resetPassword(ResetPasswordRequest $request) {
        $restaurant = Restaurant::where('email', $request->email)->first();
        if($restaurant){
            $code = Str::random(6);
            $restaurant->update(['pin_code' => $code]);
            Mail::to($restaurant->email)
                ->send(new ResetPassword($restaurant->pin_code));
            return response()->json("برجاء فحص بريدك", 200);
        }else{
            return response()->json("البيانات غير صحيحة", 400);
        }
    }

    public function newPassword(NewPassworrestaurantdRequest $request) {
        $restaurant = Restaurant::where('pin_code', $request->pin_code)->where('pin_code', '!=', null)->first();
        if($restaurant) {
            $restaurant->password = bcrypt($request->password);
            $restaurant->pin_code = null;
            $restaurant->save();
            return response()->json('تم تغيير كلمة السر بنجاح', 200);
        }else{
            return response()->json('البيانات غير صحيحة', 400);
        }
    }
}
