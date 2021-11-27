<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class monthly extends Model
{
   
    public function check(){
        return $this->belongsTo(credit::class);
        }
}
