<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FilterAssignees extends Model
{
    protected $fillable = ['assignee_id', 'filter_id'];
    public $timestamps = false;
}
