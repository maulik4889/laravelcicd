<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Neighbourhood extends Model
{

    protected $fillable = ['title','votes',  'three_bed_price', 'one_bed_price','image','status','created_at','updated_at'];

    public $timestamps = false;
   
   
}