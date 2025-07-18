@extends('layouts.main')

@section('title' , 'Exam')

@section('style')
<link rel="stylesheet" href="{{asset('css/exam-link.css')}}">
@endsection

@section('section')
<section>
    <div class="continer">
        <div class="page">
            <div class="video">
                <p id="p">Take a clear picture of your face</p>
                <video id="video" autoplay></video>
                <button id="capture">Take a photo</button>
            </div>
            <div class="canvas" id="canvasBlock">
                <canvas id="canvas"></canvas>
                <a href="/student/exam/{{$id}}" class="next" id="next">Next</a>
            </div>
            <div>
                <p id="result" style="display: none; font-size: 20px; font-weight: bold;">Please wait...</p>
                <a id="retry" style="display: none" href="/student/examlink/{{$id}}" class="next">Retry</a>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
<script>
    let fullName = "{{$studentName}}";
    console.log(fullName);
</script>
<script src="{{asset('JS/exam-link.js')}}"></script>
@endsection