<?php

namespace App\Http\Controllers\Schedule;

use App\Http\Controllers\Controller;
use App\Models\Parser\Faculty;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
    /**
     * @return Faculty[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return Faculty::all();
    }
}
