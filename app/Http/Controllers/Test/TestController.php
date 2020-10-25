<?php

namespace App\Http\Controllers\Test;

use App\Graber\Grab;
use App\Http\Controllers\Controller;
use App\Models\Parser\Faculty;
use App\Models\Parser\Group;
use App\Models\Parser\Schedule;
use App\Parser\Parser;
use App\Parser\Parsers\ParserFit;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        return (new Parser(new ParserFit()))->getData();
    }

    public function test()
    {
        $data = (new Parser(new ParserFit()))->getData();
        Group::insertGroups($data);
        return Schedule::insertSubjects($data);
    }

    public function grab()
    {
        return (new Grab())->getSrc();
    }
}
