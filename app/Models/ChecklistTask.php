<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\UserChecklistTask;
use Auth;

class ChecklistTask extends Model
{

    protected $fillable = ['title', 'checklist_category_id','task',  'status', 'created_at','updated_at'];

    public $timestamps = false;
 # tasks
 public function userTask()
 {
     return $this->hasMany(UserChecklistTask::class, 'task_id', 'id')->where('user_id',Auth::user()->id);
 }


}