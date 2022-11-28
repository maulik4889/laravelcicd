<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Lesson;
use App\Models\Review;

use App\User;
use Auth;

class Blog extends Model
{

   protected $fillable = ['title','description','tag','tag_description','image','status', 'created_at','updated_at'];
   public $timestamps = false;

}