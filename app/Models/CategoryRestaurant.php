<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryRestaurant extends Model 
{

    protected $table = 'category_restaurant';
    public $timestamps = true;
    protected $fillable = array('category_id', 'restaurant_id');

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Models\Restaurant');
    }

}