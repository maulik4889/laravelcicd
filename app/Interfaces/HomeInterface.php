<?php

namespace App\Interfaces;

use App\Http\Requests\Home\NewSkillRequest;
use App\Http\Requests\Teacher\CheckUserRequest;




use Illuminate\Http\Request;

interface HomeInterface
{
    
    public function bookingEnquiry(Request $request);
    public function getNeighnourhoods(Request $request);

    public function bestNeighbours(Request $request);
    public function checklist(Request $request);
    public function getChecklistTasks();
    public function addTaskToUserChecklist(Request $request);
    public function getTaskPercentage();
    public function getUserNonSelectedCheckList();


    

}
