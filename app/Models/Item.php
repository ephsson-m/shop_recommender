<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['name','general_category','sub_category','price'];

    public function shops()
    {
        return $this->belongsToMany(Shop::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
