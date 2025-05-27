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
        <div>
            <h3>Listen to the recording</h3>
            <audio controls>
                <source src="{{asset('uploads/report/' . $name)}}" type="audio/wav">
            </audio>
        </div>
    </section>
@endsection