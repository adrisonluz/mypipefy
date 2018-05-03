<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamsReal extends Model
{
    protected $table = 'teams_real';

    public function members()
    {
        return $this->hasMany(Members::class, 'team_id');
    }
}
