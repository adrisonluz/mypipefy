<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FilterPhases extends Model
{
    protected $fillable = ['phase_id', 'filter_id'];
    public $timestamps = false;
}
