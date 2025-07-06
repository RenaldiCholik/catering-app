<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['customer_name', 'customer_phone', 'address', 'total_price', 'status', 'note'];

    public function menus()
{
    return $this->belongsToMany(Menu::class, 'menu_order')->withPivot('quantity', 'subtotal')->withTimestamps();
}

    
    
}

