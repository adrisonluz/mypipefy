<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Config;
use Cache;

class PipefyUser extends Model
{
    protected $table = 'pipefyusers';
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'email', 'username', 'pipefy_id', 'name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public static function getuser($pipefy_id){
        return Cache::remember('pipefyuser-'.$pipefy_id, Config::get('cache.default_cache_time'), function() use($pipefy_id) {
            $select = self::select('name')->where('pipefy_id', '=', $pipefy_id)->first();
            return (!is_null($select)) ? $select->name : null;
        });
    }
}
