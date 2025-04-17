<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\UserExam;

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
            'open-time' => 'required|date_format:Y-m-d\TH:i|after:now',
            'close-time' => 'required|date_format:Y-m-d\TH:i|after:now',
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
        return view("students" , ["students" => $students , "fullMark" => $fullMark]);
    }
}
