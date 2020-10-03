<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Parser\Parser;
use App\Parser\Parsers\ParserFit;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(){
        return (new Parser(new ParserFit()))->getData();
    }
}
