<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FilterOwners extends Model
{
    protected $fillable = ['owner_id', 'filter_id'];
    public $timestamps = false;
}
