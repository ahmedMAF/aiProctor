<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\Question;


class AddQController extends Controller
{
    public function questions($id){
        $exams = Exam::where("id" , $id)->first();
        $question = Question::where("exam_id" , $id)->get();

        return view("question" , ['exam' => $exams , "question" => $question]);
    }

    public function add(Request $request , $id){

        if($request->type == 1){
            $validated = $request->validate([
                'text' => 'required',
                'grade' => 'required|numeric',
                'type' => 'required|numeric',
                'answers' => 'required|array',
                'answers.*' => 'required',
                'correct' => 'required|numeric',
            ]);

            Question::create([
                'text' => $validated['text'],
                'type' => $validated['type'],
                'grade' => $validated['grade'],
                'correct_answer' => $validated['correct'],
                'answers' => json_encode($validated['answers']),
                'exam_id' => $id,
            ]);
        }
        elseif($request->type == 2){
            $validated = $request->validate([
                'text' => 'required',
                'grade' => 'required|numeric',
                'type' => 'required|numeric',
                'tof' =>'required',
            ]);

            Question::create([
                'text' => $validated['text'],
                'type' => $validated['type'],
                'grade' => $validated['grade'],
                'correct_answer' => $validated['tof'],
                'answers' => json_encode(['true', 'false']),
                'exam_id' => $id,
            ]);
        }

        return redirect('/teacher/addQ/'. $id);

    }
}
