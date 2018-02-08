<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Config;
use Cache;
use Auth;

class PipefyUser extends Model
{
    protected $table = 'pipefyusers';
    protected $primaryKey = 'pipefy_id';
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'username', 'pipefy_id', 'name', 'avatar_url'
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

    public function allAvailableUsers($teamIds){
        $select = self::orderBy('name')
                ->where('email', '<>', Auth::user()->email)
                ->whereNotIn('pipefy_id', $teamIds)
                ->get();
        return (!is_null($select)) ? $select : null;
    }

    public function avatar(){
        return asset('storage/pipefy_avatar/'.$this->avatar_url);
    }
}
