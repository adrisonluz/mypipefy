<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Filters extends Model
{
    public function assignees()
    {
        return $this->hasMany(FilterAssignees::class, 'filter_id');
    }

    public function owners()
    {
        return $this->hasMany(FilterOwners::class, 'filter_id');
    }

    public function phases()
    {
        return $this->hasMany(FilterPhases::class, 'filter_id');
    }

    public function team()
    {
        return $this->belongsTo(TeamsReal::class, 'team_id');
    }
}
