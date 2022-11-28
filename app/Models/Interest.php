<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Interest extends Model
{

    protected $fillable = ['name', 'slug',  'status', 'created_at'];

    public $timestamps = false;

}