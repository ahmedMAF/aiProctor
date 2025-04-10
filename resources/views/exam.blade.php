@extends('layouts.main')

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
                <p id="question-text"></p>
                <p class="grade">Grade: <span id="grade"></span> Mark</p>
                <div class="option">
                    <div class="mc" id="mc">
                        <div>
                            <input id="first" type="radio" name="1">
                            <label class="op" for="first"></label>
                        </div>
                        <div>
                            <input id="second" type="radio" name="1">
                            <label class="op" for="second"></label>
                        </div>
                        <div>
                            <input id="thired" type="radio" name="1">
                            <label class="op" for="thired"></label>
                        </div>
                        <div>
                            <input id="fourth" type="radio" name="1">
                            <label class="op" for="fourth"></label>
                        </div>
                    </div>
                    <div class="tof" id="tof">
                        <div>
                            <input id="true" type="radio" name="2">
                            <label for="true">true</label>
                        </div>
                        <div>
                            <input id="false" type="radio" name="2">
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