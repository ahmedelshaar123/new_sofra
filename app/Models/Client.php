<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable
{

    protected $table = 'clients';
    public $timestamps = true;
    protected $fillable = array('name', 'email', 'phone', 'region_id', 'desc', 'is_active', 'password', 'pin_code', 'api_token');
    protected $hidden = array('password', 'pin_code', 'api_token');
    protected $guarded = array('client');

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
