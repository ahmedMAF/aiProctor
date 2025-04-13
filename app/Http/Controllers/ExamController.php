<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserExam;
use App\Models\Exam;
use App\Models\Question;
use App\Models\Answer;

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

        $index = $request->session()->get("index", 0);
        $question = Question::where('exam_id', $id)->skip($index)->take(1)->first();
        $request->session()->put("index", $index + 1);

        return view("exam" , ["question" => $question , "duration" => $exam->duration , "count" => $questions->count() , "id" => $id]);

    }

    public function refresh(Request $request , $id){}

    public function nextQuestion(Request $request , $id){

        Answer::create([
            'answer' => $request->input('answer'),
            'user_id' => $request->user()->id,
            'exam_id' => $id,
            'question_id' => $request->input('questionId'),
        ]);


        $index = $request->session()->get("index", 0);
        $question = Question::where('exam_id', $id)->skip($index)->take(1)->first();

        if (!$question) {
            $request->session()->forget("index");
            return response()->json(['message' => 'The exam has ended'], 404);
        }

        $request->session()->put("index", $index + 1);
        return response()->json($question);
    }

    public function finish(Request $request , $id){
        $user = $request->user()->id;
        $mark = 0;
        $i = 0;

        $answers = Answer::where('user_id', $user)->where('exam_id', $id)->pluck('answer');
        $correctAnswers = Question::where('exam_id', $id)->select('grade' , 'correct_answer')->get();

        foreach($answers as $answer){
            if($answer == ($correctAnswers[$i]->correct_answer - 1)){
                $mark += $correctAnswers[$i]->grade;
            }
            $i++;
        }

        UserExam::where('user_id', $user)->where('exam_id', $id)->update(['end_time' => now() , 'mark' => $mark]);
        
        return redirect('/');
    }
}
