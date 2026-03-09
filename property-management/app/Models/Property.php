<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use SoftDeletes;
    protected $fillable = [
    'title',
    'description',
    'price',
    'location',
    'type',
    'status',
    'image',
    'user_id'
];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}

