<?php


namespace App\Http\Controllers\Schedule;


use App\Http\Controllers\Controller;
use App\Models\Parser\Schedule;

class ScheduleController extends Controller
{
    public function index($group_id)
    {
        Schedule::where('group_id', $group_id)->get();
    }
}
