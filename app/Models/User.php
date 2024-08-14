<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = ['name','email','password'];

    public function shops()
    {
        return $this->belongsToMany(Shop::class);
    }
    public function items()
    {
        return $this->belongsToMany(Item::class);
    }
}
