<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserExam;
use App\Models\Exam;
use App\Models\Question;

class ExamController extends Controller
{
    public function verification($id){
        return view("exam-link" , ['id' => $id]);
    }

    public function takeExam(Request $request , $id){
        $user = $request->user();
        $exam = Exam::where("id" , $id)->first();
        $questions = Question::where("exam_id" , $id)->get();

        UserExam::create([
            'start_time' => now(),
            'user_id' => $user->id,
            'exam_id' => $id,
        ]);

        return view("exam" , ["duration" => $exam->duration , "count" => $questions->count() , "id" => $id]);

    }

    public function nextQuestion(Request $request , $id){
        $index = $request->session()->get("index", 0);
        $question = Question::where('exam_id', $id)->skip($index)->take(1)->first();

        if (!$question) {
            $request->session()->forget("index");
            return response()->json(['message' => 'The exam has ended'], 404);
        }

        $request->session()->put("index", $index + 1);
        return response()->json($question);
    }
}
