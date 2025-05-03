<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\UserExam;
use App\Models\Question;

class AddExamController extends Controller
{
    public function add(){
        return view("create-exam");
    }

    public function addExam(Request $request){
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'nav' => 'required',
            'Shuffling' =>'nullable',
            'open-time' => 'required',
            'close-time' => 'required',
            'duration' => 'required',
            'full-mark' => 'required|numeric',
            'pass-mark' => 'required|numeric',
        ]);

        if($request->Shuffling != 1){
            $validated['Shuffling'] = 0;
        }

        Exam::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'open_time' => $validated['open-time'],
            'close_time' => $validated['close-time'],
            'duration' => $validated['duration'],
            'full_mark' => $validated['full-mark'],
            'pass_mark' => $validated['pass-mark'],
            'is_sequential' => $validated['nav'],
            'do_mix' => $validated['Shuffling'],
            'user_id' => $user->id,
        ]);

        return redirect('/profile');
    }

    public function students($id){
        $students = UserExam::with("user")->where('exam_id', $id)->get();
        $fullMark = Exam::find($id)->full_mark;
        return view("students" , ["students" => $students , "fullMark" => $fullMark , "examId" => $id]);
    }

    public function report($studentId , $examId){
        $student = UserExam::with('user')->where('exam_id', $examId)->where('user_id' , $studentId)->first();
        return view("report" , ["student" => $student]);
    }

    public function updateExam($examId){
        $exam = Exam::find($examId);
        $questions = Question::where("exam_id" , $examId)->get();
        return view("update" , ["exam" => $exam , "questions" => $questions]);
    }

    public function update(Request $request , $examId){
        $exam = Exam::find($examId);
        if($exam){
            $validated = $request->validate([
                'name' => 'required',
                'description' => 'required',
                'nav' => 'required',
                'Shuffling' =>'nullable',
                'open-time' => 'required',
                'close-time' => 'required',
                'duration' => 'required',
                'full-mark' => 'required|numeric',
                'pass-mark' => 'required|numeric',
            ]);
 
            if($request->Shuffling != 1){
                $validated['Shuffling'] = 0;
            }

            $exam->name = $validated['name'];
            $exam->description = $validated['description'];
            $exam->open_time = $validated['open-time'];
            $exam->close_time = $validated['close-time'];
            $exam->duration = $validated['duration'];
            $exam->full_mark = $validated['full-mark'];
            $exam->pass_mark = $validated['pass-mark'];
            $exam->is_sequential = $validated['nav'];
            $exam->do_mix = $validated['Shuffling'];

            $exam->save();

        }

        return redirect('/teacher/update/'.$examId);
    }

    public function delete($examId){
        Exam::destroy($examId);
        return redirect('/profile');
    }
}
