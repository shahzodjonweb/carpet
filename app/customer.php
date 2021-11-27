<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class customer extends Model
{
 
    public function credits(){
        return $this->hasMany(credit::class);
        }

     
    public function deleteimage(){
        Storage::delete($this);
    }    
}
