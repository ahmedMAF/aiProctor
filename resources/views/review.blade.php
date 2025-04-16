@extends("layouts.main")

@section("title" , "Review")

@section("style")
<link rel="stylesheet" href="{{asset('css/review.css')}}">
@endsection

@section("section")
<section>
    <div class="continer">
        @php
        $i = 0;
        @endphp
        @foreach ($questions as $question)
        @if ($question->type == 1)
        <div class="qes">
            <p>{{$question->text}}</p>
            <div>
                <input {{ $answers[$i] == 0 ? 'checked' : 'disabled' }} type="radio">
                <label>{{$question->answers[0]}}</label>
            </div>
            <div>
                <input {{ $answers[$i] == 1 ? 'checked' : 'disabled' }} type="radio">
                <label>{{$question->answers[1]}}</label>
            </div>
            <div>
                <input {{ $answers[$i] == 2 ? 'checked' : 'disabled' }} type="radio">
                <label>{{$question->answers[2]}}</label>
            </div>
            <div>
                <input {{ $answers[$i] == 0 ? 'checked' : 'disabled' }} type="radio">
                <label>{{$question->answers[3]}}</label>
            </div>
            <p class="correct">The correct answer is <span>{{$question->answers[$question->correct_answer - 1]}}</span></p>
            <p>Mark <span>
                @if ($question->correct_answer - 1 == $answers[$i])
                {{$question->grade}}
                @else
                0
                @endif
                 out of {{$question->grade}}</span></p>
        </div>
        @else
        <div class="qes">
            <p>{{$question->text}}</p>
            <div>
                <input {{ $answers[$i] == 0 ? 'checked' : 'disabled' }} type="radio">
                <label>True</label>
            </div>
            <div>
                <input {{ $answers[$i] == 1 ? 'checked' : 'disabled' }} type="radio">
                <label>Fales</label>
            </div>
            <p class="correct">The correct answer is <span>{{$question->answers[$question->correct_answer - 1]}}</span></p>
            <p>Mark <span>
                @if ($question->correct_answer - 1 == $answers[$i])
                {{$question->grade}}
                @else
                0
                @endif
                 out of {{$question->grade}}</span></p>
        </div>
        @endif
        @php
        $i++;
        @endphp
        @endforeach
    </div>
</section>
@endsection