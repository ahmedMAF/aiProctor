<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function verification($id){
        return view("exam-link");
    }
}
