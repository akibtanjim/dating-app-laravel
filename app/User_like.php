<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_like extends Model
{
    public function user () {
        return $this->belongsTo('App\User','user_id','id');
    }
}
