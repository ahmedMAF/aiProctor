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
                <button class="next" id="next">Next</button>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
<script src="{{asset('JS/exam-link.js')}}"></script>
@endsection