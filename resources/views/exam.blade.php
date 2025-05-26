@extends('layouts.main')

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title', 'Exam')

@section('style')
    <link rel="stylesheet" href="{{asset('css/exam.css')}}">
@endsection

@section('section')
    <section>
        <div class="continer">
            <div class="page">
                <div class="left-qes">
                    <p id="time" class="timer">{{$m}}:{{$s}}</p>
                    <div class="boxes">
                        @for ($i = 0; $i < $count; $i++)
                            <span class="box">{{$i + 1}}</span>
                        @endfor
                    </div>
                </div>
                <div class="qes">
                    <p id="question-text">{{$question->text}}</p>
                    <p id="mark" class="grade">Grade: <span id="grade">{{$question->grade}}</span> Mark</p>
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
                                <label class="op"
                                    for="thired">{{ ($question->type == 1) ? $question->answers[2] : '' }}</label>
                            </div>
                            <div>
                                <input id="fourth" type="radio" name="answer" value="3">
                                <label class="op"
                                    for="fourth">{{ ($question->type == 1) ? $question->answers[3] : '' }}</label>
                            </div>
                        </div>
                        <div style="{{ ($question->type == 2) ? 'display: block;' : 'display: none;' }}" class="tof"
                            id="tof">
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
                    <form action="/exam/finish/{{$id}}" method="POST">
                        @csrf
                        <button type="submit" style="display: none" id="finish">Finish</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection


@section('js')
    <script src="{{asset('JS/exam.js')}}"></script>
    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let examId = {{$id}};
        let myvad;

        const ortScript = document.createElement('script');
        ortScript.src = "https://cdn.jsdelivr.net/npm/onnxruntime-web@1.14.0/dist/ort.js";
        ortScript.onload = function () {
            const vadScript = document.createElement('script');
            vadScript.src = "{{asset('JS/vad.js')}}";
            vadScript.onload = function () {
                startMic();
            };
            document.head.appendChild(vadScript);
        };
        document.head.appendChild(ortScript);

        async function startMic() {
            if (!myvad) {
                myvad = await vad.MicVAD.new({
                    onSpeechStart: () => {
                        console.log("Speech Detected");
                    },
                    onSpeechEnd: (audio) => {
                        const wavBytes = vad.utils.encodeWAV(audio);
                        const wavBlob = new Blob([wavBytes], { type: 'audio/wav' });
                        //uplod wavBlob
                        const formData = new FormData();
                        formData.append('file', wavBlob, 'speech.wav');
                        fetch(`/exam/report/${examId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: formData
                        })
                            .then(response => response.json())
                            .then(data => console.log('Upload success:', data))
                            .catch(error => console.error('Upload error:', error))

                        console.log("Speech Ended");
                    }
                });
            }
            await myvad.start();
        }
    </script>
@endsection