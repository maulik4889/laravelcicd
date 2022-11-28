<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserChecklistTask extends Model
{

    protected $fillable = ['task_id', 'user_id',  'status', 'created_at','updated_at'];

    public $timestamps = false;


}