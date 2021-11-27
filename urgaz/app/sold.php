<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sold extends Model
{
    public function credit(){
        return $this->belongsTo(credit::class);
        }
}
