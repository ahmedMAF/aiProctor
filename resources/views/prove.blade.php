@extends('layouts.main')

@section('title', 'Prove')

@section('style')
    <style>
        .audio {
            height: 100vh;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
        }

        .audio h3 {
            text-align: center;
        }
    </style>
@endsection

@section('section')
    <section class="audio">
        @if ($type == 'audio')
            <div>
                <h3>Listen to the recording</h3>
                <audio controls>
                    <source src="{{asset('uploads/report/' . $name)}}" type="audio/wav">
                </audio>
            </div>
        @else
            <div>
                <h3>Watch the video</h3>
                <video controls style="width: 500px;">
                    <source src="{{asset('uploads/report/' . $name)}}" type="video/webm">
                </video>
            </div>
        @endif
    </section>
@endsection