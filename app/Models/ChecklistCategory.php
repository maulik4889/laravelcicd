<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ChecklistTask;

class ChecklistCategory extends Model
{

    protected $fillable = ['title',   'status', 'created_at','updated_at'];

    public $timestamps = false;

 # tasks
 public function tasks()
 {
     return $this->hasMany(ChecklistTask::class, 'checklist_category_id', 'id');
 }

}