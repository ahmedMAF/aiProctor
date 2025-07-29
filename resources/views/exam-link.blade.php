@extends('layouts.main')

@section('title', 'Exam')

@section('style')
    <link rel="stylesheet" href="{{asset('css/exam-link.css')}}">
@endsection

@section('section')
    <section>
        <div class="continer" style="position: relative">
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
            <div class="instraction">
                <div class="content">
                    <h4>Please read the following instructions carefully before starting the exam</h4>
                    <ol>
                        <li>Make sure your camera and microphone are working properly before starting the exam.</li>
                        <li>Sit in a quiet place with proper lighting that clearly shows your facial features.</li>
                        <li>Ensure that your name on the platform matches exactly the name on your official ID.</li>
                        <li>Your identity will be verified by capturing a clear photo of your face and your ID.</li>
                        <li>After verification, a red dot will appear on the screen. Please look directly at it and keep it between your eyes for 5 seconds to complete the calibration process.</li>
                        <li>Once calibration is complete, the exam will start automatically.</li>
                        <li>During the exam, you will be monitored by AI which tracks your face, gaze, and head movements, analyzes your facial expressions, emotions, and behavior, detects if there is more than one face, and listens to surrounding audio.</li>
                        <li>The session will be documented by recording audio and periodically capturing images. Screen video may be recorded if any suspicious behavior is detected.</li>
                        <li>The teacher will receive a detailed report including emotional behavior analysis and any suspected cheating indicators, supported by evidence such as images, video, and audio.</li>
                        <li>No one else is allowed to be present in the room during the exam.</li>
                        <li>The use of additional devices such as mobile phones, earphones, or secondary screens is strictly prohibited.</li>
                    </ol>
                    <div class="agree">
                        <input type="checkbox" id="agree">
                        <label for="agree">I have read all of the above carefully and agree to it</label>
                        <button class="start" id="start" style="display: none">Start</button>
                    </div>
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