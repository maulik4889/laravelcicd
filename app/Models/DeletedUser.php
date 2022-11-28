<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeletedUser extends Model
{

    protected $fillable = ['name',  'reason', 'created_at'];

    public $timestamps = false;

   
}