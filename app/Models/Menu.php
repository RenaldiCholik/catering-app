<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'description'];

    public function orders()
{
    return $this->belongsToMany(Order::class,  'menu_order')
                ->withPivot('quantity', 'subtotal')
                ->withTimestamps();
}

}
