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
            //dd(json_encode($validated['answers']));
            Question::create([
                'text' => $validated['text'],
                'type' => $validated['type'],
                'grade' => $validated['grade'],
                'correct_answer' => $validated['correct'],
                'answers' => $validated['answers'],
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
                'answers' => ['true', 'false'],
                'exam_id' => $id,
            ]);
        }

        if($request->test){
            return redirect('/teacher/update/'. $id);
        }
        else{
            return redirect('/teacher/addQ/'. $id);
        }

    }

    public function delete($id , $examId){
        Question::destroy($id);
        return redirect('/teacher/update/'.$examId);
    }

    public function edit($q){
        $ques = Question::find($q);
        return view('edit-q' , ["q" => $ques]);
    }
    public function editQ(Request $request , $q){
        $ques = Question::find($q);
        if($request->type == 1){
            $validated = $request->validate([
                'text' => 'required',
                'grade' => 'required|numeric',
                'type' => 'required|numeric',
                'answers' => 'required|array',
                'answers.*' => 'required',
                'correct' => 'required|numeric',
            ]);
            $ques->text = $validated["text"];
            $ques->grade = $validated["grade"];
            $ques->type = $validated["type"];
            $ques->correct_answer = $validated["correct"];
            $ques->answers = $validated["answers"];
            $ques->save();
        }
       elseif($request->type == 2){
            $validated = $request->validate([
                'text' => 'required',
                'grade' => 'required|numeric',
                'type' => 'required|numeric',
                'tof' =>'required',
            ]);
            $ques->text = $validated["text"];
            $ques->grade = $validated["grade"];
            $ques->type = $validated["type"];
            $ques->correct_answer = $validated["tof"];
            $ques->answers = ['true', 'false'];
            $ques->save();
        }
        return redirect('/teacher/update/'.$ques->exam_id);
    }
}
