<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Answer;

class StudentController extends Controller
{
    public function review(Request $request , $id){
        $user = $request->user()->id;
        $questions = Question::where("exam_id" , $id)->get();
        $answers = Answer::where('user_id', $user)->where('exam_id', $id)->pluck('answer');

        return view("review" , ["questions" => $questions , "answers" => $answers]);
    }

}
