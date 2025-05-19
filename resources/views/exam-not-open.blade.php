@extends('layouts.main')

@section('title' , 'Exam')

@section('style')
<link rel="stylesheet" href="{{asset('css/exam-not-open.css')}}">
@endsection

@section('section')
<section>
    <p>The exam has not started yet, it will open at {{$open_time}}</p>
</section>
@endsection