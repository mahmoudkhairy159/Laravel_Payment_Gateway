<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table='products';
    protected $fillable=['name' ,'photo','price'];

    public function orders(){
        return $this->hasMany('App\Order');
    }
}
