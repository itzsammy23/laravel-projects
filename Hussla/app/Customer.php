<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'firstname', 'lastname', 'email', 'password',
    ];

    public function favorite()
    {
        return $this->hasMany(Favorite::class);
    }
}
