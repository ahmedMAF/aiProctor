@extends("layouts.main")

@section("title" , "Update")

@section("style")
<link rel="stylesheet" href="{{asset('css/create-exam.css')}}">
@endsection

@section("section")
<section>
    <div class="continer">
        <div class="info">
            <form action="">
                <div>
                    <label>Exam Name</label>
                    <input type="text" value="{{$exam->name}}">
                </div>
                <div>
                    <label>Description</label>
                    <textarea name="">{{$exam->description}}</textarea>
                </div>
                <div class="Navigation">
                    <h3>Navigation Style</h3>
                    <div class="nav">
                        <input {{$exam->is_sequential == 1 ? "checked" : ""}} type="radio" id="se" name="1">
                        <label for="se">Sequential</label>
                    </div>
                    <div class="nav">
                        <input {{$exam->is_sequential == 0 ? "checked" : ""}} type="radio" id="fr" name="1">
                        <label for="fr">Free</label>
                    </div>
                </div>
                <div class="nav">
                    <input {{$exam->do_mix == 1 ? "checked" : ""}} type="checkbox" id="sh">
                    <label for="sh">Shuffling Questions</label>
                </div>
                <div>
                    <label for="op">Open Time</label>
                    <input type="datetime-local" id="op" value="{{$exam->open_time}}">
                </div>
                <div>
                    <label for="cl">Close Time</label>
                    <input type="datetime-local" id="cl" value="{{$exam->close_time}}">
                </div>
                <div>
                    <label>Duration in minutes</label>
                    <input type="number" value="{{$exam->duration}}">
                </div>
                <div>
                    <label>Full Mark</label>
                    <input type="number" value="{{$exam->full_mark}}">
                </div>
                <div>
                    <label>Pass Mark</label>
                    <input type="number" value="{{$exam->pass_mark}}">
                </div>
                <input class="create" type="submit" value="Save">
            </form>
        </div>
        <div class="q">
            @foreach ($questions as $q)
            @if ($q->type == 1)
            <div class="qes">
                <p>{{$q->text}}</p>
                <div>
                    <input {{$q->correct_answer - 1 == 0 ? "checked" : "disabled"}} type="radio" name="{{$q->id}}">
                    <label>{{$q->answers[0]}}</label>
                </div>
                <div>
                    <input {{$q->correct_answer - 1 == 1 ? "checked" : "disabled"}} type="radio" name="{{$q->id}}">
                    <label>{{$q->answers[1]}}</label>
                </div>
                <div>
                    <input {{$q->correct_answer - 1 == 2 ? "checked" : "disabled"}} type="radio" name="{{$q->id}}">
                    <label>{{$q->answers[2]}}</label>
                </div>
                <div>
                    <input {{$q->correct_answer - 1 == 3 ? "checked" : "disabled"}} type="radio" name="{{$q->id}}">
                    <label>{{$q->answers[3]}}</label>
                </div>
                <p class="correct">The correct answer is <span>{{$q->answers[$q->correct_answer - 1]}}</span></p>
                <p>Grade <span>{{$q->grade}}</span></p>
                <div>
                    <button class="delete">Delete</button>
                    <button class="update">Update</button>
                </div>
            </div>
            @else 
            <div class="qes">
                <p>{{$q->text}}</p>
                <div>
                    <input {{$q->correct_answer - 1 == 0 ? "checked" : "disabled"}} type="radio" name="{{$q->id}}">
                    <label>{{$q->answers[0]}}</label>
                </div>
                <div>
                    <input {{$q->correct_answer - 1 == 1 ? "checked" : "disabled"}} type="radio" name="{{$q->id}}">
                    <label>{{$q->answers[1]}}</label>
                </div>
                <p class="correct">The correct answer is <span>{{$q->answers[$q->correct_answer - 1]}}</span></p>
                <p>Grade <span>{{$q->grade}}</span></p>
                <div>
                    <button class="delete">Delete</button>
                    <button class="update">Update</button>
                </div>
            </div>
            @endif
            @endforeach
        </div>
        <div class="Add-Q">
            <div>
                <button class="add" id="add">Add a Question</button>
                <div class="contant" id="contant">
                    <form action="" method="POST">
                        @csrf
                        <textarea placeholder="Write the question"></textarea>
                        <input type="number" placeholder="Grade">
                        <select name="" id="select-type">
                            <option value="" selected>Question type</option>
                            <option value="1">Multiple choice</option>
                            <option value="2">True or False</option>
                        </select>
                        <div class="t-O-Q">
                            <div class="t-o-f" id="t-o-f">
                                <div class="true">
                                    <input type="radio" id="t" name="5">
                                    <label for="t">True</label>
                                </div>
                                <div class="true">
                                    <input type="radio" id="f" name="5">
                                    <label for="f">False</label>
                                </div>
                            </div>
                            <div class="m-c" id="m-c">
                                <div class="choice">
                                    <input type="text" placeholder="First choice">
                                    <div class="choice">
                                        <input type="checkbox" id="f-choice">
                                        <label for="f-choice">This is the correct answer</label>
                                    </div>
                                </div>
                                <div class="choice">
                                    <input type="text" placeholder="second choice">
                                    <div class="choice">
                                        <input type="checkbox" id="s-choice">
                                        <label for="s-choice">This is the correct answer</label>
                                    </div>
                                </div>
                                <div class="choice">
                                    <input type="text" placeholder="Thierd choice">
                                    <div class="choice">
                                        <input type="checkbox" id="t-choice">
                                        <label for="t-choice">This is the correct answer</label>
                                    </div>
                                </div>
                                <div class="choice">
                                    <input type="text" placeholder="Fourth choice">
                                    <div class="choice">
                                        <input type="checkbox" id="fo-choice">
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

@section("js")
<script src="{{asset('JS/create-exam.js')}}"></script>
@endsection