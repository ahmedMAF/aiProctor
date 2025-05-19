@extends("layouts.main")

@section("title" , "Edit Question")

@section("style")
    <link rel="stylesheet" href="{{asset('css/edit-q.css')}}">
@endsection

@section("section")
<section>
    <div class="continer">
        <div class="Add-Q">
            <div>
                <div class="contant" id="contant">
                    <form method="POST" action="/teacher/editQ/{{$q->id}}">
                        @csrf
                        @method('PUT')
                        <textarea name="text" placeholder="Write the question">{{$q->text}}</textarea>
                        <input name="grade" type="number" placeholder="Grade" value="{{$q->grade}}">
                        <select id="select-type" disabled>
                            <option value="" disabled>Question type</option>
                            <option {{$q->type == 1 ? 'selected' : ''}} value="1">Multiple choice</option>
                            <option {{$q->type == 2 ? 'selected' : ''}} value="2">True or False</option>
                        </select>
                        <input type="text" hidden value="{{$q->type}}" name="type">
                        <div class="t-O-Q">
                            @if ($q->type == 2)
                            <div class="t-o-f" id="t-o-f">
                                <div class="true">
                                    <input {{$q->correct_answer == 1 ? 'checked' : ''}} type="radio" id="t" value="1" name="tof">
                                    <label for="t">True</label>
                                </div>
                                <div class="true">
                                    <input {{$q->correct_answer == 2 ? 'checked' : ''}} type="radio" id="f" value="2" name="tof">
                                    <label for="f">False</label>
                                </div>
                            </div>
                            @elseif($q->type == 1)
                            <div class="m-c" id="m-c">
                                <div class="choice">
                                    <input  value="{{$q->answers[0]}}" type="text" name="answers[]" placeholder="First choice">
                                    <div class="choice">
                                        <input {{$q->correct_answer == 1 ? 'checked' : ''}} type="radio" name="correct" value="1" id="f-choice">
                                        <label for="f-choice">This is the correct answer</label>
                                    </div>
                                </div>
                                <div class="choice">
                                    <input value="{{$q->answers[1]}}" type="text" name="answers[]" placeholder="second choice">
                                    <div class="choice">
                                        <input {{$q->correct_answer == 2 ? 'checked' : ''}} type="radio" name="correct" value="2" id="s-choice">
                                        <label for="s-choice">This is the correct answer</label>
                                    </div>
                                </div>
                                <div class="choice">
                                    <input value="{{$q->answers[2]}}" type="text" name="answers[]" placeholder="Thierd choice">
                                    <div class="choice">
                                        <input {{$q->correct_answer == 3 ? 'checked' : ''}} type="radio" name="correct" value="3" id="t-choice">
                                        <label for="t-choice">This is the correct answer</label>
                                    </div>
                                </div>
                                <div class="choice">
                                    <input value="{{$q->answers[3]}}" type="text" name="answers[]" placeholder="Fourth choice">
                                    <div class="choice">
                                        <input {{$q->correct_answer == 4 ? 'checked' : ''}} type="radio" name="correct" value="4" id="fo-choice">
                                        <label for="fo-choice">This is the correct answer</label>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <input class="save" type="submit" value="Save">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection