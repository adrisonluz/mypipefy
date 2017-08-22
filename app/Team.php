<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model{
	protected $fillable = [
        'id', 'user_id', 'pipefy_id', 'status',
    ];
}
