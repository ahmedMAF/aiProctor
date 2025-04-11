@extends('layouts.main')

@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title' , 'Exam')

@section('style')
<link rel="stylesheet" href="{{asset('css/exam.css')}}">
@endsection

@section('section')
<section>
    <div class="continer">
        <div class="page">
            <div class="left-qes">
                <p id="time" class="timer">{{$duration}}:00</p>
                <div class="boxes">
                    @for ($i = 0 ; $i < $count ; $i++)
                    <span class="box">{{$i+1}}</span>
                    @endfor
                </div>
            </div>
            <div class="qes">
                <p id="question-text">{{$question->text}}</p>
                <p class="grade">Grade: <span id="grade">{{$question->grade}}</span> Mark</p>
                <input id="q-id" type="text" hidden value="{{$question->id}}">
                <div class="option">
                    <div style="{{ ($question->type == 1) ? 'display: block;' : 'display: none;' }}" class="mc" id="mc">
                        <div>
                            <input id="first" type="radio" name="answer" value="0">
                            <label class="op" for="first">{{$question->answers[0]}}</label>
                        </div>
                        <div>
                            <input id="second" type="radio" name="answer" value="1">
                            <label class="op" for="second">{{$question->answers[1]}}</label>
                        </div>
                        <div>
                            <input id="thired" type="radio" name="answer" value="2">
                            <label class="op" for="thired">{{ ($question->type == 1) ? $question->answers[2] : '' }}</label>
                        </div>
                        <div>
                            <input id="fourth" type="radio" name="answer" value="3">
                            <label class="op" for="fourth">{{ ($question->type == 1) ? $question->answers[3] : '' }}</label>
                        </div>
                    </div>
                    <div style="{{ ($question->type == 2) ? 'display: block;' : 'display: none;' }}" class="tof" id="tof">
                        <div>
                            <input id="true" type="radio" name="answer" value="0">
                            <label for="true">true</label>
                        </div>
                        <div>
                            <input id="false" type="radio" name="answer" value="1">
                            <label for="false">false</label>
                        </div>
                    </div>
                </div>
                <button id="next"> Next Question</button>
            </div>
        </div>
    </div>
</section>
@endsection

<script>
    let examId = {{$id}};
</script>

@section('js')
<script src="{{asset('JS/exam.js')}}"></script>
@endsection