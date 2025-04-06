@extends('layouts.main')

@section('title' , 'Add questions')

@section('style')
<link rel="stylesheet" href="{{asset('css/create-exam.css')}}">
@endsection

@section('section')
<section>
    <div class="continer">
        <div class="info">
            <form action="">
                <div>
                    <label>Exam Name</label>
                    <input type="text" value="{{$exam->name}}" readonly>
                </div>
                <div>
                    <label>Description</label>
                    <textarea name="" readonly>{{$exam->description}}</textarea>
                </div>
                <div class="Navigation">
                    <h3>Navigation Style</h3>
                    <div class="nav">
                        <input {{ $exam->is_sequential ? 'checked' : 'disabled' }} readonly type="radio" id="se">
                        <label for="se">Sequential</label>
                    </div>
                    <div class="nav">
                        <input {{ !$exam->is_sequential ? 'checked' : 'disabled' }} type="radio" id="fr">
                        <label for="fr">Free</label>
                    </div>
                </div>
                <div class="nav">
                    <input {{ $exam->do_mix == 1 ? 'checked' : '' }} readonly type="checkbox" id="sh">
                    <label for="sh">Shuffling Questions</label>
                </div>
                <div>
                    <label for="op">Open Time</label>
                    <input type="datetime-local" id="op" readonly value="{{$exam->open_time}}">
                </div>
                <div>
                    <label for="cl">Close Time</label>
                    <input type="datetime-local" id="cl" readonly value="{{$exam->close_time}}">
                </div>
                <div>
                    <label>Duration in minutes</label>
                    <input type="number" readonly value="{{$exam->duration}}">
                </div>
                <div>
                    <label>Full Mark</label>
                    <input type="number" readonly value="{{$exam->full_mark}}">
                </div>
                <div>
                    <label>Pass Mark</label>
                    <input type="number" readonly value="{{$exam->pass_mark}}">
                </div>
            </form>
        </div>
        <div class="q">

            @foreach ($question as $q)
            @if ($q->type == 1)
            <div class="qes">
                <p>{{$q->text}}</p>
                <div>
                    <input type="radio" name="2" disabled>
                    <label>{{$q->answers[0]}}</label>
                </div>
                <div>
                    <input type="radio" name="2" disabled>
                    <label>{{$q->answers[1]}}</label>
                </div>
                <div>
                    <input type="radio" name="2" disabled>
                    <label>{{$q->answers[2]}}</label>
                </div>
                <div>
                    <input type="radio" name="2" disabled>
                    <label>{{$q->answers[3]}}</label>
                </div>
                <p class="correct">The correct answer is <span>{{$q->answers[$q->correct_answer - 1]}}</span></p>
                <p>Grade <span>{{$q->grade}}</span></p>
            </div>
            @else 
            <div class="qes">
                <p>{{$q->text}}</p>
                <div>
                    <input type="radio" name="2" disabled>
                    <label>{{$q->answers[0]}}</label>
                </div>
                <div>
                    <input type="radio" name="2" disabled>
                    <label>{{$q->answers[1]}}</label>
                </div>
                <p class="correct">The correct answer is <span>{{$q->answers[$q->correct_answer - 1]}}</span></p>
                <p>Grade <span>{{$q->grade}}</span></p>
            </div>
            @endif
            @endforeach

        </div>
        <div class="Add-Q">
            <div>
                <button class="add" id="add">Add a Question</button>
                <div class="contant" id="contant">
                    <form method="POST" action="/teacher/addQ/{{$exam->id}}">
                        @csrf
                        <textarea name="text" placeholder="Write the question"></textarea>
                        <input name="grade" type="number" placeholder="Grade">
                        <select name="type" id="select-type">
                            <option value="" selected>Question type</option>
                            <option value="1">Multiple choice</option>
                            <option value="2">True or False</option>
                        </select>
                        <div class="t-O-Q">
                            <div class="t-o-f" id="t-o-f">
                                <div class="true">
                                    <input type="radio" id="t" value="1" name="tof">
                                    <label for="t">True</label>
                                </div>
                                <div class="true">
                                    <input type="radio" id="f" value="2" name="tof">
                                    <label for="f">False</label>
                                </div>
                            </div>
                            <div class="m-c" id="m-c">
                                <div class="choice">
                                    <input type="text" name="answers[]" placeholder="First choice">
                                    <div class="choice">
                                        <input type="radio" name="correct" value="1" id="f-choice">
                                        <label for="f-choice">This is the correct answer</label>
                                    </div>
                                </div>
                                <div class="choice">
                                    <input type="text" name="answers[]" placeholder="second choice">
                                    <div class="choice">
                                        <input type="radio" name="correct" value="2" id="s-choice">
                                        <label for="s-choice">This is the correct answer</label>
                                    </div>
                                </div>
                                <div class="choice">
                                    <input type="text" name="answers[]" placeholder="Thierd choice">
                                    <div class="choice">
                                        <input type="radio" name="correct" value="3" id="t-choice">
                                        <label for="t-choice">This is the correct answer</label>
                                    </div>
                                </div>
                                <div class="choice">
                                    <input type="text" name="answers[]" placeholder="Fourth choice">
                                    <div class="choice">
                                        <input type="radio" name="correct" value="4" id="fo-choice">
                                        <label for="fo-choice">This is the correct answer</label>
                                    </div>
                                </div>
                            </div>
                            <input class="save" type="submit" value="Save">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
<script src="{{asset('JS/create-exam.js')}}"></script>
@endsection