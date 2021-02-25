<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Restaurant extends Authenticatable
{

    protected $table = 'restaurants';
    public $timestamps = true;
    protected $fillable = array('name', 'region_id', 'email', 'password', 'min_price', 'fees', 'phone', 'whatsapp', 'status', 'is_active', 'pin_code', 'api_token');
    protected $hidden = array('password', 'pin_code', 'api_token');
    protected $guarded = array('restaurant');

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category');
    }

    public function reviews()
    {
        return $this->hasMany('App\Models\Review');
    }

    public function region()
    {
        return $this->belongsTo('App\Models\Region');
    }

    public function photo()
    {
        return $this->morphOne('App\Models\Photo', 'photoable');
    }

    public function payments()
    {
        return $this->hasMany('App\Models\Restaurant');
    }

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

    public function offers()
    {
        return $this->hasMany('App\Models\Offer');
    }

    public function tokens()
    {
        return $this->morphMany('App\Models\Token', 'tokenable');
    }

    public function notifications()
    {
        return $this->hasMany('App\Models\Notification');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

}
