<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $guarded = [];

    public function customer() {
        return $this->belongsTo(Customer::class);
    }
}
