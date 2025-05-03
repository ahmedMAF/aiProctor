@extends("layouts.main")

@section("title" , "Update")

@section("style")
<link rel="stylesheet" href="{{asset('css/create-exam.css')}}">
@endsection

@section("section")
<section>
    <div class="continer">
        <div class="info">
            <form action="/teacher/update/{{$exam->id}}" method="POST">
                @csrf
                @method('PUT')
                <div>
                    <label>Exam Name</label>
                    <input type="text" value="{{$exam->name}}" name="name">
                </div>
                <div>
                    <label>Description</label>
                    <textarea name="description">{{$exam->description}}</textarea>
                </div>
                <div class="Navigation">
                    <h3>Navigation Style</h3>
                    <div class="nav">
                        <input value="1" {{$exam->is_sequential == 1 ? "checked" : ""}} type="radio" id="se" name="nav">
                        <label for="se">Sequential</label>
                    </div>
                    <div class="nav">
                        <input value="0" {{$exam->is_sequential == 0 ? "checked" : ""}} type="radio" id="fr" name="nav">
                        <label for="fr">Free</label>
                    </div>
                </div>
                <div class="nav">
                    <input value="1" {{$exam->do_mix == 1 ? "checked" : ""}} type="checkbox" id="sh" name="Shuffling">
                    <label for="sh">Shuffling Questions</label>
                </div>
                <div>
                    <label for="op">Open Time</label>
                    <input type="datetime-local" id="op" value="{{$exam->open_time}}" name="open-time">
                </div>
                <div>
                    <label for="cl">Close Time</label>
                    <input type="datetime-local" id="cl" value="{{$exam->close_time}}" name="close-time">
                </div>
                <div>
                    <label>Duration in minutes</label>
                    <input type="number" value="{{$exam->duration}}" name="duration">
                </div>
                <div>
                    <label>Full Mark</label>
                    <input type="number" value="{{$exam->full_mark}}" name="full-mark">
                </div>
                <div>
                    <label>Pass Mark</label>
                    <input type="number" value="{{$exam->pass_mark}}" name="pass-mark">
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
                    <button class="delete" onclick="deleteQ({{$q->id}} , {{$exam->id}})">Delete</button>
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
                    <button class="delete" onclick="deleteQ({{$q->id}} , {{$exam->id}})">Delete</button>
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
                    <form method="POST" action="/teacher/addQ/{{$exam->id}}">
                        @csrf
                        <input type="text" name="test" hidden value="1">
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
    <form id="delete-form" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>
    
</section>
@endsection

@section("js")
<script src="{{asset('JS/create-exam.js')}}"></script>
<script>
    function deleteQ(id , exam) {
        let form = document.getElementById('delete-form');
        form.action = '/teacher/deleteQ/' + id + '/' + exam;
        form.submit();
    }
</script>
@endsection