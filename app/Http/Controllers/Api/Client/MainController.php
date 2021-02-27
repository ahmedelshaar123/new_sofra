<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function filterRestaurant(Request $request){
        $restaurant = Restaurant::with('region')->where(function($query) use($request){
            if($request->has('region_id')){
                $query->where('region_id', $request->region_id);
            }
        })->latest()->paginate(10);
        return response()->json($restaurant, 200);
    }

    public function myNotifications(Request $request){
        $notifications = $request->user()->notifications()->with('order', 'order.client', 'order.restaurant', 'order.paymentMethod',
                'order.client.region', 'order.restaurant.region')->latest()->paginate(10);
        return response()->json($notifications, 200);
    }
}
