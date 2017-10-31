<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Config;
use Cache;
use Auth;

class PipeConfig extends Model
{
    protected $table = 'pipeconfigs';
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['phase_id', 'color', 'user_id'];
    public $timestamps = false;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
}
