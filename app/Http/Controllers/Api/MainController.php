<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ContactRequest;
use App\Models\City;
use App\Models\Contact;
use App\Models\Region;
use App\Models\Setting;
use App\Models\StaticPage;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function cities() {
        $cities = City::latest()->paginate(10);
        return response()->json($cities, 200);
    }

    public function regions(Request $request) {
        $regions = Region::with('city')->where(function ($query) use ($request){
            if($request->has('city_id')) {
                $query->where('city_id', $request->city_id);
            }
            if($request->has('keyword')) {
                $query->where('name', 'like', '%' . $request->keyword . '%');
            }
        })->latest()->paginate(10);
        return response()->json($regions, 200);
    }

    public function settings() {
        $settings = Setting::latest()->paginate(10);
        return response()->json($settings, 200);
    }

    public function staticPages() {
        $staticPages = StaticPage::latest()->paginate(10);
        return response()->json($staticPages, 200);
    }

    public function createContact(ContactRequest $request) {
        $contact = Contact::create($request->all());
        return response()->json($contact, 200);
    }

}
