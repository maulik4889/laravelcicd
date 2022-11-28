<?php

namespace App\Models;
use App\Models\BookedLesson;
use Illuminate\Database\Eloquent\Model;


class Coupon extends Model
{

    protected $fillable = ['name','discount','valid_till','status','created_at','updated_at'];

    public $timestamps = false;


   
    public function redeems()
    {
        return $this->hasMany(BookedLesson::class, 'coupon_id', 'id');
    }
    



  

}
