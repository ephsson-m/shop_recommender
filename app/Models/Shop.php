<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $fillable = ['brand','category','city','district','location_type','customer_capacity','number_of_staff'];

    public function items()
    {
        return $this->belongsToMany(Item::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
