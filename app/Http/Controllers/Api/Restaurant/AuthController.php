<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Restaurant\RegisterRequest;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(RegisterRequest $request) {
        $request->merge(['password' => bcrypt($request->password)]);
        $restaurant = Restaurant::create($request->all());
        $restaurant->api_token = Str::random(60);
        $restaurant->save();
        $path = public_path();
        $destinationPath = $path . '/uploads/restaurants/'; // upload path
        $image = $request->file('path');
        $extension = $image->getClientOriginalExtension(); // getting image extension
        $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
        $image->move($destinationPath, $name); // uploading file to given path
        $restaurant->photo()->create(['path' => 'uploads/restaurants/' . $name, 'tokenable_id' => $request->user()->id,
                'tokenable_type' => 'App\Models\Restaurant']);
        return response()->json($restaurant->load('region', 'region.city'), 200);
    }
}
