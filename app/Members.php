<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Members extends Model
{
	protected $table = 'team_members';
    protected $fillable = ['member_id', 'team_id'];
    public $timestamps = false;

    public function pipefyUser()
    {
        return $this->belongsTo(PipefyUser::class, 'member_id');
    }
}
