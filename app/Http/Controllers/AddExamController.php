<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AddExamController extends Controller
{
    public function add(){
        return view("create-exam");
    }

    public function addExam(Request $request){
        //stor in data base
        $user = $request->user();
        echo $request->input("description");
        echo $user->email;
    }
}
