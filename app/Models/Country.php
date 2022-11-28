<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{

    protected $fillable = ['name',  'iso2', 'iso3','region','timezones'];

    public $timestamps = false;

   
}