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

    static public function getPhaseColor($phase_id)
    {
        return Cache::remember('phase-'.$phase_id.'-color', Config::get('cache.default_cache_time'), function() use($phase_id) {
            $select = self::select('color')
                        ->where('phase_id', '=', $phase_id)
                        ->where('user_id', '=', Auth::user()->id)
                        ->first();
            return (!is_null($select)) ? $select->color : false;
        });
    }
}
