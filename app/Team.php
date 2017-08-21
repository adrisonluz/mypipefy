<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    public function myTeam(){
    	return $this->belongsTo('App\User');
    }
}
