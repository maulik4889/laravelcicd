<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $fillable = ['title', 'slug', 'icon','selected',  'status', 'created_at'];

    public $timestamps = false;


}