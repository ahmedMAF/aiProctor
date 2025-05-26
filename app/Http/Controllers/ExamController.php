<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserExam;
use App\Models\Exam;
use App\Models\Question;
use App\Models\Answer;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class ExamController extends Controller
{
    public function verification(Request $request, $id)
    {
        $exam = Exam::find($id);
        if ($exam->open_time > now()) {
            return view("exam-not-open", ["open_time" => $exam->open_time, "done" => 0]);
        }
        $user = $request->user();
        $userExam = UserExam::where('user_id', $user->id)->where('exam_id', $id)->first();
        if ($userExam) {
            return view("exam-not-open", ["done" => 1]);
        }
        return view("exam-link", ['id' => $id]);
    }

    public function takeExam(Request $request, $id)
    {
        $user = $request->user();
        $exam = Exam::where("id", $id)->first();

        $questions = Question::where("exam_id", $id)->get();

        UserExam::create([
            'start_time' => now(),
            'user_id' => $user->id,
            'exam_id' => $id,
        ]);

        $index = $request->session()->get("index", 0);
        $question = Question::where('exam_id', $id)->skip($index)->take(1)->first();
        $request->session()->put("index", $index + 1);

        return view("exam", ["question" => $question, "m" => $exam->duration, "s" => 0, "count" => $questions->count(), "id" => $id]);
    }

    public function refresh(Request $request, $id)
    {
        $user = $request->user()->id;
        $index = $request->session()->get("index", 0);
        $index -= 1;
        $question = Question::where('exam_id', $id)->skip($index)->take(1)->first();
        $questions = Question::where("exam_id", $id)->get();
        $exam = Exam::where("id", $id)->first();
        $startTime = UserExam::where('user_id', $user)->where('exam_id', $id)->value('start_time');

        $duration = $exam->duration * 60;
        $startTime = Carbon::parse($startTime);
        $elapsed = $startTime->diffInSeconds(Carbon::now());
        $duration = max($duration - $elapsed, 0);

        return view("exam", ["question" => $question, "m" => floor($duration / 60), "s" => ($duration % 60), "count" => $questions->count(), "id" => $id]);
    }

    public function nextQuestion(Request $request, $id)
    {

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

    public function finish(Request $request, $id)
    {
        $user = $request->user()->id;
        $mark = 0;
        $i = 0;

        $answers = Answer::where('user_id', $user)->where('exam_id', $id)->pluck('answer');
        $correctAnswers = Question::where('exam_id', $id)->select('grade', 'correct_answer')->get();

        foreach ($answers as $answer) {
            if ($answer === ($correctAnswers[$i]->correct_answer - 1)) {
                $mark += $correctAnswers[$i]->grade;
            }
            $i++;
        }

        UserExam::where('user_id', $user)->where('exam_id', $id)->update(['end_time' => now(), 'mark' => $mark]);

        return redirect('/');
    }

    public function report(Request $request, $examId)
    {
        if ($request->hasFile('file')) {
            $user = $request->user()->id;

            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move('uploads/report', $fileName);

            //UserExam::where('user_id', $user)->where('exam_id', $examId)->update(['report' => $fileName]);
            DB::table('user_exam')
                ->where('user_id', $user)
                ->where('exam_id', $examId)
                ->update([
                    'report' => DB::raw("
                        JSON_ARRAY_APPEND(
                        IFNULL(report, '[]'),
                        '$',
                        JSON_OBJECT('type', 'audio', 'time', '" . now()->toDateTimeString() . "' , 'description' , 'audio detected' , 'path' , '". $fileName ."')
                        )
                    ")
                ]);

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'No file received'], 400);
    }
}
