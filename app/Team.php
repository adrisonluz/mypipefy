<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model{
	protected $fillable = [
        'id', 'user_id', 'pipefy_id', 'status', 'order'
    ];

    public function user(){
    	return $this->belongsTo(User::class, 'user_id');
    }

    public static function invites($pipefy_id){
    	return self::select('*')->where('pipefy_id', '=', $pipefy_id)->where('status', '=', 1)->get();
    }
}