<?php

namespace App\Http\Controllers\Schedule;

use App\Http\Controllers\Controller;
use App\Models\Parser\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index($faculty, $course)
    {
        return Group::where('faculty_id', $faculty)->where('course', $course)->get();
    }
}
