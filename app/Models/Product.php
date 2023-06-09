<?php

namespace App\Models;

use App\Models\Order;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;



    function presentPrice() {

        return  '$' . $this->price / 100;

    }

    public function categories() {

        return $this->belongsToMany(Category::class);

    }

    public function orders() {

        return $this->belongsToMany(Order::class)->withPivot('quantity');

    }
}
