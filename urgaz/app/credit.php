<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class credit extends Model
{

    public function customer(){
        return $this->belongsTo(customer::class);
        }

        public function checks(){
            return $this->hasMany(check::class);
            }
            public function solds(){
                return $this->hasMany(sold::class);
                }
            public function monthly(){
                return $this->hasMany(monthly::class);
                }
}
