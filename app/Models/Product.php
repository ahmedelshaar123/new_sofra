<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model 
{

    protected $table = 'products';
    public $timestamps = true;
    protected $fillable = array('name', 'desc', 'price', 'duration', 'restaurant_id');

    public function restaurant()
    {
        return $this->belongsTo('App\Models\Restaurant');
    }

    public function photo()
    {
        return $this->morphOne('App\Models\Photo', 'photoable');
    }

    public function orders()
    {
        return $this->belongsToMany('App\Models\Order');
    }

}